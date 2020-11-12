<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use Session;

class KaziController extends Controller
{
    private $rcdate;
	/**
	 * ADMIN CLASS costructor
	 *
	 */
	public function __construct() {
		date_default_timezone_set('Asia/Dhaka');
		$this->rcdate = date('Y-m-d');
		$this->current_time = date('H:i:s');
		$this->loged_id = Session::get('admin_id');
	}

	#--------------------- Kazi Add Form -----------------------#
	public function addKazi()
	{
		$result = DB::table('union')->where('status',1)->get() ;

    	return view('kazi.addKazi')->with('result',$result) ;
	}

	#------------------- Insert Kazi Info ----------------------#
	public function addKaziInfo(Request $request)
	{
		$this->validate($request,[
			'union_id'	        => 'required',
			'name'	        	=> 'required',
			'gov_registration'	=> 'required',
			'mobile'    => 'required|size:11',
    		'address'	        => 'required',
    		'image'				=> 'mimes:jpeg,jpg,png|max:500',
		]);

		$union_id 			= trim($request->union_id);
		$ward_id 			= trim($request->ward_id);
		$name 				= trim($request->name);
		$gov_registration 	= trim($request->gov_registration);
		$mobile 			= trim($request->mobile);
		$address 			= trim($request->address);
		$images 			= $request->file('image') ;

		$duplicate_reg = DB::table('admin')
						->where('gov_registration',$gov_registration)
						->count();
		if($duplicate_reg > 0){
			Session()->put('failed', 'Sorry ! Government Registration Already Exit. Try Again');
            return Redirect::to('addKazi');
		}

		$duplicate_mobile = DB::table('admin')
						->where('mobile',$mobile)
						->count();
		if($duplicate_mobile > 0){
			Session()->put('failed', 'Sorry ! Mobile Number Already Exit. Try Again');
            return Redirect::to('addKazi');
		}

		$salt      	= 'a123A321';
     	$password   = sha1($mobile.$salt);

		$data = array() ;
		$data['union_id']			= $union_id ;
		$data['ward_id']			= $ward_id ;
		$data['name']				= $name ;
		$data['gov_registration']	= $gov_registration ;
		$data['mobile']				= $mobile ;
		$data['password']			= $password ;
		$data['address']			= $address ;
		$data['type']				= 5 ;
		$data['status']				= 1 ;
		$data['created_at']			= $this->rcdate ;

		if ($images) {
            $image_name        = str_random(20);
            $ext               = strtolower($images->getClientOriginalExtension());
            $image_full_name   ='candidate-'.$image_name.'.'.$ext;
            $upload_path       = "images/";
            $image_url         = $upload_path.$image_full_name;
            $success           = $images->move($upload_path,$image_full_name);
            $data['image']     = $image_url;
        }

        DB::table('admin')->insert($data) ;
        Session()->put('success', 'Thanks ! Marriage Registrar Information Add Successfully Complete. Your Login ID and Password is '.$mobile);
        return Redirect::to('addKazi');
	}

	#---------------- Manage Kazi ----------------------#
	public function manageKazi()
	{
		$result = DB::table('admin')
				->leftJoin('union','admin.union_id','=','union.id')
				->leftJoin('ward','admin.ward_id','=','ward.id')
				->select('admin.*','union.union_name','ward.ward_name')
				->where('admin.type',5)
				->get();

		return view('kazi.manageKazi')->with('result',$result) ;
	}

	#---------------- Edit Kazi Info --------------------------#
	public function editKaziInfo($id)
	{
		$values = DB::table('admin')
				->leftJoin('union','admin.union_id','=','union.id')
				->leftJoin('ward','admin.ward_id','=','ward.id')
				->select('admin.*','union.union_name','ward.ward_name')
				->where('admin.id',$id)
				->first();

		$result = DB::table('union')->where('status',1)->get() ;

		$all_ward = DB::table('ward')->where('union_id',$values->union_id)->get() ;

		return view('kazi.editKaziInfo')->with('values',$values)->with('result',$result)->with('all_ward',$all_ward) ;
	}

	#----------------- Kazi Profile Info --------------------------#
	public function kaziProfile()
	{
		$value = DB::table('admin')
                ->where('id',$this->loged_id)
                ->first();

        return view('kazi.kaziProfile')->with('value',$value) ;
	}

	#---------------- Kazi Profile Info Update -----------------------#
	public function updateKaziProfile($id)
	{
		$value = DB::table('admin')
                ->where('id',$this->loged_id)
                ->first();

        return view('kazi.updateKaziProfile')->with('value',$value) ;
	}

	#---------------- Kazi Profile Info Update -----------------------#
	public function updateKaziProfileInfo(Request $request)
	{
		$this->validate($request,[
            'name'      => 'required',
            'mobile'    => 'required|size:11',
            'images'    => 'mimes:jpeg,jpg,png|max:500',
        ]);

        $name           = trim($request->name);
        $mobile         = trim($request->mobile);
        $primary_id     = $request->primary_id ;
        $images         = $request->file('images') ;

        $check_count = DB::table('admin')
                    ->where('mobile',$mobile)
                    ->whereNotIn('id',[$primary_id])
                    ->count();

        if ($check_count > 0) {
            Session()->put('failed', 'Sorry ! Mobile Number Already Exit.');
            return Redirect::to('editUser/'.$primary_id);
        }

        $data                   = array();
        $data['name']           = $name ;
        $data['mobile']         = $mobile ;

        if ($images) {
            $image_name        = str_random(20);
            $ext               = strtolower($images->getClientOriginalExtension());
            $image_full_name   ='user-'.$image_name.'.'.$ext;
            $upload_path       = "images/";
            $image_url         = $upload_path.$image_full_name;
            $success           = $images->move($upload_path,$image_full_name);
            $data['image']    = $image_url;
        }

        $data['updated_at'] = $this->rcdate ;

        DB::table('admin')->where('id',$primary_id)->update($data);

        Session()->put('success', 'Thanks ! Information Update Successfully Completed.');
        return Redirect::to('updateKaziProfile/'.$primary_id);
	}

	#---------------------- Kazi Change Password ------------------#
	public function kaziChangePassword()
	{
		return view('kazi.kaziChangePassword') ;
	}

	#--------------------- Update Password -----------------------#
	public function kaziUpdatePassword(Request $request)
	{
		$this->validate($request,[
            'old_password'      => 'required',
            'new_password'      => 'required',
            'confirm_password'  => 'required'
        ]);

        $old_password = trim($request->old_password);
        $new_password = trim($request->new_password);
        $confirm_password = trim($request->confirm_password);

        $salt       = 'a123A321';
        $oldPassword  = sha1($old_password.$salt);
        $newPassword  = sha1($new_password.$salt);

        $profile_info   = DB::table('admin')
                        ->where('id',$this->loged_id)
                        ->first();

        if ($profile_info->password != $oldPassword) {
            Session()->put('failed', 'Sorry ! Old Password Not Match.Try Again');
            return Redirect::to('kaziChangePassword');
        }

        if ($new_password != $confirm_password) {
            Session()->put('failed', 'Sorry ! New Password And Confrim Password Not Match.Try Again');
            return Redirect::to('kaziChangePassword');
        }

        $data               = array() ;
        $data['password']   = $newPassword ;
        $data['updated_at'] = $this->rcdate ;

        DB::table('admin')->where('id',$this->loged_id)->update($data);

        Session()->put('success', 'Thanks ! Password Change Successfully Completed.');
        return Redirect::to('kaziChangePassword');
	}


}
