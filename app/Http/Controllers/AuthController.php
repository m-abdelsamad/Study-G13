<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\Post;
use App\Models\Reply;
use App\Models\StudySession;


class AuthController extends Controller
{
    

    public function login(Request $request){
        $request->validate([
            'email' => 'email|required',
            'password' => 'required',
        ]);

        // if(auth()->attempt($request->only('email', 'password'))){
        //     //return redirect()->route('dashboard');
        //     $user = auth()->user();
        //     return response()->JSON(['status' => 200, 'success' => true, 'user' => $user]);
        // } else {
        //     return response()->JSON(['status' => 401, 'success' => false]);

        // }
        if(!auth()->attempt($request->only('email', 'password'))){  
            return back()->with('errorLogin', 'Invalid login details');
        }
        return redirect('/dashboard');
    }

    public function register(Request $request){
        $validateForm = Validator::make($request->all(), [
        //$request->validate([
            'name' => 'required|string',
            'email' => 'email|required',
            'uni_name' => 'required|string',
            'hrs_per_day' => 'required',
            'hrs_per_week' => 'required',
            'password' => 'required',
        ]);

        // if($validateForm->fails()){
        //     // session()->flash('errors', $validateForm->errors());
        //     // return redirect()->back();
        //     return response()->JSON(['status' => 406, 'success' => false, 'errors' => $validateForm->errors()]);
        // }

        // $validator = Validator::make($request, [
        //     'name' => 'required|string',
        //     'email' => 'email|required',
        //     'password' => 'required',
        // ]);

        // if($validator->fails()) {
        //     return response()->JSON(['status' => 406, 'success' => false]);
        // }   

        $key = Str::random(15);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'key' => $key,
            'university_name' => $request->uni_name,
            'hrs_per_day' => ($request->hrs_per_day)*60*60,
            'hrs_per_week' => ($request->hrs_per_week)*60*60,
            'password' => Hash::make($request->password),
        ]);

        if(auth()->attempt($request->only('email', 'password'))){
            return response()->JSON(['status' => 200, 'success' => true, 'user' => $user]);
        }
       
        //return redirect()->route('dashboard');
    }

    public function logout(){
        auth()->logout();
        return view('welcome');
    }

    public function getUser(){
        $user = auth()->user();
        return response()->JSON(['status' => 200, 'user' => $user]);
    }

    public function deleteAccount(){
    
        $user = User::findOrFail(auth()->user()->id);  
        $posts = Post::where('user_id', $user->id)->pluck('id');
        Reply::whereIn('post_id', $posts)->delete();
        Post::where('user_id', $user->id)->delete();
        $user->delete();

        return redirect('/');
    }

}
