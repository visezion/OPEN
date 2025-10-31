<?php

namespace Workdo\Churchly\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Workdo\Churchly\Entities\ChurchVolunteerSkill;
use App\Http\Requests\VolunteerSkillRequest; // Assuming you'll create this form request

class VolunteerSkillController extends Controller
{
    // Constructor for Auth Dependency Injection
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user(); // Store the logged-in user in the controller
            return $next($request);
        });
    }

    public function index()
    {
        $this->ensurePermission('church_volunteer manage');

        $skills = ChurchVolunteerSkill::forWorkspace()
            ->withCount('volunteers')
            ->orderBy('name')
            ->paginate(15);

        return view('churchly::volunteers.skills.index', compact('skills'));
    }

    public function create()
    {
        $this->ensurePermission('church_volunteer create');

        return view('churchly::volunteers.skills.form', ['skill' => new ChurchVolunteerSkill()]);
    }

    public function store(VolunteerSkillRequest $request)
    {
        $this->ensurePermission('church_volunteer create');

        $data = $request->validated();  // Use validated data from FormRequest
        ChurchVolunteerSkill::create($data);

        return redirect()
            ->route('churchly.volunteer-skills.index')
            ->with('success', __('Skill created.'));
    }

    public function edit(ChurchVolunteerSkill $skill)
    {
        $this->ensurePermission('church_volunteer manage');
        $this->checkWorkspace($skill);

        // Ensure the skill is valid for the workspace
        if (!$this->checkWorkspace($skill)) {
            return redirect()->route('churchly.volunteer-skills.index')->with('error', __('Unauthorized skill reference.'));
        }

        return view('churchly::volunteers.skills.form', compact('skill'));
    }

    public function update(VolunteerSkillRequest $request, ChurchVolunteerSkill $skill)
    {
        $this->ensurePermission('church_volunteer manage');
        $this->checkWorkspace($skill);

        // Validate and update the skill
        $data = $request->validated();
        $skill->update($data);

        return redirect()
            ->route('churchly.volunteer-skills.index')
            ->with('success', __('Skill updated.'));
    }

    public function destroy(ChurchVolunteerSkill $skill)
    {
        $this->ensurePermission('church_volunteer manage');
        $this->checkWorkspace($skill);

        try {
            $skill->delete();
            return redirect()
                ->route('churchly.volunteer-skills.index')
                ->with('success', __('Skill removed.'));
        } catch (\Exception $e) {
            return redirect()->route('churchly.volunteer-skills.index')
                ->with('error', __('An error occurred while removing the skill.'));
        }
    }

    protected function checkWorkspace(ChurchVolunteerSkill $skill): bool
    {
        $workspace = getActiveWorkSpace();
        if (!is_null($skill->workspace) && $skill->workspace !== $workspace) {
            abort(403, __('Unauthorized skill reference.'));
        }

        return true;
    }

    protected function ensurePermission(string $permission): void
    {
        if (!isset($this->user) || !$this->user->isAbleTo($permission)) {
            abort(403, __('Permission denied.'));
        }
    }
}
