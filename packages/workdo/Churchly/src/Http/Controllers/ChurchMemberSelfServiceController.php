<?php

namespace Workdo\Churchly\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Workspace; // or your actual model
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Workdo\Churchly\Entities\ChurchMember;
use Workdo\Churchly\Entities\ChurchBranch;
use Workdo\Churchly\Entities\ChurchDepartment;
use Workdo\Churchly\Entities\ChurchDesignation;
use Workdo\Churchly\Helpers\ChurchHelper;
use Illuminate\Support\Facades\Hash;

class ChurchMemberSelfServiceController extends Controller
{
    /**
     * Show the self-registration form for a given church workspace.
     */
    public function showForm($workspace)
    {

       

        $workspaceId = ChurchHelper::getWorkspaceIdBySlug($workspace);

        if (!$workspaceId) {
            abort(404, 'Invalid church workspace');
        }

        $branches = ChurchBranch::where('workspace', $workspaceId)->pluck('name', 'id');
        $departments = ChurchDepartment::where('workspace', $workspaceId)->pluck('name', 'id');
        $designations = ChurchDesignation::where('workspace', $workspaceId)->pluck('name', 'id');

        return view('churchly::members.self-register', compact('branches', 'workspace', 'departments', 'designations'));
    }

    /**
     * Handle the self-registration submission.
     */
    public function store(Request $request, $workspace)
    {
        $workspaceId = ChurchHelper::getWorkspaceIdBySlug($workspace);
        $workspaceSlug = $request->route('workspace'); // 'cce' from route
        $workspace = Workspace::where('slug', $workspaceSlug)->first();
        $memberId = ChurchMember::generateMemberId();
        if (!$workspace) {
            abort(404, 'Invalid workspace');
        }
        $workspaceId = $workspace->id;
       

        if (!$workspaceId) {
            abort(404, 'Invalid church workspace');
        }
        $roles  = Role::where('created_by', creatorId())->where('id', $request->role)->first();
        $request->validate([
            'name'               => 'required|string|max:255',
            'email'              => 'required|email|max:255|unique:church_members,email',
            'phone'              => 'nullable|string|max:20',
            'dob'                => 'nullable|date|before:today',
            'gender'             => 'required|in:Male,Female,Other',
            'branch_id'          => 'required|exists:church_branches,id',
            'department_id'      => 'nullable|exists:church_departments,id',
            'designation_id'     => 'nullable|exists:church_designations,id',
            'address'            => 'nullable|string|max:500',
            'church_doj'         => 'nullable|date',
            'emergency_contact'  => 'required|string|max:255',
            'emergency_phone'    => 'required|string|max:20',
            'documents'          => 'nullable|file|max:2048',
            'password'           => 'nullable|string|min:6',
        ]);

        if (!isset($request->user_id)) {
                $rules['email'] = ['required','email','max:100',
                ];
                $rules['password'] = 'required';
            }


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile_no' => $request['phone'],
            'password' => Hash::make($request->password ?? 'password'),
            'type' => 'NULL',
            'lang' => 'en',
            'workspace_id' => $workspaceId,
            'active_workspace' =>  $workspaceId,
            'created_by' => creatorId(),
            
        ]);
     

        $member = new ChurchMember();
        $member->user_id           = $user->id;
        $member->name              = $request->name;
        $member->email             = $request->email;
        $member->phone             = $request->phone;
        $member->dob               = $request->dob;
        $member->church_doj        = $request->church_doj;
        $member->gender            = $request->gender;
        $member->member_id         = $memberId;
        $member->branch_id         = $request->branch_id;
        $member->department_id     = $request->department_id;
        $member->designation_id    = $request->designation_id;
        $member->address           = $request->address;
        $member->emergency_contact = $request->emergency_contact;
        $member->emergency_phone   = $request->emergency_phone;
        $member->is_active         = 0;
        $member->workspace         = $workspaceId;
        $member->created_by        = ChurchHelper::getWorkspaceCreator($workspaceId);

        if ($request->hasFile('documents')) {
            $member->document = $request->file('documents')->store('church_member_docs');
        }

        $member->save();

        try {
            Mail::raw("Dear {$member->name},\n\nThank you for registering. Your Member ID is {$memberId}.\n\nGod bless you.", function ($msg) use ($member) {
                $msg->to($member->email)
                    ->subject('Church Membership Registration');
            });
        } catch (\Exception $e) {
            logger()->error('Email sending failed: ' . $e->getMessage());
        }

        return redirect()
            ->route('churchly.self.register', $workspace)
            ->with('success', "Thank you for registering. Your Member ID is {$memberId}. Please check your email.");
    }
}
