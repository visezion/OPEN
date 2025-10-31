<?php

namespace Workdo\Churchly\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Workdo\Churchly\Entities\ChurchVolunteer;
use Workdo\Churchly\Entities\ChurchVolunteerTraining;

class VolunteerTrainingController extends Controller
{
    public function store(Request $request, ChurchVolunteer $volunteer)
    {
        $this->authorizeVolunteer($volunteer);

        $data = $this->validateTraining($request);
        $data['volunteer_id'] = $volunteer->id;
        $data['workspace'] = getActiveWorkSpace();
        $data['created_by'] = creatorId();

        ChurchVolunteerTraining::create($data);

        return back()->with('success', __('Training record added.'));
    }

    public function update(Request $request, ChurchVolunteer $volunteer, ChurchVolunteerTraining $training)
    {
        $this->authorizeVolunteer($volunteer);
        $this->authorizeTraining($training, $volunteer);

        $data = $this->validateTraining($request, $training->id);
        $training->update($data);

        return back()->with('success', __('Training record updated.'));
    }

    public function destroy(ChurchVolunteer $volunteer, ChurchVolunteerTraining $training)
    {
        $this->authorizeVolunteer($volunteer);
        $this->authorizeTraining($training, $volunteer);

        $training->delete();

        return back()->with('success', __('Training record removed.'));
    }

    protected function validateTraining(Request $request, ?int $trainingId = null): array
    {
        return $request->validate([
            'title' => 'required|string|max:191',
            'provider' => 'nullable|string|max:191',
            'completed_on' => 'nullable|date',
            'valid_until' => 'nullable|date|after_or_equal:completed_on',
            'status' => 'required|in:scheduled,in_progress,completed,expired',
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

    protected function authorizeTraining(ChurchVolunteerTraining $training, ChurchVolunteer $volunteer): void
    {
        if ($training->volunteer_id !== $volunteer->id) {
            abort(403, __('Training record mismatch.'));
        }
    }
}
