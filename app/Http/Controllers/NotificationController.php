<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        // $user_id = $request->user()->id;
        // $notifications=notification::where('user_id', $user_id)->get();
        $notifications = Notification::all();

        return  response($notifications,201);
    }

    public function create(Request $request)
    {
        // $user_id
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'type' => 'required',            
        ]);

        // notification::create([
        //     'title' => $request->title,
        //     'description' => $request->description,
        //     'cover' => $request->cover,            
        //     'autor' => $request->autor,
        //     'user_id' => $request->user()->id,
        // ]);
        $notification = new Notification;
        $notification->content = $request->content;
        $notification->type = $request->type;
               
        $notification->user_id = $request->user()->id;

        $notification->save();

        //

        return response([
            'message' => 'notification created successfully'
        ],201);
    }

    public function show($id)
    {
        $notification=Notification::findOrFail($id);
        return response($notification,201);
    }

    public function update(Request $request, $id)
    {
        $notification=Notification::findOrFail($id);
        $notification->update([
            'content' => $request->content,
            'type' => $request->type,
            
            
        ]);

        return response([
            'message'=>'notification updated successfully'
        ],201);

    }

    public function destroy($id)
    {
        Notification::where('id',$id)->delete();

        return response([
            'message'=>'notification deleted successfully'
        ],201);
    }
}