<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Parselinfo;

class OrderController extends Controller
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
        return Parselinfo::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // $user=auth('api')->user();
        //
        $this->validate($request,[
            'name' => 'required|string|max:25',
            'email' => 'sometimes|required|email|max:30',
            'phone' => 'required|phone:TZ',
            'address'=>'sometimes|required',
            'recever_name' =>'required|string|max:30',
            'recever_email' => 'sometimes|required|email|max:30',
            'recever_phone' => 'required|phone:TZ',
            'recever_address'=>'sometimes|required',
            'package_name'=>'required|max:30',
            'type'=>'required',
            'weight'=>'required',
            'package_quantity'=>'required',
            'price'=>'required',
            'paymentmethod'=>'required',
            'senderPayment_name'=>'required',
            'source'=>'required',
            'destination'=>'required',
            'distance'=>'required',
            'senderPayment_phone'=>'required|phone:TZ',
            /* 'packagestatus'=>'required',
            'paymentstatus'=>'required', */

            //'packagecode'=>'required',
           // 'package_cost'=>'required'
        ]);

        $data = $request->all();
        $data['user_id'] = $request->user()->id;
         return Parselinfo::create($data);


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
        $this->authorize('isManager');
        $parsel = Parselinfo::findOrFail($id);

        $this->validate($request,[
            'paymentStatus' => 'sometimes|required',
            'packagestatus' => 'sometimes|required',
        ]);

        $parsel->update($request->all());
        return ['message' =>'Updated Order'];
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
    }

    public function getuserorder()
    {
        //$parselinfo=new Parselinfo;
        $user=auth('api')->user();
       //return $user->load('parselinfo');
       $parsel=Parselinfo::where('user_id','=',$user->id)->oldest()->paginate(10);
        return $parsel;

    }
}
