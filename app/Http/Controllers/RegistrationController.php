<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use Session;

class RegistrationController extends Controller {
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

	#-------------------- Sign up ----------------------#
	public function signUp() 
	{
		$all_institute 		= DB::table('institute')->where('status',1)->get() ;
		$all_organization 	= DB::table('health_organization')->where('status',1)->get() ;
		$all_union 			= DB::table('union')->where('status',1)->get() ;
		return view('user.signUp')->with('all_institute',$all_institute)->with('all_organization',$all_organization)->with('all_union',$all_union) ;
	}

	#-------------------- Regisration -----------------------#
	public function userSignUpInfo(Request $request)
	{
		$this->validate($request,[
			'type'				=> 'required',
			'name'				=> 'required',
			'designation'		=> 'required',
			'mobile'			=> 'required|size:11',
			'images'         	=> 'mimes:jpeg,jpg,png|max:500'
		]);

		$type 				= trim($request->type) ;
		$institute_id 		= trim($request->institute_id) ;
		$organization_id 	= trim($request->organization_id) ;
		$union_id 			= trim($request->union_id) ;
		$name 				= trim($request->name) ;
		$designation 		= trim($request->designation) ;
		$mobile 			= trim($request->mobile) ;
		$email 				= trim($request->email) ;
		$address 			= trim($request->address) ;
		$image 				= $request->file('images') ;

		if ($type == 3 and empty($institute_id)) {
			Session::put('login_faild','Select institute first.');
          	return Redirect::to('/signUp');
		}elseif($type == 4 and empty($organization_id)){
			Session::put('login_faild','Select Organization first.');
          	return Redirect::to('/signUp');
		}elseif($type == 6 and empty($union_id)){
			Session::put('login_faild','Select Union first.');
          	return Redirect::to('/signUp');
		}

		$salt      			= 'a123A321';
     	$password  			= sha1($mobile.$salt);


     	$check_count = DB::table('admin')->where('mobile',$mobile)->count() ;
     	if ($check_count > 0) {
     		Session::put('login_faild','Sorry!! User Already Exit.');
          	return Redirect::to('/signUp');
     	}

     	if ($type == 3) {
     		$filed_name = 'institute_id' ;
     		$value      = $institute_id ;
     	}elseif($type == 4){
     		$filed_name = 'organization_id' ;
     		$value      = $organization_id ;
     	}else{
     		$filed_name = 'union_id' ;
     		$value      = $union_id ;
     	}

     	$data = array();
     	$data[$filed_name]			= $value ;
     	$data['name']				= $name ;
     	$data['designation']		= $designation ;
     	$data['email']				= $email ;
     	$data['mobile']				= $mobile ;
     	$data['address']			= $address ;
     	$data['password']			= $password ;
     	$data['type']				= $type ;
     	$data['created_at']			= $this->rcdate ;

		if ($image) {
			$image_name        = str_random(20);
			$ext               = strtolower($image->getClientOriginalExtension());
			$image_full_name   ='product-'.$image_name.'.'.$ext;
			$upload_path       = "images/";
			$image_url         = $upload_path.$image_full_name;
			$success           = $image->move($upload_path,$image_full_name);
			$data['image'] 	   = $image_url;
		}

		DB::table('admin')->insert($data) ;
		Session::put('login_success','Thanks!! Sign Up Successfully Complete.Wait For Admin Approve.');
        return Redirect::to('/signUp');
	}

	#--------------------- Get All Pending User List --------------------#
	public function pendingUserList()
	{
		$result = DB::table('admin')
				->leftJoin('institute','admin.institute_id','=','institute.id')
				->leftJoin('health_organization','admin.organization_id','=','health_organization.id')
				->select('admin.*','institute.institute_name','health_organization.organization_name')
				->where('admin.status',0)
				->get() ;
		return view('user.pendingUserList')->with('result',$result) ;
	}

	#---------------- Approve User -------------------------#
	public function userStatusApprove($id)
	{
		$data 				= array() ;
		$data['status']		= 1 ;
		$data['updated_at']	= $this->rcdate ;

		DB::table('admin')->where('id',$id)->update($data) ;

		Session::put('success','Thanks!! User Account Approve Successfully Complete.');
        return Redirect::to('/pendingUserList');
	}

	#---------------- Reject User -------------------------#
	public function userStatusReject($id)
	{
		$data 				= array() ;
		$data['status']		= 2 ;
		$data['updated_at']	= $this->rcdate ;

		DB::table('admin')->where('id',$id)->update($data) ;

		Session::put('success','Thanks!! User Account Reject Successfully Complete.');
        return Redirect::to('/pendingUserList');
	}

	#----------------- Reject User List ------------------------#
	public function rejectUserList()
	{
		$result = DB::table('admin')
				->leftJoin('institute','admin.institute_id','=','institute.id')
				->select('admin.*','institute.institute_name')
				->where('admin.status',2)
				->whereIn('admin.type',[3,4])
				->get() ;
		return view('user.rejectUserList')->with('result',$result) ;
	}

	#----------------- Active User List ------------------------#
	public function activeUserList()
	{
		$result = DB::table('admin')
				->leftJoin('institute','admin.institute_id','=','institute.id')
				->select('admin.*','institute.institute_name')
				->where('admin.status',1)
				->whereIn('admin.type',[3,4,6])
				->get() ;
		return view('user.activeUserList')->with('result',$result) ;
	}
	#---------------------Edit active user----------------------#
	public function editActiveUser($id)
	{
		$row = DB::table('admin')->where('id',$id)->first();
		return view('user.editActiveUser')->with('row',$row);
	}

