<?php

namespace Workdo\Churchly\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Workdo\Churchly\Entities\ChurchDepartment;
use Workdo\Churchly\Entities\ChurchMember;
use Workdo\Churchly\Entities\ChurchVolunteer;
use Workdo\Churchly\Entities\ChurchVolunteerSkill;
use Workdo\Churchly\Entities\Event;
use Workdo\Churchly\Entities\AttendanceEvent;

class VolunteerController extends Controller
{
    public function index()
    {
        $this->ensurePermission('church_volunteer manage');

        $volunteers = ChurchVolunteer::with(['member', 'departments', 'skills'])
            ->forWorkspace()
            ->createdBy()
            ->latest()
            ->paginate(15);

        $summary = [
            'active' => ChurchVolunteer::forWorkspace()->createdBy()->where('status', 'active')->count(),
            'inactive' => ChurchVolunteer::forWorkspace()->createdBy()->where('status', 'inactive')->count(),
            'paused' => ChurchVolunteer::forWorkspace()->createdBy()->where('status', 'paused')->count(),
        ];

        return view('churchly::volunteers.index', compact('volunteers', 'summary'));
    }

    public function create()
    {
        $this->ensurePermission('church_volunteer create');

        return $this->formResponse(new ChurchVolunteer());
    }

    public function store(Request $request)
    {
        $this->ensurePermission('church_volunteer create');

        $data = $this->validateVolunteer($request);

        return DB::transaction(function () use ($data, $request) {
            $volunteer = ChurchVolunteer::create($data);

            $this->syncDepartments(
                $volunteer,
                $request->input('departments', []),
                $request->input('primary_department')
            );
            $this->syncSkills($volunteer, $request);

            return redirect()
                ->route('churchly.volunteers.show', $volunteer)
                ->with('success', __('Volunteer profile created.'));
        });
    }

    public function show(ChurchVolunteer $volunteer)
    {
        $this->authorizeVolunteer($volunteer);

        $volunteer->load([
            'member',
            'departments',
            'skills',
            'trainings' => function ($query) {
                $query->latest();
            },
            'availabilities' => function ($query) {
                $query->orderBy('day_of_week');
            },
            'assignments' => function ($query) {
                $query->latest();
            },
        ]);

        $skills = ChurchVolunteerSkill::forWorkspace()->where('is_active', true)->orderBy('name')->get();
        $departments = ChurchDepartment::where('workspace', getActiveWorkSpace())
            ->where('created_by', creatorId())
            ->orderBy('name')
            ->get();

        $events = Event::inWorkspace()
            ->orderBy('start_time', 'asc')
            ->take(25)
            ->get();

        $attendanceEvents = AttendanceEvent::where('workspace_id', getActiveWorkSpace())
            ->with('event')
            ->orderBy('created_at', 'desc')
            ->take(25)
            ->get();

        return view('churchly::volunteers.show', compact(
            'volunteer',
            'skills',
            'departments',
            'events',
            'attendanceEvents'
        ));
    }

    public function edit(ChurchVolunteer $volunteer)
    {
        $this->authorizeVolunteer($volunteer);

        return $this->formResponse($volunteer);
    }

    public function update(Request $request, ChurchVolunteer $volunteer)
    {
        $this->authorizeVolunteer($volunteer);

        $data = $this->validateVolunteer($request, $volunteer->id);

        return DB::transaction(function () use ($volunteer, $data, $request) {
            $volunteer->update($data);

            $this->syncDepartments(
                $volunteer,
                $request->input('departments', []),
                $request->input('primary_department')
            );
            $this->syncSkills($volunteer, $request);

            return redirect()
                ->route('churchly.volunteers.show', $volunteer)
                ->with('success', __('Volunteer profile updated.'));
        });
    }

    public function destroy(ChurchVolunteer $volunteer)
    {
        $this->authorizeVolunteer($volunteer);

        $volunteer->delete();

        return redirect()
            ->route('churchly.volunteers.index')
            ->with('success', __('Volunteer removed.'));
    }

