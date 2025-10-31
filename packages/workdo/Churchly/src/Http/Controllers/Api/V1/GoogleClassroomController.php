<?php

namespace Workdo\Churchly\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Workdo\Churchly\Entities\UserGoogleAccount;
use Workdo\Churchly\Services\Google\GoogleClassroomService;

class GoogleClassroomController extends Controller
{
    public function courses()
    {
        $acct = UserGoogleAccount::where('user_id', Auth::id())->first();
        if (!$acct) return response()->json(['status'=>'error','message'=>'Google account not linked'], 404);
        $token = GoogleClassroomService::ensureAccessToken($acct);
        if (!$token) return response()->json(['status'=>'error','message'=>'Re-authorization required'], 401);
        $courses = GoogleClassroomService::listCourses($token);
        return response()->json(['status'=>'success','data'=>$courses]);
    }

    public function students($courseId)
    {
        $acct = UserGoogleAccount::where('user_id', Auth::id())->first();
        if (!$acct) return response()->json(['status'=>'error','message'=>'Google account not linked'], 404);
        $token = GoogleClassroomService::ensureAccessToken($acct);
        if (!$token) return response()->json(['status'=>'error','message'=>'Re-authorization required'], 401);
        $students = GoogleClassroomService::listStudents($token, $courseId);
        return response()->json(['status'=>'success','data'=>$students]);
    }

    public function teachers($courseId)
    {
        $acct = UserGoogleAccount::where('user_id', Auth::id())->first();
        if (!$acct) return response()->json(['status'=>'error','message'=>'Google account not linked'], 404);
        $token = GoogleClassroomService::ensureAccessToken($acct);
        if (!$token) return response()->json(['status'=>'error','message'=>'Re-authorization required'], 401);
        $teachers = GoogleClassroomService::listTeachers($token, $courseId);
        return response()->json(['status'=>'success','data'=>$teachers]);
    }
}