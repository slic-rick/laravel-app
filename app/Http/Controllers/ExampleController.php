<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
    //

    public function homePage(){
        $database = "Mr Slick";
        $list = ['Get Money',"Get Hoe(s)","Build my join"];
        return view('homepage',['name' => $database,'surname' => 'Abraham',"list" => $list]);
    }

    public function aboutPage(){
        return view('single-post');
    }
}