    protected function formResponse(ChurchVolunteer $volunteer)
    {
        $members = ChurchMember::forWorkspace()->createdBy()
            ->orderBy('name')
            ->pluck('name', 'id');

        $departments = ChurchDepartment::where('workspace', getActiveWorkSpace())
            ->where('created_by', creatorId())
            ->orderBy('name')
            ->pluck('name', 'id');

        $skills = ChurchVolunteerSkill::forWorkspace()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $selectedDepartments = $volunteer->exists
            ? $volunteer->departments()->pluck('church_departments.id')->toArray()
            : [];

        return view('churchly::volunteers.form', [
            'volunteer' => $volunteer,
            'members' => $members,
            'departments' => $departments,
            'skills' => $skills,
            'selectedDepartments' => $selectedDepartments,
            'primaryDepartment' => optional($volunteer->primary_department)->id,
            'selectedSkills' => $volunteer->skills->mapWithKeys(function ($skill) {
                return [$skill->id => $skill->pivot->proficiency ?? 'intermediate'];
            })->all(),
        ]);
    }

    protected function validateVolunteer(Request $request, ?int $volunteerId = null): array
    {
        $rules = [
            'church_member_id' => 'nullable|exists:church_members,id',
            'full_name' => 'required_without:church_member_id|string|max:191',
            'preferred_name' => 'nullable|string|max:191',
            'email' => 'nullable|email|max:191',
            'phone' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive,paused',
            'joined_at' => 'nullable|date',
            'notes' => 'nullable|string',
            'departments' => 'array',
            'departments.*' => 'exists:church_departments,id',
            'primary_department' => 'nullable|exists:church_departments,id',
            'skills' => 'array',
            'skills.*' => 'exists:church_volunteer_skills,id',
            'skill_levels' => 'array',
            'skill_levels.*' => 'in:beginner,intermediate,advanced,expert',
            'new_skills' => 'array',
            'new_skills.*' => 'string|max:191',
            'new_skills_text' => 'nullable|string',
        ];

        $data = $request->validate($rules);

        if (!empty($data['church_member_id']) && empty($data['full_name'])) {
            $member = ChurchMember::find($data['church_member_id']);
            $data['full_name'] = $member?->name ?? '';
        }

        $data['workspace'] = getActiveWorkSpace();
        $data['created_by'] = creatorId();

        return $data;
    }

    protected function syncDepartments(ChurchVolunteer $volunteer, array $departments, $primary): void
    {
        $departments = array_filter($departments, fn ($value) => !empty($value));
        $syncData = [];
        foreach ($departments as $departmentId) {
            $syncData[$departmentId] = ['is_primary' => (int) $primary === (int) $departmentId];
        }

        $volunteer->departments()->sync($syncData);
    }

    protected function syncSkills(ChurchVolunteer $volunteer, Request $request): void
    {
        $skillIds = $request->input('skills', []);
        $skillLevels = $request->input('skill_levels', []);

        $syncData = [];
        foreach ($skillIds as $skillId) {
            $level = $skillLevels[$skillId] ?? 'intermediate';
            $syncData[$skillId] = ['proficiency' => $level];
        }

        // Handle new skills inline (create if not exists).
        $newSkills = collect($request->input('new_skills', []))
            ->filter()
            ->map(function ($name) {
                return trim($name);
            })
            ->unique()
            ->take(10);

        if ($request->filled('new_skills_text')) {
            $textEntries = collect(preg_split('/[,\\n]+/', $request->input('new_skills_text')))
                ->map(fn ($name) => trim($name))
                ->filter()
                ->take(10);
            $newSkills = $newSkills->merge($textEntries)->unique();
        }

        foreach ($newSkills as $skillName) {
            $skill = ChurchVolunteerSkill::firstOrCreate(
                [
                    'workspace' => getActiveWorkSpace(),
                    'name' => $skillName,
                ],
                [
                    'category' => null,
                    'description' => null,
                    'created_by' => creatorId(),
                ]
            );

            $syncData[$skill->id] = ['proficiency' => 'intermediate'];
        }

        $volunteer->skills()->sync($syncData);
    }

    protected function authorizeVolunteer(ChurchVolunteer $volunteer): void
    {
        $this->ensurePermission('church_volunteer manage');

        if ($volunteer->workspace !== getActiveWorkSpace() || $volunteer->created_by !== creatorId()) {
            abort(403, __('Unauthorized volunteer profile.'));
        }
    }

    protected function ensurePermission(string $permission): void
    {
        if (!Auth::user() || !Auth::user()->isAbleTo($permission)) {
            abort(403, __('Permission denied.'));
        }
    }
}



