<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Workdo\Churchly\Http\Controllers\DashboardController;
use Workdo\Churchly\Http\Controllers\TimerController;
use Workdo\Churchly\Http\Controllers\MemberController;
use Workdo\Churchly\Http\Controllers\ChurchBranchController;
use Workdo\Churchly\Http\Controllers\ChurchDepartmentController;
use Workdo\Churchly\Http\Controllers\ChurchDesignationController;
use Workdo\Churchly\Http\Controllers\ChurchFeedbackController;
use Workdo\Churchly\Http\Controllers\SmsGatewayController;
use Workdo\Churchly\Http\Controllers\WaGroupController; 
use Workdo\Churchly\Http\Controllers\FormSetupController; // FormSetupController
use Workdo\Churchly\Http\Controllers\BirthdayCardController;
use Workdo\Churchly\Http\Controllers\BirthdayTemplateController;
use Workdo\Churchly\Http\Controllers\DiscipleshipController;

use Workdo\Churchly\Http\Controllers\EventController;
use Workdo\Churchly\Http\Controllers\AttendanceEventController;
use Workdo\Churchly\Http\Controllers\AttendanceRecordController;
use Workdo\Churchly\Http\Controllers\AttendanceReportController;
use Workdo\Churchly\Http\Controllers\AppBuilderController;
use Workdo\Churchly\Http\Controllers\VolunteerController;
use Workdo\Churchly\Http\Controllers\VolunteerSkillController;
use Workdo\Churchly\Http\Controllers\VolunteerTrainingController;
use Workdo\Churchly\Http\Controllers\VolunteerAvailabilityController;
use Workdo\Churchly\Http\Controllers\VolunteerAssignmentController;
use Workdo\Churchly\Http\Controllers\HouseholdController;
use Workdo\Churchly\Http\Controllers\MemberNoteController;
use Workdo\Churchly\Http\Controllers\MemberFollowUpController;
use Workdo\Churchly\Http\Controllers\MemberCommunicationController;
use Workdo\Churchly\Http\Controllers\SmartTagController;


