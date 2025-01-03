<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();

        foreach($posts as $post)
        {
            // $post->comments = \Http::get("http://comment_microservice.com/api/post/{$post->id}/comments")->json();
            $post->comments = \Http::get("http://localhost:8000/api/post/{$post->id}/comments")->json();
        }

        return $posts;
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string',
            'description' => 'required|string',
        ]);

        $post = Post::create([
            'title'       => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        return $post;
    }
}
