<?php

namespace Workdo\Churchly\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Workdo\Churchly\Entities\ChurchMember;
use Workdo\Churchly\Entities\MemberNote;

class MemberNoteController extends Controller
{
    public function index()
    {
        if (!Auth::user() || !Auth::user()->isAbleTo('church_member_note manage')) {
            abort(403, __('Permission denied.'));
        }

        $notes = MemberNote::with(['member', 'author'])
            ->where('workspace', getActiveWorkSpace())
            ->latest()
            ->paginate(20);

        $members = ChurchMember::forWorkspace()
            ->createdBy()
            ->orderBy('name')
            ->pluck('name', 'id');

        return view('churchly::care.notes.index', compact('notes', 'members'));
    }

    public function storeGlobal(Request $request)
    {
        if (!Auth::user() || !Auth::user()->isAbleTo('church_member_note manage')) {
            abort(403, __('Permission denied.'));
        }

        $data = $request->validate([
            'member_id' => 'required|exists:church_members,id',
            'title' => 'nullable|string|max:191',
            'body' => 'required|string',
            'visibility' => 'required|in:staff,pastoral,leaders,private',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|string|max:50',
            'requires_attention' => 'boolean',
        ]);

        $member = ChurchMember::forWorkspace()->findOrFail($data['member_id']);

        $this->createNote($member, $data);

        return redirect()
            ->route('churchly.care.notes.index')
            ->with('success', __('Note added to member profile.'));
    }

    public function store(Request $request, ChurchMember $member)
    {
        $this->authorizeMember($member);

        $data = $request->validate([
            'title' => 'nullable|string|max:191',
            'body' => 'required|string',
            'visibility' => 'required|in:staff,pastoral,leaders,private',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|string|max:50',
            'requires_attention' => 'boolean',
        ]);

        $this->createNote($member, $data);

        return back()->with('success', __('Note added to member profile.'));
    }

    public function update(Request $request, ChurchMember $member, MemberNote $note)
    {
        $this->authorizeMember($member);
        $this->ensureNoteBelongsToMember($member, $note);

        $data = $request->validate([
            'title' => 'nullable|string|max:191',
            'body' => 'required|string',
            'visibility' => 'required|in:staff,pastoral,leaders,private',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|string|max:50',
            'requires_attention' => 'boolean',
        ]);

        $note->update([
            'title' => $data['title'] ?? null,
            'body' => $data['body'],
            'visibility' => $data['visibility'],
            'tags' => $data['tags'] ?? null,
            'requires_attention' => $data['requires_attention'] ?? false,
        ]);

        return back()->with('success', __('Note updated.'));
    }

    public function destroy(ChurchMember $member, MemberNote $note)
    {
        $this->authorizeMember($member);
        $this->ensureNoteBelongsToMember($member, $note);

        $note->delete();

        return back()->with('success', __('Note removed.'));
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

    protected function ensureNoteBelongsToMember(ChurchMember $member, MemberNote $note): void
    {
        if ($note->member_id !== $member->id) {
            abort(404, __('Note does not belong to this member.'));
        }
    }

    protected function createNote(ChurchMember $member, array $data): MemberNote
    {
        return MemberNote::create([
            'member_id' => $member->id,
            'author_id' => Auth::id(),
            'title' => $data['title'] ?? null,
            'body' => $data['body'],
            'visibility' => $data['visibility'],
            'tags' => $data['tags'] ?? null,
            'requires_attention' => $data['requires_attention'] ?? false,
            'workspace' => getActiveWorkSpace(),
        ]);
    }
}
