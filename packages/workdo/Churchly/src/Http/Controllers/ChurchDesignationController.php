<?php

namespace Workdo\Churchly\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Workdo\Churchly\Entities\ChurchDesignation;
use Workdo\Churchly\Entities\ChurchBranch;
use Workdo\Churchly\Entities\ChurchDepartment;

class ChurchDesignationController extends Controller
{
    public function index()
    {
        $designations = ChurchDesignation::where('workspace', getActiveWorkSpace())
            ->where('created_by', creatorId())
            ->with(['branch', 'department'])
            ->latest()
            ->get();
        $branches = ChurchBranch::where('workspace', getActiveWorkSpace())
            ->where('created_by', creatorId())
            ->pluck('name', 'id');

        $departments = ChurchDepartment::where('workspace', getActiveWorkSpace())
            ->where('created_by', creatorId())
            ->pluck('name', 'id');
        return view('churchly::designation.index', compact('designations', 'branches', 'departments'));
    }

  

    public function getByDepartment(Request $request)
    {
        $departmentId = $request->get('department');

        if (!$departmentId) {
            return response()->json(['error' => 'Department ID is required.'], 400);
        }

        $designations = ChurchDesignation::where('department_id', $departmentId)
            ->pluck('name', 'id');

        return response()->json($designations);
    }


    public function byDepartment(Request $request)
{
    $departmentId = $request->query('department');
    $designations = \Workdo\Churchly\Entities\ChurchDesignation::where('department_id', $departmentId)
        ->pluck('name', 'id');

    return response()->json($designations);
}



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'branch_id' => 'required|exists:church_branches,id',
            'department_id' => 'required|exists:church_departments,id',
        ]);

        ChurchDesignation::create([
            'name' => $request->name,
            'branch_id' => $request->branch_id,
            'department_id' => $request->department_id,
            'workspace' => getActiveWorkSpace(),
            'created_by' => creatorId(),
        ]);

        return redirect()->route('churchdesignation.index')->with('success', __('Designation created successfully.'));
    }

    public function edit(ChurchDesignation $churchdesignation)
    {
        if ($churchdesignation->workspace != getActiveWorkSpace() || $churchdesignation->created_by != creatorId()) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $branches = ChurchBranch::where('workspace', getActiveWorkSpace())
            ->where('created_by', creatorId())
            ->pluck('name', 'id');

        $departments = ChurchDepartment::where('workspace', getActiveWorkSpace())
            ->where('created_by', creatorId())
            ->pluck('name', 'id');

        return view('churchly::designation.edit', compact('churchdesignation', 'branches', 'departments'));
    }

    public function update(Request $request, ChurchDesignation $churchdesignation)
    {
        if ($churchdesignation->workspace != getActiveWorkSpace() || $churchdesignation->created_by != creatorId()) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'branch_id' => 'required|exists:church_branches,id',
            'department_id' => 'required|exists:church_departments,id',
        ]);

        $churchdesignation->update([
            'name' => $request->name,
            'branch_id' => $request->branch_id,
            'department_id' => $request->department_id,
        ]);

        return redirect()->route('churchdesignation.index')->with('success', __('Designation updated successfully.'));
    }

    public function destroy(ChurchDesignation $churchdesignation)
    {
        if ($churchdesignation->workspace != getActiveWorkSpace() || $churchdesignation->created_by != creatorId()) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $churchdesignation->delete();

        return redirect()->route('churchdesignation.index')->with('success', __('Designation deleted successfully.'));
    }
}
