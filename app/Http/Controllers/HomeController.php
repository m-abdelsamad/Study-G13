<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Chat;

class HomeController extends Controller
{
    public function login(){
        return view('HomeController.login');
    }

    public function register(){
        return view('HomeController.regsiter');
    }

    public function chat(){
        $chats = Chat::getUserChats(auth()->user()->id);
        $users = User::where('id', '!=', auth()->user()->id)->get();
        
        return view('HomeController.chat', [
            'chats' => $chats,
            'users' => $users,
        ]);
    }

    public function map(){
        return view('HomeController.map');
    }

    public function termsOfService(){
        return view('HomeController.termsOfService');
    }

    // public function discussionBoard(){
    //     return view('HomeController.discussionBoard');
    // }
}
