<?php

namespace Workdo\ChurchMeet\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Workdo\ChurchMeet\Entities\Event;
use Workdo\ChurchMeet\Entities\ChurchMember;
use Workdo\ChurchMeet\Entities\EventProgram;
use Workdo\ChurchMeet\Entities\AttendanceEvent;
use Barryvdh\DomPDF\Facade\Pdf;
use Workdo\ChurchMeet\Http\Controllers\SmsGatewayController;
use Workdo\ChurchMeet\Entities\ChurchBranch;
use Workdo\ChurchMeet\Entities\ChurchEventReviewerComment;
use Workdo\ChurchMeet\Entities\ChurchDepartment;
use Workdo\ChurchMeet\Entities\ChurchDesignation;
use Workdo\ChurchMeet\Entities\ZoomSyncSetting;
use Workdo\ChurchMeet\Entities\ZenderWaGroup;
use Workdo\ChurchMeet\Http\Controllers\AttendanceRecordController;
use Workdo\ChurchMeet\Services\JitsiMeetingService;
use Workdo\ChurchMeet\Services\LivekitMeetingService;
use Workdo\ChurchMeet\Services\ZoomMeetingService;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('workspace_id', getActiveWorkSpace())
            ->latest()
            ->paginate(20);

        $recentEvents = Event::where('workspace_id', getActiveWorkSpace())->orderBy('created_at', 'desc')->get();
       
          
        return view('churchmeet::attendance.events.index', compact('events', 'recentEvents'));
    }

    public function create()
    {
        // Ã¢Å“â€¦ Fetch all active church members for dropdowns
        $members = ChurchMember::forWorkspace()->select('id', 'name')->get();
        $branches = ChurchBranch::where('workspace', getActiveWorkSpace())->orderBy('name')->get();
        $departments = ChurchDepartment::where('workspace', getActiveWorkSpace())->orderBy('name')->get();
        $zoomSetting = ZoomSyncSetting::firstOrNew(['workspace_id' => getActiveWorkSpace()]);

        // Ã¢Å“â€¦ Pass members to your Blade view
        return view('churchmeet::attendance.events.create', compact('members', 'branches', 'departments', 'zoomSetting'));
    }
    public function store(
        Request $request,
        ZoomMeetingService $zoomMeetingService,
        JitsiMeetingService $jitsiMeetingService,
        LivekitMeetingService $livekitMeetingService
    )
    {
        $request->validate([
            'title'       => 'required|string|max:191',
            'event_type'  => 'required|string|max:100',
            'start_time'  => 'nullable|date',
            'end_time'    => 'nullable|date|after_or_equal:start_time',
            'venue'       => 'nullable|string|max:191',
            'description' => 'nullable|string',
            'mode' => 'required|string|in:onsite,online,hybrid',
            'branch_id' => 'nullable|exists:church_branches,id',
            'department_id' => 'nullable|exists:church_departments,id',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
            'radius_meters' => 'nullable|integer|min:1',
        ]);
        

        // Ã¢Å“â€¦ Save event
        $zoomSetting = ZoomSyncSetting::firstOrNew(['workspace_id' => getActiveWorkSpace()]);
        $resolvedOnlinePlatform = $this->resolveOnlinePlatform(
            (string) $request->mode,
            $request->input('online_platform'),
            $zoomSetting
        );
        $resolvedEnabledMethods = $this->resolveEnabledMethods(
            (string) $request->mode,
            $resolvedOnlinePlatform,
            $request->input('enabled_methods', [])
        );
        $autoLogAttendance = $request->has('auto_log_attendance')
            ? (bool) $request->boolean('auto_log_attendance')
            : in_array($request->mode, ['online', 'hybrid'], true);

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


         // Ã°Å¸Â§Â© Save Program Items
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
        // Ã°Å¸Â§Â© Save  Attendance Event
        $attendanceEvent = AttendanceEvent::create([
            'workspace_id' => getActiveWorkSpace(),
            'branch_id' => $request->branch_id,
            'department_id' => $request->department_id,
            'event_id'     => $event->id,
            'mode' => $request->mode,
            'enabled_methods' => $resolvedEnabledMethods,
            'online_platform' => $resolvedOnlinePlatform,
            'meeting_link' => $request->meeting_link,
            'meeting_id' => $request->meeting_id,
            'meeting_passcode' => $request->meeting_passcode,
            'auto_log_attendance' => $autoLogAttendance,
            'created_by' => Auth::id(),
        ]);

        $meetingMessage = $this->maybeCreateOnlineMeetingFromRequest(
            $request,
            $attendanceEvent,
            $zoomMeetingService,
            $jitsiMeetingService,
            $livekitMeetingService
        );


        // Ã¢Å“â€¦ Save uploaded files (if any)
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('event_files', 'public');
                $event->attachments = collect(json_decode($event->attachments ?? '[]'))->push($path)->toJson();
                $event->save();
            }
        }

        // Ã¢Å“â€¦ Send WhatsApp notifications to Lead & Assistant
        $lead = ChurchMember::find($request->lead_id);
        $assistant = ChurchMember::find($request->assistant_id);

        $previewUrl = route('churchmeet.events.review', $event->id);
        

        $start = $event->start_time ? date('D, M j, Y g:i A', strtotime($event->start_time)) : 'Not specified';
        $end = $event->end_time ? date('D, M j, Y g:i A', strtotime($event->end_time)) : 'Not specified';

        $message = "Ã°Å¸â€œÂ¢ *New Event Submission Alert*\n\n"
                . "A new event has been created and requires your review.\n\n"
                . "Ã°Å¸â€œÂ *Title:* {$event->title}\n"
                . "Ã°Å¸ÂÂ·Ã¯Â¸Â *Type:* {$event->event_type}\n"
                . "Ã°Å¸â€œÂ *Venue:* " . ($event->venue ?: 'To be announced') . "\n"
                . "Ã°Å¸â€¢â€™ *Start:* {$start}\n"
                . "Ã°Å¸â€¢â€œ *End:* {$end}\n"
                . "Ã°Å¸â€˜Â¤ *Created By:* " . (Auth::user()->name ?? 'Unknown User') . "\n\n"
                . "Ã°Å¸â€â€” *Click to Preview:* {$previewUrl}\n\n"
                . "Please review the details and approve this event at your earliest convenience.\n\n"
                . "_Your Church Event Management System_";

        $gateway = new SmsGatewayController();

        if ($lead && !empty($lead->phone)) {
            $gateway->sendZenderMessage($lead->phone, $message, 'whatsapp');
        }

        if ($assistant && !empty($assistant->phone)) {
            $gateway->sendZenderMessage($assistant->phone, $message, 'whatsapp');
        }
        
        $redirect = redirect()
            ->route('churchmeet.events.index')
            ->with('success', __('Event created successfully and submitted for review.'));

        if ($meetingMessage) {
            $redirect->with('warning', $meetingMessage);
        }

        return $redirect;
    }




    /*****************************************************************************
     * Step 2 Ã¢â‚¬â€ Review Stage
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

        return view('churchmeet::attendance.events.review', compact('event', 'members'));
    }

    /**
     * Step 2B Ã¢â‚¬â€ Submit Event for Approval or Request Adjustment
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

        // Ã¢Å“â€¦ Log reviewer comment (for both cases)
        if ($request->filled('comments')) {
            ChurchEventReviewerComment::create([
                'event_id' => $event->id,
                'user_id'  => Auth::id(),
                'role'     => 'Reviewer',
                'comment'  => $request->comments,
            ]);
        }

        /**
         * Ã°Å¸Å¸Â  CASE 1: Reviewer Requests Adjustments
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
                $editUrl = route('churchmeet.events.edit', $event->id);
                $message = "Ã¢Å¡Â Ã¯Â¸Â *Event Requires Adjustments*\n\n"
                    . "Your event *{$event->title}* has been reviewed but needs updates before approval.\n\n"
                    . "Ã°Å¸â€™Â¬ *Reviewer Comment:* " . ($request->comments ?: 'Please make the necessary changes.') . "\n\n"
                    . "Ã¢Å“ÂÃ¯Â¸Â *Edit and Resubmit:* {$editUrl}\n\n"
                    . "_Churchly Event Management System_";

                $gateway->sendZenderMessage($creator->phone, $message, 'whatsapp');
            }

            return redirect()
                ->route('churchmeet.events.index')
                ->with('success', __('Event sent back to the creator for adjustment.'));
        }

        /**
         * Ã°Å¸Å¸Â¢ CASE 2: Reviewer Approves for Next Stage
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
            $approveUrl = route('churchmeet.events.approve', $event->id);
            $message = "Ã¢Å“â€¦ *Event Ready for Approval*\n\n"
                . "The event *{$event->title}* has been reviewed and is ready for final approval.\n\n"
                . "Ã°Å¸â€œâ€¦ *Type:* {$event->event_type}\n"
                . "Ã°Å¸â€œÂ *Venue:* " . ($event->venue ?: 'Not specified') . "\n"
                . "Ã°Å¸â€˜Â¤ *Reviewed By:* {$reviewerName}\n\n"
                . "Ã°Å¸â€â€” *Approve Here:* {$approveUrl}\n\n"
                . "_Churchly Notification System_";

            $gateway->sendZenderMessage($lead->phone, $message, 'whatsapp');
        }

        return redirect()
            ->route('churchmeet.events.index')
            ->with('success', __('Event submitted for approval successfully.'));
    }


    /*****************************************************************************
     * Step 3 Ã¢â‚¬â€ Approver Stage
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

        return view('churchmeet::attendance.events.approve', compact('event'));
    }

    /**
     * Step 3B Ã¢â‚¬â€ Handle Approval or Rejection
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

        // Ã¢Å“â€¦ Log approver comment (for transparency)
        if ($request->filled('comments')) {
            ChurchEventReviewerComment::create([
                'event_id' => $event->id,
                'user_id'  => Auth::id(),
                'role'     => 'Approver',
                'comment'  => $request->comments,
            ]);
        }

        // Ã°Å¸Å¸Â¢ CASE 1: APPROVED
        if ($request->action === 'approve') {
            $event->update([
                'status'           => 'approved',
                'approved_by'      => Auth::id(),
                'approved_at'      => now(),
                'approver_comments'=> $request->comments,
            ]);

            // Ã¢Å“â€¦ Notify creator that the event is approved
            $creator = $event->creator ?? ChurchMember::where('user_id', $event->created_by)->first();
            if ($creator && !empty($creator->phone)) {
                $publishUrl = route('churchmeet.events.publish', $event->id);
                $message = "Ã°Å¸Å½â€° *Event Approved!*\n\n"
                    . "Your event *{$event->title}* has been approved and is now ready for publishing.\n\n"
                    . "Ã°Å¸â€™Â¬ *Approver Comment:* " . ($request->comments ?: 'Approved successfully.') . "\n\n"
                    . "Ã°Å¸â€œÂ¢ *Publish Here:* {$publishUrl}\n\n"
                    . "_Churchly Approval System_";
                $gateway->sendZenderMessage($creator->phone, $message, 'whatsapp');
            }

            $msg = __('Event approved successfully.');

        // Ã°Å¸â€Â´ CASE 2: REJECTED
        } else {
            $event->update([
                'status'           => 'rejected',
                'approver_comments'=> $request->comments,
                'approved_by'      => Auth::id(),
                'approved_at'      => now(),
            ]);

            // Ã¢Å“â€¦ Notify creator that the event was rejected
            $creator = $event->creator ?? ChurchMember::where('user_id', $event->created_by)->first();
            if ($creator && !empty($creator->phone)) {
                $message = "Ã¢ÂÅ’ *Event Rejected*\n\n"
                    . "Your event *{$event->title}* was reviewed but not approved.\n\n"
                    . "Ã°Å¸â€™Â¬ *Approver Comment:* " . ($request->comments ?: 'No additional comments provided.') . "\n\n"
                    . "Please revise and resubmit if applicable.\n\n"
                    . "_Churchly Approval System_";
                $gateway->sendZenderMessage($creator->phone, $message, 'whatsapp');
            }

            $msg = __('Event was rejected.');
        }

        // Redirect to Publish Stage or back to list
        return redirect()
            ->route('churchmeet.events.publish', $event->id)
            ->with('success', $msg);
    }


    /**
    * Step 4 Ã¢â‚¬â€œ Publishing Stage
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

        return view('churchmeet::attendance.events.publish', compact('event', 'members', 'groups'));
    }


    /**
 * Step 4B Ã¢â‚¬â€œ Perform Publish Action
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

    // Ã¢Å“â€¦ Update event status
    $event->update([
        'status' => 'published',
        'published_by' => Auth::id(),
        'published_at' => now(),
    ]);

    $gateway = new SmsGatewayController();

    // ===========================================
    // Ã°Å¸â€œâ€¹ Basic Event Information
    // ===========================================
    $title = $event->title;
    $start = $event->start_time ? date('D, d M Y Ã¢â‚¬Â¢ h:i A', strtotime($event->start_time)) : 'To Be Announced';
    $venue = $event->venue ?? 'To Be Announced';
    $pdfUrl = route('churchmeet.events.export.pdf', $event->id);

    // ===========================================
    // Ã¢Å“â€°Ã¯Â¸Â Main Group Message (Faith-centered and clear)
    // ===========================================
    $mainMessage =
        "*{$title}*\n\n"
        . "Ã°Å¸â€œâ€¦ Date & Time: {$start}\n"
        . "Ã°Å¸â€œÂ Venue: {$venue}\n\n"
        . "Let us prayerfully prepare and wait on the Lord for this gathering. "
        . "May His presence lead every activity and every heart be strengthened for His glory.\n\n"
        . "Ã°Å¸â€â€” View full event details in PDF:\n{$pdfUrl}\n\n"
        . "_Churchly Event Management System_";

    // ===========================================
    // Ã°Å¸â€˜Â¤ Notify Program Leaders Individually
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
                . "Ã°Å¸â€â€” Event Details (PDF): {$pdfUrl}\n\n"
                . "_Churchly Event System_";

            $gateway->sendZenderMessage($program->leader->phone, $leaderMsg, 'whatsapp');
        }
    }

    // ===========================================
    // Ã°Å¸â€˜Â¥ Notify Lead, Assistant, and Creator
    // ===========================================
    $notifyList = [
        $event->lead?->phone,
        $event->assistant?->phone,
        $event->creator?->phone,
    ];

    $personalMsg =
        "Dear Team,\n\n"
        . "The event *{$title}* has been published.\n"
        . "Ã°Å¸â€œâ€¦ {$start}\n"
        . "Ã°Å¸â€œÂ {$venue}\n\n"
        . "Please coordinate with all assigned participants and continue in prayerful preparation.\n\n"
        . "Ã°Å¸â€â€” Event PDF: {$pdfUrl}\n\n"
        . "_Churchly Event System_";

    foreach (array_filter($notifyList) as $phone) {
        $gateway->sendZenderMessage($phone, $personalMsg, 'whatsapp');
    }

    // ===========================================
    // Ã°Å¸ÂÂ¢ Send to Selected WhatsApp Groups
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
    // Ã¢Å¾â€¢ Notify Additional Members
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
    // Ã¢Å“â€¦ Final Confirmation
    // ===========================================
    return redirect()
        ->route('churchmeet.events.index')
        ->with('success', __('Event published successfully and all notifications have been sent prayerfully.'));
}



    /**
     * show
     */

    /**
 * Step 5 Ã¢â‚¬â€ Display Full Event Details
 * Shows the complete event profile with attendance, program schedule, and reviewer discussion.
 */
    public function show($id)
    {
        $resolvedId = Event::decodePublicViewKey((string) $id);
        abort_if(!$resolvedId, 404, __('Event link is invalid.'));

        // Ã¢Å“â€¦ Load the event with all relations for a full detail view
        $event = Event::with([
                'lead',
                'assistant',
                'creator',
                'programs.leader',
                'reviewerComments.user'
            ])
            ->inWorkspace()
            ->findOrFail($id);

        // Ã¢Å“â€¦ Load attendance data if available
        $attendanceEvent = AttendanceEvent::with(['event', 'records.member'])
            ->where('event_id', $event->id)
            ->first();

        // Ã¢Å“â€¦ Attendance stats summary
        $attendanceStats = [
            'total_registered' => $attendanceEvent?->records?->count() ?? 0,
            'present' => $attendanceEvent?->records?->where('status', 'present')->count() ?? 0,
            'absent'  => $attendanceEvent?->records?->where('status', 'absent')->count() ?? 0,
        ];

        // Ã¢Å“â€¦ Format times for clean display
        $event->formatted_start = $event->start_time
            ? \Carbon\Carbon::parse($event->start_time)->format('D, M j, Y Ã¢â‚¬Â¢ g:i A')
            : 'Not specified';
        $event->formatted_end = $event->end_time
            ? \Carbon\Carbon::parse($event->end_time)->format('D, M j, Y Ã¢â‚¬Â¢ g:i A')
            : 'Not specified';

        // Ã¢Å“â€¦ Prepare comment thread for discussion view
        $event->formatted_start = $event->start_time
            ? \Carbon\Carbon::parse($event->start_time)->format('D, M j, Y g:i A')
            : 'Not specified';
        $event->formatted_end = $event->end_time
            ? \Carbon\Carbon::parse($event->end_time)->format('D, M j, Y g:i A')
            : 'Not specified';

        $reviewComments = $event->reviewerComments()
            ->with('user')
            ->orderBy('commented_at', 'asc')
            ->get();
        $meetingPlatform = strtolower((string) ($attendanceEvent?->online_platform ?? ''));
        $canCreateOnlineMeeting = $this->userCanCreateOnlineMeeting($attendanceEvent);
        $canCreateZoomMeeting = $canCreateOnlineMeeting && $meetingPlatform === 'zoom';
        $canCreateJitsiMeeting = $canCreateOnlineMeeting && $meetingPlatform === 'jitsi';
        $canCreateLivekitMeeting = $canCreateOnlineMeeting && $meetingPlatform === 'livekit';
        $canJoinOnlineMeeting = $this->canJoinOnlineMeeting($attendanceEvent);

        // Ã¢Å“â€¦ Send all context to the view
        return view('churchmeet::attendance.events.show', compact(
            'event',
            'attendanceEvent',
            'attendanceStats',
            'reviewComments',
            'canCreateZoomMeeting',
            'canCreateJitsiMeeting',
            'canCreateLivekitMeeting',
            'canJoinOnlineMeeting',
            'meetingPlatform'
        ));
    }

    
     public function exportPdf($id)
    {
        $event = Event::with(['lead', 'assistant', 'programs.leader'])->findOrFail($id);

        return view('churchmeet::attendance.events.pdf', compact('event'));

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
            ->findOrFail($resolvedId);

        $attendanceEvent = AttendanceEvent::where('event_id', $id)
            ->where('workspace_id', getActiveWorkSpace())
            ->first();
        $events = Event::all();
        $members = ChurchMember::forWorkspace()->select('id', 'name')->get();
        $branches = ChurchBranch::where('workspace', getActiveWorkSpace())->orderBy('name')->get();
        $departments = ChurchDepartment::where('workspace', getActiveWorkSpace())->orderBy('name')->get();
        $zoomSetting = ZoomSyncSetting::firstOrNew(['workspace_id' => getActiveWorkSpace()]);

        return view('churchmeet::attendance.events.edit', compact('event', 'members', 'events', 'attendanceEvent', 'branches', 'departments', 'zoomSetting'));
    }


    public function update(
        Request $request,
        $id,
        ZoomMeetingService $zoomMeetingService,
        JitsiMeetingService $jitsiMeetingService,
        LivekitMeetingService $livekitMeetingService
    )
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
        'branch_id' => 'nullable|exists:church_branches,id',
        'department_id' => 'nullable|exists:church_departments,id',
        'latitude'    => 'nullable|numeric',
        'longitude'   => 'nullable|numeric',
        'radius_meters' => 'nullable|integer|min:1',
        
    ]);

    // Ã¢Å“â€¦ Update main event
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

    $attendanceEvent = AttendanceEvent::firstOrNew([
        'workspace_id' => getActiveWorkSpace(),
        'event_id' => $event->id,
    ]);

    $zoomSetting = ZoomSyncSetting::firstOrNew(['workspace_id' => getActiveWorkSpace()]);
    $resolvedOnlinePlatform = $this->resolveOnlinePlatform(
        (string) $request->mode,
        $request->input('online_platform'),
        $zoomSetting
    );
    $resolvedEnabledMethods = $this->resolveEnabledMethods(
        (string) $request->mode,
        $resolvedOnlinePlatform,
        $request->input('enabled_methods', $attendanceEvent->enabled_methods ?? [])
    );
    $autoLogAttendance = $request->has('auto_log_attendance')
        ? (bool) $request->boolean('auto_log_attendance')
        : in_array($request->mode, ['online', 'hybrid'], true);

    $attendanceEvent->branch_id = $request->branch_id;
    $attendanceEvent->department_id = $request->department_id;
    $attendanceEvent->mode = $request->mode;
    $attendanceEvent->enabled_methods = $resolvedEnabledMethods;
    $attendanceEvent->online_platform = $resolvedOnlinePlatform;
    $attendanceEvent->meeting_link = $request->meeting_link;
    $attendanceEvent->meeting_id = $request->meeting_id;
    $attendanceEvent->meeting_passcode = $request->meeting_passcode;
    $attendanceEvent->auto_log_attendance = $autoLogAttendance;
    $attendanceEvent->created_by = $attendanceEvent->created_by ?: Auth::id();
    $attendanceEvent->save();

    // Ã¢Å“â€¦ Refresh program items
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
    if ($status === 'resubmitted')
    {

    // Ã¢Å“â€¦ Send WhatsApp notifications to Lead & Assistant
            $lead = ChurchMember::find($request->lead_id);
            $assistant = ChurchMember::find($request->assistant_id);

            $previewUrl = route('churchmeet.events.review', $event->id);
            

            $start = $event->start_time ? date('D, M j, Y g:i A', strtotime($event->start_time)) : 'Not specified';
            $end = $event->end_time ? date('D, M j, Y g:i A', strtotime($event->end_time)) : 'Not specified';

            $message = "Ã°Å¸â€œÂ¢ *Event Resubmission Alert*\n\n"
                    . "An event has been Modified as requested and resubmited for your review.\n\n"
                    . "Ã°Å¸â€œÂ *Title:* {$event->title}\n"
                    . "Ã°Å¸ÂÂ·Ã¯Â¸Â *Type:* {$event->event_type}\n"
                    . "Ã°Å¸â€œÂ *Venue:* " . ($event->venue ?: 'To be announced') . "\n"
                    . "Ã°Å¸â€¢â€™ *Start:* {$start}\n"
                    . "Ã°Å¸â€¢â€œ *End:* {$end}\n"
                    . "Ã°Å¸â€˜Â¤ *Created By:* " . (Auth::user()->name ?? 'Unknown User') . "\n\n"
                    . "Ã°Å¸â€â€” *Click to Preview:* {$previewUrl}\n\n"
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
    $meetingMessage = $this->maybeCreateOnlineMeetingFromRequest(
        $request,
        $attendanceEvent,
        $zoomMeetingService,
        $jitsiMeetingService,
        $livekitMeetingService
    );

    $redirect = redirect()
        ->route('churchmeet.events.index')
        ->with('success', __('Event updated successfully.'));

    if ($meetingMessage) {
        $redirect->with('warning', $meetingMessage);
    }

    return $redirect;
}


