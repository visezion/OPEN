<?php

namespace Workdo\Churchly\Http\Controllers;

use App\Models\Setting;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Workdo\Churchly\Entities\ChurchBranch;
use Workdo\Churchly\Entities\Department;
use Workdo\Churchly\Entities\Designation;
use Workdo\Churchly\Entities\Employee;

use Workdo\Churchly\Events\CreateBranch;
use Workdo\Churchly\Events\DestroyBranch;
use Workdo\Churchly\Events\UpdateBranch;

class ChurchBranchController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if (Auth::user()->isAbleTo('church_branch manage')) {
            $branches = ChurchBranch::where('created_by', '=', creatorId())->where('workspace', getActiveWorkSpace())->get();
      
            return view('churchly::branch.index', compact('branches'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        if (Auth::user()->isAbleTo('church_branch create')) {
            return view('churchly::branch.create');
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        if (Auth::user()->isAbleTo('church_branch create')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $branch             = new ChurchBranch();
            $branch->name       = $request->name;
            $branch->workspace  = getActiveWorkSpace();
            $branch->created_by = creatorId();
            $branch->save();

            event(new CreateBranch($request, $branch));

            return redirect()->route('churchbranch.index')->with('success', __('The branch has been created successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return redirect()->back();
        return view('churchly::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(ChurchBranch $branch)
    {
        if (Auth::user()->isAbleTo('church_branch edit')) {
            if ($branch->created_by == creatorId() &&  $branch->workspace  == getActiveWorkSpace()) {
                return view('churchly::churchbranch.edit', compact('branch'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, ChurchBranch $branch)
    {
        if (Auth::user()->isAbleTo('church_branch edit')) {
            if ($branch->created_by == creatorId() &&  $branch->workspace  == getActiveWorkSpace()) {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'name' => 'required',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $branch->name = $request->name;
                $branch->save();

                event(new UpdateBranch($request, $branch));

                return redirect()->route('churchbranch.index')->with('success', __('The branch details are updated successfully.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(ChurchBranch $branch)
    {
        if (Auth::user()->isAbleTo('church_branch delete')) {
            if ($branch->created_by == creatorId() &&  $branch->workspace  == getActiveWorkSpace()) {
                $employee     = Employee::where('branch_id', $branch->id)->where('workspace', getActiveWorkSpace())->get();
                if (count($employee) == 0) {
                    Department::where('branch_id', $branch->id)->delete();
                    Designation::where('branch_id', $branch->id)->delete();

                    event(new DestroyBranch($branch));

                    $branch->delete();
                } else {
                    return redirect()->route('churchbranch.index')->with('error', __('This branch has employees. Please remove the employee from this branch.'));
                }

                return redirect()->route('branch.index')->with('success', __('The branch has been deleted.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function BranchNameEdit()
    {
        if (Auth::user()->isAbleTo('church_branch edit')) {
            return view('churchly::branch.branchnameedit');
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function saveBranchName(Request $request)
    {
        if (Auth::user()->isAbleTo('branch name edit')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'hrm_branch_name' => 'required',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            } else {
                $post = $request->all();
                unset($post['_token']);

                foreach ($post as $key => $value) {
                    // Define the data to be updated or inserted
                    $data = [
                        'key' => $key,
                        'workspace' => getActiveWorkSpace(),
                        'created_by' => creatorId(),
                    ];
                    // Check if the record exists, and update or insert accordingly
                    Setting::updateOrInsert($data, ['value' => $value]);
                }
                // Settings Cache forget
                comapnySettingCacheForget();
                return redirect()->route('branch.index')->with('success', __('The branch name are updated successfully.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
