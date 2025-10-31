<?php

namespace Workdo\Churchly\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Workdo\Churchly\DataTables\ChurchMemberDataTable;
use Workdo\Churchly\Entities\ChurchBranch;
use Workdo\Churchly\Entities\ChurchDepartment;
use Workdo\Churchly\Entities\ChurchDesignation;
use Workdo\Churchly\Entities\ChurchDocumentType;
use Workdo\Churchly\Entities\ChurchMember;
use Workdo\Churchly\Helpers\ChurchHelper;
use Workdo\Churchly\Entities\ChurchMemberField;
use Workdo\Churchly\Entities\ChurchMemberCustomValue;
use Workdo\Churchly\Entities\ChurchActivityLog;
use Workdo\Churchly\Entities\DiscipleshipStage;
use Workdo\Churchly\Entities\Household;
use Workdo\Churchly\Entities\MemberNote;
use Workdo\Churchly\Entities\MemberFollowUp;
use Workdo\Churchly\Entities\MemberCommunication;
use Workdo\Churchly\Entities\MemberContribution;
use Workdo\Churchly\Entities\SmartTag;



class MemberController extends Controller
{
   public function index(Request $request)
    {
        $workspace = getActiveWorkSpace();
        $query = \Workdo\Churchly\Entities\ChurchMember::with(['departments', 'branch'])
            ->where('workspace', getActiveWorkSpace());

        // ✅ Filter by branch
        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }


        // ✅ Search by name or phone
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $members = $query->paginate(10)->appends($request->all());

        $branches = ChurchBranch::where('workspace', getActiveWorkSpace())->pluck('name', 'id');

       $user = User::where('active_workspace', getActiveWorkSpace())->first();


        return view('churchly::members.index', compact('workspace', 'members', 'branches', 'user'));
    }



    public function create()
    {
        if (!Auth::user()->isAbleTo('church_member create')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        $role      = Role::where('created_by', creatorId())->whereNotIn('name', Auth::user()->not_emp_type)->get()->pluck('name', 'id');
        $branches = ChurchBranch::where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->pluck('name', 'id');
        $departments = ChurchDepartment::where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->pluck('name', 'id');
        $designations = ChurchDesignation::where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->pluck('name', 'id');
        $users = User::where('created_by', creatorId())->where('workspace_id', getActiveWorkSpace())->pluck('name', 'id');
        $memberId = ChurchMember::generateMemberId();
        $customFields = ChurchMemberField::where('workspace', getActiveWorkSpace())->orderBy('order', 'asc')->get();
        $members      = ChurchMember::pluck('name','id');
        return view('churchly::members.create', compact('role','branches', 'departments', 'designations', 'users', 'memberId', 'customFields', 'members'));
    }
    

public function store(Request $request)
{
    $canUse = PlanCheck('User', Auth::user()->id);
    if ($canUse == false) {
        return back()->with('error', 'You have maxed out the total number of Employees allowed on your current plan');
    }

    if (!Auth::user()->isAbleTo('church_member create')) {
        return back()->with('error', __('Permission denied.'));
    }

    $roles = Role::where('created_by', creatorId())
                 ->where('id', $request->role)
                 ->firstOrFail();

    // ✅ Validation
    $rules = [
        'name'      => 'required|string|max:255',
        'email'     => [
            'required','email','max:255',
            Rule::unique('users')->where(fn ($q) =>
                $q->where('created_by', creatorId())
                  ->where('workspace_id', getActiveWorkSpace())
            ),
        ],
        'phone'     => 'nullable|string|max:20',
        'dob'       => 'nullable|date|before:today',
        'gender'    => 'required|in:Male,Female,Other',
        'address'   => 'nullable|string|max:500',

        // one branch always required
        'branch_id' => 'required|exists:church_branches,id',

        // optional multiple departments
        'departments'   => 'nullable|array',
        'departments.*.department_id'  => 'nullable|exists:church_departments,id',
        'departments.*.designation_id' => 'nullable|exists:church_designations,id',

        'church_doj'     => 'nullable|date',
        'password'       => 'nullable|string|min:6',
        'is_active'      => 'nullable|boolean',
        'emergency_contact' => 'required|string|max:255',
        'emergency_phone'   => 'required|string|max:20',
        'family_id'   => 'nullable|exists:church_members,id',
        'spouse_id'   => 'nullable|exists:church_members,id|different:family_id',
        'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png',
    ];
    $request->validate($rules);

    // ✅ Handle profile photo upload
    $profilePhoto = null;
    if ($request->hasFile('profile_photo')) {
        if (!Storage::disk('public')->exists('members/photos')) {
            Storage::disk('public')->makeDirectory('members/photos');
        }
        $profilePhoto = $request->file('profile_photo')->store('members/photos', 'public');
    }

    // ✅ Create linked User first
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'mobile_no' => $request->phone,
        'password' => Hash::make($request->password ?? 'password'),
        'type' => $roles->name,
        'lang' => 'en',
        'workspace_id' => getActiveWorkSpace(),
        'active_workspace' => getActiveWorkSpace(),
        'created_by' => creatorId(),
    ]);

    // ✅ Attach role
    $user->roles()->attach($roles->id, ['user_type' => get_class($user)]);

    // ✅ Now create ChurchMember and link to that User
    $member = ChurchMember::create([
        'user_id'    => $user->id,
        'name'       => $request->name,
        'profile_photo' => $profilePhoto,
        'dob'        => $request->dob,
        'gender'     => $request->gender,
        'phone'      => $request->phone,
        'email'      => $request->email,
        'address'    => $request->address,
        'member_id'  => ChurchMember::generateMemberId(),
        'branch_id'  => $request->branch_id,   // ✅ required branch

        'role_id'    => $request->role,
        'church_doj' => $request->church_doj,
        'membership_status' => $request->membership_status ?? 'Active',
        'family_id'  => $request->family_id,
        'spouse_id'  => $request->spouse_id,
        'emergency_contact' => $request->emergency_contact,
        'emergency_phone'   => $request->emergency_phone,
        'is_active'  => $request->is_active ?? 1,
        'workspace'  => getActiveWorkSpace(),
        'created_by' => creatorId(),
    ]);

    // ✅ Save departments + designations (optional)
    if ($request->filled('departments')) {
        $syncData = [];

        foreach ($request->departments as $dept) {
            if (!empty($dept['department_id'])) {
                $syncData[$dept['department_id']] = [
                    'designation_id' => $dept['designation_id'] ?? null,
                    'workspace'      => getActiveWorkSpace(),
                    'created_by'     => creatorId(),
                ];
            }
        }

        if (!empty($syncData)) {
            $member->departments()->sync($syncData);
        }
    }

    // ✅ Save Custom Field Values
    if ($request->has('custom')) {
        foreach ($request->custom as $key => $value) {
            ChurchMemberCustomValue::create([
                'member_id'   => $member->id,
                'field_id'    => ChurchMemberField::where('field_key', $key)->value('id'),
                'field_key'   => $key,
                'field_value' => is_array($value) ? json_encode($value) : $value,
                'workspace'   => getActiveWorkSpace(),
                'created_by'  => creatorId(),
            ]);
        }
    }

    return redirect()->route('churchly.members.index')
        ->with('success', __('Church member created successfully.'));
}


