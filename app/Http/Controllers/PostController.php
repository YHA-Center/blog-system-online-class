<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    // index page
    public function index(){
        $posts = Post::where('user_id', Auth::user()->id)->get();
        return view('backend.posts.index', compact('posts'));
    }

    // create page
    public function create(){
        $categories = Category::get();
        return view('backend.posts.create', compact('categories'));
    }

    // 1. validate -> Validator::make($request, $rule, $message)->validate();
    // 2. change array format -> ['table_column_name' => $request->name ]
    // 3. store -> Model::create(2. array format)
    // 4. return view
    // store
    public function store(Request $request){
        // dd($request->toArray());
        $this->validatePost($request); // validation
        // store image
        if(file_exists($request->image)){
            $file_name = 'cover-img'.uniqid().'.'.$request->image->getClientOriginalExtension(); // image-name
            $request->image->move('asset/posts/', $file_name); // upload image
            $path = 'asset/posts/'.$file_name;
        }
        // change array format
        $data = [
            'title' => $request->title,
            'category_id' => $request->category,
            'description' => $request->description,
            'cover' => $path,
            'user_id' => Auth::user()->id,
        ];
        // store
        if(Post::create($data)){
            // return
            return redirect()->route('post.list')->with('success', 'Created new post');
        }else{
            return view('errors.500Page');
        }
    }

    private function validatePost(Request $request){
        $rule = [
            'title' => 'required|min:3|string',
            'category' => 'required',
            'description' => 'required|min:3|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp'
        ];
        Validator::make($request->all(), $rule)->validate(); // rule -> array formate
    }

    // get the post detail
    public function get($id){
        // get row from database
        $post = Post::find($id); // get post
        if($post){
            return view('backend.posts.detail', compact('post'));
        }else{
            return view('errors.404Page');
        }
    }

    // edit
    public function edit($id){
        // Model - Category , Post where id
        $categories = Category::get();
        $post = Post::find($id);
        return view('backend.posts.edit', compact('categories', 'post'));
    }

    // update
    public function update(Request $request, $id){
        // validation
        Validator::make($request->all(), [
            'title' => 'required|min:3',
            'category' => 'required',
            'description' => 'required|min:3',
            'image' => $request->hasFile('image') ? 'required|image|mimes:jpeg,png,jpg,svg,webp,gif' : '',
        ])->validate();
        $post = Post::find($id); // find post with id
        // if new image exist, remove old image
        if($request->hasFile('image')){
            // validate image
            if(file_exists($post->cover)){ // check file exist
                unlink($post->cover); // remove old file
            }
            // add new image
            $file_name = 'cover-img-'.uniqid().'.'.$request->image->getClientOriginalExtension(); // file name
            $request->image->move('asset/posts/',$file_name); // move file to asset folder
            $path = 'asset/posts/'.$file_name; // path of image to store database
        }
        // update
        $data = [ // 'column_name' => 'request -> name value'
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category,
            'user_id' => 1,
            'cover' => $request->hasFile('image') ? $path : $post->cover,
        ];
        $post->update($data);
        return redirect()->route('post.list')->with('success', 'Success Updated');
    }

    // destroy
    public function destroy($id){
        // search
        $post = Post::find($id);
        if($post){ // check post
            if(file_exists($post->cover)){ // check image
                unlink($post->cover); // remove image
            }
            $post->delete(); // delete post
            return redirect()->route('post.list')->with('success', 'deleted success'); // return view
        }else{
            return view('errors.500Page');
        }
    }




}
