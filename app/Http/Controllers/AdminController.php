<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use Session;

class AdminController extends Controller
{
     private $rcdate ;
     /**
     * ADMIN CLASS costructor 
     *
     */
    public function __construct()
    {
        date_default_timezone_set('Asia/Dhaka');
        $this->rcdate       = date('Y-m-d');
        $this->current_time = date('H:i:s');
        $this->loged_id     = Session::get('admin_id');
    }

    #---------------------- Admin Login Page -----------------------#
    public function index()
    {
		return view('admin.index') ;    	
    }

    #---------------------- Admin Login ----------------------------#
    public function adminLogin(Request $request)
    {
    	$this->validate($request,[
    		'mobile'	=> 'required',
    		'password'	=> 'required'
    	]);

    	$mobile 	= trim($request->mobile);
    	$password 	= trim($request->password);

    	$salt      	= 'a123A321';
     	$vpassword  = sha1($password.$salt);

    	$validate_check = DB::table('admin')
    					->where('mobile',$mobile)
    					->where('password',$vpassword)
    					->where('status',1)
    					->count();
    	if ($validate_check > 0) {

    		$admin_login = DB::table('admin')
    					->where('mobile',$mobile)
    					->where('password',$vpassword)
    					->where('status',1)
    					->first();

			if ($admin_login->type == 1) {
			   	Session::put('admin_name',$admin_login->name);
	    		Session::put('admin_email',$admin_login->email);
	    		Session::put('admin_mobile',$admin_login->mobile);
		        Session::put('admin_id',$admin_login->id);
		        Session::put('type',$admin_login->type);
		        return Redirect::to('/adminDashboard'); 		
			}elseif($admin_login->type == 2){
                Session::put('admin_name',$admin_login->name);
                Session::put('admin_email',$admin_login->email);
                Session::put('admin_mobile',$admin_login->mobile);
                Session::put('admin_id',$admin_login->id);
                Session::put('type',$admin_login->type);
                return Redirect::to('/adminDashboard');
            }elseif($admin_login->type == 3){
                Session::put('admin_name',$admin_login->name);
                Session::put('admin_email',$admin_login->email);
                Session::put('admin_mobile',$admin_login->mobile);
                Session::put('admin_id',$admin_login->id);
                Session::put('type',$admin_login->type);
                return Redirect::to('/instituteDashboard');
            }elseif($admin_login->type == 4){
                Session::put('admin_name',$admin_login->name);
                Session::put('admin_email',$admin_login->email);
                Session::put('admin_mobile',$admin_login->mobile);
                Session::put('admin_id',$admin_login->id);
                Session::put('type',$admin_login->type);
                return Redirect::to('/organizationDashboard');
            }elseif($admin_login->type == 5){
                Session::put('admin_name',$admin_login->name);
                Session::put('admin_email',$admin_login->email);
                Session::put('admin_mobile',$admin_login->mobile);
                Session::put('admin_id',$admin_login->id);
                Session::put('type',$admin_login->type);
                return Redirect::to('/kaziDashboard'); 
            }else{
				Session::put('admin_name',$admin_login->name);
                Session::put('admin_email',$admin_login->email);
                Session::put('admin_mobile',$admin_login->mobile);
                Session::put('admin_id',$admin_login->id);
                Session::put('type',$admin_login->type);
                return Redirect::to('/udcDashboard');
			}   	
    		
    	}else{
    		Session::put('login_faild','Sorry!! Your Information Did Not Match. Try Again');
          return Redirect::to('/admin');
    	}
    }

    #--------------------------------- Profile -----------------------------------#
    public function profile()
    {
        $value = DB::table('admin')
                ->where('id',$this->loged_id)
                ->first();

        return view('admin.profile')->with('value',$value) ;
    }

    #---------------------- Institute Profile --------------------#
    public function instituteProfile()
    {
        $value = DB::table('admin')
                ->leftJoin('institute','admin.institute_id','=','institute.id')
                ->leftJoin('health_organization','admin.organization_id','=','health_organization.id')
                ->select('admin.*','institute.institute_name','health_organization.organization_name')
                ->where('admin.id',$this->loged_id)
                ->first();

        return view('institute.instituteProfile')->with('value',$value) ;
    }

    #--------------------- Update Institute Profile Info -------------------#
    public function instituteProfileInfo($id)
    {
        $value = DB::table('admin')
                ->leftJoin('institute','admin.institute_id','=','institute.id')
                ->leftJoin('health_organization','admin.organization_id','=','health_organization.id')
                ->select('admin.*','institute.institute_name','health_organization.organization_name')
                ->where('admin.id',$id)
                ->first();

        return view('institute.instituteProfileInfo')->with('value',$value) ;
    }

    #-------------------- Update Institute Profile Info -----------------------#
    public function updateInstituteProfileInfo(Request $request)
    {
        $this->validate($request,[
            'name'      => 'required',
            'mobile'    => 'required|size:11',
            'images'    => 'mimes:jpeg,jpg,png|max:500',
        ]);

        $name           = trim($request->name);
        $designation    = trim($request->designation);
        $mobile         = trim($request->mobile);
        $email          = trim($request->email);
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
            $data['image']    = $image_url;
        }

        $data['updated_at'] = $this->rcdate ;

        DB::table('admin')->where('id',$primary_id)->update($data);

