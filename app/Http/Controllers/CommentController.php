<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Post;
use JWTAuth;
use Carbon\Carbon;
use App\Http\Resources\CommentResource;

class CommentController extends Controller
{

    public function fetchComment($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        //$fetchComment = Comment::where('post_id', $post->id)->whereNull('parent_id')->orderBY('created_at', 'desc')->with('AllChildrenComment')->get();
        //$fetchComment = Comment::where('post_id', $slug)->with('AllChildrenComment')->first();
        //$fetchComment->AllChildrenComment; // collection of recursively loaded children
        // each of them having the same collection of children:
        //$fetchComment->AllChildrenComment->first()->AllChildrenComment; // .. and so on
        $fetchComment = CommentResource::collection(Comment::where('post_id', $post->id)
                                                            ->whereNull('parent_id')
                                                            ->orderBY('created_at', 'desc')->get());
        return response()->json(['success' => true, 'data' => $fetchComment], 200);
    }

    public function createComment(Request $request, $slug)
    {
        $user = JWTAuth::toUser($request->token);
        $post = Post::where('slug', $slug)->firstOrFail();
        $mytime = Carbon::now();
        if($user->role_id == 1) {
            $published = '1';
            $published_at = $mytime->toDateTimeString();
        } else {
            $published = '0';
            $published_at = '';
        }
        $payload = [
            'post_id' => $post->id,
            'user_id' => $user->id,
            'parent_id' => $request->parent_id,
            'content' => $request->content,
            'published' => $published,
            'published_at' => $published_at
        ];
        $createComment = new Comment($payload);
        $createComment->save();
        return response()->json([
            'success' => true,
            'data' => $createComment
        ], 200);
    }
}
