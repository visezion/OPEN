<?php

use Illuminate\Support\Facades\Route;
use Workdo\Churchly\Http\Controllers\Api\AppConfigController;
use App\Models\WorkSpace;
use Workdo\Churchly\Http\Controllers\Api\V1\AuthApiController;
use Workdo\Churchly\Http\Controllers\Api\V1\MemberApiController;
use Workdo\Churchly\Http\Controllers\Api\V1\ChurchAppBuilderController;



Route::prefix('api/v1/churchly')->group(function () {
    Route::get('/churches', function () {
        return WorkSpace::select('id','name','short_code')->where('status','active')->get();
    });

    Route::get('/church/{workspace}/config', [AppConfigController::class, 'show']);


    // Authentication (no token needed)
    Route::post('/login', [AuthApiController::class, 'login'])->name('churchly.api.login');

    //  Member management (token required)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthApiController::class, 'logout'])->name('churchly.api.logout');
        Route::apiResource('/members', MemberApiController::class)->names('churchly.api.members');
        Route::put('/member/profile', [MemberApiController::class, 'updateProfile'])->name('churchly.api.member.profile');
    });

    

    // App theme (read: public, write: token required)
Route::get('/theme', [ChurchAppBuilderController::class, 'theme']);
Route::middleware('auth:sanctum')->put('/theme', [ChurchAppBuilderController::class, 'updateTheme']);

    // Layouts and a specific layout
    Route::get('/layouts', [ChurchAppBuilderController::class, 'layouts']);
    Route::get('/layout/{screen_key}', [ChurchAppBuilderController::class, 'layout']);
    // Google OAuth + Classroom
    Route::get('/auth/google/redirect', [\Workdo\Churchly\Http\Controllers\Api\V1\GoogleAuthController::class, 'redirect']);
    Route::get('/auth/google/callback', [\Workdo\Churchly\Http\Controllers\Api\V1\GoogleAuthController::class, 'callback']);
    Route::post('/auth/google', [\Workdo\Churchly\Http\Controllers\Api\V1\GoogleAuthController::class, 'mobile']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/google/classroom/courses', [\Workdo\Churchly\Http\Controllers\Api\V1\GoogleClassroomController::class, 'courses']);
        Route::get('/google/classroom/students/{courseId}', [\Workdo\Churchly\Http\Controllers\Api\V1\GoogleClassroomController::class, 'students']);
        Route::get('/google/classroom/teachers/{courseId}', [\Workdo\Churchly\Http\Controllers\Api\V1\GoogleClassroomController::class, 'teachers']);
    });
        // Workspace Website CMS
    Route::get('/site/{workspace}/config', [\Workdo\Churchly\Http\Controllers\Api\V1\SiteController::class,'config']);
    Route::get('/site/{workspace}/pages', [\Workdo\Churchly\Http\Controllers\Api\V1\SiteController::class,'pages']);
    Route::get('/site/{workspace}/page/{slug}', [\Workdo\Churchly\Http\Controllers\Api\V1\SiteController::class,'page']);
    // GPS-based self attendance
    Route::middleware('auth:sanctum')->post('/attendance/gps-checkin', [\Workdo\Churchly\Http\Controllers\Api\V1\AttendanceGpsController::class,'checkin']);
    // YouTube synced videos (public)
    Route::get('/youtube/videos', function () {
        return \Workdo\Churchly\Entities\YouTubeVideo::where('workspace_id', getActiveWorkSpace())
            ->orderByDesc('published_at')->limit(50)->get();
    });
});
