<?php 

use Illuminate\Support\Facades\Route;
use Workdo\Churchly\Http\Controllers\ChurchFeedbackController;
use Workdo\Churchly\Http\Controllers\ChurchMemberSelfServiceController;

Route::group(['prefix' => '{workspace}'], function () {
    Route::get('register', [ChurchMemberSelfServiceController::class, 'showForm'])->name('churchly.self.register');
    Route::post('register', [ChurchMemberSelfServiceController::class, 'store'])->name('churchly.self.register.store');
});

Route::get('{workspace}/feedback/form', [ChurchFeedbackController::class, 'createPublic'])
    ->name('churchly.feedback.form');
Route::post('{workspace}/feedback/submit', [ChurchFeedbackController::class, 'storePublic'])
    ->name('churchly.feedback.submit');

// Admin CMS sections save route (kept here but guarded by auth)
Route::post('churchly/website/pages/{id}/sections', [\Workdo\Churchly\Http\Controllers\CmsController::class,'saveSections'])
    ->name('cms.pages.sections')
    ->middleware(['web','auth']);
