<?php

namespace Workdo\Churchly\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Workdo\Churchly\Entities\ChurchMember;
use Workdo\Churchly\Entities\MemberFollowUp;

class MemberFollowUpController extends Controller
{
    public function index()
    {
        if (!Auth::user() || !Auth::user()->isAbleTo('church_member_followup manage')) {
            abort(403, __('Permission denied.'));
        }

        $followups = MemberFollowUp::with(['member', 'assignee'])
            ->where('workspace', getActiveWorkSpace())
            ->orderByRaw("FIELD(status,'open','in_progress','completed','cancelled')")
            ->orderByDesc('created_at')
            ->paginate(20);

        $members = ChurchMember::forWorkspace()
            ->createdBy()
            ->orderBy('name')
            ->pluck('name', 'id');

        $careTeamUsers = User::orderBy('name')->pluck('name', 'id');

        return view('churchly::care.followups.index', compact('followups', 'members', 'careTeamUsers'));
    }

    public function storeGlobal(Request $request)
    {
        if (!Auth::user() || !Auth::user()->isAbleTo('church_member_followup manage')) {
            abort(403, __('Permission denied.'));
        }

        $data = $request->validate([
            'member_id' => 'required|exists:church_members,id',
            'subject' => 'required|string|max:191',
            'description' => 'nullable|string',
            'due_at' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
            'status' => ['required', Rule::in(['open', 'in_progress', 'completed', 'cancelled'])],
        ]);

        $member = ChurchMember::forWorkspace()->findOrFail($data['member_id']);

        $followUp = MemberFollowUp::create([
            'member_id' => $member->id,
            'subject' => $data['subject'],
            'description' => $data['description'] ?? null,
            'due_at' => $data['due_at'] ?? null,
            'status' => $data['status'],
            'assigned_to' => $data['assigned_to'] ?? null,
            'created_by' => Auth::id(),
            'workspace' => getActiveWorkSpace(),
        ]);

        if ($followUp->status === 'completed') {
            $followUp->completed_at = now();
            $followUp->save();
        }

        return redirect()->route('churchly.care.followups.index')
            ->with('success', __('Follow-up created.'));
    }

    public function store(Request $request, ChurchMember $member)
    {
        $this->authorizeMember($member);

        $data = $request->validate([
            'subject' => 'required|string|max:191',
            'description' => 'nullable|string',
            'due_at' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
            'status' => ['nullable', Rule::in(['open', 'in_progress', 'completed', 'cancelled'])],
        ]);

        MemberFollowUp::create([
            'member_id' => $member->id,
            'subject' => $data['subject'],
            'description' => $data['description'] ?? null,
            'due_at' => $data['due_at'] ?? null,
            'status' => $data['status'] ?? 'open',
            'assigned_to' => $data['assigned_to'] ?? null,
            'created_by' => Auth::id(),
            'workspace' => getActiveWorkSpace(),
        ]);

        return back()->with('success', __('Follow-up created.'));
    }

    public function update(Request $request, ChurchMember $member, MemberFollowUp $followUp)
    {
        $this->authorizeMember($member);
        $this->ensureFollowUpBelongsToMember($member, $followUp);

        $data = $request->validate([
            'subject' => 'required|string|max:191',
            'description' => 'nullable|string',
            'due_at' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
            'status' => ['required', Rule::in(['open', 'in_progress', 'completed', 'cancelled'])],
        ]);

        $followUp->fill([
            'subject' => $data['subject'],
            'description' => $data['description'] ?? null,
            'due_at' => $data['due_at'] ?? null,
            'status' => $data['status'],
            'assigned_to' => $data['assigned_to'] ?? null,
        ]);

        if ($data['status'] === 'completed' && !$followUp->completed_at) {
            $followUp->completed_at = now();
        }

        if ($data['status'] !== 'completed') {
            $followUp->completed_at = null;
        }

        $followUp->save();

        return back()->with('success', __('Follow-up updated.'));
    }

    public function destroy(ChurchMember $member, MemberFollowUp $followUp)
    {
        $this->authorizeMember($member);
        $this->ensureFollowUpBelongsToMember($member, $followUp);

        $followUp->delete();

        return back()->with('success', __('Follow-up removed.'));
    }

    protected function authorizeMember(ChurchMember $member): void
    {
        if (!Auth::user() || !Auth::user()->isAbleTo('church_member manage')) {
            abort(403, __('Permission denied.'));
        }

        if ($member->workspace != getActiveWorkSpace()) {
            abort(403, __('Member outside current workspace.'));
        }
    }

    protected function ensureFollowUpBelongsToMember(ChurchMember $member, MemberFollowUp $followUp): void
    {
        if ($followUp->member_id !== $member->id) {
            abort(404, __('Follow-up does not belong to this member.'));
        }
    }
}
