<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    $attributes = [
        'title' => $request->title,
        'description' => $request->description,
        'cover' => $request->cover,
        'autor' => $request->autor,
        'user_id' => $request->user()->id,
    ];

    if ($request->hasFile('cover')) {
        $attributes['cover'] = $request->file('cover')->store('images', 'public');
    }

    Forum::create($attributes);

    return response([
        'message' => 'Forum created successfully'
    ], 201);
}


    public function show($id)
    {
        $Forum=Forum::findOrFail($id);
        return response($Forum,201);
    }

    

    public function update(Request $request, $id)
{
    $forum = Forum::findOrFail($id);
    
    // Comprobamos que quien hace el update request es el usuario en sí
    if ($request->user()->id !== $forum->user_id) {
        return response(['message' => 'You are not authorized to update this forum post'], 403);
    }
    
    $attributes = [
        'title' => $request->title,
        'description' => $request->description,
        'autor' => $request->autor,
        'cover' => $request->cover,
    ];

    if ($request->hasFile('cover')) {
        $attributes['cover'] = $request->file('cover')->store('images', 'public');
    }

    $forum->update($attributes);

    return response([
        'message'=>'Forum updated successfully'
    ], 201);

}


public function destroy($id)
{
    $forum = Forum::findOrFail($id);

    if ($forum->user_id != Auth::id()) {
        return response()->json(['message' => 'Forbidden'], 403);
    }

    $forum->delete();

    return response()->json(['message' => 'Forum deleted successfully'], 204);
}

}
