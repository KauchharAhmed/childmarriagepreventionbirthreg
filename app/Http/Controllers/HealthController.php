<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use Session;

class HealthController extends Controller
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

	#-------------------- Add Health Organization ----------------------#
	public function addHealthOrganization()
	{
		$result = DB::table('union')->where('status',1)->get() ;

		return view('health.addHealthOrganization')->with('result',$result) ;
	}

	#---------------- Insert Health Organization Info --------------------#
	public function addHealthOgranizationInfo(Request $request)
	{
		$this->validate($request,[
			'union_id'			=> 'required',
			'organization_name'	=> 'required',
		]);

		$union_id 					= trim($request->union_id) ;
		$ward_id 					= trim($request->ward_id) ;
		$organization_name 			= trim($request->organization_name) ;
		$contact_number 			= trim($request->contact_number) ;

		$check_count = DB::table('health_organization')
					->where('union_id',$union_id)
					->where('ward_id',$ward_id)
					->where('organization_name',$organization_name)
					->count();

		if ($check_count > 0) {
			Session()->put('failed', 'Sorry ! Organization Already Exit.');
            return Redirect::to('addHealthOrganization/');
		}

		$data = array() ;
		$data['union_id']			= $union_id ;
		$data['ward_id']			= $ward_id ;
		$data['organization_name']	= $organization_name ;
		$data['contact_number']		= $contact_number ;
		$data['status']				= 1 ;
		$data['created_at']			= $this->rcdate ;

		DB::table('health_organization')->insert($data);

		Session()->put('success', 'Thanks ! Health Organization Add Successfully Complete.');
        return Redirect::to('addHealthOrganization/');
	}

	#----------------------- Manage Health Organization --------------------#
	public function manageHealthOrganization()
	{
		$result = DB::table('health_organization')
				->join('union','health_organization.union_id','=','union.id')
				->leftJoin('ward','health_organization.ward_id','=','ward.id')
				->select('health_organization.*','union.union_name','ward.ward_name')
				->get() ;

		return view('health.manageHealthOrganization')->with('result',$result) ;
	}


	#----------------------- View Health Organization ---------------------#
	public function organizationProfile()
	{
		$value = DB::table('admin')
                ->leftJoin('health_organization','admin.organization_id','=','health_organization.id')
                ->select('admin.*','health_organization.organization_name')
                ->where('admin.id',$this->loged_id)
                ->first();

        return view('health.organizationProfile')->with('value',$value) ;
	}

	#----------------------- View Health Organization Profile ---------------------#
	public function organizationProfileInfo()
	{
		$value = DB::table('admin')
                ->leftJoin('health_organization','admin.organization_id','=','health_organization.id')
                ->select('admin.*','health_organization.organization_name')
                ->where('admin.id',$this->loged_id)
                ->first();

        return view('health.organizationProfileInfo')->with('value',$value) ;
	}

	#------------------ Update Profile Info ----------------------------------#
	public function updateOrganizationProfileInfo(Request $request)
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
                    ->whereNotIn('id',[$primary_id])
                    ->count();

        if ($check_count > 0) {
            Session()->put('failed', 'Sorry ! Mobile Number Already Exit.');
            return Redirect::to('organizationProfileInfo/');
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

        Session()->put('success', 'Thanks ! Information Update Successfully Completed.');
        return Redirect::to('organizationProfileInfo/');
	}

	#------------------------ Change Password ----------------------------#
	public function organizationChangePassword()
	{
		return view('health.organizationChangePassword') ;
	}

	#=============== Update New Password ==================#
	public function organizationUpdatePasswordInfo(Request $request)
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
            return Redirect::to('organizationChangePassword');
        }

        if ($new_password != $confirm_password) {
            Session()->put('failed', 'Sorry ! New Password And Confrim Password Not Match.Try Again');
            return Redirect::to('organizationChangePassword');
        }

        $data               = array() ;
        $data['password']   = $newPassword ;
        $data['updated_at'] = $this->rcdate ;

        DB::table('admin')->where('id',$this->loged_id)->update($data);

        Session()->put('success', 'Thanks ! Password Change Successfully Completed.');
        return Redirect::to('organizationChangePassword');
	}


}
