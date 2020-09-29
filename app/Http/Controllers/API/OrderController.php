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
            'hrs'=>'required',
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
        $data['price']=$request->price *$request->package_quantity;
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        //
        if($search = \Request::get('q')){
        $parsel=Parselinfo::where(function($query) use ($search){
            $query->where('name','LIKE',"%$search%")
            ->orWhere('recever_name','LIKE',"%$search%")
            ->orWhere('package_name','LIKE',"%$search%")
            ->orWhere('source','LIKE',"%$search%")
            ->orWhere('destination','LIKE',"%$search%")
            ->orWhere('phone','LIKE',"%$search%")
            ->orWhere('recever_phone','LIKE',"%$search%")
            ->orWhere('type','LIKE',"%$search%");
        })->paginate(10);

    }else{
        $parsel= Parselinfo::latest()->paginate(10);
    }
        return $parsel;
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
