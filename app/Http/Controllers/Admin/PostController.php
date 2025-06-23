<?php

namespace App\Http\Controllers\Admin;
use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function index(){
        $pageTitle="Add Posts";
        $lists=Post::all();
        return view('admin.posts.lists',compact('pageTitle','lists'));
        // return "<h1>hahah</h1>";
    }
    public function add(){
        $pageTitle="Add Posts";
        
        return view('admin.posts.add',compact('pageTitle'));
    }
    
    public function edit($id){
        
    }

    public function delete($id){

    }
}
