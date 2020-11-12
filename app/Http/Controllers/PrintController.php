<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use Session;

class PrintController extends Controller
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


	#------------------ Print Admin Candidates Search Result Print -------------------#
	public function printAdminCandidateSearchResultView(Request $request)
	{
		$union_id           = trim($request->union_id) ;
        $ward_id            = trim($request->ward_id) ;
        $institute_id       = trim($request->institute_id) ;
        $address            = trim($request->address) ;
        $name               = trim($request->name) ;

        if($union_id == ""){
            $all_union = DB::table('union')->where('status',1)->get() ;
            foreach ($all_union as $union_value) {
                $all_union_id[] = $union_value->id ;
            }
        }else{
            $all_union_id[] = $union_id ;
        }

        if($ward_id == ""){
            $all_ward = DB::table('ward')->get() ;
            foreach ($all_ward as $ward_value) {
                $all_ward_id[] = $ward_value->id ;
            }
        }else{
            $all_ward_id[] = $institute_id ;
        }


        if ($institute_id == "") {
            $check_count = DB::table('candidates')
                    ->join('union','candidates.union_id','=','union.id')
                    ->leftJoin('ward','candidates.ward_id','=','ward.id')
                    ->leftJoin('institute','candidates.institute_id','=','institute.id')
                    ->select('candidates.*','union.union_name','ward.ward_name','institute.institute_name')         
                    ->whereIn('candidates.union_id',$all_union_id)
                    ->where('candidates.name', 'like', '%' . $name . '%')
                    ->where('candidates.address', 'like', '%' . $address . '%')
                    ->count() ;

            if ($check_count > 0) {
                $result = DB::table('candidates')
                        ->join('union','candidates.union_id','=','union.id')
                        ->leftJoin('ward','candidates.ward_id','=','ward.id')
                        ->leftJoin('institute','candidates.institute_id','=','institute.id')
                        ->select('candidates.*','union.union_name','ward.ward_name','institute.institute_name') 
                        ->whereIn('candidates.union_id',$all_union_id)
                        ->where('candidates.name', 'like', '%' . $name . '%')
                        ->where('candidates.address', 'like', '%' . $address . '%')
                        ->get() ;
                $settings = DB::table('age_setting')->where('id',1)->first() ;

                return view('print.printAdminCandidateSearchResultView')->with('result',$result)->with('settings',$settings)->with('union_id',$union_id)->with('ward_id',$ward_id)->with('institute_id',$institute_id)->with('address',$address)->with('name',$name) ;
            }else{
                echo "<h4>No Data Found</h4>";
                exit();
            }
        }else{
            $check_count = DB::table('candidates')
                    ->join('union','candidates.union_id','=','union.id')
                    ->leftJoin('ward','candidates.ward_id','=','ward.id')
                    ->leftJoin('institute','candidates.institute_id','=','institute.id')
                    ->select('candidates.*','union.union_name','ward.ward_name','institute.institute_name')         
                    ->whereIn('candidates.union_id',$all_union_id)
                    ->where('candidates.institute_id',$institute_id)
                    ->where('candidates.name', 'like', '%' . $name . '%')
                    ->where('candidates.address', 'like', '%' . $address . '%')
                    ->count() ;

            if ($check_count > 0) {
                $result = DB::table('candidates')
                        ->join('union','candidates.union_id','=','union.id')
                        ->leftJoin('ward','candidates.ward_id','=','ward.id')
                        ->leftJoin('institute','candidates.institute_id','=','institute.id')
                        ->select('candidates.*','union.union_name','ward.ward_name','institute.institute_name') 
                        ->whereIn('candidates.union_id',$all_union_id)
                        ->where('candidates.institute_id',$institute_id)
                        ->where('candidates.name', 'like', '%' . $name . '%')
                        ->where('candidates.address', 'like', '%' . $address . '%')
                        ->get() ;
                $settings = DB::table('age_setting')->where('id',1)->first() ;

                return view('print.printAdminCandidateSearchResultView')->with('result',$result)->with('settings',$settings)->with('union_id',$union_id)->with('ward_id',$ward_id)->with('institute_id',$institute_id)->with('address',$address)->with('name',$name) ;
            }else{
                echo "<h4>No Data Found</h4>";
                exit();
            }
        }
	}

    #---------------------------Print New Candidates list by udc--------------------------#
    public function printNewCandidateListByUdc(Request $request)
    {
        $union_id = trim($request->union_id);
        $result = DB::table('candidates')
                ->join('union','candidates.union_id','=','union.id')
                ->leftJoin('ward','candidates.ward_id','=','ward.id')
                ->leftJoin('institute','candidates.institute_id','=','institute.id')
                ->select('candidates.*','union.union_name','ward.ward_name','institute.institute_name') 
                ->where('candidates.union_id',$union_id)
                ->where('candidates.berth_reg_complete',1)
                ->get() ;
        $settings = DB::table('age_setting')->where('id',1)->first() ;
        return view('print.printNewCandidateListByUdc')->with('result',$result)->with('settings',$settings);
    }

    #---------------------------Print New Candidates list by udc--------------------------#
    public function printNewCandidateListByAdmin(Request $request)
    {
        $result = DB::table('candidates')
                ->join('union','candidates.union_id','=','union.id')
                ->leftJoin('ward','candidates.ward_id','=','ward.id')
                ->leftJoin('institute','candidates.institute_id','=','institute.id')
                ->select('candidates.*','union.union_name','ward.ward_name','institute.institute_name')
                ->where('candidates.berth_reg_complete',1)
                ->get() ;
        $settings = DB::table('age_setting')->where('id',1)->first() ;
        return view('print.printNewCandidateListByUdc')->with('result',$result)->with('settings',$settings);
    }

}
