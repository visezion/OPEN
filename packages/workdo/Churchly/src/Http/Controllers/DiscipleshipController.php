<?php

namespace Workdo\Churchly\Http\Controllers;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Workdo\Churchly\Entities\DiscipleshipStage;
use Workdo\Churchly\Entities\DiscipleshipRequirement;
use Workdo\Churchly\Entities\DiscipleshipMemberProgress;
use Workdo\Churchly\Entities\ChurchMember;
use Workdo\Churchly\Entities\DiscipleshipChecklist;
use Workdo\Churchly\Entities\DiscipleshipApprover;


class DiscipleshipController extends Controller
{
    /**
     * Show all discipleship stages with requirements
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!Auth::user()->isAbleTo('discipleship manage')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $stages = DiscipleshipStage::where('workspace', getActiveWorkSpace())
            ->with('requirements')
            ->orderBy('order')
            ->get();

        return view('churchly::discipleship.index', compact('stages'));
    }

    /**
     * Show a single stage with requirements + checklists
     */
    public function showStage($id)
    {
        $stage = DiscipleshipStage::with('requirements.checklists')->findOrFail($id);
        return view('churchly::discipleship.stage', compact('stage'));
    }

    /**
     * Show the setup wizard form
     */
    public function setupWizard()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!Auth::user()->isAbleTo('discipleship manage')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        return view('churchly::discipleship.setup');
    }

    /**
     * Save a new discipleship pathway (stages + requirements)
     */
    public function saveWizard(Request $request)
    {
        $request->validate([
            'stages' => 'required|array|min:1',
            'stages.*.name' => 'required|string|max:255',
            'stages.*.requirements' => 'nullable|array',
        ]);

        foreach ($request->stages as $order => $stageData) {
            $stage = DiscipleshipStage::create([
                'workspace'   => getActiveWorkSpace(),
                'name'        => $stageData['name'],
                'description' => $stageData['description'] ?? null,
                'order'       => $order + 1,
                'created_by'  => creatorId(),
            ]);

            if (!empty($stageData['requirements'])) {
                foreach ($stageData['requirements'] as $req) {
                    DiscipleshipRequirement::create([
                        'stage_id'         => $stage->id,
                        'type'              => $req['type'] ?? 'self_check', // default if missing
                        'title'            => $req['title'],
                        'description'      => $req['description'] ?? null,
                        'is_mandatory'     => $req['is_mandatory'] ?? true,
                        'points'           => $req['points'] ?? 0,
                        'auto_complete'    => $req['auto_complete'] ?? false,
                        'requires_approval'=> $req['requires_approval'] ?? false,
                        'workspace'        => getActiveWorkSpace(),
                        'created_by'       => creatorId(),
                    ]);
                }
            }
        }

        return redirect()->route('discipleship.index')
            ->with('success', __('Discipleship Pathway setup successfully.'));
    }

    /**
     * Edit a stage
     */
    public function edit($id)
    {
        if (!Auth::check() || !Auth::user()->isAbleTo('discipleship manage')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $stage = DiscipleshipStage::with('requirements')->findOrFail($id);
        return view('churchly::discipleship.edit', compact('stage'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'requirements' => 'nullable|array',
        ]);

        $stage = DiscipleshipStage::findOrFail($id);

        // ✅ Update stage info
        $stage->update([
            'name' => $request->name,
            'description' => $request->description,
            'order' => $request->order ?? $stage->order,
        ]);

        // ✅ Sync requirements
        $existingReqIds = $stage->requirements()->pluck('id')->toArray();
        $submittedReqIds = collect($request->requirements)->pluck('id')->filter()->toArray();

        // Delete removed requirements
        $toDelete = array_diff($existingReqIds, $submittedReqIds);
        if (!empty($toDelete)) {
            DiscipleshipRequirement::whereIn('id', $toDelete)->delete();
        }

        // Update or create requirements
        foreach ($request->requirements ?? [] as $reqData) {
            if (!empty($reqData['id'])) {
                // update existing
                $req = DiscipleshipRequirement::find($reqData['id']);
                if ($req) {
                    $req->update([
                        'title' => $reqData['title'],
                        'type'  => $reqData['type'],
                        'description' => $reqData['description'] ?? null,
                        'is_mandatory' => isset($reqData['is_mandatory']),
                        'requires_approval' => isset($reqData['requires_approval']),
                        'points' => $reqData['points'] ?? 0,
                    ]);
                }
            } else {
                // create new
                DiscipleshipRequirement::create([
                    'stage_id' => $stage->id,
                    'title' => $reqData['title'],
                    'type'  => $reqData['type'],
                    'description' => $reqData['description'] ?? null,
                    'is_mandatory' => isset($reqData['is_mandatory']),
                    'requires_approval' => isset($reqData['requires_approval']),
                    'points' => $reqData['points'] ?? 0,
                    'workspace' => getActiveWorkSpace(),
                    'created_by' => creatorId(),
                ]);
            }
        }

        return redirect()->route('discipleship.index')
            ->with('success', __('Stage and requirements updated successfully.'));
    }

    
    /**
     * Delete a stage + requirements
     */
    public function destroy($id)
    {
        if (!Auth::user()->isAbleTo('discipleship manage')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $stage = DiscipleshipStage::findOrFail($id);

        // Delete requirements under this stage
        $stage->requirements()->delete();
        $stage->delete();

        return redirect()->route('discipleship.index')
            ->with('success', __('Stage deleted successfully.'));
    }



    /////////////////////////////////////////////////////////////////////////////
    //
    //
    //



    public function progress(Request $request)
    {
        if (!Auth::check() || !Auth::user()->isAbleTo('discipleship manage')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $query = DiscipleshipMemberProgress::with(['member','stage','requirement','reviewedBy'])
            ->where('workspace', getActiveWorkSpace());

        // Filters
        if ($request->filled('stage_id')) {
            $query->where('stage_id', $request->stage_id);
        }
        if ($request->filled('member_id')) {
            $query->where('member_id', $request->member_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $progress = $query->orderBy('member_id')->get();
        $stages = DiscipleshipStage::where('workspace', getActiveWorkSpace())->get();
        $members = ChurchMember::where('workspace', getActiveWorkSpace())->get();

        return view('churchly::discipleship.progress', compact('progress','stages','members'));
    }


 
    public function dashboard()
    {
        $workspace = getActiveWorkSpace();

        // --- 1. KPIs ---
        $totalMembers   = ChurchMember::where('workspace', $workspace)->count();
        $totalProgress  = DiscipleshipMemberProgress::where('workspace', $workspace)->count();
        $completed      = DiscipleshipMemberProgress::where('workspace', $workspace)->where('status','completed')->count();
        $pendingApprovals = DiscipleshipMemberProgress::where('workspace',$workspace)->where('status','pending')->count();

        $avgCompletion  = $totalProgress > 0 ? round(($completed / $totalProgress) * 100,1) : 0;

        // --- 2. Stage Funnel ---
        $stages = DiscipleshipStage::withCount([
            'progress as started_count',
            'progress as completed_count' => fn($q)=>$q->where('status','completed')
        ])->where('workspace',$workspace)->orderBy('order')->get();

        // --- 3. Stage Analytics ---
        $stageCompletionRates = $stages->map(fn($s)=>[
            'stage'=>$s->name,
            'completion'=>$s->started_count>0 ? round(($s->completed_count/$s->started_count)*100,1) : 0
        ]);

        // --- 4. Requirement Heatmap ---
        $requirements = DiscipleshipRequirement::withCount([
            'progress as completed_count' => fn($q)=>$q->where('status','completed'),
            'progress as total_count'
        ])->where('workspace',$workspace)->get();
        $reqHeatmap = $requirements->map(fn($r)=>[
            'title'=>$r->title,
            'drop_rate'=>$r->total_count>0 ? 100 - round(($r->completed_count/$r->total_count)*100,1) : 0
        ]);

        // --- 5. Member Leaderboard ---
        $leaderboard = ChurchMember::withCount([
            'progress as points_total' => fn($q)=>$q->select(\DB::raw('COALESCE(SUM(points),0)'))
        ])->orderByDesc('points_total')->limit(10)->get();

        // --- 6. At-Risk Members ---
        $stalledMembers = DiscipleshipMemberProgress::with('member','stage')
            ->where('workspace',$workspace)
            ->where('status','in_progress')
            ->where('updated_at','<', now()->subDays(30))
            ->get();

        // --- 7. Mentor Analytics ---
        $mentors = ChurchMember::withCount([
            'discipleshipReviews as approvals_count'
        ])->orderByDesc('approvals_count')->get();

        // --- 8. Department Metrics ---
        $deptStats = ChurchMember::select('department_id',\DB::raw('COUNT(*) as total'))
            ->where('workspace',$workspace)->groupBy('department_id')->get();

        // --- 9. Timeline ---
        $timeline = DiscipleshipMemberProgress::select(
            \DB::raw('DATE(completed_at) as date'),
            \DB::raw('COUNT(*) as total')
        )->where('workspace',$workspace)
        ->whereNotNull('completed_at')
        ->groupBy('date')->orderBy('date')->get();

        // --- 10. Suggestions ---
        $suggestions = [];
        if($stalledMembers->count() > 0) $suggestions[] = "Send reminders to {$stalledMembers->count()} stalled members";
        if($pendingApprovals > 0) $suggestions[] = "Review {$pendingApprovals} pending approvals";
        if($completed > 0) $suggestions[] = "Generate certificates for {$completed} completed requirements";

        return view('churchly::discipleship.dashboard', compact(
            'totalMembers','totalProgress','completed','pendingApprovals','avgCompletion',
            'stages','stageCompletionRates','reqHeatmap','leaderboard',
            'stalledMembers','mentors','deptStats','timeline','suggestions'
        ));
    }



    /**
     * Member view: My Discipleship Journey
     */
    public function myJourney()
    {
        $user = Auth::user();

        // Get church member record tied to this user
        $member = ChurchMember::where('user_id', $user->id)
            ->where('workspace', getActiveWorkSpace())
            ->with(['progress.requirement', 'progress.stage'])
            ->first();

        if (!$member) {
            return redirect()->route('discipleship.dashboard')
                ->with('error', __('You are not registered as a church member.'));
        }

        $stages = DiscipleshipStage::where('workspace', getActiveWorkSpace())
            ->with('requirements')
            ->orderBy('order')
            ->get();

        return view('churchly::discipleship.my_journey', compact('member', 'stages'));
    }

    /**
     * Submit a requirement (mark done, upload file, write testimony, etc.)
     */

    /**
     * Submit requirement by member
     */
    public function submitRequirement(Request $request, $requirementId)
    {
        $user = Auth::user();
        $member = ChurchMember::where('user_id', $user->id)
            ->where('workspace', getActiveWorkSpace())
            ->firstOrFail();

        $requirement = DiscipleshipRequirement::findOrFail($requirementId);

        $progress = DiscipleshipMemberProgress::firstOrNew([
            'member_id'      => $member->id,
            'stage_id'       => $requirement->stage_id,
            'requirement_id' => $requirement->id,
            'workspace'      => getActiveWorkSpace(),
        ]);

        $progress->status = 'pending';

        // If requirement requires approval → set status + assign approver
        if ($requirement->requires_approval) {
            $progress->status = 'in_review';

            $approver = $this->findApprover($member, $requirement);
            if ($approver) {
                $progress->reviewed_by = $approver->user_id;
            }
        } else {
            // fallback: assign to any global admin if needed
            $progress->reviewed_by = User::role('admin')->first()?->id;
            $progress->status = 'completed';
            $progress->completed_at = now();
        }

        // Optional: handle evidence (file/text)
        if ($requirement->type === 'file_upload' && $request->hasFile('evidence')) {
            $path = $request->file('evidence')->store('discipleship/evidence', 'public');
            $progress->evidence = $path;
        } elseif ($requirement->type === 'custom_text' && $request->filled('evidence')) {
            $progress->evidence = $request->input('evidence');
        }

        $progress->save();

        return back()->with('success', __('Requirement submitted successfully.'));
    }

    /**
     * Find approver based on branch, department, or stage
     */
    protected function findApprover($member, $requirement)
    {
        $workspace = getActiveWorkSpace();

        // check stage first
        $stageApprover = DiscipleshipApprover::where('workspace', $workspace)
            ->where('scope', 'stage')
            ->where('reference_id', $requirement->stage_id)
            ->first();
        if ($stageApprover) return $stageApprover;

        // then department
        $deptApprover = DiscipleshipApprover::where('workspace', $workspace)
            ->where('scope', 'department')
            ->where('reference_id', $member->department_id)
            ->first();
        if ($deptApprover) return $deptApprover;

        // then branch
        $branchApprover = DiscipleshipApprover::where('workspace', $workspace)
            ->where('scope', 'branch')
            ->where('reference_id', $member->branch_id)
            ->first();
        if ($branchApprover) return $branchApprover;

        return null; // no approver found
    }



    public function approvals()
{
    $workspace = getActiveWorkSpace();

    $query = DiscipleshipMemberProgress::with(['member','stage','requirement'])
        ->where('workspace', $workspace)
        ->where('status', 'in_review');


    
    // Only restrict by approver if not admin
    if (!User::where('type','company')->where('id',Auth::id())->exists()) {
        $query->where('reviewed_by', Auth::id());
    }

    $pendingProgress = $query->orderBy('created_at','desc')->get();

    return view('churchly::discipleship.requirements.approval', compact('pendingProgress'));
}



    public function reviewRequirement(Request $request, $progressId)
{
    $progress = DiscipleshipMemberProgress::findOrFail($progressId);

    $action = $request->input('action'); // approve | reject

    if ($action === 'approve') {
        $progress->status = 'approved';
        $progress->completed_at = now();
        $progress->reviewed_by = Auth::id();
    } elseif ($action === 'reject') {
        $progress->status = 'rejected';
        $progress->reviewed_by = Auth::id();
    }

    $progress->save();

    // check stage completion → award badge
    $this->checkAndAwardBadge($progress->member_id, $progress->stage_id);

    return redirect()->back()->with('success', __('Requirement reviewed successfully.'));
}



//////////////////////////////////////////////////////////////



    /**
     * Show approver assignments (admin)
     */
    public function approversIndex()
    {
        $workspace = getActiveWorkSpace();
        $approvers = DiscipleshipApprover::with('user')->where('workspace',$workspace)->get();
        $users = User::all();
        $branches = \Workdo\Churchly\Entities\ChurchBranch::where('workspace',$workspace)->get();
        $departments = \Workdo\Churchly\Entities\ChurchDepartment::where('workspace',$workspace)->get();
        $stages = DiscipleshipStage::where('workspace',$workspace)->get();

        return view('churchly::discipleship.approvers.index', compact(
            'approvers','users','branches','departments','stages'
        ));
    }

    /**
     * Store a new approver assignment
     */
    public function approversStore(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'scope' => 'required|in:branch,department,stage',
            'reference_id' => 'required|integer',
        ]);

        DiscipleshipApprover::create([
            'user_id' => $request->user_id,
            'scope' => $request->scope,
            'reference_id' => $request->reference_id,
            'workspace' => getActiveWorkSpace(),
        ]);

        return back()->with('success', __('Approver assigned successfully.'));
    }

    /**
     * Delete approver assignment
     */
    public function approversDestroy($id)
    {
        $approver = DiscipleshipApprover::findOrFail($id);
        $approver->delete();

        return back()->with('success', __('Approver removed successfully.'));
    }



    protected function checkAndAwardBadge($memberId, $stageId)
    {
        $stage = DiscipleshipStage::with('requirements')->find($stageId);

        $completedCount = DiscipleshipMemberProgress::where('member_id', $memberId)
            ->where('stage_id', $stageId)
            ->whereIn('status', ['approved', 'completed'])
            ->count();

        if ($completedCount >= $stage->requirements->count()) {
            // award badge
            DiscipleshipMemberProgress::where('member_id', $memberId)
                ->where('stage_id', $stageId)
                ->update(['badge_awarded' => 1]);
        }
    }


}




