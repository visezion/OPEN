<?php

namespace Workdo\Churchly\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Workdo\Churchly\Entities\ChurchMember;
use Workdo\Churchly\Entities\MemberCommunication;

class MemberCommunicationController extends Controller
{
    public function index()
    {
        if (!Auth::user() || !Auth::user()->isAbleTo('church_member_communication manage')) {
            abort(403, __('Permission denied.'));
        }

        $communications = MemberCommunication::with(['member', 'sender'])
            ->where('workspace', getActiveWorkSpace())
            ->orderByDesc(\DB::raw('COALESCE(sent_at, created_at)'))
            ->paginate(20);

        $members = ChurchMember::forWorkspace()
            ->createdBy()
            ->orderBy('name')
            ->pluck('name', 'id');

        return view('churchly::care.communications.index', compact('communications', 'members'));
    }

    public function storeGlobal(Request $request)
    {
        if (!Auth::user() || !Auth::user()->isAbleTo('church_member_communication manage')) {
            abort(403, __('Permission denied.'));
        }

        $data = $request->validate([
            'member_id' => 'required|exists:church_members,id',
            'channel' => 'required|string|max:50',
            'subject' => 'nullable|string|max:191',
            'body' => 'nullable|string',
            'sent_at' => 'nullable|date',
        ]);

        $member = ChurchMember::forWorkspace()->findOrFail($data['member_id']);

        MemberCommunication::create([
            'member_id' => $member->id,
            'channel' => $data['channel'],
            'subject' => $data['subject'] ?? null,
            'body' => $data['body'] ?? null,
            'meta' => null,
            'sent_at' => $data['sent_at'] ?? now(),
            'sent_by' => Auth::id(),
            'workspace' => getActiveWorkSpace(),
        ]);

        return redirect()->route('churchly.care.communications.index')
            ->with('success', __('Communication logged.'));
    }

    public function store(Request $request, ChurchMember $member)
    {
        $this->authorizeMember($member);

        $data = $request->validate([
            'channel' => 'required|string|max:50',
            'subject' => 'nullable|string|max:191',
            'body' => 'nullable|string',
            'sent_at' => 'nullable|date',
            'meta' => 'nullable|array',
        ]);

        MemberCommunication::create([
            'member_id' => $member->id,
            'channel' => $data['channel'],
            'subject' => $data['subject'] ?? null,
            'body' => $data['body'] ?? null,
            'meta' => $data['meta'] ?? null,
            'sent_at' => $data['sent_at'] ?? now(),
            'sent_by' => Auth::id(),
            'workspace' => getActiveWorkSpace(),
        ]);

        return back()->with('success', __('Communication logged on member timeline.'));
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
}


