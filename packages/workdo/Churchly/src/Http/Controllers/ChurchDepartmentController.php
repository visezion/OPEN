<?php

namespace Workdo\Churchly\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Workdo\Churchly\Entities\ChurchBranch;
use Workdo\Churchly\Entities\ChurchDepartment;

class ChurchDepartmentController extends Controller
{
    public function index()
    {
        $departments = ChurchDepartment::where('workspace', getActiveWorkSpace())
            ->where('created_by', creatorId())
            ->latest()
            ->paginate(10);

        return view('churchly::departments.index', compact('departments'));
        
    }

    public function create()
    {
        $branches = ChurchBranch::where('workspace', getActiveWorkSpace())
            ->where('created_by', creatorId())
            ->pluck('name', 'id');

        return view('churchly::departments.create', compact('branches'));
    }
    public function getByBranch(Request $request)
{
    $branchId = $request->get('branch');

    if (!$branchId) {
        return response()->json(['error' => 'Branch ID is required.'], 400);
    }

    $departments = ChurchDepartment::where('branch_id', $branchId)
        ->pluck('name', 'id');

    return response()->json($departments);
}

public function byBranch(Request $request)
{
    $branchId = $request->query('branch');
    $departments = \Workdo\Churchly\Entities\ChurchDepartment::where('branch_id', $branchId)
        ->pluck('name', 'id');

    return response()->json($departments);
}


    public function store(Request $request)
    {
        $validated = $request->validate([
            'branch_id' => 'required|exists:church_branches,id',
            'name' => 'required|string|max:255',
        ]);

        $validated['workspace'] = getActiveWorkSpace();
        $validated['created_by'] = creatorId();

        ChurchDepartment::create($validated);

        return redirect()->route('churchly.departments.index')->with('success', __('Department created successfully.'));
    }

    public function edit(ChurchDepartment $department)
    {
        $this->authorizeAccess($department);

        $branches = ChurchBranch::where('workspace', getActiveWorkSpace())
            ->where('created_by', creatorId())
            ->pluck('name', 'id');

        return view('churchly::departments.edit', compact('department', 'branches'));
    }

    public function update(Request $request, ChurchDepartment $department)
    {
        $this->authorizeAccess($department);

        $validated = $request->validate([
            'branch_id' => 'required|exists:church_branches,id',
            'name' => 'required|string|max:255',
        ]);

        $department->update($validated);

        return redirect()->route('churchly.departments.index')->with('success', __('Department updated successfully.'));
    }

    public function destroy(ChurchDepartment $department)
    {
        $this->authorizeAccess($department);

        $department->delete();

        return redirect()->route('churchly.departments.index')->with('success', __('Department deleted successfully.'));
    }

    private function authorizeAccess(ChurchDepartment $department)
    {
        if ($department->created_by != creatorId() || $department->workspace != getActiveWorkSpace()) {
            abort(403, __('Unauthorized action.'));
        }
    }
}
