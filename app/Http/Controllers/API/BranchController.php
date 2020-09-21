<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
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
        return Branch::latest()->paginate(10);
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
            'branchname' => 'required|string|max:25',
            'branchemail' => 'required|email|max:30|unique:branches',
            'branchphone' => 'required|phone:TZ|unique:branches',
            'branchaddress' =>'required|string|max:50',
            'branchcity' =>'required|string|max:25',
            'branchmanager' =>'required|string|max:50'

        ]);

        return Branch::create([
            'branchname' => $request['branchname'],
            'branchemail' => $request['branchemail'],
            'branchphone' => $request['branchphone'],
            'branchaddress' =>$request['branchaddress'],
            'branchcity' =>$request['branchcity'],
            'branchmanager' =>$request['branchmanager'],
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
        //$branch=Branch::findOrFail($id);
       // return Branch::all();
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
        $branch=Branch::where(function($query) use ($search){
            $query->where('branchname','LIKE',"%$search%")
            ->orWhere('branchcity','LIKE',"%$search%")
            ->orWhere('branchmanager','LIKE',"%$search%");
        })->paginate(10);

    }else{
        $branch= Branch::latest()->paginate(10);
    }
        return $branch;
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
        $branch = Branch::findOrFail($id);

        $this->validate($request,[
            'branchname' => 'required|string|max:25',
            'branchemail' => 'required|email|max:30',
            'branchphone' => 'required',
            'branchaddress' =>'required|string|max:50',
            'branchcity' =>'required|string|max:25',
            'branchmanager' =>'required|string|max:50'
        ]);

        $branch->update($request->all());
        return ['message' =>'Updated Branch'];
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
        $branch =Branch::findOrFail($id);
        $branch->delete();

        return ['message'=>'Company deleted'];
    }
}
