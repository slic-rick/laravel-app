<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function showCreatePost(){
        return view('create-post');

    }

    function search($term) {
        $posts  = Post::search($term) -> get();
        $posts-> load('user:id,name,avatar');
        return $posts;
        
    }

    function showUpdatePost(Post $post) {
        return view('edit-post',['post' => $post]);
        
    }

    function updatePost(Post $post,Request $request) {

            $formFields = $request -> validate([
                'title' => 'required',
                'body' => 'required'
            ]);

            $formFields['title'] = strip_tags($formFields['title']);
            $formFields['body'] = strip_tags($formFields['body']);

            $post -> update($formFields);

            return redirect('/profile/'.auth()-> user() -> name) -> with('success','Post successfully updated!');
        
    }

    function delete(Post $post){
        if(!$post -> id === auth() -> user() -> id){
            return 'You can not delete this post!!';
        }

        $post -> delete();

        return redirect('/profile/'.auth() -> user() -> name) -> with('success','You successfully deleted the post!');
    }

    public function showSinglePost(Post $post){
        $markdown = Str::markdown($post-> body);
        $post['body'] = $markdown;
        return view('single-post',['post' => $post]);
    }

    public function createPost(Request $request){
        $validate_post = $request -> validate([
            'title' => ['required','min:4','max:250'],
            'body' => ['required','min:10']
        ]);
        
        $validate_post['title'] = strip_tags($validate_post['title']);
        $validate_post['body'] = strip_tags($validate_post['body']);
        $validate_post['user_id'] = auth() -> id();
        
        Post::create($validate_post);

        return 'created blog post';

    }
}

