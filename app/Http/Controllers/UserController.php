<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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

    public function showPage(Request $request ){
        if (auth() -> check()) {
            return view('homepage-feed');
        } else {
            return view('homepage');
        }
        
    }

    public function profile(User $user){

         $posts = $user->posts() -> latest() -> get();
         //return $posts;

        return view('profile-page',['name' => $user -> name, 'posts' => $posts,'count' => $posts ->count(), 'avatar' => $user -> avatar]);

        
    }

    public function logout(Request $request){
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
