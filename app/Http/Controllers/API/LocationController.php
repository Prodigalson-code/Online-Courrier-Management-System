<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Location;

class LocationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Location::latest()->paginate(10);
    }

    public function getlocations()
    {

        return Location::latest()->paginate(52);

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
        $this->authorize('isManager');
        $this->validate($request,[
            'source' => 'required|string|max:25',
            'destination' => 'required',
            'distance' => 'required',
            'hrs' => 'required',
            'type' => 'required|string|max:25',
            'weight' => 'required',
            'price' => 'required',

        ]);

        return Location::create([
            'source' => $request['source'],
            'destination' => $request['destination'],
            'distance' => $request['distance'],
            'hrs'=>$request['hrs'],
            'type' => $request['type'],
            'weight' => $request['weight'],
            'price' => $request['price'],

        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $location = Location::findOrFail($id);
        $this->authorize('isManager');

        $this->validate($request,[
            'source' => 'required|string|max:25',
            'destination' => 'required',
            'distance' => 'required',
            'hrs' => 'required',
            'type' => 'required|string|max:25',
            'weight' => 'required',
            'price' => 'required',
        ]);



        //'password' => bcrypt($request->password);
        $location->update($request->all());
        return ['message' =>'Updated Item'];

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $this->authorize('isManager');
        $location =Location::findOrFail($id);
        $location->delete();

        return ['message'=>'Item deleted'];
    }
}
