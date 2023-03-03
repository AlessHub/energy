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

        
       // Subida y almacenamiento de la covern
       $cover = $request->file('cover');
       $coverName = time() . '.' . $cover->getClientOriginalExtension();
       $coverPath = 'covers/forums/';
       $cover->move(public_path($coverPath), $coverName);

   
   // Creación y almacenamiento de la imagen
$forum = new Forum();
$forum->title = $request->title;
$forum->description = $request->description;
// $forum->user_id = auth()->id();
$forum->cover = $coverPath . $coverName;
$forum->autor = $request->autor;
// $forum->category = $request->category;
// $forum->price = $request->price;
$forum->save();

return response()->json($forum, 201);
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

        if($request->hasFile('cover')) {
            $Forum['cover'] = $request->file('cover')->store('covers', 'public');
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
