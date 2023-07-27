<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/admins',function() {

    return 'Only Admins can view this page';
    
}) -> middleware('can:onlyAdmins') ;

Route::get('/',[UserController::class,"showPage"]) -> name('login');
Route:: post('/register',[UserController::class,'registerUser']) -> middleware('guest');
Route:: post('/login',[UserController::class,'login']) -> middleware('guest');
Route:: post('/logout',[UserController::class,'logout']);
Route::get('/manage-avatar',[UserController::class,"showAvatarForm"]) -> middleware('auth');
Route::Post('/manage-avatar',[UserController::class,"saveAvatarForm"]) -> middleware('auth');

// Follows controller
Route::Post('/follow-user/{user:name}',[FollowController::class,"followUser"]) -> middleware('auth');
Route::Post('/unfollow-user{user:name}',[FollowController::class,"unfollowUser"]) -> middleware('auth');

//Post routes
Route:: get('/create-post',[PostController::class,'showCreatePost'])-> middleware('mustBeLoggedIn');
Route:: post('/create-post',[PostController::class,'createPost']) -> middleware('mustBeLoggedIn');
Route:: get('/posts/{post}',[PostController::class,'showSinglePost']);
Route:: delete('/posts/{post}',[PostController::class,'delete']);

Route:: get('/posts/{post}/edit',[PostController::class,'showUpdatePost'])-> middleware('can:update,post');
Route:: put('/posts/edit/{post}',[PostController::class,'updatePost'])-> middleware('can:update,post');

// Profile Routes
Route:: get('/profile/{user:name}',[UserController::class,'profile']);
