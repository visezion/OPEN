<?php

namespace Workdo\Churchly\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Workdo\Churchly\Entities\AttendanceEvent;
use Workdo\Churchly\Entities\ChurchEvent;
use Workdo\Churchly\Entities\ChurchVolunteer;
use Workdo\Churchly\Entities\ChurchVolunteerAssignment;

class VolunteerAssignmentController extends Controller
{
    public function store(Request $request, ChurchVolunteer $volunteer)
    {
        $this->authorizeVolunteer($volunteer);

        $data = $this->validateAssignment($request);
        $data['volunteer_id'] = $volunteer->id;
        $data['workspace'] = getActiveWorkSpace();
        $data['created_by'] = creatorId();
        $data['assignment_label'] = $data['assignment_label'] ?? $this->resolveLabel($data);

        ChurchVolunteerAssignment::create($data);

        return back()->with('success', __('Volunteer assignment added.'));
    }

    public function update(Request $request, ChurchVolunteer $volunteer, ChurchVolunteerAssignment $assignment)
    {
        $this->authorizeVolunteer($volunteer);
        $this->authorizeAssignment($assignment, $volunteer);

        $data = $this->validateAssignment($request, $assignment->id);
        $data['assignment_label'] = $data['assignment_label'] ?? $this->resolveLabel($data);

        $assignment->update($data);

        return back()->with('success', __('Volunteer assignment updated.'));
    }

    public function destroy(ChurchVolunteer $volunteer, ChurchVolunteerAssignment $assignment)
    {
        $this->authorizeVolunteer($volunteer);
        $this->authorizeAssignment($assignment, $volunteer);

        $assignment->delete();

        return back()->with('success', __('Assignment removed.'));
    }

    protected function validateAssignment(Request $request, ?int $assignmentId = null): array
    {
        $rules = [
            'assignment_type' => 'required|in:event,attendance_event,worship_team,service_role',
            'assignment_id' => 'nullable|integer',
            'assignment_label' => 'nullable|string|max:191',
            'role' => 'nullable|string|max:191',
            'scheduled_for' => 'nullable|date',
            'status' => 'required|in:planned,confirmed,completed,cancelled',
            'notes' => 'nullable|string',
        ];

        $data = $request->validate($rules);

        if (in_array($data['assignment_type'], ['event', 'attendance_event'], true)) {
            $request->validate([
                'assignment_id' => 'required|integer|min:1',
            ]);
        }

        return $data;
    }

    protected function resolveLabel(array $data): ?string
    {
        if ($data['assignment_type'] === 'event' && !empty($data['assignment_id'])) {
            $event = ChurchEvent::find($data['assignment_id']);
            return $event?->title ?? $event?->name;
        }

        if ($data['assignment_type'] === 'attendance_event' && !empty($data['assignment_id'])) {
            $attendanceEvent = AttendanceEvent::with('event')->find($data['assignment_id']);
            return $attendanceEvent?->event?->title ?? $attendanceEvent?->event?->name;
        }

        return null;
    }

    protected function authorizeVolunteer(ChurchVolunteer $volunteer): void
    {
        if (!Auth::user() || !Auth::user()->isAbleTo('church_volunteer manage')) {
            abort(403, __('Permission denied.'));
        }

        if ($volunteer->workspace !== getActiveWorkSpace() || $volunteer->created_by !== creatorId()) {
            abort(403, __('Unauthorized volunteer profile.'));
        }
    }

    protected function authorizeAssignment(ChurchVolunteerAssignment $assignment, ChurchVolunteer $volunteer): void
    {
        if ($assignment->volunteer_id !== $volunteer->id) {
            abort(403, __('Assignment mismatch.'));
        }
    }
}