	#---------------------Update Active App User-------------------------#
	public function updateActiveUserInfo(Request $request)
	{
		$this->validate($request,[
			'name'			=> 'required',
			'designation'	=> 'required',
			'images'        => 'mimes:jpeg,jpg,png|max:500'
		]);

		$name 			= trim($request->name);
		$designation 	= trim($request->designation);
		$email 			= trim($request->email);
		$mobile 	    = trim($request->mobile);
		$address 		= trim($request->address);
		$image 			= $request->file('images');
		$id 			= trim($request->id);
		$current_image 	= trim($request->current_image);

		$count2 = DB::table('admin')->where('mobile',$mobile)->whereNotIn('id',[$id])->count();
		if($count2 > 0){
			Session()->put('failed', 'Sorry ! Mobile Already Exists.');
            return Redirect::to('editActiveUser/'.$id);
            exit();
		}

		if(empty($image)){
			$data = array();
			$data['name'] 		 = $name;
			$data['designation'] = $designation;
			$data['email'] 		 = $email;
			$data['mobile']      = $mobile;
			$data['address'] 	 = $address;
		}else{
			$image_name        = str_random(20);
			$ext               = strtolower($image->getClientOriginalExtension());
			$image_full_name   ='user-'.$image_name.'.'.$ext;
			$upload_path       = "images/";
			$image_url         = $upload_path.$image_full_name;
			$success           = $image->move($upload_path,$image_full_name);

			if ($current_image != "") {
                unlink($current_image);
            }
			
			$data = array();
			$data['name'] 		 = $name;
			$data['designation'] = $designation;
			$data['email'] 		 = $email;
			$data['address'] 	 = $address;
			$data['image'] 	   	 = $image_url;
		}

		DB::table('admin')->where('id',$id)->update($data) ;
		Session::put('success','Thanks!! User Update Successfully Complete.');
		return Redirect::to('editActiveUser/'.$id);
	}


	#========================== ADMIN USER SECTOIN =========================#
	public function addAppUser()
	{
		$all_institute 		= DB::table('institute')->where('status',1)->get() ;
		$all_organization 	= DB::table('health_organization')->where('status',1)->get() ;
		$all_union 			= DB::table('union')->where('status',1)->get() ;
		return view('user.addAppUser')->with('all_institute',$all_institute)->with('all_organization',$all_organization)->with('all_union',$all_union) ;
	}


	#===================== Insert App User Info ==============================#
	public function addAppUserInfo(Request $request)
	{
		$this->validate($request,[
			'type'				=> 'required',
			'name'				=> 'required',
			'designation'		=> 'required',
			'mobile'			=> 'required|size:11',
			'images'         	=> 'mimes:jpeg,jpg,png|max:500'
		]);

		$type 				= trim($request->type) ;
		$institute_id 		= trim($request->institute_id) ;
		$organization_id 	= trim($request->organization_id) ;
		$union_id 			= trim($request->union_id) ;
		$name 				= trim($request->name) ;
		$designation 		= trim($request->designation) ;
		$mobile 			= trim($request->mobile) ;
		$email 				= trim($request->email) ;
		$address 			= trim($request->address) ;
		$image 				= $request->file('images') ;

		if ($type == 3 and empty($institute_id)) {
			Session::put('login_faild','Select institute first.');
          	return Redirect::to('/addAppUser');
		}elseif($type == 4 and empty($organization_id)){
			Session::put('login_faild','Select Organization first.');
          	return Redirect::to('/addAppUser');
		}elseif($type == 6 and empty($union_id)){
			Session::put('login_faild','Select Union first.');
          	return Redirect::to('/addAppUser');
		}

		$salt      			= 'a123A321';
     	$password  			= sha1($mobile.$salt);


     	$check_count = DB::table('admin')->where('mobile',$mobile)->count() ;
     	if ($check_count > 0) {
     		Session::put('login_faild','Sorry!! User Already Exit.');
          	return Redirect::to('/addAppUser');
     	}

     	if ($type == 3) {
     		$filed_name = 'institute_id' ;
     		$value      = $institute_id ;
     	}elseif($type == 4){
     		$filed_name = 'organization_id' ;
     		$value      = $organization_id ;
     	}else{
     		$filed_name = 'union_id' ;
     		$value      = $union_id ;
     	}

     	$data = array();
     	$data[$filed_name]			= $value ;
     	$data['name']				= $name ;
     	$data['designation']		= $designation ;
     	$data['email']				= $email ;
     	$data['mobile']				= $mobile ;
     	$data['address']			= $address ;
     	$data['password']			= $password ;
     	$data['type']				= $type ;
     	$data['status']				= 1 ;
     	$data['created_at']			= $this->rcdate ;

		if ($image) {
			$image_name        = str_random(20);
			$ext               = strtolower($image->getClientOriginalExtension());
			$image_full_name   ='product-'.$image_name.'.'.$ext;
			$upload_path       = "images/";
			$image_url         = $upload_path.$image_full_name;
			$success           = $image->move($upload_path,$image_full_name);
			$data['image'] 	   = $image_url;
		}

		DB::table('admin')->insert($data) ;
		Session::put('success','Thanks!! User Add Successfully Complete.Login Id And Password is '.$mobile);
		return Redirect::to('/addAppUser');
	}

}