public function generateQr($id)
{
    $member = \Workdo\Churchly\Entities\ChurchMember::findOrFail($id);
    $member->generateQrCode();

    return back()->with('success', __('QR Code generated successfully.'));
}


public function show($id)
{
    if (!Auth::user()->isAbleTo('church_member show')) {
        return redirect()->back()->with('error', __('Permission denied.'));
    }

    try {
        $memberId = Crypt::decrypt($id);
    } catch (\Throwable $th) {
        return redirect()->back()->with('error', __('Member Not Found.'));
    }

    $workspace = \App\Models\WorkSpace::find(getActiveWorkSpace());
    $workspaceName = $workspace?->name ?? 'Organization';

    $member = ChurchMember::where('id', $memberId)
        ->where('workspace', getActiveWorkSpace())
        ->with(['branch', 'departments', 'designation', 'user'])
        ->first();

    if (!$member) {
        return redirect()->back()->with('error', __('Member Not Found.'));
    }

    $member->load([
        'households.members',
        'notes.author',
        'followUps.assignee',
        'communications.sender',
        'smartTags',
        'contributions',
    ]);

    $households = $member->households;
    $availableHouseholds = Household::forWorkspace()->orderBy('name')->get();
    $memberNotes = MemberNote::where('member_id', $member->id)
        ->with('author')
        ->orderByDesc('created_at')
        ->take(20)
        ->get();
    $memberFollowUps = MemberFollowUp::where('member_id', $member->id)
        ->with('assignee')
        ->orderByRaw("FIELD(status,'open','in_progress','completed','cancelled')")
        ->orderByDesc('created_at')
        ->get();
    $memberCommunications = MemberCommunication::where('member_id', $member->id)
        ->with('sender')
        ->orderByDesc(\DB::raw('COALESCE(sent_at, created_at)'))
        ->take(25)
        ->get();
    $memberContributions = MemberContribution::where('member_id', $member->id)
        ->orderByDesc('received_at')
        ->take(12)
        ->get();
    $availableSmartTags = SmartTag::forWorkspace()->orderBy('name')->withCount('members')->get();
    $careTeamUsers = User::select('id', 'name')->orderBy('name')->get();

    // ✅ Family group
    $familyMembers = ChurchMember::where('family_id', $member->family_id)
        ->with('spouse')
        ->get();

    // ✅ All church members with branch + department
    $allMembers = \DB::table('church_members')
        ->leftJoin('church_branches', 'church_members.branch_id', '=', 'church_branches.id')
        ->leftJoin('church_member_department', 'church_members.id', '=', 'church_member_department.church_member_id')
        ->leftJoin('church_departments', 'church_member_department.department_id', '=', 'church_departments.id')
        ->leftJoin('church_designations', 'church_member_department.designation_id', '=', 'church_designations.id')
        ->where('church_members.workspace', getActiveWorkSpace())
        ->select(
            'church_members.id',
            'church_members.name',
            'church_members.branch_id',
            'church_branches.name as branch',
            'church_departments.id as department_id',
            'church_departments.name as department',
            'church_departments.branch_id as dept_branch_id',   // ✅ department's true branch
            'church_designations.name as designation',
            'church_members.profile_photo'
        )
        ->get();

    //-----------------------------------------
    // ✅ Build nodes + links
    // Hierarchy: member → department → branch → workspace → GOD
    //-----------------------------------------
    $nodes = [];
    $links = [];

    // GOD + Workspace
    $nodes[] = ['id' => 'GOD', 'name' => 'GOD', 'type' => 'god'];
    $nodes[] = ['id' => 'WORKSPACE', 'name' => $workspaceName, 'type' => 'workspace'];
    $links[] = ['source' => 'WORKSPACE', 'target' => 'GOD', 'type' => 'god'];

    // Branch nodes
    $branches = $allMembers->whereNotNull('branch_id')->unique('branch_id');
    foreach ($branches as $b) {
        $nodes[] = [
            'id' => 'branch-'.$b->branch_id,
            'name' => $b->branch,
            'type' => 'branch'
        ];
        $links[] = ['source' => 'branch-'.$b->branch_id, 'target' => 'WORKSPACE', 'type' => 'workspace'];
    }

    // Department nodes (scoped by dept + branch)
    $departments = $allMembers->whereNotNull('department_id')
        ->unique(fn($d) => $d->department_id.'-'.$d->dept_branch_id);

    foreach ($departments as $d) {
        $deptKey = 'dept-'.$d->department_id.'-branch-'.$d->dept_branch_id;

        $nodes[] = [
            'id'   => $deptKey,
            'name' => $d->department,
            'type' => 'department',
            'branch_id' => $d->dept_branch_id,
        ];

        // Connect dept → branch
        $links[] = [
            'source' => $deptKey,
            'target' => 'branch-'.$d->dept_branch_id,
            'type'   => 'branch'
        ];
    }

    // Member nodes
    foreach ($allMembers as $m) {
        $nodes[] = [
            'id'   => 'member-'.$m->id,   // ✅ prefixed
            'name' => $m->name,
            'branch' => $m->branch,
            'department' => $m->department,
            'designation' => $m->designation,
            'photo' => $m->profile_photo
                ? asset('storage/'.$m->profile_photo)
                : 'https://ui-avatars.com/api/?name='.urlencode($m->name),
            'type' => 'member'
        ];

        if ($m->department_id && $m->dept_branch_id) {
            $deptKey = 'dept-'.$m->department_id.'-branch-'.$m->dept_branch_id;
            $links[] = ['source' => 'member-'.$m->id, 'target' => $deptKey, 'type' => 'department'];
        } elseif ($m->branch_id) {
            $links[] = ['source' => 'member-'.$m->id, 'target' => 'branch-'.$m->branch_id, 'type' => 'branch'];
        }
    }

    //-----------------------------------------
    // ✅ Other sections (teams, donations, activities, profile completion, etc.)
    //-----------------------------------------
    $teams = $member->teams ?? collect();
    $donations = collect();
    $donationsMonths = [];
    $donationsAmounts = [];
    $activities = $member->activities()->latest()->take(5)->get() ?? collect();

    $fieldsToCheck = ['name', 'email', 'phone', 'dob', 'gender', 'address', 'emergency_contact', 'emergency_phone'];
    $filled = 0;
    $missingFields = [];
    foreach ($fieldsToCheck as $field) {
        if (!empty($member->$field)) {
            $filled++;
        } else {
            $missingFields[] = ucfirst(str_replace('_', ' ', $field));
        }
    }
    $completion = round(($filled / count($fieldsToCheck)) * 100);

    $birthdayCountdown = null;
    $birthdayDate = null;
    $birthdayMonth = null;
    if ($member->dob) {
        $dob = \Carbon\Carbon::parse($member->dob);
        $nextBirthday = $dob->copy()->year(now()->year);
        if ($nextBirthday->isPast()) {
            $nextBirthday->addYear();
        }
        $birthdayCountdown = now()->diffInDays($nextBirthday, false);
        $birthdayDate = $nextBirthday->format('d M');
        $birthdayMonth = $dob->month;
    }

    $engagementScore = rand(50, 95);
    
    
    //Discipleship path
    $stages = DiscipleshipStage::where('workspace', getActiveWorkSpace())
            ->with('requirements')
            ->orderBy('order')
            ->get();

    return view('churchly::members.show', compact(
        'member',
        'teams',
        'donations',
        'donationsMonths',
        'donationsAmounts',
        'activities',
        'completion',
        'missingFields',
        'birthdayCountdown',
        'birthdayDate',
        'birthdayMonth',
        'engagementScore',
        'familyMembers',
        'nodes',
        'links',
        'workspaceName',
        'stages',
        'households',
        'availableHouseholds',
        'memberNotes',
        'memberFollowUps',
        'memberCommunications',
        'memberContributions',
        'availableSmartTags',
        'careTeamUsers'
    ));
}





