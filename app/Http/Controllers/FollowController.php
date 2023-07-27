<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    //

   public function followUser(User $user) {

    // return 'Follow User';

    // can not follow yourself

    if ($user -> id == auth() -> user() -> id) {

        return back() -> with('failure', 'you can not follow yourself');
    }

    // can not follow a user that you already follwed
    $count = Follow::where([['user_id','=',auth() -> user() -> id],['followedUser','=',$user -> id]]) -> count();
    if($count > 0){
        return back() -> with('failure', 'you  already followed user!');
    }
    
        $follow = new Follow;
        $follow -> user_id = auth() -> user() ->id;
        $follow -> followedUser = $user->id;

        $follow -> save();
        return back() -> with('success', 'you successfully followed user!');

    }

    public function unfollowUser() {

    }
}
