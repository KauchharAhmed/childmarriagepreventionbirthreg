<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use Session;

class CsvController extends Controller
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

	public function exportCandidateSearchResult(Request $request)
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

         // output headers so that the file is downloaded rather than displayed
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=child_marriage_candidate_list.csv');
          // create a file pointer connected to the output stream
        $output = fopen('php://output', 'w');

        fputcsv($output, array('SL NO','NAME','FATHER NAME','MOTHER NAME','VILLAGE','UNION','INSTITUTE','MOBILE','DOB','AGE'));


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
                $i = 1 ;
                foreach ($result as $value) {
                    $exDob  = date('Y-m-d',strtotime($value->dob));
                    $interval = date_diff(date_create(), date_create($exDob));
                    $date_of_birth = $interval->format("%Y Year, %M Months, %d Days Old");
                    fputcsv($output, array($i++,$value->name,$value->father_name,$value->mother_name,$value->address,$value->union_name,$value->institute_name,$value->contact_number,$exDob,$date_of_birth));
                }

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

                $i = 1 ;
                foreach ($result as $value) {
                    $exDob  = date('Y-m-d',strtotime($value->dob));
                    $interval = date_diff(date_create(), date_create($exDob));
                    $date_of_birth = $interval->format("%Y Year, %M Months, %d Days Old");
                    fputcsv($output, array($i++,$value->name,$value->father_name,$value->mother_name,$value->address,$value->union_name,$value->institute_name,$value->contact_number,$exDob,$date_of_birth));
                }
            }else{
                echo "<h4>No Data Found</h4>";
                exit();
            }
        }

	}
}
