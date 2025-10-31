<?php

namespace Workdo\Churchly\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Workdo\Churchly\Entities\ChurchMember;
use App\Models\Role;

class MemberApiController extends Controller
{
    public function index(Request $request)
    {
        $members = ChurchMember::with(['branch', 'departments'])
            ->where('workspace', getActiveWorkSpace())
            ->paginate(20);

        return response()->json([
            'status' => 'success',
            'data' => $members,
        ]);
    }

    public function show($id)
    {
        $member = ChurchMember::with(['branch', 'departments', 'user'])
            ->where('workspace', getActiveWorkSpace())
            ->find($id);

        if (!$member) {
            return response()->json(['status' => 'error', 'message' => 'Member not found'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $member]);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'gender' => 'required|in:Male,Female,Other',
            'branch_id' => 'required|exists:church_branches,id',
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|min:6',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        $role = Role::find($request->role_id);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password ?? 'password'),
            'type' => $role->name ?? 'Member',
            'workspace_id' => getActiveWorkSpace(),
            'active_workspace' => getActiveWorkSpace(),
            'created_by' => creatorId(),
        ]);

        $user->roles()->attach($role->id, ['user_type' => get_class($user)]);

        $member = ChurchMember::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'branch_id' => $request->branch_id,
            'workspace' => getActiveWorkSpace(),
            'created_by' => creatorId(),
        ]);

        return response()->json(['status' => 'success', 'data' => $member], 201);
    }

    public function update(Request $request, $id)
    {
        $member = ChurchMember::find($id);
        if (!$member) {
            return response()->json(['status' => 'error', 'message' => 'Member not found'], 404);
        }

        $member->update($request->only('name', 'email', 'gender', 'branch_id'));

        if ($member->user) {
            $member->user->update([
                'name' => $member->name,
                'email' => $member->email,
            ]);
        }

        return response()->json(['status' => 'success', 'message' => 'Member updated', 'data' => $member]);
    }

    public function updateProfile(Request $request)
{
    $user = $request->user();
    $member = \Workdo\Churchly\Entities\ChurchMember::where('user_id', $user->id)
        ->where('workspace', getActiveWorkSpace())
        ->first();

    if (!$member) {
        return response()->json(['status' => 'error', 'message' => 'Member profile not found'], 404);
    }

    // ✅ Validate input
    $validated = $request->validate([
        'name'              => 'sometimes|string|max:255',
        'email'             => 'sometimes|email|max:255|unique:users,email,'.$user->id,
        'phone'             => 'nullable|string|max:20',
        'address'           => 'nullable|string|max:500',
        'dob'               => 'nullable|date|before:today',
        'gender'            => 'nullable|in:Male,Female,Other',
        'emergency_contact' => 'nullable|string|max:255',
        'emergency_phone'   => 'nullable|string|max:20',
        'profile_photo'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // ✅ Handle profile photo upload
    if ($request->hasFile('profile_photo')) {
        $path = $request->file('profile_photo')->store('members/photos', 'public');
        $validated['profile_photo'] = $path;
    }

    // ✅ Update ChurchMember
    $member->update($validated);

    // ✅ Sync with linked User
    $user->update([
        'name' => $validated['name'] ?? $user->name,
        'email' => $validated['email'] ?? $user->email,
        'mobile_no' => $validated['phone'] ?? $user->mobile_no,
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Profile updated successfully',
        'data' => $member->fresh(['branch', 'departments', 'user'])
    ]);
}

    public function destroy($id)
    {
        $member = ChurchMember::find($id);
        if (!$member) {
            return response()->json(['status' => 'error', 'message' => 'Member not found'], 404);
        }

        if ($member->user) {
            $member->user->delete();
        }

        $member->delete();
        return response()->json(['status' => 'success', 'message' => 'Member deleted']);
    }
}
