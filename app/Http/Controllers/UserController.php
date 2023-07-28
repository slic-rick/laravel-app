<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Follow;
use App\Events\ExampleEvent;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function showAvatarForm() {

        return view('avatar-form');
        
    }


    public function saveAvatarForm(Request $request) {

        $request -> validate([
            'avatar' => 'required|image|max:2000'
        ]);

      
       $user = auth() -> user();
       $fileName = $user -> id . '-'. uniqid() .'.jpg';
       $imageData= Image::make($request -> file('avatar')) -> fit(120) -> encode('jpg');
       Storage::put('/public/avatars/'.$fileName,$imageData);


       $old = $user -> avatar;
       $user -> avatar =  $fileName;
       $user -> save();

       if ($old != '/fallback-avatar.jpg') {
        Storage::delete(str_replace('/storage/','public/',$old));
       }

       return back() -> with('success','Replaced your avatar');


    }

    public function loginApi(Request $request) {

        $validateData = $request -> validate([
            'name' => 'required',
            'password' => 'required'
        ]);

        if (auth() -> attempt($validateData)) {
            // return token
            $user = User::where('name',$validateData['name']) -> first();

            return $user -> createToken('userToken') -> plainTextToken;
        }

        return 'Wrong login credintials!';
        
    }

    public function showPage(Request $request ){
        if (auth() -> check()) {
            return view('homepage-feed',['posts' => auth() -> user() -> feedPosts() -> latest() -> paginate(4)]);
        } else {

            $postCount = Cache::remember('postCount',20,function (){
                //sleep(5);
                return Post::count();
            });

            return view('homepage',['postCount' => $postCount]);
        }
        
    }

    public function profile(User $user){
         
        // Then we are following the $user.
        $this -> sharedData($user);
        
        $posts = $user->posts() -> latest() -> get();
        return view('profile-page',['posts' => $posts]);

        
    }



    public function profileRaw(User $user) {
        return response()->json(['theHTML' => view('profile-posts-only', ['posts' => $user->posts()->latest()->get()])->render(), 'pageName' => $user->name . "'s Profile"]);
    }

    public function profileFollowers(User $user){

        $this -> sharedData($user);


        $followers = $user->followers() -> latest() -> get();
       return view('profile-followers',[ 'followers' => $followers]);

       
   }

   public function profileFollowersRaw(User $user){
    return response()->json(['theHTML' => view('profile-followers-only', ['followers' => $user->followers()->latest()->get()])->render(), 'pageName' => $user->name . "'s Followers"]);

}

   public function profileFollowing(User $user)
   {
    $this -> sharedData($user);
    $following = $user->following() -> latest() -> get();

    return view('profile-following',[ 'following' => $following]);
   
    }

    public function profileFollowingRaw(User $user)
    {
        return response()->json(['theHTML' => view('profile-following-only', ['following' => $user->following()->latest()->get()])->render(), 'pageName' => $user->name . "'s Following"]);

     }



    private function sharedData($user){

        $isFollowing = 0;

        if(auth() -> check()){
            $isFollowing = Follow::where([['user_id', '=', auth() -> user() -> id],['followedUser','=',$user -> id]]) -> count();
        }

        View::share('sharedData',['isFollowing' => $isFollowing,'name' => $user -> name,'count' => $user -> posts() ->count(), 'avatar' => $user -> avatar, 'followersCount' => $user->followers->count(), 'followingCount' => $user->following->count()]);


    }

    public function logout(Request $request){
        event(new ExampleEvent(['name' => auth() -> user() -> name, 'action' => 'Logout']));
        auth()->logout();
        return redirect('/') -> with('logout','logged out successfully');

    }

    public function login(Request $request){

        $login = $request -> validate([
            'loginusername' => 'required',
            'loginpassword' => 'required'
        ]);

        if (auth() -> attempt(['name' => $login['loginusername'], 'password' => $login['loginpassword']])) {
            $request ->session() -> regenerate();
            event(new ExampleEvent(['name' => auth() -> user() -> name, 'action' => 'Login']));
            return redirect('') -> with('success','Logged in successfully !!');
            
        } else {
            # code...
            return redirect('') -> with('failure','Please enter the right login details!!');
        }
    }


    public function registerUser (Request $request){

        $getUser = $request -> validate([
            'name' => ['required','min:3','max:20',Rule::unique('users','name')],
            'email' => ['required','email',Rule::unique('users','email')],
            'password' => ['required','min:4','confirmed']
        ]);

        $getUser['password'] = bcrypt($getUser['password']);

        $user = User::create($getUser);
        auth() -> login($user);
        return redirect('') -> with('success','Account created successfully!!');

    }


}
