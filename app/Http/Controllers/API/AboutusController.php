<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Aboutus;

class AboutusController extends Controller
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
        return Aboutus::latest()->paginate(10);
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
        $this->validate($request,[
            'title' => 'required|string|max:50',
            'mission' => 'required',
            'vision' => 'required',
            'value' =>'required',
            'description' =>'required',


        ]);

        return Aboutus::create([
            'title' => $request['title'],
            'mission' => $request['mission'],
            'vision' => $request['vision'],
            'value' =>$request['value'],
            'description' =>$request['description'],
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
        $about = Aboutus::findOrFail($id);

        $this->validate($request,[
            'title' => 'required|string|max:50',
            'mission' => 'required',
            'vision' => 'required',
            'value' =>'required',
            'description' =>'required',
        ]);

        $about->update($request->all());
        return ['message' =>'Updated About'];
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
        $about =Aboutus::findOrFail($id);
        $about->delete();

        return ['message'=>' deleted'];
    }
}
