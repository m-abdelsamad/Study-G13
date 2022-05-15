<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Reply;
use Illuminate\Support\Facades\Validator;

class DiscussionBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $posts = Post::all();
        return view('DiscussionBoard.index', [
            "posts" => $posts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('DiscussionBoard.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateForm = Validator::make($request->all(), [
            'post_title' => ['required' , 'string'],
            'post_description' => ['required' , 'string'],
        ]);

        $post = Post::create([
            "user_id" => auth()->user()->id,
            "title" => $request->post_title,
            "description" => $request->post_description,
            "attachment" => null,
        ]);

        // $replies = count($post->replies());

        return response()->JSON(['status' => 200, 'post' => $post, 'user'=> auth()->user()]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);

        return view('DiscussionBoard.show', [
            "post" => $post,
        ]);
    }

    /**
     * Show the form for deleting the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        Reply::whereIn('post_id', [$id])->delete();
        $post->delete();
        return redirect('/discussionBoard');
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deletePost($id)
    {
        $post = Post::findOrFail($id);
        Reply::whereIn('post_id', [$id])->delete();
        $post->delete();

        return response()->JSON(['status' => 200]);
    }


    public function addReply(Request $request, $id){
        $validateForm = Validator::make($request->all(), [
            'reply_content' => ['required' , 'string'],
        ]);

        $post = Post::findOrFail($id);
        $reply = Reply::create([
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
            'content' => $request->reply_content,
        ]);

        return response()->JSON(['status' => 200, 'reply' => $reply, 'user'=> auth()->user()]);


    }
}