/**
 * Step 5 Ã¢â‚¬â€œ Overall Event Analytics & Insight Dashboard
 * Provides comprehensive analysis across all events,
 * covering attendance trends, department participation,
 * and predictive faith-based insights.
 */
public function analytics()
{
    $workspaceId = getActiveWorkSpace();

    $events = Event::with(['programs', 'attendanceEvents.records.member'])
        ->inWorkspace()
        ->where('status', 'published')
        ->orderBy('start_time', 'desc')
        ->get();

    $departments = ChurchDepartment::where('workspace', $workspaceId)
        ->pluck('name', 'id')
        ->toArray();

    $memberDepartments = \DB::table('church_member_department')
        ->where('workspace', $workspaceId)
        ->select('church_member_id', 'department_id')
        ->get()
        ->groupBy('church_member_id')
        ->map(fn ($rows) => $rows->pluck('department_id')->unique()->values()->all())
        ->toArray();

    $departmentMembersCount = \DB::table('church_member_department')
        ->where('workspace', $workspaceId)
        ->select('department_id', \DB::raw('COUNT(DISTINCT church_member_id) as total_members'))
        ->groupBy('department_id')
        ->pluck('total_members', 'department_id')
        ->toArray();

    $totalEvents = $events->count();
    $totalMembers = ChurchMember::forWorkspace()->count();

    // ===============================================
    // Ã°Å¸â€œÅ  Aggregate Event-Level Metrics
    // ===============================================
    $totalAttendanceRecords = 0;
    $attendanceRates = [];
    $departmentParticipation = [];

    foreach ($events as $event) {
        $attendanceCount = $event->attendanceEvents->sum(
            fn ($attendanceEvent) => $attendanceEvent->records->count()
        );
        $rate = $totalMembers > 0 ? round(($attendanceCount / $totalMembers) * 100, 1) : 0;
        $attendanceRates[$event->title] = $rate;
        $totalAttendanceRecords += $attendanceCount;

        foreach ($event->attendanceEvents as $attendanceEvent) {
            foreach ($attendanceEvent->records as $record) {
                $memberId = $record->member_id ?? null;
                $departmentIds = $memberId ? ($memberDepartments[$memberId] ?? []) : [];

                if ($departmentIds === []) {
                    $departmentParticipation['Unassigned'] = ($departmentParticipation['Unassigned'] ?? 0) + 1;
                    continue;
                }

                foreach ($departmentIds as $departmentId) {
                    $departmentName = $departments[$departmentId] ?? 'Unassigned';
                    $departmentParticipation[$departmentName] = ($departmentParticipation[$departmentName] ?? 0) + 1;
                }
            }
        }
    }

    $assignedMemberIds = array_map('intval', array_keys($memberDepartments));
    $unassignedMembersQuery = ChurchMember::forWorkspace();
    if ($assignedMemberIds !== []) {
        $unassignedMembersQuery->whereNotIn('id', $assignedMemberIds);
    }
    $unassignedMemberCount = $unassignedMembersQuery->count();

    $departmentAttendancePercentages = [];

    foreach ($departmentParticipation as $deptName => $presentCount) {
        $deptId = array_search($deptName, $departments, true);
        $departmentTotalMembers = $deptName === 'Unassigned'
            ? $unassignedMemberCount
            : ($departmentMembersCount[$deptId] ?? 0);
        $percentage = $departmentTotalMembers > 0 ? round(($presentCount / $departmentTotalMembers) * 100, 1) : 0;

        $departmentAttendancePercentages[$deptName] = [
            'present' => $presentCount,
            'total'   => $departmentTotalMembers,
            'rate'    => $percentage,
        ];
    }

    uasort($departmentAttendancePercentages, function (array $left, array $right) {
        return $right['rate'] <=> $left['rate'];
    });

    $departmentComparison = $departmentAttendancePercentages;


    // ===============================================
    // Ã¢Å¡â„¢Ã¯Â¸Â Calculate Averages and Trends
    // ===============================================
    $avgAttendanceRate = $totalEvents > 0 ? round(array_sum($attendanceRates) / $totalEvents, 1) : 0;
    $highestAttendanceEvent = collect($attendanceRates)->sortDesc()->keys()->first();
    $lowestAttendanceEvent = collect($attendanceRates)->sort()->keys()->first();
    $mostActiveDept = collect($departmentParticipation)->sortDesc()->keys()->first();

    // ===============================================
    // Ã°Å¸â€Â® Predictive & Spiritual Insights
    // ===============================================
    if ($avgAttendanceRate >= 90) {
        $spiritualInsight = "God is moving mightily Ã¢â‚¬â€ unity and devotion are increasing among the believers.";
    } elseif ($avgAttendanceRate >= 70) {
        $spiritualInsight = "A healthy level of engagement. Keep nurturing consistency through teaching and fellowship.";
    } elseif ($avgAttendanceRate >= 50) {
        $spiritualInsight = "Encourage members to renew their passion for service. Pray for fresh fire of commitment.";
    } else {
        $spiritualInsight = "A season for prayer and revival. The Spirit is calling the church to a deeper awakening.";
    }

    // Predict the next eventÃ¢â‚¬â„¢s expected attendance
    $predictedNextAttendance = $avgAttendanceRate >= 70
        ? min(100, $avgAttendanceRate + 5)
        : max(40, $avgAttendanceRate + 10);

    // ===============================================
    // Ã°Å¸â€™Â¡ AI-Style Action Suggestions
    // ===============================================
    $actionSuggestions = [
        'Schedule pre-event prayer chains to strengthen participation.',
        'Empower department leaders with follow-up responsibilities.',
        'Encourage testimonies to build excitement for upcoming gatherings.',
        'Analyze recurring low-attendance events and address timing conflicts.',
        'Use WhatsApp groups to remind and motivate members prayerfully.'
    ];

    // ===============================================
    // Ã°Å¸â€œË† Analytics Summary
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
    // Ã°Å¸Â§Â  Prepare Chart Data
    // ===============================================
    $chartData = [
        'labels' => array_keys($attendanceRates),
        'data' => array_values($attendanceRates),
        'department_labels' => array_keys($departmentAttendancePercentages),
        'department_data' => array_column($departmentAttendancePercentages, 'rate'),
    ];

    // ===============================================
    // Ã°Å¸â€œÂ¤ Send to View
    // ===============================================
    return view('churchmeet::attendance.events.analytics-overall', compact(
        'analyticsSummary',
        'chartData',
        'spiritualInsight',
        'actionSuggestions',
        'departmentComparison'
    ));
}



    protected function maybeCreateOnlineMeetingFromRequest(
        Request $request,
        AttendanceEvent $attendanceEvent,
        ZoomMeetingService $zoomMeetingService,
        JitsiMeetingService $jitsiMeetingService,
        LivekitMeetingService $livekitMeetingService
    ): ?string
    {
        $platform = strtolower((string) ($attendanceEvent->online_platform ?: $request->input('online_platform')));
        $shouldAutoCreateZoomMeeting = $request->boolean('create_zoom_meeting')
            || (
                $platform === 'zoom'
                && empty($attendanceEvent->meeting_id)
                && empty($attendanceEvent->meeting_link)
            );

        if ($shouldAutoCreateZoomMeeting) {
            if ($attendanceEvent->meeting_id) {
                return null;
            }

            $setting = ZoomSyncSetting::firstOrNew(['workspace_id' => getActiveWorkSpace()]);

            if (!$setting->account_id || !$setting->client_id || !$setting->client_secret) {
                return __('Event saved, but Zoom meeting was not created because Zoom OAuth is not configured.');
            }

            try {
                $zoomMeetingService->createMeetingForAttendanceEvent(
                    $setting,
                    $attendanceEvent,
                    $setting->host_user_id ?: 'me'
                );
            } catch (\Throwable $exception) {
                return __('Event saved, but Zoom meeting creation failed: :message', ['message' => $exception->getMessage()]);
            }

            return null;
        }

        $shouldAutoCreateJitsiMeeting = $request->boolean('create_jitsi_meeting')
            || (
                $platform === 'jitsi'
                && empty($attendanceEvent->meeting_id)
                && empty($attendanceEvent->meeting_link)
            );

        if ($shouldAutoCreateJitsiMeeting) {
            try {
                $jitsiMeetingService->createRoomForAttendanceEvent(
                    $attendanceEvent,
                    $request->input('jitsi_domain'),
                    $request->input('meeting_id')
                );
            } catch (\Throwable $exception) {
                return __('Event saved, but Jitsi room creation failed: :message', ['message' => $exception->getMessage()]);
            }
        }

        $shouldAutoCreateLivekitMeeting = $request->boolean('create_livekit_meeting')
            || (
                $platform === 'livekit'
                && empty($attendanceEvent->meeting_id)
                && empty($attendanceEvent->meeting_link)
            );

        if ($shouldAutoCreateLivekitMeeting) {
            $setting = ZoomSyncSetting::firstOrNew(['workspace_id' => getActiveWorkSpace()]);

            if (!$livekitMeetingService->canUseLiveKit($setting)) {
                return __('Event saved, but LiveKit room creation was skipped because LiveKit is not fully configured.');
            }

            try {
                $livekitMeetingService->createRoomForAttendanceEvent(
                    $setting,
                    $attendanceEvent,
                    $request->input('meeting_id')
                );
            } catch (\Throwable $exception) {
                return __('Event saved, but LiveKit room creation failed: :message', ['message' => $exception->getMessage()]);
            }
        }

        return null;
    }

    protected function resolveOnlinePlatform(string $mode, $requestedPlatform, ZoomSyncSetting $setting): ?string
    {
        if (!in_array($mode, ['online', 'hybrid'], true)) {
            return null;
        }

        $requested = strtolower(trim((string) $requestedPlatform));
        $allowed = ['zoom', 'jitsi', 'livekit', 'youtube', 'custom'];

        if (in_array($requested, $allowed, true)) {
            return $requested;
        }

        $preferred = strtolower(trim((string) ($setting->preferred_platform ?: 'jitsi')));

        if ($preferred === 'zoom' && (!$setting->account_id || !$setting->client_id || !$setting->client_secret)) {
            $preferred = !empty($setting->livekit_enabled) && !empty($setting->livekit_server_url) && !empty($setting->livekit_api_key) && !empty($setting->livekit_api_secret)
                ? 'livekit'
                : 'jitsi';
        }

        if ($preferred === 'livekit' && (
            empty($setting->livekit_enabled)
            || empty($setting->livekit_server_url)
            || empty($setting->livekit_api_key)
            || empty($setting->livekit_api_secret)
        )) {
            $preferred = 'jitsi';
        }

        return in_array($preferred, $allowed, true) ? $preferred : 'jitsi';
    }

    protected function resolveEnabledMethods(string $mode, ?string $platform, $requestedMethods): array
    {
        $methods = is_array($requestedMethods) ? $requestedMethods : [];
        $methods = array_values(array_unique(array_filter(array_map('strval', $methods))));

        if (!empty($methods)) {
            return $methods;
        }

        $defaults = ['manual'];

        if ($mode !== 'online') {
            $defaults[] = 'qr';
        }

        if ($mode === 'onsite') {
            $defaults[] = 'kiosk';
        }

        if ($platform && in_array($platform, ['zoom', 'jitsi', 'livekit', 'youtube'], true)) {
            $defaults[] = $platform;
        }

        return array_values(array_unique($defaults));
    }

    protected function userCanCreateOnlineMeeting(?AttendanceEvent $attendanceEvent): bool
    {
        $user = Auth::user();

        if (!$user || !$attendanceEvent) {
            return false;
        }

        if (
            $user->isAbleTo('churchly settings manage') ||
            $user->isAbleTo('churchly event manage') ||
            $user->isAbleTo('churchly event create')
        ) {
            return true;
        }

        if (!$attendanceEvent->department_id) {
            return false;
        }

        $churchMember = ChurchMember::forWorkspace()->where('user_id', $user->id)->first();

        if (!$churchMember) {
            return false;
        }

        $keywords = ['leader', 'head', 'pastor', 'minister', 'director', 'coordinator', 'hod'];
        $designationIds = $churchMember->departments()
            ->where('church_departments.id', $attendanceEvent->department_id)
            ->withPivot('designation_id')
            ->get()
            ->pluck('pivot.designation_id')
            ->filter();

        if ($designationIds->isEmpty()) {
            return false;
        }

        return ChurchDesignation::whereIn('id', $designationIds)
            ->where(function ($query) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $query->orWhere('name', 'like', '%' . $keyword . '%');
                }
            })
            ->exists();
    }

    protected function canJoinOnlineMeeting(?AttendanceEvent $attendanceEvent): bool
    {
        if (!$attendanceEvent) {
            return false;
        }

        $platform = strtolower((string) $attendanceEvent->online_platform);

        if ($platform === 'zoom') {
            return !empty($attendanceEvent->meeting_id);
        }

        if ($platform === 'jitsi') {
            return !empty($attendanceEvent->meeting_id) || !empty($attendanceEvent->meeting_link);
        }

        if ($platform === 'livekit') {
            return !empty($attendanceEvent->meeting_id);
        }

        return false;
    }

    public function destroy($id)
    {
        $event = Event::inWorkspace()->findOrFail($id);
        $event->delete();

        return back()->with('success', __('Event deleted successfully.'));
    }
}

