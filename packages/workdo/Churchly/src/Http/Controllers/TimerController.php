<?php

namespace Workdo\Churchly\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class TimerController extends Controller
{
    public function timer()
    {
        if(Auth::check())
        {
            if (Auth::user()->isAbleTo('churchly dashboard manage'))
            {
                return view('churchly::timer');
            }
            else
            {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        }
        else
        {
            return redirect()->route('login');
        }

    }
    
    public function doc()
    {          
        return view('churchly::doc');
    }
 }