Route::middleware(['web', 'auth'])->group(function () {

    // Dashboard and Timer
    Route::get('dashboard/church', [DashboardController::class, 'index'])->name('dashboard.church');
    Route::get('timer', [TimerController::class, 'timer'])->name('timer.church');
    Route::get('doc', [TimerController::class, 'doc'])->name('timer.doc');

    // Members CRUD (use custom show route with encrypted IDs)
    Route::resource('members', MemberController::class)->except(['show']);
   // Route::get('members-grid', [MemberController::class, 'grid'])->name('members.grid');
    Route::get('members/{id}', [MemberController::class, 'show'])->name('members.show');

    // Import/Export pages
    Route::get('members/import/export', [MemberController::class, 'fileImportExport'])->name('members.import.export');
    Route::get('members/import/modal', [MemberController::class, 'fileImportModal'])->name('members.import.modal');
    Route::get('members/import/sample', [MemberController::class, 'downloadSample'])->name('members.import.sample');

    // Import processing
    Route::post('members/import/file', [MemberController::class, 'fileImport'])->name('members.import.file'); // ?????? clearer
    Route::get('members/import/preview', [MemberController::class, 'memberImportPreview'])->name('members.import.preview');
    Route::post('members/import/confirm', [MemberController::class, 'memberImportConfirm'])->name('members.import.confirm');
        Route::post('members/import/google', [MemberController::class, 'importCsvFromDrive'])->name('members.import.google');

    // Member Detail drill-down
    Route::get('members/{id}/detail', [MemberController::class, 'memberDetail'])->name('members.detail');

    Route::post('/members/{id}/generate-qr', [MemberController::class, 'generateQr'])
        ->name('churchly.members.generate_qr');

    // Volunteer Management
    Route::prefix('churchly')->name('churchly.')->group(function () {
        Route::resource('volunteers', VolunteerController::class);
        Route::resource('volunteer-skills', VolunteerSkillController::class)->except(['show']);
        Route::post('volunteers/{volunteer}/trainings', [VolunteerTrainingController::class, 'store'])
            ->name('volunteers.trainings.store');
        Route::put('volunteers/{volunteer}/trainings/{training}', [VolunteerTrainingController::class, 'update'])
            ->name('volunteers.trainings.update');
        Route::delete('volunteers/{volunteer}/trainings/{training}', [VolunteerTrainingController::class, 'destroy'])
            ->name('volunteers.trainings.destroy');

        Route::post('volunteers/{volunteer}/availability', [VolunteerAvailabilityController::class, 'store'])
            ->name('volunteers.availability.store');
        Route::put('volunteers/{volunteer}/availability/{availability}', [VolunteerAvailabilityController::class, 'update'])
            ->name('volunteers.availability.update');
        Route::delete('volunteers/{volunteer}/availability/{availability}', [VolunteerAvailabilityController::class, 'destroy'])
            ->name('volunteers.availability.destroy');

        Route::post('volunteers/{volunteer}/assignments', [VolunteerAssignmentController::class, 'store'])
            ->name('volunteers.assignments.store');
        Route::put('volunteers/{volunteer}/assignments/{assignment}', [VolunteerAssignmentController::class, 'update'])
            ->name('volunteers.assignments.update');
        Route::delete('volunteers/{volunteer}/assignments/{assignment}', [VolunteerAssignmentController::class, 'destroy'])
            ->name('volunteers.assignments.destroy');

        Route::resource('households', HouseholdController::class)->except(['show']);
        Route::post('households/{household}/members', [HouseholdController::class, 'attachMember'])->name('households.members.attach');
        Route::post('households/link-member', [HouseholdController::class, 'attachMemberFromForm'])->name('households.members.attach-form');
        Route::delete('households/{household}/members/{member}', [HouseholdController::class, 'detachMember'])->name('households.members.detach');

        Route::resource('smart-tags', SmartTagController::class)->except(['show']);
        Route::post('smart-tags/{smart_tag}/run', [SmartTagController::class, 'run'])->name('smart-tags.run');
    });

    Route::post('members/{member}/notes', [MemberNoteController::class, 'store'])->name('members.notes.store');
    Route::put('members/{member}/notes/{note}', [MemberNoteController::class, 'update'])->name('members.notes.update');
    Route::delete('members/{member}/notes/{note}', [MemberNoteController::class, 'destroy'])->name('members.notes.destroy');

    Route::post('members/{member}/follow-ups', [MemberFollowUpController::class, 'store'])->name('members.followups.store');
    Route::put('members/{member}/follow-ups/{followUp}', [MemberFollowUpController::class, 'update'])->name('members.followups.update');
    Route::delete('members/{member}/follow-ups/{followUp}', [MemberFollowUpController::class, 'destroy'])->name('members.followups.destroy');

    Route::prefix('churchly')->name('churchly.')->group(function () {
    // Care lists
        Route::get('care/notes', [MemberNoteController::class, 'index'])->name('care.notes.index');
        Route::get('care/followups', [MemberFollowUpController::class, 'index'])->name('care.followups.index');
        Route::get('care/communications', [MemberCommunicationController::class, 'index'])->name('care.communications.index');
        
        Route::post('care/notes', [MemberNoteController::class, 'storeGlobal'])->name('care.notes.store');
        Route::post('care/followups', [MemberFollowUpController::class, 'storeGlobal'])->name('care.followups.store');
        Route::post('care/communications', [MemberCommunicationController::class, 'storeGlobal'])->name('care.communications.store');
    });  

// routes/web.php
Route::get('/birthday-card/{member}', [BirthdayCardController::class, 'generate'])
    ->name('birthday.card')
    ->middleware('auth');


   // Birthday Templates
    Route::middleware(['auth'])->prefix('birthday-templates')->group(function () {
        Route::get('/', [BirthdayTemplateController::class, 'index'])->name('birthday_templates.index');
        Route::post('/', [BirthdayTemplateController::class, 'store'])->name('birthday_templates.store');
        Route::post('/activate/{id}', [BirthdayTemplateController::class, 'activate'])->name('birthday_templates.activate');

        // New routes for edit/update/delete
        Route::get('/{id}/edit', [BirthdayTemplateController::class, 'edit'])->name('birthday_templates.edit');
        Route::put('/{id}', [BirthdayTemplateController::class, 'update'])->name('birthday_templates.update');
        Route::delete('/{id}', [BirthdayTemplateController::class, 'destroy'])->name('birthday_templates.destroy');
    });








    // ??? Place specific routes FIRST
    Route::prefix('members/setup')->middleware(['web','auth'])->group(function () {
        Route::get('form_setup', [FormSetupController::class, 'index'])->name('formsetup.index');
        Route::post('form_setup', [FormSetupController::class, 'store'])->name('formsetup.store');
        Route::get('form_setup/{id}/edit', [FormSetupController::class, 'edit'])->name('formsetup.edit');
        Route::put('form_setup/{id}', [FormSetupController::class, 'update'])->name('formsetup.update');
        Route::delete('form_setup/{id}', [FormSetupController::class, 'destroy'])->name('formsetup.destroy');
    });



    // Branch CRUD
    Route::resource('churchbranch', ChurchBranchController::class);
    Route::get('branchnameedit', [ChurchBranchController::class, 'BranchNameEdit'])->name('branchname.edit');
    Route::post('branch-settings', [ChurchBranchController::class, 'saveBranchName'])->name('branchname.update');
    
    Route::prefix('churchly/members')->name('churchly.members.')->middleware(['web', 'auth', 'verified'])->group(function() {
    Route::get('/', [MemberController::class, 'index'])->name('index');
    Route::get('/create', [MemberController::class, 'create'])->name('create');
    Route::post('/', [MemberController::class, 'store'])->name('store');
    Route::get('/{member}/edit', [MemberController::class, 'edit'])->name('edit');
    Route::put('/{member}', [MemberController::class, 'update'])->name('update');
    Route::delete('/{member}', [MemberController::class, 'destroy'])->name('destroy');
    });



    Route::resource('churchdesignation', ChurchDesignationController::class);

  

    // Churchly Departments CRUD routes (no group, explicit, clean)
    Route::middleware(['web', 'auth'])->group(function () {
        Route::get('churchly-departments', [ChurchDepartmentController::class, 'index'])->name('churchly.departments.index');
        Route::get('churchly-departments/create', [ChurchDepartmentController::class, 'create'])->name('churchly.departments.create');
        Route::post('churchly-departments', [ChurchDepartmentController::class, 'store'])->name('churchly.departments.store');
        Route::get('churchly-departments/{department}/edit', [ChurchDepartmentController::class, 'edit'])->name('churchly.departments.edit');
        Route::put('churchly-departments/{department}', [ChurchDepartmentController::class, 'update'])->name('churchly.departments.update');
        Route::delete('churchly-departments/{department}', [ChurchDepartmentController::class, 'destroy'])->name('churchly.departments.destroy');
    });


// Route group for Church Feedback, assuming 'auth' and 'workspace' middleware
        Route::get('/feedback/dashboard', [ChurchFeedbackController::class, 'dashboard'])->name('feedback.dashboard');

        // Use resource routes, but exclude ones we define manually
        Route::resource('feedback', ChurchFeedbackController::class)->except(['edit', 'update', 'destroy', 'index']);
        Route::get('feedback/{id}/edit', [ChurchFeedbackController::class, 'edit'])->name('feedback.edit');
        Route::put('feedback/{id}', [ChurchFeedbackController::class, 'update'])->name('feedback.update');
        Route::delete('feedback/{id}', [ChurchFeedbackController::class, 'destroy'])->name('feedback.destroy');
        Route::get('feedback', [ChurchFeedbackController::class, 'index'])->name('feedback.index');
        Route::post('feedback/{id}/reply', [ChurchFeedbackController::class, 'reply'])->name('feedback.reply');
        Route::get('feedback-export', [ChurchFeedbackController::class, 'export'])->name('feedback.export');
        Route::post('feedback-import', [ChurchFeedbackController::class, 'import'])->name('feedback.import');
 
        Route::get('/feedback/{id}/review', [ChurchFeedbackController::class, 'review'])->name('feedback.review');
        Route::put('/feedback/{id}/update-response', [ChurchFeedbackController::class, 'updateResponse'])->name('feedback.updateResponse');


    // Public feedback form (optional, based on type)
    Route::get('{workspace}/feedback/form', [ChurchFeedbackController::class, 'publicForm'])->name('churchly.feedback.form');
    Route::post('{workspace}/feedback/submit', [ChurchFeedbackController::class, 'publicSubmit'])->name('churchly.feedback.submit');


    Route::get('/feedback/attachment/{filename}', function ($filename) {
        $path = storage_path('app/public/feedback_attachments/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    })->name('feedback.download');

    Route::prefix('sms-gateway')->name('sms-gateway.')->middleware(['web', 'auth'])->group(function () {
   // Route::prefix('sms-gateway')->name('sms-gateway.')->middleware(['auth', 'workspace'])->group(function () {
    Route::get('/', [SmsGatewayController::class, 'edit'])->name('edit'); // Edit/view config
    Route::post('/', [SmsGatewayController::class, 'update'])->name('update'); // Save config
    Route::post('/test-send', [SmsGatewayController::class, 'testSend'])->name('test-send'); // Test send

    // Optional advanced gateway management (if you're listing/adding SMS devices)
    Route::get('/manage', [SmsGatewayController::class, 'index'])->name('index');
    Route::post('/manage', [SmsGatewayController::class, 'store'])->name('store');
    Route::delete('/manage/{gateway}', [SmsGatewayController::class, 'destroy'])->name('destroy');

    // Optional: Test plain SMS via controller if needed later
    // Route::post('/sms/test', [ChurchSmsController::class, 'testSms'])->name('sms.test');
});

        Route::get('/zender/whatsapp-groups', [SmsGatewayController::class, 'getWhatsAppGroups'])
            ->middleware(['auth'])
            ->name('zender.whatsapp.groups');
        Route::get('/zender/sync-groups', [SmsGatewayController::class, 'syncAndReturnGroups'])
            ->middleware(['auth'])
            ->name('zender.sync.groups');

        Route::prefix('churchly')->name('wa_group.')->middleware(['auth'])->group(function () {
        Route::get('wa-groups', [WaGroupController::class, 'index'])->name('index');
        Route::get('wa-groups/create', [WaGroupController::class, 'create'])->name('create');
        
        Route::post('wa-groups', [WaGroupController::class, 'store'])->name('store');
        Route::get('wa-groups/{id}', [WaGroupController::class, 'show'])->name('show');
        Route::delete('wa-groups/{id}', [WaGroupController::class, 'destroy'])->name('destroy');

    });
   

    Route::middleware(['auth'])->prefix('discipleship')->group(function () {

        // ========= MEMBER ROUTES =========
        Route::get('/', [DiscipleshipController::class, 'index'])->name('discipleship.index');
        Route::get('/my-journey', [DiscipleshipController::class, 'myJourney'])->name('discipleship.my_journey');
        Route::get('/progress', [DiscipleshipController::class, 'progress'])->name('discipleship.progress');
        Route::post('/requirement/{id}/submit', [DiscipleshipController::class, 'submitRequirement'])->name('discipleship.requirement.submit');

        // ========= ADMIN/PASTOR ROUTES =========
        Route::get('/setup', [DiscipleshipController::class, 'setupWizard'])->name('discipleship.setup');
        Route::post('/setup/save', [DiscipleshipController::class, 'saveWizard'])->name('discipleship.setup.save');

        Route::get('/dashboard', [DiscipleshipController::class, 'dashboard'])->name('discipleship.dashboard');
      

        // Approver management
        Route::get('/approvers', [DiscipleshipController::class, 'approversIndex'])->name('discipleship.approvers.index');
        Route::post('/approvers', [DiscipleshipController::class, 'approversStore'])->name('discipleship.approvers.store');
        Route::delete('/approvers/{id}', [DiscipleshipController::class, 'approversDestroy'])->name('discipleship.approvers.destroy');


        Route::get('/approvals', [DiscipleshipController::class, 'approvals'])->name('discipleship.requirements.approvals');
        Route::post('/requirement/{id}/review', [DiscipleshipController::class, 'reviewRequirement'])->name('discipleship.requirement.review');

        // ========= DYNAMIC ROUTES =========
        Route::get('/{stage}/edit', [DiscipleshipController::class, 'edit'])->name('discipleship.edit');
        Route::post('/{stage}/update', [DiscipleshipController::class, 'update'])->name('discipleship.update');
        Route::delete('/{stage}/delete', [DiscipleshipController::class, 'destroy'])->name('discipleship.destroy');
        Route::get('/{id}', [DiscipleshipController::class, 'showStage'])->name('discipleship.show');
    });




    Route::middleware(['auth'])->group(function() {
        
        // Events
        Route::resource('events', EventController::class, ['as' => 'churchly']);
        Route::get('{id}/export-pdf', [EventController::class, 'exportPdf'])->name('churchly.events.export.pdf');
     
  
        Route::get('events/analytics', [EventController::class, 'analytics'])
            ->name('churchly.events.analytics');

        
        Route::get('events/analytics/overall', [EventController::class, 'analytics'])
            ->name('churchly.events.analytics.overall');


 

        // Review Routes
        Route::get('events/{id}/review', [EventController::class, 'review'])->name('churchly.events.review');
        Route::post('events/{id}/submit-review', [EventController::class, 'submitForReview'])->name('churchly.events.submitReview');

        // Event Approval (Approver Stage)
        Route::get('events/{id}/approve', [EventController::class, 'approve'])
            ->name('churchly.events.approve');
        Route::post('events/{id}/approve-action', [EventController::class, 'approveAction'])
            ->name('churchly.events.approveAction');


        // Live Reviewer Comments (AJAX Endpoint)
        Route::get('events/{id}/comments', [EventController::class, 'fetchComments'])
            ->name('churchly.events.comments');
        
        //Publish
        Route::get('events/{id}/publish', [EventController::class, 'publish'])
            ->name('churchly.events.publish');
        Route::post('events/{id}/publish-action', [EventController::class, 'publishAction'])
            ->name('churchly.events.publishAction');


        // Attendance Events
        Route::resource('attendance_events', AttendanceEventController::class, ['as' => 'churchly']);

        // qr scanner
        Route::get('attendance_events/{event}/scan', [AttendanceEventController::class, 'showScanner'])
            ->name('churchly.attendance_events.scan');
        Route::post('attendance_events/{event}/mark', [AttendanceEventController::class, 'markAttendance'])
            ->name('churchly.attendance_events.mark');


           
        
        // Attendance Records
        Route::post('attendance/{attendanceEvent}/manual', [AttendanceRecordController::class, 'manualCheckIn'])
            ->name('churchly.attendance.manualCheckIn');
        Route::post('attendance/{attendanceEvent}/qr', [AttendanceRecordController::class, 'qrCheckIn'])
            ->name('churchly.attendance.qrCheckIn');
        Route::post('attendance/{attendanceEvent}/kiosk', [AttendanceRecordController::class, 'kioskCheckIn'])
            ->name('churchly.attendance.kioskCheckIn');
        Route::post('attendance/{attendanceEvent}/face', [AttendanceRecordController::class, 'faceAiCheckIn'])
            ->name('churchly.attendance.faceAiCheckIn');
        Route::post('attendance/{attendanceEvent}/online', [AttendanceRecordController::class, 'onlineCheckIn'])
            ->name('churchly.attendance.onlineCheckIn');
        Route::get('attendance/search-member', [AttendanceRecordController::class, 'searchMember'])->name('churchly.attendance.searchMember');


        // Reports
        Route::get('attendance/reports/dashboard', [AttendanceReportController::class, 'dashboard'])
            ->name('churchly.attendance.reports.dashboard');
        Route::get('attendance/reports/event/{id}', [AttendanceReportController::class, 'eventReport'])
            ->name('churchly.attendance.reports.event');
        Route::get('attendance/reports/member/{id}', [AttendanceReportController::class, 'memberReport'])
            ->name('churchly.attendance.reports.member');
        Route::get('attendance/reports/branch/{id}', [AttendanceReportController::class, 'branchReport'])
            ->name('churchly.attendance.reports.branch');
    });


    

    
        




    Route::group(['prefix'=>'app-builder','middleware'=>['auth']], function() {
        Route::get('/', [AppBuilderController::class,'index'])->name('app-builder.index');
        Route::post('/branding', [AppBuilderController::class,'saveBranding'])->name('app-builder.saveBranding');
        Route::post('/features', [AppBuilderController::class,'saveFeatures'])->name('app-builder.saveFeatures');
        Route::post('/menu', [AppBuilderController::class,'saveMenu'])->name('app-builder.saveMenu');
        Route::post('/layout', [AppBuilderController::class,'saveLayout'])->name('app-builder.saveLayout');
        Route::get('/publish', [AppBuilderController::class,'publishSettings'])->name('app-builder.publish');
        Route::post('/publish', [AppBuilderController::class,'savePublishSettings'])->name('app-builder.publish.save');
    });
    Route::get('app-builder/layout', [AppBuilderController::class,'layoutEditor'])->name('app-builder.layout');
});

Route::get('/departments/by-branch', [ChurchDepartmentController::class, 'byBranch'])->name('departments.byBranch');
Route::get('/designations/by-department', [ChurchDesignationController::class, 'byDepartment'])->name('designations.byDepartment');

// Admin API docs
Route::middleware(['web','auth'])->get('churchly/api-docs', function () {
    return view('churchly::api.docs');
})->name('churchly.api.docs');

// Google Integration (admin)
Route::middleware(['web','auth'])->group(function() {
    Route::get('churchly/google', [\Workdo\Churchly\Http\Controllers\GoogleIntegrationController::class,'credentials'])->name('churchly.google.credentials');
    Route::post('churchly/google', [\Workdo\Churchly\Http\Controllers\GoogleIntegrationController::class,'saveCredentials'])->name('churchly.google.credentials.save');
    Route::get('churchly/google/connect', [\Workdo\Churchly\Http\Controllers\GoogleIntegrationController::class,'connect'])->name('churchly.google.connect');
    Route::get('churchly/google/callback', [\Workdo\Churchly\Http\Controllers\GoogleIntegrationController::class,'callback'])->name('churchly.google.callback');
});

// YouTube Sync (admin)
Route::middleware(['web','auth'])->group(function() {
    Route::get('churchly/youtube', [\Workdo\Churchly\Http\Controllers\YouTubeSyncController::class,'index'])->name('churchly.youtube.index');
    Route::post('churchly/youtube', [\Workdo\Churchly\Http\Controllers\YouTubeSyncController::class,'save'])->name('churchly.youtube.save');
});
// Zoom Integration (admin)
Route::middleware(['web','auth'])->group(function(){
    Route::get('churchly/zoom', [\Workdo\Churchly\Http\Controllers\ZoomIntegrationController::class,'index'])->name('churchly.zoom.index');
    Route::post('churchly/zoom', [\Workdo\Churchly\Http\Controllers\ZoomIntegrationController::class,'save'])->name('churchly.zoom.save');
    Route::get('churchly/zoom/test', [\Workdo\Churchly\Http\Controllers\ZoomIntegrationController::class,'test'])->name('churchly.zoom.test');
    Route::get('churchly/zoom/sync', [\Workdo\Churchly\Http\Controllers\ZoomIntegrationController::class,'syncNow'])->name('churchly.zoom.sync');
});

// Website CMS (admin)
Route::middleware(['web','auth'])->prefix('churchly/website')->name('cms.')->group(function(){
    Route::get('/pages', [\Workdo\Churchly\Http\Controllers\CmsController::class,'pages'])->name('pages');
    Route::get('/pages/create', [\Workdo\Churchly\Http\Controllers\CmsController::class,'pageCreate'])->name('pages.create');
    Route::post('/pages', [\Workdo\Churchly\Http\Controllers\CmsController::class,'pageStore'])->name('pages.store');
    Route::get('/pages/{id}/edit', [\Workdo\Churchly\Http\Controllers\CmsController::class,'pageEdit'])->name('pages.edit');
    Route::post('/pages/{id}', [\Workdo\Churchly\Http\Controllers\CmsController::class,'pageUpdate'])->name('pages.update');
    Route::delete('/pages/{id}', [\Workdo\Churchly\Http\Controllers\CmsController::class,'pageDestroy'])->name('pages.delete');
    Route::post('/pages/sort', [\Workdo\Churchly\Http\Controllers\CmsController::class,'updatePagesOrder'])->name('pages.sort');

    Route::get('/theme', [\Workdo\Churchly\Http\Controllers\CmsController::class,'theme'])->name('theme');
    Route::post('/theme', [\Workdo\Churchly\Http\Controllers\CmsController::class,'saveTheme'])->name('theme.save');

    Route::get('/menu', [\Workdo\Churchly\Http\Controllers\CmsController::class,'menu'])->name('menu');
    Route::post('/menu', [\Workdo\Churchly\Http\Controllers\CmsController::class,'saveMenu'])->name('menu.save');

    Route::get('/assets', [\Workdo\Churchly\Http\Controllers\CmsController::class,'assets'])->name('assets');
    Route::post('/assets', [\Workdo\Churchly\Http\Controllers\CmsController::class,'uploadAsset'])->name('assets.upload');
});
// Public site preview (SSR)
Route::get('{workspace}/site', [\Workdo\Churchly\Http\Controllers\SitePublicController::class,'home'])->name('site.home');
Route::get('{workspace}/site/{slug}', [\Workdo\Churchly\Http\Controllers\SitePublicController::class,'page'])->name('site.page');



