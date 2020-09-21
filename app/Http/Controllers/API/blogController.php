<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Blog;

class blogController extends Controller
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
        return Blog::latest()->paginate(10);
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
            'title' => 'required|string|max:25',
            'description' => 'required',


        ]);

        return Blog::create([
            'title' => $request['title'],
            'description' => $request['description'],
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
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        //
        if($search = \Request::get('q')){
        $blog=Blog::where(function($query) use ($search){
            $query->where('title','LIKE',"%$search%");
        })->paginate(10);

    }else{
        $blog=Blog::latest()->paginate(10);
    }
        return $blog;
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
        $blog = Blog::findOrFail($id);

        $this->validate($request,[
            'title' => 'required|string|max:25',
            'description' => 'required',

        ]);

        $blog->update($request->all());
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
        $blog =Blog::findOrFail($id);
        $blog->delete();

        return ['message'=>'Company deleted'];
    }
}
