<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    public function index(Request $request)
    {
        // $user_id = $request->user()->id;
        // $Forums=Forum::where('user_id', $user_id)->get();
        $Forums = Forum::all();

        return  response($Forums,201);
    }

    public function create(Request $request)
    {
        // $user_id
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required|max:255',            
            'cover' => 'required',
            'autor' => 'required',            
        ]);

        // Forum::create([
        //     'title' => $request->title,
        //     'description' => $request->description,
        //     'cover' => $request->cover,            
        //     'autor' => $request->autor,
        //     'user_id' => $request->user()->id,
        // ]);
        $forum = new Forum;
        $forum->title = $request->title;
        $forum->description = $request->description;
        $forum->cover = $request->cover;
        $forum->autor = $request->autor;
        $forum->user_id = $request->user()->id;
        $forum->save();

        //

        return response([
            'message' => 'Forum created successfully'
        ],201);
    }

    public function show($id)
    {
        $Forum=Forum::findOrFail($id);
        return response($Forum,201);
    }

    public function update(Request $request, $id)
    {
        $Forum=Forum::findOrFail($id);
        $Forum->update([
            'title' => $request->title,
            'description' => $request->description,
            'cover' => $request->cover,
            'autor' => $request->autor,
            
        ]);

        return response([
            'message'=>'Forum updated successfully'
        ],201);

    }

    public function destroy($id)
    {
        $Forum=Forum::where('id',$id)->delete();

        return response([
            'message'=>'Forum deleted successfully'
        ],201);
    }
}
