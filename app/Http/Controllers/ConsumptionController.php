<?php

namespace App\Http\Controllers;

use App\Models\Consumption;
use Illuminate\Http\Request;

class ConsumptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $consumptions = Consumption::all();
        return response($consumptions,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'date'=> 'required',
            'electricMoney'=> 'required|max:8',
            'electricEnergy'=> 'required|max:8',
            'waterMoney'=> 'required|max:8',
            'waterEnergy'=> 'required|max:8',
        ]);
        
        $consumption = new Consumption;
        $consumption->date = $request->date;
        $consumption->electricMoney = $request->electricMoney;
        $consumption->electricEnergy = $request->electricEnergy;
        $consumption->waterMoney = $request->waterMoney;
        $consumption->waterEnergy = $request->waterEnergy;
        $consumption->user_id = $request->user()->id;
        $consumption->save();
        
        return response([
            'message' => 'Consumption created successfully' 
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Consumption  $consumption
     * @return \Illuminate\Http\Response
     */
    public function show(Consumption $consumption)
    {
        //
        $consumption = Consumption::findOrFail($consumption->id);
        return response($consumption, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Consumption  $consumption
     * @return \Illuminate\Http\Response
     */
    public function edit(Consumption $consumption)
    {
        //
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Consumption  $consumption
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Consumption $consumption)
    {
        //
        $request->validate([
            'date'=> 'required',
            'electricMoney'=> 'required|max:8',
            'electricEnergy'=> 'required|max:8',
            'waterMoney'=> 'required|max:8',
            'waterEnergy'=> 'required|max:8',
        ]);
        
        $consumption->date = $request->date;
        $consumption->electricMoney = $request->electricMoney;
        $consumption->electricEnergy = $request->electricEnergy;
        $consumption->waterMoney = $request->waterMoney;
        $consumption->waterEnergy = $request->waterEnergy;
        $consumption->user_id = $request->user()->id;
        $consumption->update();
        
        return response([
            'message' => 'Consumption update successfully' 
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Consumption  $consumption
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $consumption=Consumption::where('id',$id)->delete();
        return response([
            'message' => 'Consumption updateed successfull' 
        ],200);
    }
}