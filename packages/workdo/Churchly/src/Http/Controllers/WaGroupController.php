<?php

namespace Workdo\Churchly\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Workdo\Churchly\Entities\ZenderWaGroup;
use Workdo\Churchly\Entities\ChurchBranch;
use Workdo\Churchly\Entities\ChurchDepartment;
use Workdo\Churchly\Entities\ChurchDesignation;
use Workdo\Churchly\Http\Controllers\SmsGatewayController;

class WaGroupController extends Controller
{
    public function index()
    {
        if (!Auth::user()->isAbleTo('church_settings manage')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $groups = ZenderWaGroup::with(['branches', 'departments', 'designations'])
            ->where('workspace_id', getActiveWorkSpace())
            ->get();

        // Fetch WhatsApp groups from the API
            $groupOptions = [];

        try {
            $response = app(SmsGatewayController::class)->getWhatsAppGroups();
            Log::debug('WhatsApp API Response:', ['response' => $response]);

            if (
                isset($response->original['status']) &&
                $response->original['status'] === 'success' &&
                isset($response->original['groups']['data']) &&
                is_array($response->original['groups']['data'])
            ) {
                $groupOptions = collect($response->original['groups']['data'])
                    ->pluck('name', 'gid')
                    ->toArray();
            } else {
                Log::warning('Unexpected WhatsApp group structure.', ['response' => $response]);
                return redirect()->route('sms-gateway.edit')->with('error', __('Unexpected WhatsApp group format from API (Contact WhatsApp Server Admin) https://zender.vicezion.com'));
            }
        } catch (\Throwable $e) {
            Log::error('Failed to fetch WhatsApp groups.', ['exception' => $e]);
           return redirect() ->route('sms-gateway.edit')->with('error', __('Unable to load WhatsApp groups. Kindly check your WhatsApp API settings.'));


        }

        $branches = ChurchBranch::where('workspace', getActiveWorkSpace())->pluck('name', 'id');

         return view('churchly::wa_group.index', compact('groupOptions','branches','groups' ));
    }

    
public function store(Request $request)
{
    if (!Auth::user()->isAbleTo('church_settings manage')) {
        return redirect()->back()->with('error', __('Permission denied.'));
    }

    $request->validate([
        'group_id'       => 'required|string',
        'group_name'     => 'required|string|max:255',
        'branch_id'      => 'nullable|exists:church_branches,id',
        'department_id'  => 'nullable|exists:church_departments,id',
        'designation_id' => 'nullable|exists:church_designations,id',
    ]);

    // 🔍 Check if group already exists in this workspace
    $existing = ZenderWaGroup::where('group_id', $request->group_id)
        ->where('workspace_id', getActiveWorkSpace())
        ->first();

    if ($existing) {
        return redirect()
            ->route('wa_group.index')
            ->with('error', __('This WhatsApp group has already been assigned. Please delete the existing assignment before reassigning.'));
    }

    try {
        // ✅ Create new assignment
        $group = ZenderWaGroup::create([
            'group_id'     => $request->group_id,
            'name'         => $request->group_name,
            'workspace_id' => getActiveWorkSpace(),
            'created_by'   => creatorId(),
        ]);

        if ($request->filled('branch_id')) {
            $group->branches()->sync([$request->branch_id]);
        }

        if ($request->filled('department_id')) {
            $group->departments()->sync([$request->department_id]);
        }

        if ($request->filled('designation_id')) {
            $group->designations()->sync([$request->designation_id]);
        }

        return redirect()
            ->route('wa_group.index')
            ->with('success', __('WhatsApp group assigned successfully.'));

    } catch (\Throwable $e) {
        \Log::error('Failed to assign WhatsApp group.', [
            'exception' => $e,
            'user_id'   => Auth::id(),
        ]);

        return redirect()
            ->back()
            ->withInput()
            ->with('error', __('Something went wrong while assigning the group.'));
    }
}


    public function show($id)
    {
        if (!Auth::user()->isAbleTo('church_settings manage')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $group = ZenderWaGroup::with(['branches', 'departments', 'designations'])
            ->where('workspace_id', getActiveWorkSpace())
            ->findOrFail($id);

        return view('churchly::wa_group.show', compact('group'));
    }

    public function destroy($id)
    {
        if (!Auth::user()->isAbleTo('churchly communication sms')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $group = ZenderWaGroup::where('workspace_id', getActiveWorkSpace())->findOrFail($id);

        $group->branches()->detach();
        $group->departments()->detach();
        $group->designations()->detach();
        $group->delete();

        return redirect()->route('wa_group.index')->with('success', __('WhatsApp group deleted successfully.'));
    }
}
