<?php

namespace App\Http\Controllers;

use App\Models\Advice;
use Illuminate\Http\Request;

class AdviceController extends Controller
{
    public function index(Request $request)
    {
        $Advices=Advice::all();
        return  response($Advices,201);
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'value' => 'required',            
            'type' => 'required',         
        ]);

        Advice::create([
            'content' => $request->content,
            'value' => $request->value,
            'type' => $request->type,            
        ]);

        return response([
            'message' => 'Advice created successfully'
        ],201);
    }

    public function show($id)
    {
        $Advice=Advice::findOrFail($id);
        return response($Advice,201);
    }

    public function update(Request $request, $id)
    {
        $Advice=Advice::findOrFail($id);
        $Advice->update([
            'content' => $request->content,
            'value' => $request->value,
            'type' => $request->type,    
        ]);

        return response([
            'message'=>'Advice updated successfully'
        ],201);

    }

    public function destroy($id)
    {
        $Advice=Advice::where('id',$id)->delete();

        return response([
            'message'=>'Advice deleted successfully'
        ],201);
    }
}
