<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use Session;

class WardController extends Controller
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

	#----------------- Ward Info Add Form -------------------#
	public function addWard()
	{
		$result = DB::table('union')->where('status',1)->get();

		return view('ward.addWard')->with('result',$result) ;
	}

	#---------------------- Insert Ward Info --------------------#
	public function addWardInfo(Request $request)
	{
		$this->validate($request,[
			'union_id'	=> 'required',
			'ward_name'	=> 'required'
		]);

		$union_id 	= trim($request->union_id) ;
		$ward_name 	= trim($request->ward_name) ;

		$check_count = DB::table('ward')->where('union_id',$union_id)->where('ward_name',$ward_name)->count() ;

		if ($check_count > 0) {
			Session()->put('failed', 'Sorry ! Ward Name Already Exit.');
            return Redirect::to('addWard/');
		}

		$data = array() ;
		$data['union_id']	= $union_id ;
		$data['ward_name']	= $ward_name ;
		DB::table('ward')->insert($data) ;
		Session()->put('success', 'Thanks ! Ward Add Successfully Completed.');
        return Redirect::to('addWard/');
	}

	#-------------------------- Manage Ward -----------------------------#
	public function manageWard()
	{
		$result = DB::table('ward')
				->join('union','ward.union_id','=','union.id')
				->select('ward.*','union.union_name')
				->get();

		return view('ward.manageWard')->with('result',$result) ;
	}

	#--------------------- Edit Ward Info Form ------------------------#
	public function editWard($id)
	{
		$value = DB::table('ward')
				->join('union','ward.union_id','=','union.id')
				->select('ward.*','union.union_name')
				->where('ward.id',$id)
				->first();

		$result = DB::table('union')->where('status',1)->get();

		return view('ward.editWard')->with('value',$value)->with('result',$result) ;
	}

	#---------------- Update Ward Info Form ---------------------------#
	public function updateWardInfo(Request $request)
	{
		$this->validate($request,[
			'union_id'	=> 'required',
			'ward_name'	=> 'required'
		]);

		$union_id 		= trim($request->union_id) ;
		$ward_name 		= trim($request->ward_name) ;
		$primary_id 	= trim($request->primary_id) ;

		$check_count = DB::table('ward')
					->where('union_id',$union_id)
					->where('ward_name',$ward_name)
					->whereNotIn('id',[$primary_id])
					->count() ;

		if ($check_count > 0) {
			Session()->put('failed', 'Sorry ! Ward Name Already Exit.');
            return Redirect::to('editWard/'.$primary_id);
		}

		$data = array() ;
		$data['union_id']	= $union_id ;
		$data['ward_name']	= $ward_name ;
		DB::table('ward')->where('id',$primary_id)->update($data) ;
		Session()->put('success', 'Thanks ! Ward Update Successfully Completed.');
        return Redirect::to('editWard/'.$primary_id);
	}

}