public function edit($id)
{
    if (!Auth::user()->isAbleTo('church_member edit')) {
        return redirect()->back()->with('error', __('Permission denied.'));
    }

    try {
        $id = Crypt::decrypt($id);
    } catch (\Throwable $th) {
        return redirect()->back()->with('error', __('Member Not Found.'));
    }

    $member = ChurchMember::with(['departments', 'customValues'])->findOrFail($id);

    $branches = ChurchBranch::where('created_by', creatorId())
        ->where('workspace', getActiveWorkSpace())
        ->pluck('name', 'id');

    $departments = ChurchDepartment::where('created_by', creatorId())
        ->where('workspace', getActiveWorkSpace())
        ->where('branch_id', $member->branch_id)
        ->pluck('name', 'id');

    $designations = ChurchDesignation::where('created_by', creatorId())
        ->where('workspace', getActiveWorkSpace())
        ->whereIn('department_id', $member->departments->pluck('id'))
        ->pluck('name', 'id');

    $users = User::where('created_by', creatorId())
        ->where('workspace_id', getActiveWorkSpace())
        ->pluck('name', 'id');

    $role = Role::where('created_by', creatorId())
        ->whereNotIn('name', Auth::user()->not_emp_type ?? [])
        ->pluck('name', 'id');

    // ✅ FIX: Add members for family/spouse dropdowns
    $members = ChurchMember::where('workspace', getActiveWorkSpace())
        ->where('created_by', creatorId())
        ->pluck('name', 'id');

    $customFields = ChurchMemberField::where('workspace', getActiveWorkSpace())
        ->where('created_by', creatorId())
        ->get();

    return view('churchly::members.edit', compact(
        'member',
        'branches',
        'departments',
        'designations',
        'users',
        'role',
        'members',
        'customFields'
    ));
}



