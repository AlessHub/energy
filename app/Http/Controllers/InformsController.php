<?php

namespace App\Http\Controllers;

use App\Models\Informs;
use Illuminate\Http\Request;

class InformsController extends Controller
{
    public function index(Request $request)
    {
        // $user_id = $request->user()->id;
        // $Informs=Inform::where('user_id', $user_id)->get();
        $Informs = Informs::all();

        return  response($Informs,201);
    }

    public function create(Request $request)
    {
        // $user_id
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'expense' => 'required',            
            'carbonPrint' => 'required',                       
        ]);

        // Inform::create([
        //     'title' => $request->title,
        //     'description' => $request->description,
        //     'cover' => $request->cover,            
        //     'autor' => $request->autor,
        //     'user_id' => $request->user()->id,
        // ]);
        $Inform = new Informs;
        $Inform->date = $request->date;
        $Inform->expense = $request->expense;
        $Inform->carbonPrint = $request->carbonPrint;        
        $Inform->user_id = $request->user()->id;

        $Inform->save();

        //

        return response([
            'message' => 'Inform created successfully'
        ],201);
    }

    public function show($id)
    {
        $Inform=Informs::findOrFail($id);
        return response($Inform,201);
    }

    public function update(Request $request, $id)
    {
        $Inform=Informs::findOrFail($id);
        $Inform->update([
            'title' => $request->title,
            'description' => $request->description,
            'cover' => $request->cover,
            'autor' => $request->autor,
            
        ]);

        return response([
            'message'=>'Inform updated successfully'
        ],201);

    }

    public function destroy($id)
    {
        Informs::where('id',$id)->delete();

        return response([
            'message'=>'Inform deleted successfully'
        ],201);
    }
}
