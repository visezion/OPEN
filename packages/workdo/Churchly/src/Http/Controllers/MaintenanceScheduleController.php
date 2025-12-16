<?php

namespace Workdo\Churchly\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Workdo\Churchly\Entities\ChurchBranch;
use Workdo\Churchly\Entities\ChurchDepartment;
use Workdo\Churchly\Entities\AssetInventory;
use Workdo\Churchly\Entities\MaintenanceCategory;
use Workdo\Churchly\Entities\MaintenanceLog;
use Workdo\Churchly\Entities\MaintenanceSchedule;
use Workdo\Churchly\Exports\MaintenanceScheduleExport;
use Workdo\Churchly\Services\MaintenanceSchedulePdfGenerator;
use Workdo\Churchly\Services\MaintenanceScheduleService;

class MaintenanceScheduleController extends Controller
{
    private array $priorityOptions = [
        'low' => 'Low',
        'medium' => 'Medium',
        'high' => 'High',
        'critical' => 'Critical',
    ];

    private array $frequencyOptions = [
        'one_time' => 'One-time',
        'daily' => 'Daily',
        'weekly' => 'Weekly',
        'monthly' => 'Monthly',
        'quarterly' => 'Quarterly',
        'yearly' => 'Yearly',
        'custom' => 'Custom interval',
    ];

    private array $statusOptions = [
        'active' => 'Active',
        'paused' => 'Paused',
        'completed' => 'Completed',
        'archived' => 'Archived',
    ];

    private array $categoryOptions = [
        'Electrical',
        'HVAC',
        'IT Infrastructure',
        'Plumbing',
        'Building',
        'Vehicles',
        'Audio/Visual',
        'General',
    ];

    private array $filterKeys = ['status', 'priority', 'category', 'branch_id', 'department_id', 'from', 'to'];

    public function index(Request $request)
    {
        $filters = $this->resolveFilters($request);
        $base = $this->applyFilters(
            MaintenanceSchedule::with(['branch', 'department', 'assignedTo'])->forWorkspace(),
            $filters
        );

        $stats = [
            'total_active' => MaintenanceSchedule::forWorkspace()->where('status', 'active')->count(),
            'overdue' => MaintenanceSchedule::forWorkspace()->where('next_due_date', '<', today())->count(),
            'due_this_week' => MaintenanceSchedule::forWorkspace()
                ->whereBetween('next_due_date', [today(), today()->addDays(7)])
                ->count(),
            'completed_this_month' => MaintenanceSchedule::forWorkspace()
                ->where('status', 'completed')
                ->where('updated_at', '>=', now()->startOfMonth())
                ->count(),
        ];

        $schedules = $base->latest('next_due_date')->paginate(15)->withQueryString();

        $branches = ChurchBranch::where('workspace', getActiveWorkSpace())->pluck('name', 'id');
        $departments = ChurchDepartment::where('workspace', getActiveWorkSpace())->pluck('name', 'id');
        $users = User::where('workspace_id', getActiveWorkSpace())->get();

        return view('churchly::maintenance.index', [
            'schedules' => $schedules,
            'filters' => $filters,
            'priorityOptions' => $this->priorityOptions,
            'frequencyOptions' => $this->frequencyOptions,
            'statusOptions' => $this->statusOptions,
            'categoryOptions' => $this->categoryOptions,
            'branches' => $branches,
            'departments' => $departments,
            'assignableUsers' => $users,
            'stats' => $stats,
        ]);
    }

    public function create()
    {
        if ($response = $this->ensurePermission('maintenance schedule create')) {
            return $response;
        }

        return view('churchly::maintenance.create', $this->formDependencies());
    }

