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
            $post->comments_microservice = \Http::get("http://localhost:8001/api/post/{$post->id}/comments")->json();
        }

        return $posts;
    }



    public function store(Request $request)
    {
        $post = Post::create([
            'title'       => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        return $post;
    }



    public function comment(Request $request, $id)
    {
        $post     = Post::find($id);

        $comments = $post->comments;

        array_push($comments, [
            'text' => $request->input('text'),
        ]);

        $post->comments = $comments;

        $post->save();
    }
}
