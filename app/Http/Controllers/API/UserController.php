<?php

namespace App\Http\Controllers\API;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\Parselinfo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;


class UserController extends Controller
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
        $user=User::where('type','!=',"customer")->oldest()->paginate(20);
        return $user;
    }

    public function Customerindex()
    {
        //
        $user=User::where('type','=',"customer")->oldest()->paginate(20);
        return $user;
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
        $this->authorize(['isAdmin','isManager']);
        $this->validate($request,[
            'name' => 'required|string|max:25',
            'email' => 'required|email|max:30|unique:users',
            'phone' => 'required|phone:TZ|unique:users',
            'type'=>'required',
            'password' =>'required|string|min:8'
        ]);

        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'type'=>$request['type'],
            'password' => Hash::make($request['password']),
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
     * Display the specified resource.
     *
     * @param  int  $id
     * /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *  * @return \Illuminate\Http\Response
     */


     public function profile()
    {
        //
        $data=auth('api')->user();
        return response()->json($data);
    }

    public function customer()
    {
        //
        return auth('api')->user();
    }

    public function getuser()
    {
        //
        return auth('api')->user();
    }


    public function updateProfile(Request $request)
    {

        $user =auth('api')->user();
       // $user = User::findOrFail($id);
       $this->validate($request,[
        'name' => 'required|string|max:25',
        'email' => 'required|email|max:30|unique:users,email,'.$user->id,
        'phone' => 'required|phone:TZ|unique:users,phone,'.$user->id,
        'password'=> 'sometimes|required|string|min:8'


    ]);

        $currentPhoto = $user->photo;


        if($request->photo != $currentPhoto)
        {
            $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
            \Image::make($request->photo)->save(public_path('img/profile/').$name);
            $request->merge(['photo' => $name]);

            $photo = public_path('img/profile/').$currentPhoto;

            if(file_exists( $photo)){

                @unlink( $photo);

            }
        }

        if(!empty($request->password)){
            $request->merge(['password'=>Hash::make($request['password'])]);
        }

        $user->update($request->all());

        Parselinfo::where('user_id',$user->id)->update(['phone'=>$user->phone,'email'=>$user->email,'name'=>$user->name,]);


        return['message'=>"Success"];




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
        $user = User::findOrFail($id);
        $this->authorize('isAdmin');

        $this->validate($request,[
            'name' => 'required|string|max:25',
            'email' => 'required|email|max:30|unique:users,email,'.$user->id,
            'phone' => 'required|phone:TZ|unique:users,phone,'.$user->id,
            'password'=> 'sometimes|required|string|min:8'


        ]);

        if(!empty($request->password)){
            $request->merge(['password'=>Hash::make($request['password'])]);
        }

        $user->update($request->all());
        Parselinfo::where('user_id',$user->id)->update(['phone'=>$user->phone,'email'=>$user->email,'name'=>$user->name,]);

    }



    public function customerupdate(Request $request, $id)
    {
        //
        $user = User::findOrFail($id);
        $this->authorize('isManager');

        $this->validate($request,[
            'name' => 'required|string|max:25',
            'email' => 'required|email|max:30|unique:users,email,'.$user->id,
            'phone' => 'required|phone:TZ|unique:users,phone,'.$user->id,
            'password'=> 'sometimes|required|string|min:8'
        ]);

        if(!empty($request->password)){
            $request->merge(['password'=>Hash::make($request['password'])]);
        }

        /* if($user->parselinfo->user_id == $request->id){
            $user->parselinfo->email=$request->email;
        } */

        $user->update($request->all());
        Parselinfo::where('user_id',$user)->update(['phone'=>$user->phone,'email'=>$user->email,'name'=>$user->name,]);
        return ['message' =>'Updated Customer'];
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
        $this->authorize('isAdmin');
        $user =User::findOrFail($id);
        $user->delete();

        return ['message'=>'Staff deleted'];
    }
}