        Session()->put('success', 'Thanks ! User Information Update Successfully Completed.');
        return Redirect::to('instituteProfileInfo/'.$primary_id);
    }

    #------------------- Institute Profile Info ------------------------#
    public function instituteChangePassword()
    {
        return view('institute.instituteChangePassword') ;
    }

    #---------------- Change Password --------------------#
    public function instituteUpdatePassword(Request $request)
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
            return Redirect::to('instituteChangePassword');
        }

        if ($new_password != $confirm_password) {
            Session()->put('failed', 'Sorry ! New Password And Confrim Password Not Match.Try Again');
            return Redirect::to('instituteChangePassword');
        }

        $data               = array() ;
        $data['password']   = $newPassword ;
        $data['updated_at'] = $this->rcdate ;

        DB::table('admin')->where('id',$this->loged_id)->update($data);

        Session()->put('success', 'Thanks ! Password Change Successfully Completed.');
        return Redirect::to('instituteChangePassword');
    }

    #------------------------ Update User Profile --------------------#
    public function updateProfile($id)
    {
        $value = DB::table('admin')
                ->where('id',$id)
                ->first();

        return view('admin.updateProfile')->with('value',$value) ;
    }

    #--------------------- Change Password ----------------------#
    public function changePassword()
    {
        return view('admin.changePassword') ;
    }

    #-------------------- Update New Password ------------------------#
    public function updatePassword(Request $request)
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
            return Redirect::to('changePassword');
        }

        if ($new_password != $confirm_password) {
            Session()->put('failed', 'Sorry ! New Password And Confrim Password Not Match.Try Again');
            return Redirect::to('changePassword');
        }

        $data               = array() ;
        $data['password']   = $newPassword ;
        $data['updated_at'] = $this->rcdate ;

        DB::table('admin')->where('id',$this->loged_id)->update($data);

        Session()->put('success', 'Thanks ! Password Change Successfully Completed.');
        return Redirect::to('changePassword');
    }

    #----------------------- User Section ----------------------------#
    public function addUser()
    {
    	return view('user.addUser') ;
    }

    #----------------------- Add User Info --------------------------#
    public function addUserInfo(Request $request)
    {
    	$this->validate($request,[
    		'name'		=> 'required',
    		'mobile'	=> 'required',
    		'images'    => 'mimes:jpeg,jpg,png|max:500',
    	]);

    	$name 			= trim($request->name);
    	$designation 	= trim($request->designation);
    	$mobile 		= trim($request->mobile);
    	$email 			= trim($request->email);
    	$images 		= $request->file('images') ;

    	$check_count = DB::table('admin')->where('mobile',$mobile)->count();

    	if ($check_count > 0) {
    		Session()->put('failed', 'Sorry ! Mobile Number Already Exit.');
            return Redirect::to('addUser');
    	}

    	$salt      	= 'a123A321';
     	$password  = sha1($mobile.$salt);

    	$data 					= array();
    	$data['name']			= $name ;
    	$data['designation']	= $designation ;
    	$data['mobile']			= $mobile ;
    	$data['password']		= $password ;
    	$data['email']			= $email ;

    	if ($images) {
            $image_name        = str_random(20);
            $ext               = strtolower($images->getClientOriginalExtension());
            $image_full_name   ='user-'.$image_name.'.'.$ext;
            $upload_path       = "images/";
            $image_url         = $upload_path.$image_full_name;
            $success           = $images->move($upload_path,$image_full_name);
            $data['image']    = $image_url;
        }

        $data['status']		= 1 ;
        $data['type']		= 2 ;
        $data['created_at']	= $this->rcdate ;

        DB::table('admin')->insert($data);

        Session()->put('success', 'Thanks ! User Add Successfully Completed.');
        return Redirect::to('addUser');
    }

    #---------------------- Manage User -------------------------#
    public function manageUser()
    {
        $result = DB::table('admin')
                ->where('type',2)
                ->get();
        
        return view('user.manageUser')->with('result',$result);
    }

    #------------------------ Change User status ----------------------#
    public function changeUserStatus($id)
    {
        $get_bank_status = DB::table('admin')
                        ->where('id',$id)
                        ->first();

        $status = $get_bank_status->status ;

        if($status == 1){
            $nstatus = 2 ;
        }else{
            $nstatus = 1 ;
        }

        $data               = array();
        $data['status']     = $nstatus ;
        $data['updated_at'] = $this->rcdate ;

        DB::table('admin')
        ->where('id',$id)
        ->update($data);

        Session::put('success','Thanks ! User Status Change Successfully Completed .');
        return Redirect::to('manageUser');
    }

    #--------------------- Edit User Info ---------------------------------#
    public function editUser($id)
    {
        $value = DB::table('admin')
                ->where('id',$id)
                ->first();

        return view('user.editUser')->with('value',$value) ;
    }

    #--------------------- Udpate user Info ----------------------#
    public function updateUserInfo(Request $request)
    {
        $this->validate($request,[
            'name'      => 'required',
            'mobile'    => 'required|size:11',
            'images'    => 'mimes:jpeg,jpg,png|max:500',
        ]);

        $name           = trim($request->name);
        $designation    = trim($request->designation);
        $mobile         = trim($request->mobile);
        $email          = trim($request->email);
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
            $data['image']    = $image_url;
        }

        $data['updated_at'] = $this->rcdate ;

        DB::table('admin')->where('id',$primary_id)->update($data);

        Session()->put('success', 'Thanks ! User Information Update Successfully Completed.');
        return Redirect::to('editUser/'.$primary_id);
    }

    #----------------------------- Logout--------------------------#
    public function adminLogout()
    {
        Session::put('admin_id',null);
        Session::put('type',null);
        return Redirect::to('/');
    }

}