    public function store(Request $request)
    {
        if ($response = $this->ensurePermission('maintenance schedule create')) {
            return $response;
        }

        $data = $request->validate([
            'asset_name' => 'required|string|max:191',
            'asset_code' => [
                'nullable',
                'string',
                'max:64',
                Rule::unique('maintenance_schedules')->where('workspace_id', getActiveWorkSpace()),
            ],
            'location' => 'nullable|string|max:255',
            'category' => ['required', Rule::in($this->categoryOptions)],
            'priority' => ['required', Rule::in(array_keys($this->priorityOptions))],
            'frequency_type' => ['required', Rule::in(array_keys($this->frequencyOptions))],
            'frequency_value' => 'nullable|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'estimated_duration_minutes' => 'nullable|integer|min:0',
            'estimated_cost' => 'nullable|numeric|min:0',
            'status' => ['nullable', Rule::in(array_keys($this->statusOptions))],
            'assigned_to' => 'nullable|exists:users,id',
            'branch_id' => 'nullable|exists:church_branches,id',
            'department_id' => 'nullable|exists:church_departments,id',
        ]);

        if (empty($data['asset_code'])) {
            $data['asset_code'] = 'MAINT-' . strtoupper(Str::random(6));
        }

        $data['status'] = $data['status'] ?? 'active';
        $data['workspace_id'] = getActiveWorkSpace();
        $data['created_by'] = creatorId();
        $data['updated_by'] = creatorId();
        $data['next_due_date'] = MaintenanceScheduleService::initialNextDueDate(
            $data['frequency_type'],
            $data['frequency_value'] ?? 1,
            Carbon::parse($data['start_date']),
            $data['end_date'] ?? null
        )->toDateString();

        $schedule = MaintenanceSchedule::create($data);

        MaintenanceLog::create([
            'workspace_id' => $schedule->workspace_id,
            'schedule_id' => $schedule->id,
            'branch_id' => $schedule->branch_id,
            'department_id' => $schedule->department_id,
            'due_date' => $schedule->next_due_date,
            'status' => 'pending',
            'created_by' => creatorId(),
            'updated_by' => creatorId(),
        ]);

        return redirect()->route('maintenance.index')->with('success', __('Maintenance schedule created.'));
    }

    public function show(MaintenanceSchedule $schedule)
    {
        $this->ensureWorkspace($schedule);

        if ($response = $this->ensurePermission('maintenance schedule manage')) {
            return $response;
        }

        $logs = MaintenanceLog::where('schedule_id', $schedule->id)->latest()->paginate(10);

        return view('churchly::maintenance.show', [
            'schedule' => $schedule->load(['branch', 'department', 'assignedTo']),
            'logs' => $logs,
            'statusOptions' => $this->statusOptions,
            'frequencyOptions' => $this->frequencyOptions,
            'assignableUsers' => User::where('workspace_id', getActiveWorkSpace())->pluck('name', 'id'),
        ]);
    }

    public function edit(MaintenanceSchedule $schedule)
    {
        $this->ensureWorkspace($schedule);

        if ($response = $this->ensurePermission('maintenance schedule edit')) {
            return $response;
        }

        return view('churchly::maintenance.edit', array_merge([
            'schedule' => $schedule->load(['branch', 'department', 'assignedTo']),
        ], $this->formDependencies()));
    }

    public function update(Request $request, MaintenanceSchedule $schedule)
    {
        $this->ensureWorkspace($schedule);

        if ($response = $this->ensurePermission('maintenance schedule edit')) {
            return $response;
        }

        $data = $request->validate([
            'asset_name' => 'required|string|max:191',
            'asset_code' => [
                'nullable',
                'string',
                'max:64',
                Rule::unique('maintenance_schedules')
                    ->where('workspace_id', getActiveWorkSpace())
                    ->ignore($schedule->id),
            ],
            'location' => 'nullable|string|max:255',
            'category' => ['required', Rule::in($this->categoryOptions)],
            'priority' => ['required', Rule::in(array_keys($this->priorityOptions))],
            'frequency_type' => ['required', Rule::in(array_keys($this->frequencyOptions))],
            'frequency_value' => 'nullable|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'estimated_duration_minutes' => 'nullable|integer|min:0',
            'estimated_cost' => 'nullable|numeric|min:0',
            'status' => ['nullable', Rule::in(array_keys($this->statusOptions))],
            'assigned_to' => 'nullable|exists:users,id',
            'branch_id' => 'nullable|exists:church_branches,id',
            'department_id' => 'nullable|exists:church_departments,id',
        ]);

        $data['status'] = $data['status'] ?? $schedule->status;
        $data['updated_by'] = creatorId();
        $data['next_due_date'] = MaintenanceScheduleService::calculateNextDueDate(
            $data['frequency_type'],
            $data['frequency_value'] ?? 1,
            Carbon::parse($data['start_date']),
            $data['end_date'] ?? null
        )->toDateString();

        $schedule->update($data);

        return redirect()->route('maintenance.index')->with('success', __('Maintenance schedule updated.'));
    }

    public function destroy(MaintenanceSchedule $schedule)
    {
        $this->ensureWorkspace($schedule);

        if ($response = $this->ensurePermission('maintenance schedule delete')) {
            return $response;
        }

        $schedule->status = 'archived';
        $schedule->save();
        $schedule->delete();

        return redirect()->route('maintenance.index')->with('success', __('Maintenance schedule archived.'));
    }

