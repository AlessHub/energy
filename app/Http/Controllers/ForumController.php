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
            'image' => 'required',
            'autor' => 'required',            
        ]);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'covers/forums/';
            $image->move(public_path($imagePath), $imageName);
        
            // Creación y almacenamiento del foro
            $forum = new Forum();
            $forum->title = $request->title;
            $forum->description = $request->description;
            $forum->image = $imagePath . $imageName;
            $forum->user_id = auth()->id();
            $forum->autor = $request->autor;
            $forum->save();
        
            return response()->json($forum, 201);
        } else {
            return response()->json(['message' => 'Debe proporcionar una imagen válida'], 400);
        }
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
            'image' => $request->image,
            'autor' => $request->autor,            
        ]);

        if($request->hasFile('image')) {
            $Forum['image'] = $request->file('image')->store('covers', 'public');
        }

        $Forum->update($Forum);

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
