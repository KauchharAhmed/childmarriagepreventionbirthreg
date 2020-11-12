<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use Session;

class UdcController extends Controller
{
    private $rcdate ;
	/**
	* CANDIDATE CLASS costructor 
	*
	*/
    public function __construct()
    {
        date_default_timezone_set('Asia/Dhaka');
        $this->rcdate       = date('Y-m-d');
        $this->current_time = date('H:i:s');
        $this->loged_id     = Session::get('admin_id');
    }

    #--------------------- UDC Profile View --------------------------#
    public function udcProfile()
    {
    	$value = DB::table('admin')
    		->join('union','admin.union_id','=','union.id')
            ->select('admin.*','union.union_name')
            ->where('admin.id',$this->loged_id)
            ->first();

        return view('udc.udcProfile')->with('value',$value) ;
    }


    public function udcProfileInfo()
    {
    	$value = DB::table('admin')
    		->join('union','admin.union_id','=','union.id')
            ->select('admin.*','union.union_name')
            ->where('admin.id',$this->loged_id)
            ->first();

        return view('udc.udcProfileInfo')->with('value',$value) ;
    }

    #------------------- Update UDC Profile Info -------------------#
    public function updateUdcProfileInfo(Request $request)
    {
    	$this->validate($request,[
            'name'      	=> 'required',
            'designation'   => 'required',
            'mobile'    	=> 'required|size:11',
            'images'    	=> 'mimes:jpeg,jpg,png|max:500',
        ]);

        $name           = trim($request->name);
        $designation    = trim($request->designation);
        $mobile         = trim($request->mobile);
        $email          = trim($request->email);
        $primary_id     = $request->primary_id ;
        $images         = $request->file('images') ;

        $check_count = DB::table('admin')
                    ->where('mobile',$mobile)
                    ->whereNotIn('id',[$this->loged_id])
                    ->count();

        if ($check_count > 0) {
            Session()->put('failed', 'Sorry ! Mobile Number Already Exit.');
            return Redirect::to('udcProfileInfo');
        }

        $data                   = array();
        $data['name']           = $name ;
        $data['designation']    = $designation ;
        $data['mobile']         = $mobile ;
        $data['email']          = $email ;


        if ($images) {
            $image_name        = str_random(20);
            $ext               = strtolower($images->getClientOriginalExtension());
            $image_full_name   ='user-'.$image_name.'.'.$ext;
            $upload_path       = "images/";
            $image_url         = $upload_path.$image_full_name;
            $success           = $images->move($upload_path,$image_full_name);
            $data['image']     = $image_url;
        }

        $data['updated_at'] = $this->rcdate ;

        DB::table('admin')->where('id',$this->loged_id)->update($data);

        Session()->put('success', 'Thanks ! Information Update Successfully Completed.');
        return Redirect::to('udcProfileInfo/');	
    }

    #--------------------- UDC Password Change Form ------------------#
    public function udcChangePassword()
    {
    	return view('udc.udcChangePassword') ;
    }

    #------------------- Update New Password ------------------------#
    public function udcUpdatePasswordInfo(Request $request)
    {
    	$this->validate($request,[
            'old_password'      => 'required',
            'new_password'      => 'required',
            'confirm_password'  => 'required'
        ]);

        $old_password 		= trim($request->old_password);
        $new_password 		= trim($request->new_password);
        $confirm_password 	= trim($request->confirm_password);

        $salt       	= 'a123A321';
        $oldPassword  	= sha1($old_password.$salt);
        $newPassword  	= sha1($new_password.$salt);

        $profile_info   = DB::table('admin')
                        ->where('id',$this->loged_id)
                        ->first();

        if ($profile_info->password != $oldPassword) {
            Session()->put('failed', 'Sorry ! Old Password Not Match.Try Again');
            return Redirect::to('udcChangePassword');
        }

        if ($new_password != $confirm_password) {
            Session()->put('failed', 'Sorry ! New Password And Confrim Password Not Match.Try Again');
            return Redirect::to('udcChangePassword');
        }

        $data               = array() ;
        $data['password']   = $newPassword ;
        $data['updated_at'] = $this->rcdate ;

        DB::table('admin')->where('id',$this->loged_id)->update($data);

        Session()->put('success', 'Thanks ! Password Change Successfully Completed.');
        return Redirect::to('udcChangePassword');	
    }

}
