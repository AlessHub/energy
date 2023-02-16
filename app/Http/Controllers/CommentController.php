<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Comments = Comment::all();

        return  response($Comments,201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|max:255',            
            'autor' => 'required',            
        ]);
        $comment = new Comment();
        $comment->content = $request->content;        
        $comment->autor = $request->autor;
        $comment->user_id = $request->user()->id;

        $comment->save();

        //

        return response([
            'message' => 'comment created successfully'
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Comment=Comment::findOrFail($id);
        return response($Comment,201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Comment=Comment::findOrFail($id);
        $Comment->update([
            'title' => $request->title,
            'description' => $request->description,
            'cover' => $request->cover,
            'autor' => $request->autor,
            
        ]);

        return response([
            'message'=>'Comment updated successfully'
        ],201);

    }

    public function destroy($id)
    {
        $Comment=Comment::where('id',$id)->delete();

        return response([
            'message'=>'Comment deleted successfully'
        ],201);
    }
}
