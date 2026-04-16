<?php

use Illuminate\Support\Facades\Route;
use Workdo\ChurchMeet\Http\Controllers\AttendanceEventController;
use Workdo\ChurchMeet\Http\Controllers\AttendanceRecordController;
use Workdo\ChurchMeet\Http\Controllers\AttendanceReportController;
use Workdo\ChurchMeet\Http\Controllers\EventController;
use Workdo\ChurchMeet\Http\Controllers\MeetingRoomController;
use Workdo\ChurchMeet\Http\Controllers\ZoomIntegrationController;
use Workdo\ChurchMeet\Http\Controllers\ZoomMeetingController;

Route::prefix('churchmeet')->name('churchmeet.')->group(function () {
    Route::resource('events', EventController::class);
    Route::get('events/{id}/export-pdf', [EventController::class, 'exportPdf'])->name('events.export.pdf');
    Route::get('events/analytics', [EventController::class, 'analytics'])->name('events.analytics');
    Route::get('events/analytics/overall', [EventController::class, 'analytics'])->name('events.analytics.overall');
    Route::get('events/{id}/review', [EventController::class, 'review'])->name('events.review');
    Route::post('events/{id}/submit-review', [EventController::class, 'submitForReview'])->name('events.submitReview');
    Route::get('events/{id}/approve', [EventController::class, 'approve'])->name('events.approve');
    Route::post('events/{id}/approve-action', [EventController::class, 'approveAction'])->name('events.approveAction');
    Route::get('events/{id}/publish', [EventController::class, 'publish'])->name('events.publish');
    Route::post('events/{id}/publish-action', [EventController::class, 'publishAction'])->name('events.publishAction');

    Route::resource('attendance_events', AttendanceEventController::class);
    Route::get('attendance_events/{event}/scan', [AttendanceEventController::class, 'showScanner'])->name('attendance_events.scan');
    Route::post('attendance_events/{event}/mark', [AttendanceEventController::class, 'markAttendance'])->name('attendance_events.mark');

    Route::post('attendance/{attendanceEvent}/manual', [AttendanceRecordController::class, 'manualCheckIn'])->name('attendance.manualCheckIn');
    Route::post('attendance/{attendanceEvent}/qr', [AttendanceRecordController::class, 'qrCheckIn'])->name('attendance.qrCheckIn');
    Route::post('attendance/{attendanceEvent}/kiosk', [AttendanceRecordController::class, 'kioskCheckIn'])->name('attendance.kioskCheckIn');
    Route::post('attendance/{attendanceEvent}/face', [AttendanceRecordController::class, 'faceAiCheckIn'])->name('attendance.faceAiCheckIn');
    Route::post('attendance/{attendanceEvent}/online', [AttendanceRecordController::class, 'onlineCheckIn'])->name('attendance.onlineCheckIn');
    Route::get('attendance/search-member', [AttendanceRecordController::class, 'searchMember'])->name('attendance.searchMember');

    Route::get('attendance/reports/dashboard', [AttendanceReportController::class, 'dashboard'])->name('attendance.reports.dashboard');
    Route::get('attendance/reports/event/{id}', [AttendanceReportController::class, 'eventReport'])->name('attendance.reports.event');
    Route::get('attendance/reports/member/{id}', [AttendanceReportController::class, 'memberReport'])->name('attendance.reports.member');
    Route::get('attendance/reports/branch/{id}', [AttendanceReportController::class, 'branchReport'])->name('attendance.reports.branch');

    Route::get('meetings/{attendanceEvent}/join', [MeetingRoomController::class, 'join'])->name('meetings.join');
    Route::post('meetings/{attendanceEvent}/presence', [MeetingRoomController::class, 'markPresence'])->name('meetings.presence');
    Route::post('events/{event}/jitsi/create', [MeetingRoomController::class, 'createJitsiForEvent'])->name('jitsi.meetings.create');
    Route::post('events/{event}/livekit/create', [MeetingRoomController::class, 'createLiveKitForEvent'])->name('livekit.meetings.create');

    Route::get('integrations', [ZoomIntegrationController::class, 'index'])->name('integrations.index');
    Route::post('integrations', [ZoomIntegrationController::class, 'save'])->name('integrations.save');
    Route::get('integrations/zoom/test', [ZoomIntegrationController::class, 'test'])->name('integrations.zoom.test');
    Route::get('integrations/zoom/sync', [ZoomIntegrationController::class, 'syncNow'])->name('integrations.zoom.sync');

    Route::get('zoom', [ZoomIntegrationController::class, 'index'])->name('zoom.index');
    Route::post('zoom', [ZoomIntegrationController::class, 'save'])->name('zoom.save');
    Route::get('zoom/test', [ZoomIntegrationController::class, 'test'])->name('zoom.test');
    Route::get('zoom/sync', [ZoomIntegrationController::class, 'syncNow'])->name('zoom.sync');
    Route::post('events/{event}/zoom/create', [ZoomMeetingController::class, 'createForEvent'])->name('zoom.meetings.create');
    Route::get('zoom/meetings/{attendanceEvent}/join', [ZoomMeetingController::class, 'join'])->name('zoom.meetings.join');
    Route::post('zoom/meetings/{attendanceEvent}/signature', [ZoomMeetingController::class, 'signature'])->name('zoom.meetings.signature');
});