public function update(Request $request, $id)
{
    if (!Auth::user()->isAbleTo('church_member edit')) {
        return redirect()->back()->with('error', __('Permission denied.'));
    }

    $member = ChurchMember::with('departments')->findOrFail($id);

    // Load linked User safely
    $user = User::find($member->user_id);

    // ✅ Validation rules
    $rules = [
        'name' => 'required|string|max:255',
        'email' => [
            'required', 'email', 'max:255',
            Rule::unique('users', 'email')->ignore($user?->id),
        ],
        'phone' => 'nullable|string|max:20',
        'dob' => 'nullable|date|before:today',
        'gender' => 'required|in:Male,Female,Other',
        'address' => 'nullable|string|max:500',
        'branch_id' => 'required|exists:church_branches,id',

        // optional multiple departments
        'departments'   => 'nullable|array',
        'departments.*.department_id'  => 'nullable|exists:church_departments,id',
        'departments.*.designation_id' => 'nullable|exists:church_designations,id',

        'church_doj' => 'nullable|date',
        'password' => 'nullable|string|min:6',
        'role' => 'required|exists:roles,id',
        'emergency_contact' => 'required|string|max:255',
        'emergency_phone'   => 'required|string|max:20',
        'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ];
    $request->validate($rules);

    // ✅ Handle profile photo upload
    if ($request->hasFile('profile_photo')) {
        if (!Storage::disk('public')->exists('members/photos')) {
            Storage::disk('public')->makeDirectory('members/photos');
        }
        $member->profile_photo = $request->file('profile_photo')->store('members/photos', 'public');
    }

    // ✅ Update linked User
    if ($user) {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile_no = $request->phone;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Update role
        $role = Role::where('created_by', creatorId())
            ->where('id', $request->role)
            ->first();

        if ($role) {
            $user->type = $role->name;
            $user->roles()->sync([$role->id => ['user_type' => get_class($user)]]);
        }

        $user->save();
    }

    // ✅ Update ChurchMember (base info)
    $member->fill($request->only([
        'name', 'email', 'phone', 'dob', 'gender', 'address',
        'branch_id', 'church_doj', 'emergency_contact', 'emergency_phone'
    ]));

    $member->is_active = $request->is_active ?? 1;
    $member->role_id   = $request->role;
    $member->save();

    // ✅ Update Departments & Designations
    if ($request->filled('departments')) {
        $syncData = [];

        foreach ($request->departments as $dept) {
            if (!empty($dept['department_id'])) {
                $syncData[$dept['department_id']] = [
                    'designation_id' => $dept['designation_id'] ?? null,
                    'workspace'      => getActiveWorkSpace(),
                    'created_by'     => creatorId(),
                ];
            }
        }

        $member->departments()->sync($syncData);
    } else {
        // if user clears all departments
        $member->departments()->detach();
    }

    // ✅ Update Custom Fields
    if ($request->has('custom')) {
        foreach ($request->custom as $key => $value) {
            ChurchMemberCustomValue::updateOrCreate(
                [
                    'member_id' => $member->id,
                    'field_key' => $key,
                ],
                [
                    'field_id'    => ChurchMemberField::where('field_key', $key)->value('id'),
                    'field_value' => is_array($value) ? json_encode($value) : $value,
                    'workspace'   => getActiveWorkSpace(),
                    'created_by'  => creatorId(),
                ]
            );
        }
    }

    // ✅ Log update activity
    ChurchActivityLog::create([
        'member_id'     => $member->id,
        'activity_type' => 'profile_update',
        'description'   => 'Member profile updated.',
        'related_id'    => $member->id,
        'ip_address'    => request()->ip(),
        'user_agent'    => request()->header('User-Agent'),
        'created_by'    => auth()->id(),
        'workspace_id'  => getActiveWorkSpace(),
    ]);

    return redirect()->route('churchly.members.index')
        ->with('success', __('Church member updated successfully.'));
}



/*
    public function destroy($id)
    {
        if (!Auth::user()->isAbleTo('church_member delete')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $member = ChurchMember::findOrFail($id);
        $member->delete();

        return redirect()->route('churchly.members.index')->with('success', __('Church member deleted successfully.'));
    }*/

    public function fileImportExport()
    {
        if (!Auth::user()->isAbleTo('church_member manage')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        return view('churchly::members.import_export');
    }


    public function fileImport(Request $request)
{
    $request->validate([
        'csv_file' => 'required|mimes:csv,txt|max:2048',
    ]);

    $path = $request->file('csv_file')->getRealPath();

    // Read file into rows
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    $rows = array_map(fn($line) => array_map('trim', str_getcsv($line, ',')), $lines);

    if (count($rows) < 2) {
        return back()->with('error', 'Your CSV file appears empty or missing data.');
    }

    // Extract & normalize headers
    $header = array_map(fn($h) => strtolower(str_replace([' ', '-', '.'], '_', trim($h))), array_shift($rows));

    // ✅ Required columns
    $requiredColumns = $this->requiredColumns;
    $missing = array_diff($requiredColumns, $header);

    if (count($missing) > 0) {
        if (count($missing) > 4) {
            return back()->with('error', "Your CSV is missing several required columns. Please download the sample CSV and restructure your file before uploading.");
        } else {
            return back()->with('error', "Your CSV is missing the following required columns: " . implode(', ', $missing) . ". Please fix your file or download the sample CSV.");
        }
    }

    // Align rows with headers
    $data = [];
    foreach ($rows as $row) {
        if (count($row) < count($header)) {
            $row = array_pad($row, count($header), null);
        } elseif (count($row) > count($header)) {
            $row = array_slice($row, 0, count($header));
        }
        $combined = @array_combine($header, $row);
        if ($combined) {
            $data[] = $combined;
        }
    }

    if (empty($data)) {
        return back()->with('error', 'No valid rows found in CSV file.');
    }

    // ✅ Save rows in session
    session(['import_rows' => $data]);

    // Redirect to preview
    return redirect()->route('members.import.preview');
}





    public function fileImportModal()
    {
        return view('churchly::members.import_modal');
    }

public function memberImportData(Request $request)
{
    foreach ($request->rows as $row) {

        // 🔍 Branch
        $branch = ChurchBranch::where('id', $row['branch_id'])
            ->orWhereRaw('LOWER(name) = ?', [strtolower($row['branch_id'])])
            ->first();
        $branchId = $branch ? $branch->id : 9999;

        // 🔍 Department
        $department = ChurchDepartment::where('id', $row['department_id'])
            ->orWhereRaw('LOWER(name) = ?', [strtolower($row['department_id'])])
            ->first();
        $departmentId = $department ? $department->id : 9999;

        // 🔍 Designation
        $designation = ChurchDesignation::where('id', $row['designation_id'])
            ->orWhereRaw('LOWER(name) = ?', [strtolower($row['designation_id'])])
            ->first();
        $designationId = $designation ? $designation->id : 9999;

        // 🔍 Role
        $role = Role::where('id', $row['role_id'])
            ->orWhereRaw('LOWER(name) = ?', [strtolower($row['role_id'])])
            ->first();
        $roleId = $role ? $role->id : 9999;
        $roleName = $role ? $role->name : "Unknown";

        // ✅ Parse dates safely
        $dob = $this->parseDate($row['dob']);
        $churchDoj = $this->parseDate($row['church_doj']);

        // ✅ Generate unique Member ID
        $memberId = ChurchMember::generateMemberId();

        // ✅ 1. Create User first
        $user = User::create([
            'name'           => $row['name'],
            'email'          => $row['email'],
            'mobile_no'      => $row['phone'],
            'password'       => \Illuminate\Support\Facades\Hash::make('password'), // default password
            'type'           => $roleName,
            'lang'           => 'en',
            'workspace_id'   => getActiveWorkSpace(),
            'active_workspace' => getActiveWorkSpace(),
            'created_by'     => creatorId(),
        ]);

        // Attach role to user if valid
        if ($roleId !== 9999) {
            $user->roles()->attach($roleId, ['user_type' => get_class($user)]);
        }

        // ✅ 2. Create ChurchMember linked to User
        ChurchMember::create([
            'user_id'         => $user->id,
            'member_id'       => $memberId,
            'name'            => $row['name'],
            'email'           => $row['email'],
            'phone'           => $row['phone'],
            'dob'             => $dob,
            'gender'          => $row['gender'],
            'address'         => $row['address'],
            'branch_id'       => $branchId,
            'department_id'   => $departmentId,
            'designation_id'  => $designationId,
            'church_doj'      => $churchDoj,
            'emergency_contact' => $row['emergency_contact'],
            'emergency_phone'   => $row['emergency_phone'],
            'is_active'       => true, // default active
            'workspace'       => getActiveWorkSpace(),
            'created_by'      => creatorId(),
        ]);
    }

    return redirect()->route('members.index')->with('success', 'Members imported successfully!');
}


private function smartMatch($model, $input, $workspace = true)
{
    if (!$input) {
        return [
            'id' => null,
            'name' => 'Unknown',
            'confidence' => 0,
            'matchType' => 'empty',
            'original' => $input,
            'suggestions' => [],
        ];
    }

    $original = trim($input);
    $input = strtolower($original);

    // 🔄 Normalize input
    $input = preg_replace('/\s+team$/', '', $input); // remove "team"
    $input = rtrim($input, 's'); // remove plural

    // ✅ Alias dictionary (covering all entity types)
    $aliases = [
        // Departments
        'tech'            => 'Technical Department',
        'technical'       => 'Technical Department',
        'technical team'  => 'Technical Department',
        'it'              => 'Technical Department',
        'ict'             => 'Technical Department',
        'media team'      => 'Media Department',
        'media'           => 'Media Department',
        'medias'          => 'Media Department',
        'sound'           => 'Media Department',
        'choir'           => 'Music Department',
        'music team'      => 'Music Department',
        'usher'           => 'Ushering Department',
        'ushers'          => 'Ushering Department',
        'protocol'        => 'Protocol Department',
        'security'        => 'Protocol Department',
        'followup'        => 'Follow-up Department',
        'follow-up'       => 'Follow-up Department',
        'prayer'          => 'Prayer Department',
        'intercessors'    => 'Prayer Department',
        'children'        => 'Children Department',
        'kids'            => 'Children Department',

        // Designations
        'leader'          => 'Leader',
        'pastor'          => 'Pastor',
        'assistant'       => 'Assistant Pastor',
        'member'          => 'Member',
        'members'         => 'Member',
        'director'        => 'Director',

        // Roles
        'churchs'         => 'Church',
        'churc'           => 'Church',
        'admin'           => 'Administrator',

        // Branches (common typos)
        'magisa'          => 'Magusa',
        'magisa'          => 'Magusa',
        'magusa'          => 'Magusa',
        'kyrena'          => 'Kyrenia',
        'kyrenia'         => 'Kyrenia',
    ];

    // ✅ Direct alias match
    if (isset($aliases[$input])) {
        $record = $model::whereRaw('LOWER(name) = ?', [strtolower($aliases[$input])])->first();
        if ($record) {
            return [
                'id' => $record->id,
                'name' => $record->name,
                'confidence' => 80,
                'matchType' => 'alias',
                'original' => $original,
                'suggestions' => [],
            ];
        }
    }

    // ✅ Exact DB match
    $query = $model::query();
    if ($workspace && \Schema::hasColumn((new $model)->getTable(), 'workspace')) {
        $query->where('workspace', getActiveWorkSpace());
    }

    $record = $query->whereRaw('LOWER(name) = ?', [$input])->first();
    if ($record) {
        return [
            'id' => $record->id,
            'name' => $record->name,
            'confidence' => 100,
            'matchType' => 'exact',
            'original' => $original,
            'suggestions' => [],
        ];
    }

    // ✅ Fuzzy matching (Levenshtein + similar_text)
    $all = $model::when(
        $workspace && \Schema::hasColumn((new $model)->getTable(), 'workspace'),
        fn($q) => $q->where('workspace', getActiveWorkSpace())
    )->pluck('name', 'id')->toArray();

    $scores = [];
    foreach ($all as $id => $name) {
        $target = strtolower($name);

        $lev = levenshtein($input, $target);
        similar_text($target, $input, $percent);

        $score = (100 - min($lev, 100)) * 0.4 + $percent * 0.6;

        $scores[] = ['id' => $id, 'name' => $name, 'score' => round($score, 1)];
    }

    usort($scores, fn($a, $b) => $b['score'] <=> $a['score']);
    $best = $scores[0] ?? null;

    if ($best && $best['score'] >= 70) {
        return [
            'id' => $best['id'],
            'name' => $best['name'],
            'confidence' => $best['score'],
            'matchType' => 'fuzzy',
            'original' => $original,
            'suggestions' => array_slice($scores, 0, 3), // Top 3 matches
        ];
    }

    // ❌ Unknown (but still return best guesses for admin)
    return [
        'id' => null,
        'name' => 'Unknown',
        'confidence' => 0,
        'matchType' => 'unknown',
        'original' => $original,
        'suggestions' => array_slice($scores, 0, 3),
    ];
}



public function memberImportPreview()
{
    $rows = session('import_rows', []);

    if (empty($rows)) {
        return redirect()->route('members.index')
            ->with('error', 'No data to preview. Please upload a CSV.');
    }

    $cleanRows = [];
    foreach ($rows as $row) {
        $branch      = $this->smartMatch(ChurchBranch::class, $row['branch_id']);
        $department  = $this->smartMatch(ChurchDepartment::class, $row['department_id']);
        $designation = $this->smartMatch(ChurchDesignation::class, $row['designation_id']);
        $role        = $this->smartMatch(Role::class, $row['role_id'], false);

        $dob       = $this->parseDate($row['dob']);
        $churchDoj = $this->parseDate($row['church_doj']);

        $cleanRows[] = [
            'name'              => $row['name'] ?? null,
            'email'             => $row['email'] ?? null,
            'phone'             => $row['phone'] ?? null,
            'dob'               => $dob,
            'gender'            => $row['gender'] ?? null,
            'address'           => $row['address'] ?? null,
            'church_doj'        => $churchDoj,
            'emergency_contact' => $row['emergency_contact'] ?? null,
            'emergency_phone'   => $row['emergency_phone'] ?? null,
            'branch'            => $branch,
            'department'        => $department,
            'designation'       => $designation,
            'role'              => $role,
            'member_id'         => ChurchMember::generateMemberId(),
        ];
    }

   
    $roles = Role::whereNotIn('name', ['Super Admin', 'Company']) ->pluck('name', 'id');
    return view('churchly::members.import_preview', compact('cleanRows'))
        ->with([
            'branches'     => ChurchBranch::where('workspace', getActiveWorkSpace())->pluck('name', 'id'),
            'departments'  => ChurchDepartment::where('workspace', getActiveWorkSpace())->pluck('name', 'id'),
            'designations' => ChurchDesignation::where('workspace', getActiveWorkSpace())->pluck('name', 'id'),
            'roles'        => $roles,
        ]);
}


public function memberImportConfirm(Request $request)
{
    $report = ['created' => 0, 'skipped' => 0, 'errors' => 0];
    

    \DB::beginTransaction();
    try {
        foreach ($request->rows as $row) {
            if (empty($row['email']) || empty($row['name'])) {
                $report['errors']++;
                continue;
            }

            $email = strtolower(trim($row['email']));
            $phone = preg_replace('/\D/', '', $row['phone'] ?? '');
            $name  = ucwords(strtolower(trim($row['name'])));

            // Duplicate detection
            $existingUser = User::where('email', $email)
                ->orWhere('mobile_no', $phone)
                ->first();
            if ($existingUser) {
                $report['skipped']++;
                continue;
            }

            $branchId      = $row['branch_id'] ?? null;
            $departmentId  = $row['department_id'] ?? null;
            $designationId = $row['designation_id'] ?? null;
            $roleId        = $row['role_id'] ?? null;
            $roleName      = $row['role_name'] ?? 'Member';

            $dob       = $this->parseDate($row['dob'] ?? null);
            $churchDoj = $this->parseDate($row['church_doj'] ?? null);

            $memberId = ChurchMember::generateMemberId();

            // Create User
            $user = User::create([
                'name'             => $name,
                'email'            => $email,
                'mobile_no'        => $phone,
                'password'         => Hash::make('password'),
                'type'             => $roleName,
                'lang'             => 'en',
                'workspace_id'     => getActiveWorkSpace(),
                'active_workspace' => getActiveWorkSpace(),
                'created_by'       => creatorId(),
            ]);

            if ($roleId) {
                $user->roles()->attach($roleId, ['user_type' => get_class($user)]);
            }

            // Create Member
            ChurchMember::create([
                'user_id'           => $user->id,
                'member_id'         => $memberId,
                'name'              => $name,
                'email'             => $email,
                'phone'             => $phone,
                'dob'               => $dob,
                'gender'            => $row['gender'] ?? null,
                'address'           => $row['address'] ?? null,
                'branch_id'         => $branchId,
                'department_id'     => $departmentId,
                'designation_id'    => $designationId,
                'role_id'           => $roleId,
                'church_doj'        => $churchDoj,
                'emergency_contact' => $row['emergency_contact'] ?? null,
                'emergency_phone'   => $row['emergency_phone'] ?? null,
                'is_active'         => true,
                'workspace'         => getActiveWorkSpace(),
                'created_by'        => creatorId(),
            ]);

            $report['created']++;
        }

        \DB::commit();
        return redirect()->route('members.index')
            ->with('success', "Import completed. {$report['created']} created, {$report['skipped']} skipped, {$report['errors']} errors.");
    } catch (\Exception $e) {
        \DB::rollBack();
        return back()->with('error', "❌ Import failed: " . $e->getMessage());
    }
}




public function importCsvFromDrive(Request $request)
{
    $request->validate([
        'gdrive_link' => 'required|url',
    ]);

    $url = $request->gdrive_link;

    // Extract file ID from link
    if (preg_match('/\/d\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
        $fileId = $matches[1];
    } else {
        return back()->with('error', 'Invalid Google Drive link format.');
    }

    // Build direct download URL
    $downloadUrl = "https://drive.google.com/uc?export=download&id={$fileId}";

    try {
        $csvData = file_get_contents($downloadUrl);
    } catch (\Exception $e) {
        return back()->with('error', 'Unable to download file from Google Drive.');
    }

    // ✅ Reuse your normal CSV logic
    $lines = array_filter(explode("\n", $csvData));
    $rows = array_map(fn($line) => array_map('trim', str_getcsv($line)), $lines);

    if (count($rows) < 2) {
        return back()->with('error', 'CSV file is empty or invalid.');
    }

    $header = array_map(fn($h) => strtolower(str_replace([' ', '-', '.'], '_', trim($h))), array_shift($rows));
    $missing = array_diff($this->requiredColumns, $header);

    if ($missing) {
        return back()->with('error', 'Missing required columns: ' . implode(', ', $missing));
    }

    $data = [];
    foreach ($rows as $row) {
        $row = array_pad($row, count($header), null);
        $data[] = array_combine($header, $row);
    }

    session(['import_rows' => $data]);

    return redirect()->route('members.import.preview');
}






public function downloadSample()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="members_sample.csv"',
        ];

        // Define standard headers your system expects
        $columns = [
            'name',
            'email',
            'phone',
            'dob',
            'gender',
            'address',
            'branch_id',
            'department_id',
            'designation_id',
            'church_doj',
            'emergency_contact',
            'emergency_phone',
            'role_id',
        ];

        // Add one sample row to guide users
        $sampleData = [
            [
                'John Doe',
                'john@example.com',
                '123456789',
                '1990-01-01',
                'Male',
                '123 Main Street',
                '1',
                '2',
                '3',
                '2024-01-10',
                'Jane Doe',
                '987654321',
                '4'
            ]
        ];

        $callback = function () use ($columns, $sampleData) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($sampleData as $row) {
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    



function resolveNameToId($model, $input, $workspace = true) {
    $input = strtolower(trim($input));

    // Step 1: Direct ID match
    if (is_numeric($input) && $model::find($input)) {
        return ['id' => $input, 'name' => $model::find($input)->name, 'matchType' => 'exact', 'confidence' => 100];
    }

    // Step 2: Direct name match
    $record = $model::whereRaw('LOWER(name) = ?', [$input])->first();
    if ($record) {
        return ['id' => $record->id, 'name' => $record->name, 'matchType' => 'exact', 'confidence' => 100];
    }

    // Step 3: Fuzzy match with all DB names
    $best = null; $bestScore = 0;
    foreach ($model::all() as $record) {
        similar_text($input, strtolower($record->name), $percent);
        if ($percent > $bestScore) {
            $bestScore = $percent;
            $best = $record;
        }
    }

    if ($bestScore >= 80) {
        return ['id' => $best->id, 'name' => $best->name, 'matchType' => 'fuzzy', 'confidence' => round($bestScore), 'original' => $input];
    }

    // Step 4: Unknown
    return ['id' => 9999, 'name' => 'Unknown', 'matchType' => 'unknown', 'confidence' => 0, 'original' => $input];
}



    private function parseDate($value)
    {
        if (!$value) {
            return null;
        }

        // Try multiple formats
        foreach (['d/m/Y', 'Y-m-d', 'm/d/Y'] as $format) {
            try {
                return \Carbon\Carbon::createFromFormat($format, trim($value))->format('Y-m-d');
            } catch (\Exception $e) {
                continue;
            }
        }

        // If nothing works, return null
        return null;
    }
private $requiredColumns = [
    'name', 'email', 'phone', 'dob', 'gender', 'address',
    'branch_id', 'department_id', 'designation_id',
    'church_doj', 'emergency_contact', 'emergency_phone', 'role_id'
];


private function validateCsvColumns(array $headers)
{
    $normalizedHeaders = array_map(fn($h) => strtolower(trim($h)), $headers);

    $missing = array_diff($this->requiredColumns, $normalizedHeaders);

    if (count($missing) > 0) {
        if (count($missing) > 4) {
            // 🚨 Too many missing columns
            throw new \Exception(
                "Your CSV is missing several required columns. 
                Please download the sample CSV and restructure your file before uploading."
            );
        } else {
            // ⚠️ List missing columns
            throw new \Exception(
                "Your CSV is missing the following required columns: " .
                implode(', ', $missing) .
                ". Please fix your file or download the sample CSV."
            );
        }
    }

    return true;
}

        public function destroy($id)
{
    if (!Auth::user()->isAbleTo('church_member delete')) {
        return redirect()->back()->with('error', __('Permission denied.'));
    }

    \DB::beginTransaction();
    try {
        $member = ChurchMember::with('user')->findOrFail($id);

        // ✅ Delete related custom values
        ChurchMemberCustomValue::where('member_id', $member->id)->delete();

        // ✅ Detach departments (pivot table cleanup)
        $member->departments()->detach();

        // ✅ Delete profile photo if exists
        if ($member->profile_photo && Storage::disk('public')->exists($member->profile_photo)) {
            Storage::disk('public')->delete($member->profile_photo);
        }

        // ✅ Delete related user (except super admin)
        if ($member->user && $member->user->type !== 'super admin') {
            $member->user->delete();
        }

        // ✅ Delete the member record
        $member->delete();

        \DB::commit();

        return redirect()->route('churchly.members.index')
            ->with('success', __('Church member and associated user deleted successfully.'));
    } catch (\Exception $e) {
        \DB::rollBack();
        \Log::error('ChurchMember Deletion Error: ' . $e->getMessage(), [
            'trace' => $e->getTrace()
        ]);

        return redirect()->back()->with('error', __('Failed to delete church member. Please try again.'));
    }
}
}


