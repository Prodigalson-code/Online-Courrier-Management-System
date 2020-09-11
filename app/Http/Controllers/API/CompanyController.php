<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Company;
use Illuminate\Http\Request;

use Intervention\Image\Facades\Image;
//use Intervention\Image\ImageManagerStatic as Image;

class CompanyController extends Controller
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
        return Company::latest()->paginate(10);

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
            'companyname' => 'required|string|max:25',
            'companyemail' => 'required|email|max:30|unique:companies',
            'companyphone' => 'required|phone:TZ|unique:companies',
            'companyaddress' =>'required|string|max:50',
            'companycity' =>'required|string|max:25',
            'companylogo' =>'required',
            'companygst'=>'required|numeric'

        ]);

         if($request->companylogo)
        {
           $name = time().'.' . explode('/', explode(':', substr($request->companylogo, 0, strpos($request->companylogo, ';')))[1])[1];
            \Image::make($request->companylogo)->save(public_path('img/logo/').$name);
            $request->merge(['companylogo' => $name]);
         }


        Company::create($request->all());
        return ['message' => 'Success'];
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
        $company = Company::findOrFail($id);

        $this->validate($request,[

             'companyname' => 'required|string|max:25',
            'companyemail' => 'required|email|max:30|unique:companies',
            'companyphone' => 'required|phone:TZ|unique:companies',
            'companyaddress' =>'required|string|max:50',
            'companycity' =>'required|string|max:25',
            'companylogo' =>'sometimes',
            'companygst'=>'required|numeric'
        ]);

        $currentPhoto = $company->companylogo;

        if($request->companylogo != $currentPhoto){

             $name = time().'.' . explode('/', explode(':', substr($request->companylogo, 0, strpos($request->companylogo, ';')))[1])[1];
            \Image::make($request->companylogo)->save(public_path('img/logo/').$name);
            $request->merge(['companylogo' => $name]);

            $companyLogo = public_path('img/logo/').$currentPhoto;

            if(file_exists( $companyLogo)){

                @unlink( $companyLogo);

            }

        }

        $company->update($request->all());

        return ['message' => 'Success'];
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
        $company = Company::findOrFail($id);

        $company->delete();

        $currentPhoto = $company->companylogo;

        $companylogo = public_path('img/profile/').$currentPhoto;

        if(file_exists($companylogo)) {

            @unlink($companylogo);

        }

        return [
         'message' => 'Photo deleted successfully'
        ];
    }


}
