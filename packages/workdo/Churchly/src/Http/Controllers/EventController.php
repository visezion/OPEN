<?php

namespace Workdo\Churchly\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Workdo\Churchly\Entities\Event;
use Workdo\Churchly\Entities\ChurchMember;
use Workdo\Churchly\Entities\EventProgram;
use Workdo\Churchly\Entities\AttendanceEvent;
use Barryvdh\DomPDF\Facade\Pdf;
use Workdo\Churchly\Http\Controllers\SmsGatewayController;
use Workdo\Churchly\Entities\ChurchEventReviewerComment;
use Workdo\Churchly\Entities\ChurchDepartment;
use Workdo\Churchly\Entities\ZenderWaGroup;
use Workdo\Churchly\Http\Controllers\AttendanceRecordController;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('workspace_id', getActiveWorkSpace())
            ->latest()
            ->paginate(20);

        $recentEvents = Event::where('workspace_id', getActiveWorkSpace())->orderBy('created_at', 'desc')->get();
       
          
        return view('churchly::attendance.events.index', compact('events', 'recentEvents'));
    }

    public function create()
    {
        // ✅ Fetch all active church members for dropdowns
        $members = ChurchMember::forWorkspace()->select('id', 'name')->get();

        // ✅ Pass members to your Blade view
        return view('churchly::attendance.events.create', compact('members'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:191',
            'event_type'  => 'required|string|max:100',
            'start_time'  => 'nullable|date',
            'end_time'    => 'nullable|date|after_or_equal:start_time',
            'venue'       => 'nullable|string|max:191',
            'description' => 'nullable|string',
            'mode' => 'required|string|in:onsite,online,hybrid',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
            'radius_meters' => 'nullable|integer|min:1',
        ]);
        

        // ✅ Save event
        $event = Event::create([
            'workspace_id' => getActiveWorkSpace(),
            'created_by'   => Auth::id(),
            'title'        => $request->title,
            'description'  => $request->description,
            'event_type'   => $request->event_type,
            'status'       => 'draft',
            'start_time'   => $request->start_time,
            'end_time'     => $request->end_time,
            'recurrence'   => $request->recurrence ?? 'none',
            'lead_id'      => $request->lead_id,
            'assistant_id' => $request->assistant_id,
            'venue'        => $request->venue,
            'latitude'     => $request->latitude,
            'longitude'    => $request->longitude,
            'radius_meters'=> $request->radius_meters ?? 100,
            'attendance_methods' => json_encode($request->methods ?? []),
        ]);


         // 🧩 Save Program Items
        if ($request->program_item && is_array($request->program_item)) {
            foreach ($request->program_item as $index => $item) {
                if (!empty($item)) {
                    EventProgram::create([
                        'event_id'     => $event->id,
                        'order_no'     => $index + 1,
                        'status'       => 'draft',
                        'program_item' => $item,
                        'duration'     => $request->duration[$index] ?? 0,
                        'leader_id'    => $request->leader[$index] ?? null,
                        'note'         => $request->note[$index] ?? null,
                    ]);
                }
            }
        }
        // 🧩 Save  Attendance Event
        AttendanceEvent::create([
            'workspace_id' => getActiveWorkSpace(),
            'branch_id' => $request->branch_id,
            'department_id' => $request->department_id,
            'event_id'     => $event->id,
            'mode' => $request->mode,
            'enabled_methods' => $request->enabled_methods ?? [],
            'online_platform' => $request->online_platform,
            'meeting_link' => $request->meeting_link,
            'meeting_id' => $request->meeting_id,
            'meeting_passcode' => $request->meeting_passcode,
            'auto_log_attendance' => $request->auto_log_attendance ?? false,
            'created_by' => Auth::id(),
        ]);


        // ✅ Save uploaded files (if any)
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('event_files', 'public');
                $event->attachments = collect(json_decode($event->attachments ?? '[]'))->push($path)->toJson();
                $event->save();
            }
        }

        // ✅ Send WhatsApp notifications to Lead & Assistant
        $lead = ChurchMember::find($request->lead_id);
        $assistant = ChurchMember::find($request->assistant_id);

        $previewUrl = route('churchly.events.review', $event->id);
        

        $start = $event->start_time ? date('D, M j, Y g:i A', strtotime($event->start_time)) : 'Not specified';
        $end = $event->end_time ? date('D, M j, Y g:i A', strtotime($event->end_time)) : 'Not specified';

        $message = "📢 *New Event Submission Alert*\n\n"
                . "A new event has been created and requires your review.\n\n"
                . "📝 *Title:* {$event->title}\n"
                . "🏷️ *Type:* {$event->event_type}\n"
                . "📍 *Venue:* " . ($event->venue ?: 'To be announced') . "\n"
                . "🕒 *Start:* {$start}\n"
                . "🕓 *End:* {$end}\n"
                . "👤 *Created By:* " . (Auth::user()->name ?? 'Unknown User') . "\n\n"
                . "🔗 *Click to Preview:* {$previewUrl}\n\n"
                . "Please review the details and approve this event at your earliest convenience.\n\n"
                . "_Your Church Event Management System_";

        $gateway = new SmsGatewayController();

        if ($lead && !empty($lead->phone)) {
            $gateway->sendZenderMessage($lead->phone, $message, 'whatsapp');
        }

        if ($assistant && !empty($assistant->phone)) {
            $gateway->sendZenderMessage($assistant->phone, $message, 'whatsapp');
        }
        
        return redirect()
            ->route('churchly.events.index')
            ->with('success', __('Event created successfully and submitted for review.'));
    }




    /*****************************************************************************
     * Step 2 — Review Stage
     * Displays event details for review, allows feedback, and manages next steps.
     *****************************************************************************/

    public function review($id)
    {
        $event = Event::with([
                'programs.leader',
                'lead',
                'assistant',
                'reviewerComments.user'
            ])
            ->inWorkspace()
            ->findOrFail($id);

        $members = ChurchMember::forWorkspace()->select('id', 'name')->get();

        return view('churchly::attendance.events.review', compact('event', 'members'));
    }

    /**
     * Step 2B — Submit Event for Approval or Request Adjustment
     * Handles reviewer decisions: send back for edits or forward for approval.
     */
    public function submitForReview(Request $request, $id)
    {
        $event = Event::inWorkspace()->findOrFail($id);

        $request->validate([
            'comments' => 'nullable|string|max:1000',
            'action'   => 'required|in:adjust,approve',
        ]);

        $gateway = new SmsGatewayController();
        $reviewerName = Auth::user()->name ?? 'Reviewer';

        // ✅ Log reviewer comment (for both cases)
        if ($request->filled('comments')) {
            ChurchEventReviewerComment::create([
                'event_id' => $event->id,
                'user_id'  => Auth::id(),
                'role'     => 'Reviewer',
                'comment'  => $request->comments,
            ]);
        }

        /**
         * 🟠 CASE 1: Reviewer Requests Adjustments
         * Event is sent back to the creator for edits.
         */
        if ($request->action === 'adjust') {
            $event->update([
                'status'             => 'revision_required',
                'reviewer_comments'  => $request->comments,
                'reviewed_by'        => Auth::id(),
                'reviewed_at'        => now(),
            ]);

            // Fetch the event creator (User or ChurchMember depending on structure)
            $creator = $event->creator ?? ChurchMember::where('user_id', $event->created_by)->first();

            if ($creator && !empty($creator->phone)) {
                $editUrl = route('churchly.events.edit', $event->id);
                $message = "⚠️ *Event Requires Adjustments*\n\n"
                    . "Your event *{$event->title}* has been reviewed but needs updates before approval.\n\n"
                    . "💬 *Reviewer Comment:* " . ($request->comments ?: 'Please make the necessary changes.') . "\n\n"
                    . "✏️ *Edit and Resubmit:* {$editUrl}\n\n"
                    . "_Churchly Event Management System_";

                $gateway->sendZenderMessage($creator->phone, $message, 'whatsapp');
            }

            return redirect()
                ->route('churchly.events.index')
                ->with('success', __('Event sent back to the creator for adjustment.'));
        }

        /**
         * 🟢 CASE 2: Reviewer Approves for Next Stage
         * Event is forwarded to the lead for final approval.
         */
        $event->update([
            'status'             => 'approved',
            'reviewer_comments'  => $request->comments,
            'reviewed_by'        => Auth::id(),
            'reviewed_at'        => now(),
        ]);

        $lead = $event->lead ?? ChurchMember::find($event->lead_id);

        if ($lead && !empty($lead->phone)) {
            $approveUrl = route('churchly.events.approve', $event->id);
            $message = "✅ *Event Ready for Approval*\n\n"
                . "The event *{$event->title}* has been reviewed and is ready for final approval.\n\n"
                . "📅 *Type:* {$event->event_type}\n"
                . "📍 *Venue:* " . ($event->venue ?: 'Not specified') . "\n"
                . "👤 *Reviewed By:* {$reviewerName}\n\n"
                . "🔗 *Approve Here:* {$approveUrl}\n\n"
                . "_Churchly Notification System_";

            $gateway->sendZenderMessage($lead->phone, $message, 'whatsapp');
        }

        return redirect()
            ->route('churchly.events.index')
            ->with('success', __('Event submitted for approval successfully.'));
    }


    /*****************************************************************************
     * Step 3 — Approver Stage
     * Displays event details for final approval or rejection.
     *****************************************************************************/
    public function approve($id)
    {
        $event = Event::with([
                'lead',
                'assistant',
                'creator',
                'programs.leader',
                'reviewerComments.user'
            ])
            ->inWorkspace()
            ->findOrFail($id);

        // abort_unless(Auth::user()->can('approve events'), 403);

        return view('churchly::attendance.events.approve', compact('event'));
    }

    /**
     * Step 3B — Handle Approval or Rejection
     * Approver can approve the event or send it back as rejected.
     */
    public function approveAction(Request $request, $id)
    {
        $event = Event::inWorkspace()->findOrFail($id);

        $request->validate([
            'comments' => 'nullable|string|max:1000',
            'action'   => 'required|in:approve,reject',
        ]);

        $gateway = new SmsGatewayController();
        $approverName = Auth::user()->name ?? 'Approver';

        // ✅ Log approver comment (for transparency)
        if ($request->filled('comments')) {
            ChurchEventReviewerComment::create([
                'event_id' => $event->id,
                'user_id'  => Auth::id(),
                'role'     => 'Approver',
                'comment'  => $request->comments,
            ]);
        }

        // 🟢 CASE 1: APPROVED
        if ($request->action === 'approve') {
            $event->update([
                'status'           => 'approved',
                'approved_by'      => Auth::id(),
                'approved_at'      => now(),
                'approver_comments'=> $request->comments,
            ]);

            // ✅ Notify creator that the event is approved
            $creator = $event->creator ?? ChurchMember::where('user_id', $event->created_by)->first();
            if ($creator && !empty($creator->phone)) {
                $publishUrl = route('churchly.events.publish', $event->id);
                $message = "🎉 *Event Approved!*\n\n"
                    . "Your event *{$event->title}* has been approved and is now ready for publishing.\n\n"
                    . "💬 *Approver Comment:* " . ($request->comments ?: 'Approved successfully.') . "\n\n"
                    . "📢 *Publish Here:* {$publishUrl}\n\n"
                    . "_Churchly Approval System_";
                $gateway->sendZenderMessage($creator->phone, $message, 'whatsapp');
            }

            $msg = __('Event approved successfully.');

        // 🔴 CASE 2: REJECTED
        } else {
            $event->update([
                'status'           => 'rejected',
                'approver_comments'=> $request->comments,
                'approved_by'      => Auth::id(),
                'approved_at'      => now(),
            ]);

            // ✅ Notify creator that the event was rejected
            $creator = $event->creator ?? ChurchMember::where('user_id', $event->created_by)->first();
            if ($creator && !empty($creator->phone)) {
                $message = "❌ *Event Rejected*\n\n"
                    . "Your event *{$event->title}* was reviewed but not approved.\n\n"
                    . "💬 *Approver Comment:* " . ($request->comments ?: 'No additional comments provided.') . "\n\n"
                    . "Please revise and resubmit if applicable.\n\n"
                    . "_Churchly Approval System_";
                $gateway->sendZenderMessage($creator->phone, $message, 'whatsapp');
            }

            $msg = __('Event was rejected.');
        }

        // Redirect to Publish Stage or back to list
        return redirect()
            ->route('churchly.events.publish', $event->id)
            ->with('success', $msg);
    }


    /**
    * Step 4 – Publishing Stage
    * Finalizes the event and sends notifications to all involved.
    */
    public function publish($id)
    {
        $event = Event::with(['programs.leader', 'lead', 'assistant', 'creator'])
            ->inWorkspace()
            ->findOrFail($id);

        $members = ChurchMember::forWorkspace()->select('id', 'name', 'phone')->get();
        $groups = ZenderWaGroup::with(['branches', 'departments', 'designations'])
            ->where('workspace_id', getActiveWorkSpace())
            ->get();

        return view('churchly::attendance.events.publish', compact('event', 'members', 'groups'));
    }


    /**
 * Step 4B – Perform Publish Action
 * Publishes the event and sends notifications to leaders, groups, and members.
 */
