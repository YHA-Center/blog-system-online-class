<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // home
    public function index()
    {
        $users = User::get(); // users
        $posts = Post::paginate(4);  // posts
        $categories = Category::all();  // categories
        $feature_post = Post::latest()->first(); // feature_post
        $latest_post = Post::latest('created_at')->take(7)->get(); // latest_post
        return view('frontend.index', compact('posts', 'categories', 'feature_post', 'latest_post', 'users'));
    }

    // blog detail
    public function get($id)
    {
        $post = Post::find($id);
        $comments = Comment::paginate(6); // get comment
        $latest_post = Post::latest('created_at')->take(5)->get();
        return view('frontend.detail', compact('post', 'latest_post', 'comments'));
    }

    // get by category
    public function getByCategory($id)
    {
        $posts = Post::where('category_id', $id)->paginate(4);
        $categories = Category::all();
        $category = Category::where('id', $id)->first();
        $latest_post = Post::latest('created_at')->take(7)->get();
        return view('frontend.index', compact('posts', 'categories', 'latest_post', 'category'));
    }

    // search
    public function search(Request $request)
    {
        // find
        $term = $request->searchTerm;
        $posts = Post::where('title', 'LIKE', '%'.$term.'%')->paginate(4);
        $categories = Category::all();
        $latest_post = Post::latest('created_at')->take(7)->get();
        // return
        return view('frontend.index', compact('posts', 'categories', 'latest_post', 'term'));
    }
}
