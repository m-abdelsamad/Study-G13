<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DiscussionBoardController;
use App\Http\Controllers\StudyTimmerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MailerController;

use App\Http\Controllers\MessageController;
use App\Http\Controllers\FriendController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::get('login', [HomeController::class, 'login'])->name('login');
Route::get('register', [HomeController::class, 'register']);
Route::get('chat', [HomeController::class, 'chat'])->name('chat')->middleware('auth');
Route::get('map', [HomeController::class, 'map'])->name('map')->middleware('auth');
Route::get('termsOfService', [HomeController::class, 'termsOfService'])->name('termsOfService');

// Route::get('leaderboard', [HomeController::class, 'leaderboard'])->name('leaderboard')->middleware('auth');


Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('getUser', [AuthController::class, 'getUser']);
Route::post('/deleteAccount', [AuthController::class, 'deleteAccount'])->middleware('auth');


Route::get('/discussionBoard', [DiscussionBoardController::class, 'index'])->name('discussionBoard.index')->middleware('auth');
Route::get('/discussionBoard/{id}', [DiscussionBoardController::class, 'show'])->name('discussionBoard.show')->middleware('auth');
Route::post('/discussionBoard/store', [DiscussionBoardController::class, 'store'])->name('discussionBoard.store')->middleware('auth');
Route::post('/discussionBoard/{id}/addReply', [DiscussionBoardController::class, 'addReply'])->name('discussionBoard.addReply')->middleware('auth');
Route::post('/discussionBoard/deletePost/{id}', [DiscussionBoardController::class, 'deletePost'])->name('discussionBoard.deletePost')->middleware('auth');
Route::delete('/discussionBoard/{id}', [DiscussionBoardController::class, 'destroy'])->name('discussionBoard.destroy')->middleware('auth');


Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index')->middleware('auth');
Route::post('/dashboard', [DashboardController::class, 'updateDetails'])->name('dashboard.updateDetails')->middleware('auth');


Route::get('timer', [StudyTimmerController::class, 'timmer'])->name('timmer')->middleware('auth');
Route::post('timer/submitStudySession', [StudyTimmerController::class, 'submitStudySession'])->name('submitStudySession')->middleware('auth');

Route::get('/sendEmail', [MailerController::class, 'sendEmail'])->name('sendEmail');



// Route::post('sendMessage/{id}', [MessageController::class, 'storeMessage']);
// Route::post('createChat', [MessageController::class, 'storeChat']);


// Route::get('/findFriends', [FriendController::class, 'index'])->middleware('auth');
// Route::post('/addFriend/{id}', [FriendController::class, 'store']);
