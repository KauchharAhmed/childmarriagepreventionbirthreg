<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use Session;

class InstituteController extends Controller
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

	#------------------ Add Institute Form ---------------------#
	public function addInstitute()
	{
		$result = DB::table('union')->where('status',1)->get() ;

		return view('institute.addInstitute')->with('result',$result) ;
	}

	#-------------------- Get Ward By Union -----------------------#
	public function getWardByUnion(Request $request)
	{
		$union_id = trim($request->union_id) ;

		$query = DB::table('ward')->where('union_id',$union_id)->get() ;
		echo "<option value=''>Select Ward</option>";
	    foreach ($query as $ward) {
	    	echo "<option value=".$ward->id.">".$ward->ward_name."</option>";
	    } 
	}

	#-------------------- Get Ward By Union -----------------------#
	public function getWardByUnionForFront(Request $request)
	{
		$union_id = trim($request->union_id) ;

		$query = DB::table('ward')->where('union_id',$union_id)->get() ;
		echo "<option value=''>ওয়ার্ড নির্বাচন করুন</option>";
	    foreach ($query as $ward) {
	    	echo "<option value=".$ward->id.">".$ward->ward_name."</option>";
	    } 
	}

	#-------------------- Get Ward By Union -----------------------#
	public function getUnionWiseSchool(Request $request)
	{
		$union_id = trim($request->union_id) ;

		$query = DB::table('institute')->where('union_id',$union_id)->get() ;
		echo "<option value=''>Select Institute</option>";
	    foreach ($query as $value) {
	    	echo "<option value=".$value->id.">".$value->institute_name."</option>";
	    } 
	}

	#------------------ Insert Institute Info ----------------------#
	public function addInstituteInfo(Request $request)
	{
		$this->validate($request,[
			'union_id'			=> 'required',
			'institute_name'	=> 'required',
		]);

		$union_id 					= trim($request->union_id) ;
		$ward_id 					= trim($request->ward_id) ;
		$institute_name 			= trim($request->institute_name) ;
		$institute_contact_number 	= trim($request->institute_contact_number) ;

		$check_count = DB::table('institute')
					->where('union_id',$union_id)
					->where('ward_id',$ward_id)
					->where('institute_name',$institute_name)
					->count();

		if ($check_count > 0) {
			Session()->put('failed', 'Sorry ! Institute Already Exit.');
            return Redirect::to('addInstitute/');
		}

		$data = array() ;
		$data['union_id']					= $union_id ;
		$data['ward_id']					= $ward_id ;
		$data['institute_name']				= $institute_name ;
		$data['institute_contact_number']	= $institute_contact_number ;
		$data['status']						= 1 ;
		$data['created_at']					= $this->rcdate ;

		DB::table('institute')->insert($data);

		Session()->put('success', 'Thanks ! Institute Add Successfully Complete.');
        return Redirect::to('addInstitute/');
	}

	#-------------------- Manage Institute ------------------------#
	public function manageInstitute()
	{
		$result = DB::table('institute')
				->join('union','institute.union_id','=','union.id')
				->leftJoin('ward','institute.ward_id','=','ward.id')
				->select('institute.*','union.union_name','ward.ward_name')
				->get() ;

		return view('institute.manageInstitute')->with('result',$result) ;
	}

	#------------------- Edit Institute -----------------------#
	public function editInstitute($id)
	{
		$in_value = DB::table('institute')
				->join('union','institute.union_id','=','union.id')
				->leftJoin('ward','institute.ward_id','=','ward.id')
				->select('institute.*','union.union_name','ward.ward_name')
				->where('institute.id',$id)
				->first() ;

		$result = DB::table('union')->where('status',1)->get() ;		

		return view('institute.editInstitute')->with('in_value',$in_value)->with('result',$result) ;
	}

}
