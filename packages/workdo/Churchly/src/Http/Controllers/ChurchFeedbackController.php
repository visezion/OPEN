<?php

namespace Workdo\Churchly\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\WorkSpace;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
        $defaultWeekEnding = now()->endOfWeek(Carbon::SUNDAY)->toDateString();
        $attendancePreview = $this->buildAttendanceSummary($defaultWeekEnding, $member);

        return view('churchly::feedback.create', compact('attendancePreview', 'defaultWeekEnding'));
    }

    public function store(Request $request)
    {
        $member = $this->resolveChurchMember(Auth::user());

        if (!$member) {
            return redirect()->back()->with('error', __('You are not linked to a church member profile.'));
        }

        $validated = $this->validateReportRequest($request);
        $attendanceSummary = $this->buildAttendanceSummary($validated['week_ending_date'], $member);

        $data = $this->buildReportRecordData($validated, $member, $attendanceSummary);

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('feedback_attachments', 'public');
        }

        $feedback = ChurchFeedback::create($data);

        $this->notifyDepartmentWhatsapp($feedback);

        return redirect()->route('feedback.index')->with('success', __('Weekly report submitted successfully.'));
    }

    public function edit($id)
    {
        if (!Auth::user()->isAbleTo('feedback edit')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $feedback = $this->findFeedbackFromEncryptedId($id);
        if (!$feedback) {
            return redirect()->back()->with('error', __('Invalid report ID.'));
        }

        $member = $this->resolveChurchMember(Auth::user());
        $defaultWeekEnding = optional($feedback->week_ending_date)->toDateString() ?? now()->endOfWeek(Carbon::SUNDAY)->toDateString();
        $attendancePreview = $feedback->attendance_summary ?: $this->buildAttendanceSummary($defaultWeekEnding, $member);

        return view('churchly::feedback.edit', compact('feedback', 'attendancePreview', 'defaultWeekEnding'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->isAbleTo('feedback edit')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $feedback = $this->findFeedbackFromEncryptedId($id);
        if (!$feedback) {
            return redirect()->back()->with('error', __('Invalid report ID.'));
        }

        $member = $this->resolveChurchMember(Auth::user());
        if (!$member) {
            return redirect()->back()->with('error', __('You are not linked to a church member profile.'));
        }

        $validated = $this->validateReportRequest($request);
        $attendanceSummary = $this->buildAttendanceSummary($validated['week_ending_date'], $member);
        $data = $this->buildReportRecordData($validated, $member, $attendanceSummary, $feedback);

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

        $attendanceSummary = $feedback->attendance_summary ?: $this->buildAttendanceSummary(
            optional($feedback->week_ending_date)->toDateString(),
            $this->resolveChurchMember($feedback->submitter)
        );

        return view('churchly::feedback.show', compact('feedback', 'attendanceSummary'));
    }

    public function destroy($id)
    {
        if (!Auth::user()->isAbleTo('feedback delete')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $feedback = $this->findFeedbackFromEncryptedId($id);
        if (!$feedback) {
            return redirect()->back()->with('error', __('Invalid report ID.'));
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
        if (!Auth::user()->isAbleTo('feedback review')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $feedback = $this->findFeedbackFromEncryptedId($id, true);
        if (!$feedback) {
            return redirect()->back()->with('error', __('Invalid report ID.'));
        }

        $attendanceSummary = $feedback->attendance_summary ?: $this->buildAttendanceSummary(
            optional($feedback->week_ending_date)->toDateString(),
            $this->resolveChurchMember($feedback->submitter)
        );

        return view('churchly::feedback.review', compact('feedback', 'attendanceSummary'));
    }

    public function updateResponse(Request $request, $id)
    {
        if (!Auth::user()->isAbleTo('feedback review')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $request->validate([
            'admin_response' => 'required|string',
            'status' => 'required|in:pending,reviewed,resolved',
        ]);

        $feedback = ChurchFeedback::findOrFail($id);
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
        ]);

        $member = $this->resolveChurchMember(Auth::user());

        return response()->json(
            $this->buildAttendanceSummary($request->string('week_ending_date')->toString(), $member)
        );
    }

    public function export()
    {
        abort(501, 'Export functionality coming soon.');
    }

    protected function visibleFeedbackQuery()
    {
        $user = Auth::user();
        $member = $this->resolveChurchMember($user);
        $query = ChurchFeedback::with(['department', 'submitter', 'attendanceEvent.event'])
            ->where('workspace_id', getActiveWorkSpace());

        if ($user->isAbleTo('feedback view all')) {
            return $query;
        }

        if ($user->isAbleTo('feedback view branch')) {
            return $query->where('branch_id', $member?->branch_id ?? $user->branch_id);
        }

        if ($user->isAbleTo('feedback view department')) {
            return $query->where('branch_id', $member?->branch_id ?? $user->branch_id)
                ->where('department_id', $this->resolveDepartmentId($member) ?? $user->department_id);
        }

        if ($user->isAbleTo('feedback view own')) {
            return $query->where('submitted_by', $user->id);
        }

        abort(403, 'Unauthorized');
    }

    protected function validateReportRequest(Request $request): array
    {
        return $request->validate([
            'week_ending_date' => 'required|date',
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
        ChurchMember $member,
        array $attendanceSummary,
        ?ChurchFeedback $feedback = null
    ): array {
        $departmentId = $this->resolveDepartmentId($member);
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
            'branch_id' => $member->branch_id,
            'department_id' => $departmentId,
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
            $query->with(['submitter', 'reviewer', 'branch', 'department', 'workspace', 'attendanceEvent.event']);
        }

        return $query->find($id);
    }

    protected function notifyDepartmentWhatsapp(ChurchFeedback $feedback): void
    {
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
