<?php

namespace Workdo\Churchly\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Workdo\Churchly\Entities\MaintenanceLog;
use Workdo\Churchly\Entities\MaintenanceSchedule;
use Workdo\Churchly\Services\MaintenanceScheduleService;

class MaintenanceLogController extends Controller
{
    public function store(Request $request, MaintenanceSchedule $schedule)
    {
        $this->ensureWorkspace($schedule);

        if ($response = $this->ensurePermission('maintenance log manage')) {
            return $response;
        }

        $data = $request->validate([
            'due_date' => 'nullable|date',
            'status' => ['required', Rule::in(['pending', 'in_progress', 'completed', 'overdue', 'cancelled'])],
            'notes' => 'nullable|string',
            'performed_by' => 'nullable|exists:users,id',
            'reported_by' => 'nullable|exists:users,id',
            'cost_incurred' => 'nullable|numeric|min:0',
            'attachments' => 'nullable|string',
        ]);

        $log = MaintenanceLog::create([
            'workspace_id' => $schedule->workspace_id,
            'schedule_id' => $schedule->id,
            'branch_id' => $schedule->branch_id,
            'department_id' => $schedule->department_id,
            'due_date' => $data['due_date'] ?? $schedule->next_due_date,
            'status' => $data['status'],
            'performed_by' => $data['performed_by'] ?? null,
            'reported_by' => $data['reported_by'] ?? null,
            'notes' => $data['notes'] ?? null,
            'cost_incurred' => $data['cost_incurred'] ?? null,
            'attachments' => $data['attachments'] ?? null,
            'created_by' => creatorId(),
            'updated_by' => creatorId(),
        ]);

        if ($log->status === 'completed') {
            $schedule->last_completed_at = now();
            $schedule->next_due_date = MaintenanceScheduleService::nextDueDateFromSchedule($schedule)->toDateString();
            $schedule->save();
        }

        return redirect()->back()->with('success', __('Maintenance log saved.'));
    }

    public function updateStatus(Request $request, MaintenanceLog $log)
    {
        $this->ensureWorkspace($log);

        if ($response = $this->ensurePermission('maintenance log update')) {
            return $response;
        }

        $data = $request->validate([
            'status' => ['required', Rule::in(['pending', 'in_progress', 'completed', 'overdue', 'cancelled'])],
            'started_at' => 'nullable|date',
            'completed_at' => 'nullable|date',
            'notes' => 'nullable|string',
            'performed_by' => 'nullable|exists:users,id',
            'cost_incurred' => 'nullable|numeric|min:0',
        ]);

        $log->update([
            'status' => $data['status'],
            'started_at' => $data['started_at'] ?? $log->started_at,
            'completed_at' => $data['completed_at'] ?? $log->completed_at,
            'notes' => $data['notes'] ?? $log->notes,
            'performed_by' => $data['performed_by'] ?? $log->performed_by,
            'cost_incurred' => $data['cost_incurred'] ?? $log->cost_incurred,
            'updated_by' => creatorId(),
        ]);

        if ($log->status === 'completed') {
            $schedule = $log->schedule;
            $schedule->last_completed_at = now();
            $schedule->next_due_date = MaintenanceScheduleService::nextDueDateFromSchedule($schedule)->toDateString();
            $schedule->save();
        }

        return redirect()->back()->with('success', __('Maintenance log updated.'));
    }

    public function show(MaintenanceLog $log)
    {
        $this->ensureWorkspace($log);

        if ($response = $this->ensurePermission('maintenance log manage')) {
            return $response;
        }

        return view('churchly::maintenance.log', [
            'log' => $log->load(['schedule', 'performedBy', 'reportedBy']),
        ]);
    }

    private function ensureWorkspace($model): void
    {
        if ($model->workspace_id !== getActiveWorkSpace()) {
            abort(404);
        }
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
}