    public function calendar()
    {
        if ($response = $this->ensurePermission('maintenance schedule manage')) {
            return $response;
        }

        $events = MaintenanceSchedule::forWorkspace()
            ->where('status', '!=', 'archived')
            ->orderBy('next_due_date')
            ->get()
            ->map(function (MaintenanceSchedule $schedule) {
                return [
                    'title' => $schedule->asset_name,
                    'start' => $schedule->next_due_date,
                    'status' => $schedule->status,
                    'url' => route('maintenance.show', $schedule),
                ];
            });

        return view('churchly::maintenance.calendar', [
            'events' => $events,
        ]);
    }

    public function export(Request $request, string $format = 'excel')
    {
        if ($response = $this->ensurePermission('maintenance schedule manage')) {
            return $response;
        }

        $filters = $this->resolveFilters($request);
        $schedules = $this->applyFilters(
            MaintenanceSchedule::with(['branch', 'department', 'assignedTo'])->forWorkspace(),
            $filters
        )
            ->orderBy('next_due_date')
            ->get();

        $timestamp = now()->format('YmdHis');

        if ($format === 'excel') {
            return Excel::download(new MaintenanceScheduleExport($schedules), "maintenance-schedules-{$timestamp}.xlsx");
        }

        if ($format === 'pdf') {
            $pdfContent = (new MaintenanceSchedulePdfGenerator())->generate($schedules);
            return Response::make($pdfContent, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => "attachment; filename=\"maintenance-schedules-{$timestamp}.pdf\"",
            ]);
        }

        abort(404);
    }

    public function print(Request $request)
    {
        if ($response = $this->ensurePermission('maintenance schedule manage')) {
            return $response;
        }

        $filters = $this->resolveFilters($request);
        $schedules = $this->applyFilters(
            MaintenanceSchedule::with(['branch', 'department', 'assignedTo'])->forWorkspace(),
            $filters
        )
            ->orderBy('next_due_date')
            ->get();

        return view('churchly::maintenance.print', [
            'schedules' => $schedules,
            'filters' => $filters,
            'statusOptions' => $this->statusOptions,
            'priorityOptions' => $this->priorityOptions,
            'categoryOptions' => $this->categoryOptions,
        ]);
    }

    private function formDependencies(): array
    {
        return [
            'branches' => ChurchBranch::where('workspace', getActiveWorkSpace())->pluck('name', 'id'),
            'departments' => ChurchDepartment::where('workspace', getActiveWorkSpace())->pluck('name', 'id'),
            'assignableUsers' => User::where('workspace_id', getActiveWorkSpace())->pluck('name', 'id'),
            'priorityOptions' => $this->priorityOptions,
            'frequencyOptions' => $this->frequencyOptions,
            'statusOptions' => $this->statusOptions,
            'categoryOptions' => array_unique(array_merge(
                $this->categoryOptions,
                MaintenanceCategory::forWorkspace()->pluck('name')->toArray()
            )),
            'assetOptions' => AssetInventory::forWorkspace()->orderBy('asset_name')->pluck('asset_name')->unique()->values(),
        ];
    }

    private function resolveFilters(Request $request): array
    {
        return array_merge(array_fill_keys($this->filterKeys, null), $request->only($this->filterKeys));
    }

    private function applyFilters(Builder $query, array $filters): Builder
    {
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }

        if (!empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        if (!empty($filters['branch_id'])) {
            $query->where('branch_id', $filters['branch_id']);
        }

        if (!empty($filters['department_id'])) {
            $query->where('department_id', $filters['department_id']);
        }

        if (!empty($filters['from'])) {
            $query->whereDate('next_due_date', '>=', Carbon::parse($filters['from']));
        }

        if (!empty($filters['to'])) {
            $query->whereDate('next_due_date', '<=', Carbon::parse($filters['to']));
        }

        return $query;
    }

    private function userCanSkipPermissions(): bool
    {
        $user = Auth::user();

        if (! $user) {
            return false;
        }

        return $user->hasRole('company') || $user->type === 'company';
    }

    private function ensurePermission(string $permission)
    {
        if ($this->userCanSkipPermissions() || Auth::user()->can($permission)) {
            return null;
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    private function ensureWorkspace(MaintenanceSchedule $schedule): void
    {
        if ($schedule->workspace_id !== getActiveWorkSpace()) {
            abort(404);
        }
    }
}
