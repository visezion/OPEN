<?php

namespace Workdo\Churchly\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WorkSpace;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Workdo\Churchly\Entities\AttendanceEvent;
use Workdo\Churchly\Entities\ChurchBranch;
use Workdo\Churchly\Entities\ChurchDepartment;
use Workdo\Churchly\Entities\ChurchFeedback;
use Workdo\Churchly\Entities\ChurchMember;

class ChurchFeedbackController extends Controller
{
    public function dashboard()
    {
        $query = $this->visibleFeedbackQuery();

        $statswithcount = [
            'total' => (clone $query)->count(),
            'pending' => (clone $query)->where('status', 'pending')->count(),
            'reviewed' => (clone $query)->where('status', 'reviewed')->count(),
            'resolved' => (clone $query)->where('status', 'resolved')->count(),
        ];

        $stats = [
            'pending' => $statswithcount['pending'],
            'reviewed' => $statswithcount['reviewed'],
            'resolved' => $statswithcount['resolved'],
        ];

        $categoryCounts = (clone $query)
            ->select('category')
            ->selectRaw('count(*) as total')
            ->groupBy('category')
            ->pluck('total', 'category')
            ->toArray();

        $recentFeedbacks = (clone $query)
            ->latest('week_ending_date')
            ->latest()
            ->limit(5)
            ->get();

        $feedbackEvents = (clone $query)->latest()->get()->map(function (ChurchFeedback $feedback) {
            return [
                'title' => $feedback->title . ' (' . ucfirst($feedback->status) . ')',
                'start' => optional($feedback->week_ending_date ?? $feedback->created_at)->format('Y-m-d'),
                'color' => match ($feedback->status) {
                    'resolved' => '#198754',
                    'reviewed' => '#ffc107',
                    default => '#dc3545',
                },
                'url' => route('feedback.show', Crypt::encrypt($feedback->id)),
            ];
        })->toArray();

        return view('churchly::feedback.dashboard', compact(
            'stats',
            'statswithcount',
            'categoryCounts',
            'recentFeedbacks',
            'feedbackEvents'
        ));
    }

    public function index(Request $request)
    {
        $query = $this->visibleFeedbackQuery();

        $query->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->type, fn ($q) => $q->where('type', $request->type))
            ->when($request->category, fn ($q) => $q->where('category', $request->category));

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $perPage = (int) $request->get('per_page', 15);
        $feedbacks = $query->latest('week_ending_date')->latest()->paginate($perPage)->appends($request->all());

