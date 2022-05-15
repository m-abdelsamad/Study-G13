<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\StudySession;
use Carbon\Carbon;

class DashboardController extends Controller
{
    //
    public function index(){
        //$studySession = StudySession::orderBy('time', 'DESC')-
        //$studySessions = StudySession::orderBy('time', 'DESC')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->take(10)->get();
        $users = User::get();
        $now = Carbon::now();
        $studySessions = StudySession::whereBetween("created_at", [
            $now->startOfWeek()->format('Y-m-d'), //This will return date in format like this: 2022-01-10
            $now->endOfWeek()->format('Y-m-d')
         ])->orderBy('time', 'DESC')->take(10)->get();

        $myWeekSession = StudySession::where('user_id', auth()->user()->id)
        ->whereBetween("created_at", [
            $now->startOfWeek()->format('Y-m-d'), //This will return date in format like this: 2022-01-10
            $now->endOfWeek()->format('Y-m-d')
         ])->get();
        
         $studySession = StudySession::where('user_id', auth()->user()->id)->where('created_at', '>=', Carbon::today())->first();
        
        return view('HomeController.dashboard', [
            'studySessions' => $studySessions,
            'users' => $users,
            'studySession' => $studySession,
            'myWeekSession'=> $myWeekSession,
        ]);
    }


    public function updateDetails(Request $request){
        $user = User::findorFail(auth()->user()->id);
        $user->update([
            "name" => $request->name,
            "email" => $request->email,
            "university_name" => $request->uni_name,
            "hrs_per_day" => ($request->hrs_per_day)*60*60,
            "hrs_per_week" => ($request->hrs_per_week)*60*60,
        ]);



        // return response()->JSON(['status' => 200,]);
        return redirect('/dashboard');
    }


    // public function createStudySessionArray($studySessions){
    //     $array = array();

    //     foreach(studySessions as $studySession){
    //         if(in_array())
    //     }
    // }
}
