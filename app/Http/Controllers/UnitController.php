<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use Session;

class UnitController extends Controller
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

	// Function for add Unit
	public function addUnit()
	{
		$all_union = DB::table('union')->where('status',1)->get();
		return view('unit.addUnit')->with('all_union',$all_union);
	}

	// Function for add unit info
	public function addUnitInfo(Request $request)
	{
		$this->validate($request,[
            'union_id'   => 'required',
            'ward_id'    => 'required',
            'unit_name'  => 'required'
        ]);

        $union_id    = trim($request->union_id);
        $ward_id     = trim($request->ward_id);
        $unit_name   = trim($request->unit_name);

        $count = DB::table('unit')->where('union_id',$union_id)->where('ward_id',$ward_id)->where('unit_name',$unit_name)->count();
        if($count > 0){
        	Session()->put('failed', 'Sorry ! Unit Already Exists.');
            return Redirect::to('addUnit');
            exit();
        }

        $data = array();
        $data['union_id']     = $union_id;
        $data['ward_id']      = $ward_id;
        $data['unit_name']    = $unit_name;
        $data['status']       = "1";
        $data['created_at']   = $this->rcdate;

        $query = DB::table('unit')->insert($data) ;
        if($query){
            Session()->put('success', 'Thanks ! Unit Successfully Added.');
            return Redirect::to('addUnit');
            
        }else{
            Session()->put('failed', 'Sorry ! Somthing Went Wrong.');
            return Redirect::to('addUnit');
       	}
	}

	// Function for manage unit
	public function manageUnit()
	{
		$result = DB::table('unit')
			->join('union','unit.union_id','=','union.id')
			->join('ward','unit.ward_id','=','ward.id')
			->select('unit.*','union.union_name','ward.ward_name')
			->where('unit.status',1)->get();
		return view('unit.manageUnit')->with('result',$result);
	}

	// Function for edit unit
	public function editUnit($id)
	{
		$row = DB::table('unit')
			->join('union','unit.union_id','=','union.id')
			->join('ward','unit.ward_id','=','ward.id')
			->select('unit.*','union.union_name','ward.ward_name')
			->where('unit.status',1)
			->where('unit.id',$id)
			->first();
		$all_union = DB::table('union')->where('status',1)->get();
		return view('unit.editUnit')->with('row',$row)->with('all_union',$all_union);
	}

	// Function for update unit
	public function updateUnitInfo(Request $request)
	{
		$this->validate($request,[
            'union_id'   => 'required',
            'ward_id'    => 'required',
            'unit_name'  => 'required'
        ]);

        $union_id    = trim($request->union_id);
        $ward_id     = trim($request->ward_id);
        $unit_name   = trim($request->unit_name);
        $id   		 = trim($request->id);

        $count = DB::table('unit')->where('union_id',$union_id)->where('ward_id',$ward_id)->where('unit_name',$unit_name)->whereNotIn('id',[$id])->count();
        if($count > 0){
        	Session()->put('failed', 'Sorry ! Unit Already Exists.');
            return Redirect::to('editUnit/'.$id);
            exit();
        }

        $data = array();
        $data['union_id']     = $union_id;
        $data['ward_id']      = $ward_id;
        $data['unit_name']    = $unit_name;
        $data['status']       = "1";
        $data['modified_at']  = $this->rcdate;

        $query = DB::table('unit')->where('id',$id)->update($data) ;
        if($query){
            Session()->put('success', 'Thanks ! Unit Successfully Updated.');
            return Redirect::to('editUnit/'.$id);
            
        }else{
            Session()->put('failed', 'Sorry ! Somthing Went Wrong.');
            return Redirect::to('editUnit/'.$id);
       	}
	}

} // End of controller
