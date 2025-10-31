<?php

namespace Workdo\Churchly\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Workdo\Churchly\Entities\ChurchFeedback;
use Workdo\Churchly\Entities\ChurchBranch;
use Workdo\Churchly\Entities\ChurchDepartment;
use Workdo\Churchly\Entities\ChurchMember;
use App\Models\Workspace;
use Illuminate\Support\Str;
use Workdo\Churchly\Helpers\ChurchHelper;


class ChurchFeedbackController extends Controller
    {
        /**
         * Display feedback list (internal admin view).
         */
       public function dashboard()
        {
            $user = auth()->user();
            $query = ChurchFeedback::query();

            // 🔐 Always filter to current workspace
        $query = ChurchFeedback::with(['department', 'submitter'])
            ->where('workspace_id', getActiveWorkSpace());
        

            // 🔐 Role-based permission scope
            if ($user->isAbleTo('feedback view all')) {
                // all access within workspace
            } elseif ($user->isAbleTo('feedback view branch')) {
                $query->where('branch_id', $user->branch_id);
            } elseif ($user->isAbleTo('feedback view department')) {
                $query->where('branch_id', $user->branch_id)
                    ->where('department_id', $user->department_id);
            } elseif ($user->isAbleTo('feedback view own')) {
                $query->where('submitted_by', $user->id);
            } else {
                abort(403, 'Unauthorized');
            }

            // Stats
            $statswithcount = [
                'total'    => $query->count(),
                'pending'  => (clone $query)->where('status', 'pending')->count(),
                'reviewed' => (clone $query)->where('status', 'reviewed')->count(),
                'resolved' => (clone $query)->where('status', 'resolved')->count(),
            ];
        $stats = [
            // 'total'    => $query->count(),
                'pending'  => (clone $query)->where('status', 'pending')->count(),
                'reviewed' => (clone $query)->where('status', 'reviewed')->count(),
                'resolved' => (clone $query)->where('status', 'resolved')->count(),
            ];
            // Categories
            $categoryCounts = (clone $query)
                ->select('category')
                ->selectRaw('count(*) as total')
                ->groupBy('category')
                ->pluck('total', 'category')
                ->toArray();

            // Recent feedbacks
            $recentFeedbacks = (clone $query)
                ->latest()
                ->limit(5)
                ->get();

            // Calendar events
            $feedbackEvents = (clone $query)->latest()->get()->map(function ($feedback) {
                return [
                    'title' => $feedback->title . ' (' . ucfirst($feedback->status) . ')',
                    'start' => $feedback->created_at->format('Y-m-d'),
                    'color' => match ($feedback->status) {
                        'resolved' => '#198754',
                        'reviewed' => '#ffc107',
                        'pending' => '#dc3545',
                        default => '#0d6efd',
                    },
                    'url' => route('feedback.show', Crypt::encrypt($feedback->id)),
                ];
            })->toArray(); // <<< make sure it's an array

            return view('churchly::feedback.dashboard', compact(
                'stats',
                'categoryCounts',
                'recentFeedbacks',
                'feedbackEvents',
                'statswithcount'
            ));
        }
        
   public function index(Request $request)
    {
        $user = Auth::user();
        $member = ChurchMember::where('user_id', $user->id)->first();
           
       

        $query = ChurchFeedback::with(['department', 'submitter']);

        // 🔐 Always filter to current workspace    
        $query = ChurchFeedback::with(['department', 'submitter'])
            ->where('workspace_id', getActiveWorkSpace());
        
        // 🔐 Permission Scope
        if ($user->isAbleTo('feedback view all')) {
            // Full access (within workspace)
        } elseif ($user->isAbleTo('feedback view branch')) {
            $query->where('branch_id', $member->branch_id);
        } elseif ($user->isAbleTo('feedback view department')) {
            $query->where('branch_id', $member->branch_id)
                ->where('department_id', $member->department_id);
        } elseif ($user->isAbleTo('feedback view own')) {
            $query->where('submitted_by', $user->id);
        } else {
            abort(403, 'Unauthorized');
        }

        // 🔍 Apply Filters
        $query->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->type, fn($q) => $q->where('type', $request->type))
            ->when($request->category, fn($q) => $q->where('category', $request->category));

        // 🔎 Search
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // 📄 Pagination
        $perPage = $request->get('per_page', 15);
        $feedbacks = $query->latest()->paginate($perPage)->appends($request->all());

        // ✅ Return to Blade
        return view('churchly::feedback.index', compact('feedbacks'));
    }


    public function create()
    {
        $branches = ChurchBranch::pluck('name', 'id');
        $departments = ChurchDepartment::pluck('name', 'id');

        return view('churchly::feedback.create', compact('branches', 'departments'));
    }


    public function store(Request $request)
{
    

    try {
        $user   = Auth::user();
        $member = ChurchMember::where('user_id', $user->id)->first();

        if (!$member) {
            return redirect()->back()->with('error', __('You are not linked to a church member profile.'));
        }

        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'message'      => 'required|string',
            'category'     => 'nullable|in:suggestion,complaint,praise,other',
            'attachment'   => 'nullable|file|max:2048',
            'is_anonymous' => 'nullable|boolean',
        ]);

        $data = $validated + [
            'type'          => 'internal',
            'submitted_by'  => $user->id,
            'name'          => $user->name,
            'email'         => $user->email,
            'branch_id'     => $member->branch_id,
            'department_id' => $member->department_id,
            'workspace_id'  => $user->workspace_id ?? 1,
        ];

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('feedback_attachments', 'public');
        }

        $feedback = ChurchFeedback::create($data);

        // WhatsApp notify
        $dashboardUrl = route('feedback.index');
        $cleanMessage = \Str::of($feedback->message)->replace('&nbsp;', ' ')->stripTags()->squish()->limit(150, '...');
        $submitter    = $feedback->is_anonymous ? 'Anonymous' : $feedback->name;
        $message      = "📢 New Feedback Report Submitted\n\n".
                        "Title: {$feedback->title}\n".
                        "Category: {$feedback->category}\n".
                        "Message: {$cleanMessage}\n\n".
                        "Submitted By: {$submitter}\n\n".
                        "📌 Please log in to the dashboard for full details:\n{$dashboardUrl}";

        $waFailed = false;
        if ($feedback->department && $feedback->department->whatsappGroups->isNotEmpty()) {
            foreach ($feedback->department->whatsappGroups as $group) {
                try {
                    $result = \Workdo\Churchly\Helpers\WhatsAppNotifier::sendToGroup($group->group_id, $message);
                    if (!($result['success'] ?? false)) {
                        $waFailed = true;
                    }
                } catch (\Throwable $e) {
                    $waFailed = true;
                }
            }
        }

        if ($waFailed) {
            return redirect()->route('feedback.index') ->with('warning', __('Feedback saved, but some WhatsApp notifications failed.'));
        }


        return redirect()->route('feedback.index')->with('success', __('Feedback submitted successfully.'));
        

    } catch (\Throwable $e) {
     
        return redirect()->back()->with('error', __('Something went wrong while submitting feedback. Please try again.'));
    }
    return redirect()->route('feedback.index')->with('success', __('Feedback submitted successfully.'));
}



    public function edit($id)
    {
        if (!Auth::user()->isAbleTo('feedback edit')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        try {
            $id = Crypt::decrypt($id);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', __('Invalid Feedback ID.'));
        }

        $feedback = ChurchFeedback::findOrFail($id);
        $branches = ChurchBranch::pluck('name', 'id');
        $departments = ChurchDepartment::pluck('name', 'id');

        

        return view('churchly::feedback.edit', compact('feedback', 'branches', 'departments'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->isAbleTo('feedback delete')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        try {
            $id = Crypt::decrypt($id);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', __('Invalid Feedback ID.'));
        }

        $feedback = ChurchFeedback::findOrFail($id);
     

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'category' => 'nullable|in:suggestion,complaint,praise,other',
            'branch_id' => 'nullable|exists:branches,id',
            'department_id' => 'nullable|exists:departments,id',
            'attachment' => 'nullable|file|max:2048',
            'is_anonymous' => 'nullable|boolean',
        ]);

        if ($request->hasFile('attachment')) {
            // Delete old attachment
            if ($feedback->attachment && Storage::disk('public')->exists($feedback->attachment)) {
                Storage::disk('public')->delete($feedback->attachment);
            }
            $validated['attachment'] = $request->file('attachment')->store('feedback_attachments', 'public');
        }

        $feedback->update($validated);

        return redirect()->route('feedback.index')->with('success', __('Feedback updated successfully.'));
    }

    
    /**
     * View single feedback (admin).
     */
    public function show($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', __('Feedback Not Found.'));
        }
        $feedback = ChurchFeedback::with(['submitter', 'reviewer', 'branch', 'department'])->findOrFail($id);
        return view('churchly::feedback.show', compact('feedback'));
    }



    public function destroy($id)
    {
          if (!Auth::user()->isAbleTo('feedback delete')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        try {
            $id = Crypt::decrypt($id);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', __('Invalid Feedback ID.'));
        }
        
        $feedback = ChurchFeedback::findOrFail($id);
      

        // Delete file
        if ($feedback->attachment && Storage::disk('public')->exists($feedback->attachment)) {
            Storage::disk('public')->delete($feedback->attachment);
        }

        $feedback->delete();

        return redirect()->route('feedback.index')->with('success', __('Feedback deleted successfully.'));
    }


    /**
     * Show public feedback form.
     */
    public function createPublic()
    {
        $branches = ChurchBranch::all();
        $departments = ChurchDepartment::all();

        return view('churchly::feedback.public_form', compact('branches', 'departments'));
    }

    /**
     * Store public or internal feedback.
     */
    public function storePublic(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:internal,public',
            'category' => 'required|in:suggestion,complaint,praise,other',
            'is_anonymous' => 'sometimes|boolean',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'branch_id' => 'nullable|exists:branches,id',
            'department_id' => 'nullable|exists:departments,id',
            'attachment' => 'nullable|file|max:2048',
        ]);

        if ($request->hasFile('attachment')) {
            $validated['attachment'] = $request->file('attachment')->store('feedback_attachments','public');
        }

        $validated['submitted_by'] = Auth::check() ? Auth::id() : null;
        $validated['workspace_id'] = Auth::check() ? Auth::user()->workspace_id : Workspace::first()?->id;

        ChurchFeedback::create($validated);

        return back()->with('success', __('Feedback submitted successfully.'));
        
    }


    public function review($id)
    {
        if (!Auth::user()->isAbleTo('feedback review')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
         try {
            $id = Crypt::decrypt($id);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', __('Invalid Feedback ID.'));
        }

        $feedback = ChurchFeedback::findOrFail($id);
        return view('churchly::feedback.review', compact('feedback'));
    }

    public function updateResponse(Request $request, $id)
    {
        if (!Auth::user()->isAbleTo('feedback review')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
          
        $request->validate([
            'admin_response' => 'required|string',
            'status' => 'required|in:pending,reviewed,resolved',
        ]);

        $feedback = ChurchFeedback::findOrFail($id);
        $feedback->admin_response = $request->admin_response;
        $feedback->status = $request->status;
        $feedback->reviewed_by = auth()->id();
        $feedback->reviewed_at = now();
        $feedback->save();

        return redirect()->route('feedback.index')->with('success', 'Feedback response updated successfully.');
    }


    /**
     * Export feedback to CSV.
     */
    public function export()
    {
        // Placeholder: Implement export logic with filters later
        abort(501, 'Export functionality coming soon.');
    }
}