        return view('churchly::feedback.index', compact('feedbacks'));
    }

    public function create()
    {
        $member = $this->resolveChurchMember(Auth::user());
        $defaultWeekEnding = now()->toDateString();
        $attendanceSelection = $this->buildAttendanceSelectionData($defaultWeekEnding, $member);
        $attendancePreview = $attendanceSelection['summary'];
        $attendanceOptions = $attendanceSelection['options'];
        $selectedAttendanceEventId = $attendanceSelection['selected_attendance_event_id'];
        $directRecipients = $this->directRecipientOptions(Auth::user());
        $canSendDirect = $this->canUserSendDirectReports(Auth::user()) && $directRecipients->isNotEmpty();
        $selectedRecipientUserId = old('recipient_user_id');

        return view('churchly::feedback.create', compact(
            'attendancePreview',
            'attendanceOptions',
            'selectedAttendanceEventId',
            'defaultWeekEnding',
            'directRecipients',
            'canSendDirect',
            'selectedRecipientUserId'
        ));
    }

    public function store(Request $request)
    {
        $member = $this->resolveChurchMember(Auth::user());
        $validated = $this->validateReportRequest($request);
        $recipientUserId = $this->resolveRecipientUserId($request, $validated);
        $attendanceSelection = $this->buildAttendanceSelectionData(
            $validated['week_ending_date'],
            $member,
            isset($validated['attendance_event_id']) ? (int) $validated['attendance_event_id'] : null
        );

        if (!$attendanceSelection['requested_attendance_event_id_valid']) {
            return redirect()->back()
                ->withInput()
                ->with('error', __('The selected attendance record is not available for this report week.'));
        }

        $attendanceSummary = $attendanceSelection['summary'];

        $data = $this->buildReportRecordData($validated, $member, $attendanceSummary, null, $recipientUserId);

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('feedback_attachments', 'public');
        }

        $feedback = ChurchFeedback::create($data);

        $this->notifyDepartmentWhatsapp($feedback);

        return redirect()->route('feedback.index')->with('success', __('Weekly report submitted successfully.'));
    }

    public function edit($id)
    {
        $feedback = $this->findFeedbackFromEncryptedId($id);
        if (!$feedback) {
            return redirect()->back()->with('error', __('Invalid report ID.'));
        }
        if (!$this->canEditFeedback($feedback)) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $member = $this->resolveChurchMember(Auth::user());
        $defaultWeekEnding = optional($feedback->week_ending_date)->toDateString() ?? now()->toDateString();
        $attendanceSelection = $this->buildAttendanceSelectionData(
            $defaultWeekEnding,
            $member,
            old('attendance_event_id', $feedback->attendance_event_id)
        );
        $attendancePreview = $feedback->attendance_summary ?: $attendanceSelection['summary'];
        $attendanceOptions = $attendanceSelection['options'];
        $selectedAttendanceEventId = old(
            'attendance_event_id',
            $feedback->attendance_event_id ?? $attendanceSelection['selected_attendance_event_id']
        );
        $directRecipients = $this->directRecipientOptions(Auth::user());
        $canSendDirect = $this->canUserSendDirectReports(Auth::user()) && $directRecipients->isNotEmpty();
        $selectedRecipientUserId = old('recipient_user_id', $feedback->recipient_user_id);

        return view('churchly::feedback.edit', compact(
            'feedback',
            'attendancePreview',
            'attendanceOptions',
            'selectedAttendanceEventId',
            'defaultWeekEnding',
            'directRecipients',
            'canSendDirect',
            'selectedRecipientUserId'
        ));
    }

    public function update(Request $request, $id)
    {
        $feedback = $this->findFeedbackFromEncryptedId($id);
        if (!$feedback) {
            return redirect()->back()->with('error', __('Invalid report ID.'));
        }
        if (!$this->canEditFeedback($feedback)) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $member = $this->resolveChurchMember(Auth::user());
        $validated = $this->validateReportRequest($request);
        $recipientUserId = $this->resolveRecipientUserId($request, $validated, $feedback);
        $attendanceSelection = $this->buildAttendanceSelectionData(
            $validated['week_ending_date'],
            $member,
            isset($validated['attendance_event_id']) ? (int) $validated['attendance_event_id'] : null
        );

        if (!$attendanceSelection['requested_attendance_event_id_valid']) {
            return redirect()->back()
                ->withInput()
                ->with('error', __('The selected attendance record is not available for this report week.'));
        }

        $attendanceSummary = $attendanceSelection['summary'];
        $data = $this->buildReportRecordData($validated, $member, $attendanceSummary, $feedback, $recipientUserId);

        if ($request->hasFile('attachment')) {
            if ($feedback->attachment && Storage::disk('public')->exists($feedback->attachment)) {
                Storage::disk('public')->delete($feedback->attachment);
            }

            $data['attachment'] = $request->file('attachment')->store('feedback_attachments', 'public');
        }

        $feedback->update($data);

        return redirect()->route('feedback.index')->with('success', __('Weekly report updated successfully.'));
    }

    public function show($id)
    {
        $feedback = $this->findFeedbackFromEncryptedId($id, true);
        if (!$feedback) {
            return redirect()->back()->with('error', __('Report not found.'));
        }
        if (!$this->canViewFeedback($feedback)) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $attendanceSummary = $feedback->attendance_summary ?: $this->buildAttendanceSummary(
            optional($feedback->week_ending_date)->toDateString(),
            $this->resolveChurchMember($feedback->submitter)
        );

        return view('churchly::feedback.show', compact('feedback', 'attendanceSummary'));
    }

    public function destroy($id)
    {
        $feedback = $this->findFeedbackFromEncryptedId($id);
        if (!$feedback) {
            return redirect()->back()->with('error', __('Invalid report ID.'));
        }
        if (!$this->canDeleteFeedback($feedback)) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        if ($feedback->attachment && Storage::disk('public')->exists($feedback->attachment)) {
            Storage::disk('public')->delete($feedback->attachment);
        }

        $feedback->delete();

        return redirect()->route('feedback.index')->with('success', __('Report deleted successfully.'));
    }

    public function createPublic($workspaceSlug)
    {
        $branches = ChurchBranch::all();
        $departments = ChurchDepartment::all();

        $workspace = WorkSpace::where('slug', $workspaceSlug)
            ->orWhere('domain', $workspaceSlug)
            ->orWhere('subdomain', $workspaceSlug)
            ->firstOrFail();

        return view('churchly::feedback.public_form', compact('branches', 'departments', 'workspace'));
    }

    public function storePublic(Request $request, $workspaceSlug)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:internal,public',
            'category' => 'required|in:suggestion,complaint,praise,other',
            'is_anonymous' => 'sometimes|boolean',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'branch_id' => 'nullable|integer',
            'department_id' => 'nullable|integer',
            'attachment' => 'nullable|file|max:2048',
        ]);

        if ($request->hasFile('attachment')) {
            $validated['attachment'] = $request->file('attachment')->store('feedback_attachments', 'public');
        }

        $workspace = WorkSpace::where('slug', $workspaceSlug)
            ->orWhere('domain', $workspaceSlug)
            ->orWhere('subdomain', $workspaceSlug)
            ->firstOrFail();

        $validated['submitted_by'] = Auth::check() ? Auth::id() : null;
        $validated['workspace_id'] = $workspace->id;

        ChurchFeedback::create($validated);

        return back()->with('success', __('Feedback submitted successfully.'));
    }

    public function review($id)
    {
        $feedback = $this->findFeedbackFromEncryptedId($id, true);
        if (!$feedback) {
            return redirect()->back()->with('error', __('Invalid report ID.'));
        }
        if (!$this->canReviewFeedback($feedback)) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $attendanceSummary = $feedback->attendance_summary ?: $this->buildAttendanceSummary(
            optional($feedback->week_ending_date)->toDateString(),
            $this->resolveChurchMember($feedback->submitter)
        );

        return view('churchly::feedback.review', compact('feedback', 'attendanceSummary'));
    }

    public function updateResponse(Request $request, $id)
    {
        $request->validate([
            'admin_response' => 'required|string',
            'status' => 'required|in:pending,reviewed,resolved',
        ]);

        $feedback = ChurchFeedback::findOrFail($id);
        if (!$this->canReviewFeedback($feedback)) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        $feedback->admin_response = $request->admin_response;
        $feedback->status = $request->status;
        $feedback->reviewed_by = auth()->id();
        $feedback->reviewed_at = now();
        $feedback->save();

        return redirect()->route('feedback.index')->with('success', __('Report response updated successfully.'));
    }

    public function attendanceSummary(Request $request): JsonResponse
    {
        $request->validate([
            'week_ending_date' => 'required|date',
            'attendance_event_id' => 'nullable|integer',
        ]);

        $member = $this->resolveChurchMember(Auth::user());
        $attendanceSelection = $this->buildAttendanceSelectionData(
            $request->string('week_ending_date')->toString(),
            $member,
            $request->filled('attendance_event_id') ? (int) $request->input('attendance_event_id') : null
        );

        return response()->json(
            $attendanceSelection['summary'] + [
                'options' => $attendanceSelection['options'],
                'selected_attendance_event_id' => $attendanceSelection['selected_attendance_event_id'],
            ]
        );
    }

    public function export()
    {
        abort(501, 'Export functionality coming soon.');
    }

    protected function visibleFeedbackQuery(): Builder
    {
        $user = Auth::user();
        $member = $this->resolveChurchMember($user);
        $query = ChurchFeedback::with(['department', 'submitter', 'recipient', 'attendanceEvent.event'])
            ->where('workspace_id', getActiveWorkSpace());

        if ($user->isAbleTo('feedback view all')) {
            return $query;
        }

        $branchId = $member?->branch_id ?? $user->branch_id ?? null;
        $departmentId = $this->resolveDepartmentId($member) ?? $user->department_id ?? null;

        return $query->where(function (Builder $visibleQuery) use ($user, $branchId, $departmentId) {
            $visibleQuery->where('submitted_by', $user->id)
                ->orWhere('recipient_user_id', $user->id)
                ->orWhere(function (Builder $standardScopeQuery) use ($user, $branchId, $departmentId) {
                    $standardScopeQuery->whereNull('recipient_user_id')
                        ->where(function (Builder $permissionScopeQuery) use ($user, $branchId, $departmentId) {
                            $hasScope = false;

                            if ($user->isAbleTo('feedback view own')) {
                                $permissionScopeQuery->orWhere('submitted_by', $user->id);
                                $hasScope = true;
                            }

                            if ($user->isAbleTo('feedback view branch') && $branchId) {
                                $permissionScopeQuery->orWhere('branch_id', $branchId);
                                $hasScope = true;
                            }

                            if ($user->isAbleTo('feedback view department') && $branchId && $departmentId) {
                                $permissionScopeQuery->orWhere(function (Builder $departmentScopeQuery) use ($branchId, $departmentId) {
                                    $departmentScopeQuery->where('branch_id', $branchId)
                                        ->where('department_id', $departmentId);
                                });
                                $hasScope = true;
                            }

                            if (!$hasScope) {
                                $permissionScopeQuery->whereRaw('1 = 0');
                            }
                        });
                });
        });
    }

    protected function validateReportRequest(Request $request): array
    {
        return $request->validate([
            'week_ending_date' => 'required|date',
            'attendance_event_id' => 'nullable|integer',
            'recipient_user_id' => 'nullable|integer',
            'activities' => 'nullable|string',
            'achievements' => 'nullable|string',
            'service_tasks' => 'nullable|string',
            'service_observations' => 'nullable|string',
            'challenges' => 'nullable|string',
            'support_needed' => 'nullable|string',
            'plans' => 'nullable|string',
            'recommendations' => 'nullable|string',
            'attachment' => 'nullable|file|max:4096',
            'is_anonymous' => 'nullable|boolean',
        ]);
    }

    protected function buildReportRecordData(
        array $validated,
        ?ChurchMember $member,
        array $attendanceSummary,
        ?ChurchFeedback $feedback = null,
        ?int $recipientUserId = null
    ): array {
        $attendanceEvent = null;
        if (!empty($attendanceSummary['attendance_event_id'])) {
            $attendanceEvent = AttendanceEvent::query()
                ->where('workspace_id', getActiveWorkSpace())
                ->find($attendanceSummary['attendance_event_id']);
        }

        $departmentId = $this->resolveDepartmentId($member) ?? $attendanceEvent?->department_id;
        $branchId = $member?->branch_id ?? $attendanceEvent?->branch_id;
        $department = $departmentId ? ChurchDepartment::find($departmentId) : null;
        $title = $this->buildReportTitle($department, $validated['week_ending_date']);
        $payload = [
            'activities' => $validated['activities'] ?? null,
            'achievements' => $validated['achievements'] ?? null,
            'service_tasks' => $validated['service_tasks'] ?? null,
            'service_observations' => $validated['service_observations'] ?? null,
            'challenges' => $validated['challenges'] ?? null,
            'support_needed' => $validated['support_needed'] ?? null,
            'plans' => $validated['plans'] ?? null,
            'recommendations' => $validated['recommendations'] ?? null,
        ];

        return [
            'title' => $title,
            'message' => $this->buildReportSummaryText($payload, $attendanceSummary),
            'type' => $feedback?->type ?? 'internal',
            'category' => $feedback?->category ?? 'other',
            'record_kind' => 'weekly_report',
            'week_ending_date' => $validated['week_ending_date'],
            'report_payload' => $payload,
            'attendance_summary' => $attendanceSummary,
            'attendance_event_id' => $attendanceSummary['attendance_event_id'] ?? null,
            'submitted_by' => $feedback?->submitted_by ?? Auth::id(),
            'name' => Auth::user()?->name,
            'email' => Auth::user()?->email,
            'branch_id' => $branchId,
            'department_id' => $departmentId,
            'recipient_user_id' => $recipientUserId,
            'workspace_id' => Auth::user()?->workspace_id ?? getActiveWorkSpace(),
            'is_anonymous' => (bool) ($validated['is_anonymous'] ?? false),
        ];
    }

    protected function buildReportTitle(?ChurchDepartment $department, string $weekEndingDate): string
    {
        $weekEnding = Carbon::parse($weekEndingDate)->format('d M Y');
        $departmentName = $department?->name ?? __('General');

        return __('Weekly Report') . ' - ' . $departmentName . ' - ' . $weekEnding;
    }

    protected function buildReportSummaryText(array $payload, array $attendanceSummary): string
    {
        $summaryParts = [];

        if (!empty($payload['activities'])) {
            $summaryParts[] = __('Activities') . ': ' . Str::of(strip_tags((string) $payload['activities']))->squish()->limit(180, '...');
        }

        if (!empty($payload['achievements'])) {
            $summaryParts[] = __('Achievements') . ': ' . Str::of(strip_tags((string) $payload['achievements']))->squish()->limit(180, '...');
        }

        if (isset($attendanceSummary['present_count'], $attendanceSummary['total_members'])) {
            $summaryParts[] = __('Attendance') . ': ' . $attendanceSummary['present_count'] . '/' . $attendanceSummary['total_members'];
        }

        if (!empty($payload['plans'])) {
            $summaryParts[] = __('Plans') . ': ' . Str::of(strip_tags((string) $payload['plans']))->squish()->limit(140, '...');
        }

        return implode("\n", $summaryParts);
    }

    protected function buildAttendanceSummary(?string $weekEndingDate, ?ChurchMember $member): array
    {
        return $this->buildAttendanceSelectionData($weekEndingDate, $member)['summary'];

        $weekEnding = $weekEndingDate ? Carbon::parse($weekEndingDate)->endOfDay() : now()->endOfWeek(Carbon::SUNDAY)->endOfDay();
        $weekStart = $weekEnding->copy()->subDays(6)->startOfDay();
        $departmentId = $this->resolveDepartmentId($member);
        $branchId = $member?->branch_id;
        $totalMembers = $this->departmentMemberCount($branchId, $departmentId);

        $attendanceEvent = AttendanceEvent::with(['event', 'records'])
            ->where('workspace_id', getActiveWorkSpace())
            ->when($branchId, fn ($query) => $query->where('branch_id', $branchId))
            ->when($departmentId, fn ($query) => $query->where('department_id', $departmentId))
            ->where(function ($query) use ($weekStart, $weekEnding) {
                $query->whereBetween('checkin_start_at', [$weekStart, $weekEnding])
                    ->orWhereHas('event', function ($eventQuery) use ($weekStart, $weekEnding) {
                        $eventQuery->whereBetween('start_time', [$weekStart, $weekEnding]);
                    });
            })
            ->whereHas('records')
            ->orderByDesc('checkin_start_at')
            ->orderByDesc('id')
            ->first();

        if (!$attendanceEvent && $departmentId) {
            $attendanceEvent = AttendanceEvent::with(['event', 'records'])
                ->where('workspace_id', getActiveWorkSpace())
                ->where(function ($query) use ($weekStart, $weekEnding) {
                    $query->whereBetween('checkin_start_at', [$weekStart, $weekEnding])
                        ->orWhereHas('event', function ($eventQuery) use ($weekStart, $weekEnding) {
                            $eventQuery->whereBetween('start_time', [$weekStart, $weekEnding]);
                        });
                })
                ->whereHas('records')
                ->orderByDesc('checkin_start_at')
                ->orderByDesc('id')
                ->first();
        }

        if (!$attendanceEvent) {
            return [
                'week_start' => $weekStart->toDateString(),
                'week_end' => $weekEnding->toDateString(),
                'attendance_event_id' => null,
                'source_label' => __('No attendance event or meeting was found for the selected week.'),
                'source_mode' => __('Not linked'),
                'total_members' => $totalMembers,
                'present_count' => 0,
                'absent_count' => 0,
                'attendance_rate' => 0,
                'is_auto_synced' => false,
            ];
        }

        $latestMemberStates = $attendanceEvent->records
            ->sortByDesc(function ($record) {
                return optional($record->check_in_time ?? $record->created_at)->timestamp;
            })
            ->groupBy('member_id')
            ->map(fn ($records) => $records->first());

        $presentCount = $latestMemberStates->filter(function ($record) {
            return in_array($record->status, ['present', 'late'], true);
        })->count();

        $explicitAbsentCount = $latestMemberStates->filter(function ($record) {
            return in_array($record->status, ['absent', 'excused'], true);
        })->count();

        $absentCount = $totalMembers > 0
            ? max($totalMembers - $presentCount, 0)
            : $explicitAbsentCount;

        $attendanceRate = $totalMembers > 0 ? round(($presentCount / $totalMembers) * 100, 1) : 0;
        $sourceDate = $attendanceEvent->event?->start_time ?? $attendanceEvent->checkin_start_at ?? $attendanceEvent->created_at;
        $sourceName = $attendanceEvent->event?->title ?? __('Attendance Session');
        $sourceMode = $attendanceEvent->online_platform
            ? strtoupper((string) $attendanceEvent->online_platform)
            : ucfirst((string) ($attendanceEvent->mode ?? 'onsite'));

        return [
            'week_start' => $weekStart->toDateString(),
            'week_end' => $weekEnding->toDateString(),
            'attendance_event_id' => $attendanceEvent->id,
            'source_label' => $sourceName . ' • ' . optional($sourceDate)->format('d M Y'),
            'source_mode' => $sourceMode,
            'total_members' => $totalMembers,
            'present_count' => $presentCount,
            'absent_count' => $absentCount,
            'attendance_rate' => $attendanceRate,
            'is_auto_synced' => true,
        ];
    }

    protected function departmentMemberCount(?int $branchId, ?int $departmentId): int
    {
        $query = ChurchMember::query()->where('workspace', getActiveWorkSpace());

        if ($branchId) {
            $query->where('branch_id', $branchId);
        }

        if ($departmentId) {
            $query->where(function ($departmentQuery) use ($departmentId) {
                $usedDirectColumn = false;

                if (Schema::hasColumn('church_members', 'department_id')) {
                    $departmentQuery->where('department_id', $departmentId);
                    $usedDirectColumn = true;
                }

                if ($usedDirectColumn) {
                    $departmentQuery->orWhereHas('departments', function ($relationshipQuery) use ($departmentId) {
                        $relationshipQuery->where('church_departments.id', $departmentId);
                    });
                } else {
                    $departmentQuery->whereHas('departments', function ($relationshipQuery) use ($departmentId) {
                        $relationshipQuery->where('church_departments.id', $departmentId);
                    });
                }
            });
        }

        return (int) $query->count();
    }

    protected function buildAttendanceSelectionData(
        ?string $weekEndingDate,
        ?ChurchMember $member,
        ?int $selectedAttendanceEventId = null
    ): array {
        $weekEnding = $weekEndingDate ? Carbon::parse($weekEndingDate)->endOfDay() : now()->endOfDay();
        $weekStart = $weekEnding->copy()->subDays(6)->startOfDay();
        $attendanceEvents = $this->attendanceEventsForWeek($weekStart, $weekEnding, $member);
        $matchedAttendanceEvent = $selectedAttendanceEventId
            ? $attendanceEvents->firstWhere('id', $selectedAttendanceEventId)
            : null;
        $attendanceEvent = $matchedAttendanceEvent ?: $attendanceEvents->first();
        $requestedAttendanceEventIdValid = !$selectedAttendanceEventId || (bool) $matchedAttendanceEvent;
        $branchId = $member?->branch_id ?? $attendanceEvent?->branch_id;
        $departmentId = $this->resolveDepartmentId($member) ?? $attendanceEvent?->department_id;
        $totalMembers = ($branchId || $departmentId)
            ? $this->departmentMemberCount($branchId, $departmentId)
            : 0;

        if (!$attendanceEvent) {
            return [
                'summary' => [
                    'week_start' => $weekStart->toDateString(),
                    'week_end' => $weekEnding->toDateString(),
                    'attendance_event_id' => null,
                    'source_label' => __('No attendance record is available for this report week.'),
                    'source_mode' => __('Not linked'),
                    'total_members' => $totalMembers,
                    'present_count' => 0,
                    'absent_count' => 0,
                    'attendance_rate' => 0,
                    'is_auto_synced' => false,
                ],
                'options' => [],
                'selected_attendance_event_id' => null,
                'requested_attendance_event_id_valid' => $requestedAttendanceEventIdValid,
            ];
        }

        $selectedOption = $this->attendanceOptionPayload($attendanceEvent, $member);
        $summary = $this->attendanceSummaryPayload($attendanceEvent, $weekStart, $weekEnding, $totalMembers, $selectedOption);

        return [
            'summary' => $summary,
            'options' => $attendanceEvents
                ->map(fn (AttendanceEvent $event) => $this->attendanceOptionPayload($event, $member))
                ->values()
                ->all(),
            'selected_attendance_event_id' => $attendanceEvent->id,
            'requested_attendance_event_id_valid' => $requestedAttendanceEventIdValid,
        ];
    }

    protected function attendanceEventsForWeek(Carbon $weekStart, Carbon $weekEnding, ?ChurchMember $member)
    {
        $departmentId = $this->resolveDepartmentId($member);
        $memberId = $member?->id;
        $userId = Auth::id();

        return AttendanceEvent::with(['event', 'records'])
            ->where('workspace_id', getActiveWorkSpace())
            ->where(function ($query) use ($userId, $departmentId, $memberId) {
                $query->where('created_by', $userId)
                    ->orWhereHas('event', function ($eventQuery) use ($userId) {
                        $eventQuery->where('created_by', $userId);
                    });

                if ($departmentId) {
                    $query->orWhere('department_id', $departmentId);
                }

                if ($memberId) {
                    $query->orWhereHas('records', function ($recordQuery) use ($memberId) {
                        $recordQuery->where('member_id', $memberId);
                    });
                }
            })
            ->where(function ($query) use ($weekStart, $weekEnding) {
                $query->whereBetween('checkin_start_at', [$weekStart, $weekEnding])
                    ->orWhereBetween('created_at', [$weekStart, $weekEnding])
                    ->orWhereHas('event', function ($eventQuery) use ($weekStart, $weekEnding) {
                        $eventQuery->whereBetween('start_time', [$weekStart, $weekEnding])
                            ->orWhereBetween('created_at', [$weekStart, $weekEnding]);
                    });
            })
            ->whereHas('records')
            ->get()
            ->sortBy(function (AttendanceEvent $attendanceEvent) use ($member, $userId) {
                $sourceDate = $this->attendanceEventSourceDate($attendanceEvent);
                $sourceTimestamp = $sourceDate?->timestamp ?? 0;
                $distanceFromNow = $sourceDate ? abs($sourceDate->diffInSeconds(now(), false)) : 999999999999;
                $activePriority = $this->attendanceEventIsActiveNow($attendanceEvent) ? 0 : 1;
                $todayPriority = $sourceDate?->isToday() ? 0 : 1;
                $futurePriority = $sourceDate && $sourceDate->isFuture() && !$sourceDate->isToday() ? 1 : 0;
                $scopePriority = $this->attendanceEventScopePriority($attendanceEvent, $member, $userId);

                return sprintf(
                    '%d-%d-%d-%012d-%d-%010d',
                    $activePriority,
                    $todayPriority,
                    $futurePriority,
                    $distanceFromNow,
                    $scopePriority,
                    max(0, 9999999999 - min($sourceTimestamp, 9999999999))
                );
            })
            ->values();
    }

    protected function attendanceSummaryPayload(
        AttendanceEvent $attendanceEvent,
        Carbon $weekStart,
        Carbon $weekEnding,
        int $totalMembers,
        array $selectedOption
    ): array {
        $latestMemberStates = $attendanceEvent->records
            ->sortByDesc(function ($record) {
                return optional($record->check_in_time ?? $record->created_at)->timestamp;
            })
            ->groupBy('member_id')
            ->map(fn ($records) => $records->first());

        $presentCount = $latestMemberStates->filter(function ($record) {
            return in_array($record->status, ['present', 'late'], true);
        })->count();

        $explicitAbsentCount = $latestMemberStates->filter(function ($record) {
            return in_array($record->status, ['absent', 'excused'], true);
        })->count();

        $absentCount = $totalMembers > 0
            ? max($totalMembers - $presentCount, 0)
            : $explicitAbsentCount;

        $attendanceRate = $totalMembers > 0 ? round(($presentCount / $totalMembers) * 100, 1) : 0;

        return [
            'week_start' => $weekStart->toDateString(),
            'week_end' => $weekEnding->toDateString(),
            'attendance_event_id' => $attendanceEvent->id,
            'source_label' => $selectedOption['label'],
            'source_mode' => $selectedOption['mode'],
            'total_members' => $totalMembers,
            'present_count' => $presentCount,
            'absent_count' => $absentCount,
            'attendance_rate' => $attendanceRate,
            'is_auto_synced' => true,
        ];
    }

    protected function attendanceOptionPayload(AttendanceEvent $attendanceEvent, ?ChurchMember $member): array
    {
        $sourceDate = $this->attendanceEventSourceDate($attendanceEvent);
        $sourceName = $attendanceEvent->event?->title ?? __('Attendance Session');
        $sourceMode = $attendanceEvent->online_platform
            ? strtoupper((string) $attendanceEvent->online_platform)
            : ucfirst((string) ($attendanceEvent->mode ?? 'onsite'));
        $scopeLabels = $this->attendanceEventScopeLabels($attendanceEvent, $member, Auth::id());
        $scopeSuffix = empty($scopeLabels) ? '' : ' • ' . implode(' / ', $scopeLabels);

        return [
            'id' => $attendanceEvent->id,
            'label' => $sourceName . ' - ' . ($sourceDate?->format('d M Y') ?? __('No date')) . $scopeSuffix,
            'mode' => $sourceMode,
        ];
    }

    protected function attendanceEventScopeLabels(AttendanceEvent $attendanceEvent, ?ChurchMember $member, ?int $userId): array
    {
        $labels = [];
        $memberId = $member?->id;
        $departmentId = $this->resolveDepartmentId($member);

        if ($userId && $this->attendanceEventWasCreatedByUser($attendanceEvent, $userId)) {
            $labels[] = __('Created by you');
        }

        if ($departmentId && (int) $attendanceEvent->department_id === (int) $departmentId) {
            $labels[] = __('Your department');
        }

        if ($memberId && $attendanceEvent->records->contains('member_id', $memberId)) {
            $labels[] = __('You attended');
        }

        return array_values(array_unique($labels));
    }

    protected function attendanceEventScopePriority(AttendanceEvent $attendanceEvent, ?ChurchMember $member, ?int $userId): int
    {
        $memberId = $member?->id;
        $departmentId = $this->resolveDepartmentId($member);

        if ($userId && $this->attendanceEventWasCreatedByUser($attendanceEvent, $userId)) {
            return 0;
        }

        if ($memberId && $attendanceEvent->records->contains('member_id', $memberId)) {
            return 1;
        }

        if ($departmentId && (int) $attendanceEvent->department_id === (int) $departmentId) {
            return 2;
        }

        return 3;
    }

    protected function attendanceEventWasCreatedByUser(AttendanceEvent $attendanceEvent, int $userId): bool
    {
        return (int) $attendanceEvent->created_by === $userId
            || (int) ($attendanceEvent->event?->created_by ?? 0) === $userId;
    }

    protected function attendanceEventSourceDate(AttendanceEvent $attendanceEvent): ?Carbon
    {
        $date = $attendanceEvent->checkin_start_at
            ?? $attendanceEvent->event?->start_time
            ?? $attendanceEvent->created_at
            ?? $attendanceEvent->event?->created_at;

        if (!$date) {
            return null;
        }

        return $date instanceof Carbon ? $date : Carbon::parse($date);
    }

    protected function attendanceEventIsActiveNow(AttendanceEvent $attendanceEvent): bool
    {
        $now = now();
        $start = $attendanceEvent->checkin_start_at ?? $attendanceEvent->event?->start_time;
        $end = $attendanceEvent->checkin_end_at ?? $attendanceEvent->event?->end_time;

        if (!$start) {
            return false;
        }

        $start = $start instanceof Carbon ? $start : Carbon::parse($start);
        $end = $end ? ($end instanceof Carbon ? $end : Carbon::parse($end)) : $start->copy()->endOfDay();

        return $now->between($start, $end);
    }

    protected function resolveChurchMember($user): ?ChurchMember
    {
        if (!$user) {
            return null;
        }

        return ChurchMember::with('departments')->where('user_id', $user->id)->first();
    }

    protected function resolveDepartmentId(?ChurchMember $member): ?int
    {
        if (!$member) {
            return null;
        }

        if (isset($member->department_id) && $member->department_id) {
            return (int) $member->department_id;
        }

        return $member->departments->first()?->id;
    }

    protected function findFeedbackFromEncryptedId($id, bool $withRelations = false): ?ChurchFeedback
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (\Throwable $th) {
            return null;
        }

        $query = ChurchFeedback::query();
        if ($withRelations) {
            $query->with(['submitter', 'reviewer', 'recipient', 'branch', 'department', 'workspace', 'attendanceEvent.event']);
        }

        return $query->find($id);
    }

    protected function canUserSendDirectReports(?User $user): bool
    {
        return (bool) $user?->isAbleTo('feedback send direct');
    }

    protected function directRecipientOptions(?User $sender)
    {
        if (!$sender || !$this->canUserSendDirectReports($sender)) {
            return collect();
        }

        $workspaceId = getActiveWorkSpace();

        return User::query()
            ->where('id', '!=', $sender->id)
            ->where(function (Builder $query) use ($workspaceId) {
                $query->where('workspace_id', $workspaceId)
                    ->orWhere('active_workspace', $workspaceId);
            })
            ->orderBy('name')
            ->get()
            ->filter(function (User $user) {
                return $user->isAbleTo('feedback review') || $user->isAbleTo('feedback view all');
            })
            ->values()
            ->map(function (User $user) {
                $label = $user->name;
                if (!empty($user->email)) {
                    $label .= ' (' . $user->email . ')';
                }

                return [
                    'id' => $user->id,
                    'label' => $label,
                ];
            });
    }

    protected function resolveRecipientUserId(Request $request, array $validated, ?ChurchFeedback $feedback = null): ?int
    {
        if (!$request->has('recipient_user_id')) {
            return $feedback?->recipient_user_id;
        }

        if (!$request->filled('recipient_user_id')) {
            return null;
        }

        if (!$this->canUserSendDirectReports(Auth::user())) {
            abort(403, 'Unauthorized recipient selection.');
        }

        $selectedRecipientUserId = (int) ($validated['recipient_user_id'] ?? 0);

        if ($selectedRecipientUserId === (int) Auth::id()) {
            throw ValidationException::withMessages([
                'recipient_user_id' => __('You cannot send a direct report to yourself.'),
            ]);
        }

        $allowedRecipientIds = $this->directRecipientOptions(Auth::user())
            ->pluck('id')
            ->map(fn ($id) => (int) $id);

        if (!$allowedRecipientIds->contains($selectedRecipientUserId)) {
            throw ValidationException::withMessages([
                'recipient_user_id' => __('The selected direct recipient is not allowed for this report.'),
            ]);
        }

        return $selectedRecipientUserId;
    }

    protected function canViewFeedback(ChurchFeedback $feedback): bool
    {
        return $this->visibleFeedbackQuery()
            ->whereKey($feedback->id)
            ->exists();
    }

    protected function canEditFeedback(ChurchFeedback $feedback): bool
    {
        $user = Auth::user();

        if (!$user || !$user->isAbleTo('feedback edit')) {
            return false;
        }

        if ($user->isAbleTo('feedback view all')) {
            return true;
        }

        return (int) $feedback->submitted_by === (int) $user->id;
    }

    protected function canDeleteFeedback(ChurchFeedback $feedback): bool
    {
        $user = Auth::user();

        if (!$user || !$user->isAbleTo('feedback delete')) {
            return false;
        }

        if ($user->isAbleTo('feedback view all')) {
            return true;
        }

        return (int) $feedback->submitted_by === (int) $user->id;
    }

    protected function canReviewFeedback(ChurchFeedback $feedback): bool
    {
        $user = Auth::user();

        if (!$user || !$user->isAbleTo('feedback review')) {
            return false;
        }

        if ($user->isAbleTo('feedback view all')) {
            return true;
        }

        if ($feedback->recipient_user_id) {
            return (int) $feedback->recipient_user_id === (int) $user->id;
        }

        return $this->canViewFeedback($feedback);
    }

    protected function notifyDepartmentWhatsapp(ChurchFeedback $feedback): void
    {
        if ($feedback->recipient_user_id) {
            return;
        }

        $dashboardUrl = route('feedback.index');
        $submitter = $feedback->is_anonymous ? __('Anonymous') : ($feedback->name ?: __('Unknown'));
        $summary = data_get($feedback->attendance_summary, 'present_count', 0) . '/' . data_get($feedback->attendance_summary, 'total_members', 0);
        $message = "📢 New Weekly Report Submitted\n\n"
            . "Title: {$feedback->title}\n"
            . "Attendance: {$summary}\n"
            . "Submitted By: {$submitter}\n\n"
            . "Dashboard:\n{$dashboardUrl}";

        if (!$feedback->department || $feedback->department->whatsappGroups->isEmpty()) {
            return;
        }

        foreach ($feedback->department->whatsappGroups as $group) {
            try {
                \Workdo\Churchly\Helpers\WhatsAppNotifier::sendToGroup($group->group_id, $message);
            } catch (\Throwable $exception) {
                // Keep report submission successful even when notification delivery fails.
            }
        }
    }
}