public function publishAction(Request $request, $id)
{
    $event = Event::with(['programs.leader', 'lead', 'assistant', 'creator'])
        ->inWorkspace()
        ->findOrFail($id);

    $request->validate([
        'groups' => 'array|nullable',
        'additional_members' => 'array|nullable',
        'notify_all' => 'nullable|boolean',
    ]);

    // ✅ Update event status
    $event->update([
        'status' => 'published',
        'published_by' => Auth::id(),
        'published_at' => now(),
    ]);

    $gateway = new SmsGatewayController();

    // ===========================================
    // 📋 Basic Event Information
    // ===========================================
    $title = $event->title;
    $start = $event->start_time ? date('D, d M Y • h:i A', strtotime($event->start_time)) : 'To Be Announced';
    $venue = $event->venue ?? 'To Be Announced';
    $pdfUrl = route('churchly.events.export.pdf', $event->id);

    // ===========================================
    // ✉️ Main Group Message (Faith-centered and clear)
    // ===========================================
    $mainMessage =
        "*{$title}*\n\n"
        . "📅 Date & Time: {$start}\n"
        . "📍 Venue: {$venue}\n\n"
        . "Let us prayerfully prepare and wait on the Lord for this gathering. "
        . "May His presence lead every activity and every heart be strengthened for His glory.\n\n"
        . "🔗 View full event details in PDF:\n{$pdfUrl}\n\n"
        . "_Churchly Event Management System_";

    // ===========================================
    // 👤 Notify Program Leaders Individually
    // ===========================================
    foreach ($event->programs as $program) {
        if ($program->leader && $program->leader->phone) {
            $leaderMsg =
                "Hello {$program->leader->name},\n\n"
                . "You are assigned for *{$program->program_item}* "
                . "during *{$title}*.\n"
                . "Allocated Duration: {$program->duration} minutes\n"
                . "Venue: {$venue} | Start: {$start}\n\n"
                . "Please take time to seek the Lord in prayer and prepare in faith. "
                . "May the Holy Spirit empower you.\n\n"
                . "🔗 Event Details (PDF): {$pdfUrl}\n\n"
                . "_Churchly Event System_";

            $gateway->sendZenderMessage($program->leader->phone, $leaderMsg, 'whatsapp');
        }
    }

    // ===========================================
    // 👥 Notify Lead, Assistant, and Creator
    // ===========================================
    $notifyList = [
        $event->lead?->phone,
        $event->assistant?->phone,
        $event->creator?->phone,
    ];

    $personalMsg =
        "Dear Team,\n\n"
        . "The event *{$title}* has been published.\n"
        . "📅 {$start}\n"
        . "📍 {$venue}\n\n"
        . "Please coordinate with all assigned participants and continue in prayerful preparation.\n\n"
        . "🔗 Event PDF: {$pdfUrl}\n\n"
        . "_Churchly Event System_";

    foreach (array_filter($notifyList) as $phone) {
        $gateway->sendZenderMessage($phone, $personalMsg, 'whatsapp');
    }

    // ===========================================
    // 🏢 Send to Selected WhatsApp Groups
    // ===========================================
    if (!empty($request->groups)) {
        $selectedGroups = ZenderWaGroup::whereIn('id', $request->groups)
            ->where('workspace_id', getActiveWorkSpace())
            ->get();

        foreach ($selectedGroups as $group) {
            if (!empty($group->group_id)) {
                $gateway->sendZenderMessage($group->group_id, $mainMessage, 'whatsapp');
            }
        }
    }

    // ===========================================
    // ➕ Notify Additional Members
    // ===========================================
    if (!empty($request->additional_members)) {
        $extraMembers = ChurchMember::whereIn('id', $request->additional_members)->get();
        foreach ($extraMembers as $member) {
            if (!empty($member->phone)) {
                $gateway->sendZenderMessage($member->phone, $mainMessage, 'whatsapp');
            }
        }
    }

    // ===========================================
    // ✅ Final Confirmation
    // ===========================================
    return redirect()
        ->route('churchly.events.index')
        ->with('success', __('Event published successfully and all notifications have been sent prayerfully.'));
}



    /**
     * show
     */

    /**
 * Step 5 — Display Full Event Details
 * Shows the complete event profile with attendance, program schedule, and reviewer discussion.
 */
    public function show($id)
    {
        // ✅ Load the event with all relations for a full detail view
        $event = Event::with([
                'lead',
                'assistant',
                'creator',
                'programs.leader',
                'reviewerComments.user'
            ])
            ->inWorkspace()
            ->findOrFail($id);

        // ✅ Load attendance data if available
        $attendanceEvent = AttendanceEvent::with(['event', 'records.member'])
            ->where('event_id', $event->id)
            ->first();

        // ✅ Attendance stats summary
        $attendanceStats = [
            'total_registered' => $attendanceEvent?->records?->count() ?? 0,
            'present' => $attendanceEvent?->records?->where('status', 'present')->count() ?? 0,
            'absent'  => $attendanceEvent?->records?->where('status', 'absent')->count() ?? 0,
        ];

        // ✅ Format times for clean display
        $event->formatted_start = $event->start_time
            ? \Carbon\Carbon::parse($event->start_time)->format('D, M j, Y • g:i A')
            : 'Not specified';
        $event->formatted_end = $event->end_time
            ? \Carbon\Carbon::parse($event->end_time)->format('D, M j, Y • g:i A')
            : 'Not specified';

        // ✅ Prepare comment thread for discussion view
        $reviewComments = $event->reviewerComments()
            ->with('user')
            ->orderBy('commented_at', 'asc')
            ->get();

        // ✅ Send all context to the view
        return view('churchly::attendance.events.show', compact(
            'event',
            'attendanceEvent',
            'attendanceStats',
            'reviewComments'
        ));
    }

    
     public function exportPdf($id)
    {
        $event = Event::with(['lead', 'assistant', 'programs.leader'])->findOrFail($id);

        return view('churchly::attendance.events.pdf', compact('event'));

    }

    public function edit($id)
    {
    $event = Event::with([
                    'programs.leader',
                    'lead',
                    'assistant',
                    'reviewerComments.user'
                ])
                ->inWorkspace()
                ->findOrFail($id);

        $attendanceEvent = AttendanceEvent::findOrFail($id);
        $events = Event::all();

            $members = ChurchMember::forWorkspace()->select('id', 'name')->get();

        return view('churchly::attendance.events.edit', compact('event', 'members', 'events', 'attendanceEvent'));
    }


    public function update(Request $request, $id)
    {
    $event = Event::findOrFail($id);
    if ($event->status === 'revision_required')
        {
            $status = 'resubmitted';
        }else{
        $status = 'draft';
    }

    $request->validate([
        'title'       => 'required|string|max:191',
        'event_type'  => 'required|string|max:100',
        'start_time'  => 'nullable|date',
        'end_time'    => 'nullable|date|after_or_equal:start_time',
        'venue'       => 'nullable|string|max:191',
        'description' => 'nullable|string',
        'mode'        => 'required|string|in:onsite,online,hybrid',
        'latitude'    => 'nullable|numeric',
        'longitude'   => 'nullable|numeric',
        'radius_meters' => 'nullable|integer|min:1',
        
    ]);

    // ✅ Update main event
    $event = Event::findOrFail($id);
    $event->update([
        'title'        => $request->title,
        'event_type'   => $request->event_type,
        'description'  => $request->description,
        'venue'        => $request->venue,
        'status'       => $status,
        'start_time'   => $request->start_time,
        'end_time'     => $request->end_time,
        'recurrence'   => $request->recurrence ?? 'none',
        'lead_id'      => $request->lead_id,
        'assistant_id' => $request->assistant_id,
        'latitude'     => $request->latitude,
        'longitude'    => $request->longitude,
        'radius_meters'=> $request->radius_meters ?? $event->radius_meters,
        'updated_at'   => now(),
    ]);

    // ✅ Refresh program items
    EventProgram::where('event_id', $id)->delete();

    if ($request->program_item && is_array($request->program_item)) {
        foreach ($request->program_item as $index => $item) {
            if (!empty($item)) {
                EventProgram::create([
                    'event_id'     => $id,
                    'order_no'     => $index + 1,
                    'status'       => 'draft',
                    'program_item' => $item,
                    'duration'     => $request->duration[$index] ?? 0,
                    'leader_id'    => $request->leader[$index] ?? null,
                    'note'         => $request->note[$index] ?? null,
                ]);
            }
        }
    }
    if ($status = 'resubmitted')
    {

    // ✅ Send WhatsApp notifications to Lead & Assistant
            $lead = ChurchMember::find($request->lead_id);
            $assistant = ChurchMember::find($request->assistant_id);

            $previewUrl = route('churchly.events.review', $event->id);
            

            $start = $event->start_time ? date('D, M j, Y g:i A', strtotime($event->start_time)) : 'Not specified';
            $end = $event->end_time ? date('D, M j, Y g:i A', strtotime($event->end_time)) : 'Not specified';

            $message = "📢 *Event Resubmission Alert*\n\n"
                    . "An event has been Modified as requested and resubmited for your review.\n\n"
                    . "📝 *Title:* {$event->title}\n"
                    . "🏷️ *Type:* {$event->event_type}\n"
                    . "📍 *Venue:* " . ($event->venue ?: 'To be announced') . "\n"
                    . "🕒 *Start:* {$start}\n"
                    . "🕓 *End:* {$end}\n"
                    . "👤 *Created By:* " . (Auth::user()->name ?? 'Unknown User') . "\n\n"
                    . "🔗 *Click to Preview:* {$previewUrl}\n\n"
                    . "Please review the details and approve this event at your earliest convenience.\n\n"
                    . "_Your Church Event Management System_";

            $gateway = new SmsGatewayController();

            if ($lead && !empty($lead->phone)) {
                $gateway->sendZenderMessage($lead->phone, $message, 'whatsapp');
            }

            if ($assistant && !empty($assistant->phone)) {
                $gateway->sendZenderMessage($assistant->phone, $message, 'whatsapp');
            }

    }
    return redirect()
        ->route('churchly.events.index')
        ->with('success', __('Event updated successfully.'));
}


