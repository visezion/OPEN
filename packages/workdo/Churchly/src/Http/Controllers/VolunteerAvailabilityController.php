<?php

namespace Workdo\Churchly\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Workdo\Churchly\Entities\ChurchVolunteer;
use Workdo\Churchly\Entities\ChurchVolunteerAvailability;

class VolunteerAvailabilityController extends Controller
{
    public function store(Request $request, ChurchVolunteer $volunteer)
    {
        $this->authorizeVolunteer($volunteer);

        $data = $this->validateAvailability($request);
        $data['volunteer_id'] = $volunteer->id;
        $data['workspace'] = getActiveWorkSpace();
        $data['created_by'] = creatorId();

        ChurchVolunteerAvailability::create($data);

        return back()->with('success', __('Availability slot added.'));
    }

    public function update(Request $request, ChurchVolunteer $volunteer, ChurchVolunteerAvailability $availability)
    {
        $this->authorizeVolunteer($volunteer);
        $this->authorizeAvailability($availability, $volunteer);

        $data = $this->validateAvailability($request, $availability->id);
        $availability->update($data);

        return back()->with('success', __('Availability slot updated.'));
    }

    public function destroy(ChurchVolunteer $volunteer, ChurchVolunteerAvailability $availability)
    {
        $this->authorizeVolunteer($volunteer);
        $this->authorizeAvailability($availability, $volunteer);

        $availability->delete();

        return back()->with('success', __('Availability slot removed.'));
    }

    protected function validateAvailability(Request $request, ?int $availabilityId = null): array
    {
        return $request->validate([
            'day_of_week' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday,flexible',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'effective_from' => 'nullable|date',
            'effective_until' => 'nullable|date|after_or_equal:effective_from',
            'timezone' => 'nullable|string|max:120',
            'notes' => 'nullable|string',
        ]);
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

    protected function authorizeAvailability(ChurchVolunteerAvailability $availability, ChurchVolunteer $volunteer): void
    {
        if ($availability->volunteer_id !== $volunteer->id) {
            abort(403, __('Availability record mismatch.'));
        }
    }
}
