<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\StudySession;

class StudyTimmerController extends Controller
{
    //

    public function timmer(){
        return view('HomeController.timmer');
    }


    public function submitStudySession(Request $request){
        $studySession = StudySession::where('user_id', auth()->user()->id)->where('created_at', '>=', Carbon::today())->first();

        if(is_null($studySession)){
            StudySession::create([
                'user_id' => auth()->user()->id,
                'time' => $request->totalSeconds,
            ]);
        } else {
            $prevTime = $studySession->time;            
            $newTime = ($prevTime + $request->totalSeconds);
            // return $newTime;
            // exit;
            $studySession->update(["time" => $newTime]);
        }

        return response()->JSON(['status' => 200,]);
    }
}