/**
 * Step 5 – Overall Event Analytics & Insight Dashboard
 * Provides comprehensive analysis across all events,
 * covering attendance trends, department participation,
 * and predictive faith-based insights.
 */
public function analytics()
{
    // ✅ Fetch all published events in the active workspace
    $events = Event::with(['programs', 'attendanceEvents.records.member'])
    ->inWorkspace()
    ->where('status', 'published')
    ->orderBy('start_time', 'desc')
    ->get();

    // Preload departments as an id→name map
    $departments = ChurchDepartment::pluck('name', 'id')->toArray();

    $totalEvents = $events->count();
    $totalMembers = ChurchMember::forWorkspace()->count();

    // ===============================================
    // 📊 Aggregate Event-Level Metrics
    // ===============================================
    $totalAttendanceRecords = 0;
    $attendanceRates = [];
    $departmentParticipation = [];

    foreach ($events as $event) {
        $attendanceEvent = $event->attendanceEvents->first();
        $attendanceCount = $attendanceEvent?->records->count() ?? 0;
        $rate = $totalMembers > 0 ? round(($attendanceCount / $totalMembers) * 100, 1) : 0;
        $attendanceRates[$event->title] = $rate;
        $totalAttendanceRecords += $attendanceCount;
    // Preload departments as an ID → name map
    $departments = \Workdo\Churchly\Entities\ChurchDepartment::pluck('name', 'id')->toArray();

    // Preload member-to-department mapping (from pivot table)
    $memberDepartments = \DB::table('church_member_department')
        ->pluck('department_id', 'church_member_id')
        ->toArray();

    // Collect department participation without relationships
    $departmentParticipation = [];

    foreach ($attendanceEvent?->records ?? [] as $record) {
        $memberId = $record->member_id ?? null;
        $deptId = $memberDepartments[$memberId] ?? null;
        $deptName = $departments[$deptId] ?? 'Unassigned';

        $departmentParticipation[$deptName] = ($departmentParticipation[$deptName] ?? 0) + 1;
    }


    }


     //   =========================
    // 🧮 Department Attendance Percentage Calculation
    // ===============================

    // Step 1: Get total members per department
    $departmentMembersCount = \DB::table('church_member_department')
        ->select('department_id', \DB::raw('COUNT(church_member_id) as total_members'))
        ->groupBy('department_id')
        ->pluck('total_members', 'department_id')
        ->toArray();

    // Step 2: Calculate attendance per department
    $departmentAttendancePercentages = [];

    foreach ($departmentParticipation as $deptName => $presentCount) {
        // Find department_id by name
        $deptId = array_search($deptName, $departments);

        $totalMembers = $departmentMembersCount[$deptId] ?? 0;
        $percentage = $totalMembers > 0 ? round(($presentCount / $totalMembers) * 100, 1) : 0;

        $departmentAttendancePercentages[$deptName] = [
            'present' => $presentCount,
            'total'   => $totalMembers,
            'rate'    => $percentage,
        ];
    }

    // Step 3: Sort by attendance rate (highest first)
    arsort($departmentAttendancePercentages);

    // Step 4: Pass to view
    $chartData['department_labels'] = array_keys($departmentAttendancePercentages);
    $chartData['department_data'] = array_column($departmentAttendancePercentages, 'rate');
    $departmentComparison = $departmentAttendancePercentages;


    // ===============================================
    // ⚙️ Calculate Averages and Trends
    // ===============================================
    $avgAttendanceRate = $totalEvents > 0 ? round(array_sum($attendanceRates) / $totalEvents, 1) : 0;
    $highestAttendanceEvent = collect($attendanceRates)->sortDesc()->keys()->first();
    $lowestAttendanceEvent = collect($attendanceRates)->sort()->keys()->first();
    $mostActiveDept = collect($departmentParticipation)->sortDesc()->keys()->first();

    // ===============================================
    // 🔮 Predictive & Spiritual Insights
    // ===============================================
    if ($avgAttendanceRate >= 90) {
        $spiritualInsight = "God is moving mightily — unity and devotion are increasing among the believers.";
    } elseif ($avgAttendanceRate >= 70) {
        $spiritualInsight = "A healthy level of engagement. Keep nurturing consistency through teaching and fellowship.";
    } elseif ($avgAttendanceRate >= 50) {
        $spiritualInsight = "Encourage members to renew their passion for service. Pray for fresh fire of commitment.";
    } else {
        $spiritualInsight = "A season for prayer and revival. The Spirit is calling the church to a deeper awakening.";
    }

    // Predict the next event’s expected attendance
    $predictedNextAttendance = $avgAttendanceRate >= 70
        ? min(100, $avgAttendanceRate + 5)
        : max(40, $avgAttendanceRate + 10);

    // ===============================================
    // 💡 AI-Style Action Suggestions
    // ===============================================
    $actionSuggestions = [
        'Schedule pre-event prayer chains to strengthen participation.',
        'Empower department leaders with follow-up responsibilities.',
        'Encourage testimonies to build excitement for upcoming gatherings.',
        'Analyze recurring low-attendance events and address timing conflicts.',
        'Use WhatsApp groups to remind and motivate members prayerfully.'
    ];

    // ===============================================
    // 📈 Analytics Summary
    // ===============================================
    $analyticsSummary = [
        'total_events' => $totalEvents,
        'total_attendance_records' => $totalAttendanceRecords,
        'avg_attendance_rate' => $avgAttendanceRate,
        'highest_attendance_event' => $highestAttendanceEvent,
        'lowest_attendance_event' => $lowestAttendanceEvent,
        'most_active_dept' => $mostActiveDept,
        'predicted_next_attendance' => $predictedNextAttendance,
    ];

    // ===============================================
    // 🧠 Prepare Chart Data
    // ===============================================
    $chartData = [
        'labels' => array_keys($attendanceRates),
        'data' => array_values($attendanceRates),
        'department_labels' => array_keys($departmentParticipation),
        'department_data' => array_values($departmentParticipation),
    ];

    // ===============================================
    // 📤 Send to View
    // ===============================================
    return view('churchly::attendance.events.analytics-overall', compact(
        'analyticsSummary',
        'chartData',
        'spiritualInsight',
        'actionSuggestions',
        'departmentComparison'
    ));
}



    public function destroy($id)
    {
        $event = Event::inWorkspace()->findOrFail($id);
        $event->delete();

        return back()->with('success', __('Event deleted successfully.'));
    }
}
