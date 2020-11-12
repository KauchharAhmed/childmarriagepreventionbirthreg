<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use Session;


class CandidateController extends Controller
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

    #======================= INSTITUTE CANDIDATE ADD SECTION ========================#
    public function addStudent()
    {
    	$result = DB::table('union')->where('status',1)->get() ;

    	return view('candidate.addStudent')->with('result',$result) ;
    }

    #-------------------- Insert Student Info -----------------------#
    public function addStudentInfo(Request $request)
    {
    	$this->validate($request,[
    		'union_id'			=> 'required',
    		'name'				=> 'required',
    		'father_name'		=> 'required',
            'mother_name'       => 'required',
    		'gender'		    => 'required',
    		'birth_reg_no'		=> 'required',
            'contact_number'    => 'required|size:11',
    		'address'	        => 'required',
    		'dob'				=> 'required',
    		'image'				=> 'mimes:jpeg,jpg,png|max:500',
    	]);

    	$union_id		= trim($request->union_id) ;
    	$ward_id		= trim($request->ward_id) ;
    	$name			= trim($request->name) ;
    	$father_name	= trim($request->father_name) ;
        $mother_name    = trim($request->mother_name) ;
    	$gender	        = trim($request->gender) ;
    	$birth_reg_no	= trim($request->birth_reg_no) ;
        $contact_number = trim($request->contact_number) ;
        $address        = trim($request->address) ;
    	$type_here	    = trim($request->type_here) ;
    	$dob			= trim($request->dob) ;
    	$dob_final 		= date('Y-m-d',strtotime($dob));

    	$images = $request->file('image') ;

    	$duplicate_check = DB::table('candidates')->where('birth_reg_no',$birth_reg_no)->where('type',1)->count();

    	if ($duplicate_check > 0) {
    		Session()->put('failed', 'Sorry ! Student Information Already Exit.');
            if ($type_here == 1) {
                return Redirect::to('addStudent');
            }else{
                return Redirect::to('studentAddForm');
            }
    	}
        if ($type_here == 1) {
            $admin_info     = DB::table('admin')->where('id',$this->loged_id)->first() ;
            $institute_id   = $admin_info->institute_id ;
        }else{
            $institute_id   = trim($request->institute_id) ;
        }


    	$data = array() ;
    	$data['added_id']		= $this->loged_id ;
    	$data['union_id']		= $union_id ;
        $data['ward_id']        = $ward_id ;
    	$data['institute_id']	=  $institute_id ;
    	$data['name']			= $name ;
    	$data['father_name']	= $father_name ;
        $data['mother_name']    = $mother_name ;
    	$data['gender']	        = $gender ;
        $data['contact_number'] = $contact_number ;
    	$data['address']	    = $address ;
    	$data['dob']			= $dob_final ;
    	$data['birth_reg_no']	= $birth_reg_no ;
    	$data['type']			= 1 ;
    	$data['status']			= 1 ;
    	$data['created_at']		= $this->rcdate;

    	if ($images) {
            $image_name        = str_random(20);
            $ext               = strtolower($images->getClientOriginalExtension());
            $image_full_name   ='candidate-'.$image_name.'.'.$ext;
            $upload_path       = "images/";
            $image_url         = $upload_path.$image_full_name;
            $success           = $images->move($upload_path,$image_full_name);
            $data['image']     = $image_url;
        }

       $query = DB::table('candidates')->insert($data) ;
       if ($query) {
       		Session()->put('success', 'Thanks ! Student Information Add Successfully Complete.');
            if ($type_here == 1) {
                return Redirect::to('addStudent');
            }else{
                return Redirect::to('studentAddForm');
            }
            
       }else{
       		Session()->put('failed', 'Sorry ! Somthing Went Wrong.');
            if ($type_here == 1) {
                return Redirect::to('addStudent');
            }else{
                return Redirect::to('studentAddForm');
            }
       }
    }

    #----------------- Manage Student Info -----------------------#
    public function manageStudent()
    {
        $result = DB::table('candidates')
                ->join('union','candidates.union_id','=','union.id')
                ->leftjoin('ward','candidates.ward_id','=','ward.id')
                ->select('candidates.*','union.union_name','ward.ward_name')
                ->where('candidates.added_id',$this->loged_id)
                ->where('candidates.type',1)
                ->orderBy('candidates.id','desc')
                ->get() ;

        return view('candidate.manageStudent')->with('result',$result);
    }

    #----------------- Manage Student Info -----------------------#
    public function manageAllStudent()
    {
    	$result = DB::table('candidates')
    			->join('union','candidates.union_id','=','union.id')
                ->join('ward','candidates.ward_id','=','ward.id')
    			->leftJoin('institute','candidates.institute_id','=','institute.id')
    			->select('candidates.*','union.union_name','ward.ward_name','institute.institute_name')
    			->where('candidates.added_id',$this->loged_id)
                ->where('candidates.type',1)
    			->orderBy('candidates.id','desc')
    			->get() ;

    	return view('candidate.manageAllStudent')->with('result',$result);
    }

    #--------------------- View Student Info --------------------------#
    public function viewStudentInfo($id)
    {
    	$value = DB::table('candidates')
    			->join('union','candidates.union_id','=','union.id')
                ->leftJoin('ward','candidates.ward_id','=','ward.id')
    			->leftJoin('institute','candidates.institute_id','=','institute.id')
    			->select('candidates.*','union.union_name','ward.ward_name','institute.institute_name')
    			->where('candidates.id',$id)
    			->first() ;

    	return view('candidate.viewStudentInfo')->with('value',$value);

        // $result = DB::table('candidates')
        //         ->join('union','candidates.union_id','=','union.id')
        //         ->leftJoin('ward','candidates.ward_id','=','ward.id')
        //         ->leftJoin('institute','candidates.institute_id','=','institute.id')
        //         ->select('candidates.*','union.union_name','ward.ward_name','institute.institute_name') 
        //         ->where('candidates.institute_id',$inst_info->institute_id)
        //         ->get() ;
        // $settings = DB::table('age_setting')->where('id',1)->first() ;

        // return view('candidate.manageInstituteCandidates')->with('result',$result)->with('settings',$settings) ;
    }

    #=========================== CHILD SECTION ===========================#
    public function addChild()
    {
        $result = DB::table('union')->where('status',1)->get() ;

        return view('candidate.addChild')->with('result',$result) ;
    }

    #-------------------- Insert Child Info ------------------------#
    public function addChildInfo(Request $request)
    {
        $this->validate($request,[
            'union_id'          => 'required',
            'name'              => 'required',
            'father_name'       => 'required',
            'mother_name'       => 'required',
            'gender'            => 'required',
            'contact_number'    => 'required|size:11',
            'address'           => 'required',
            'dob'               => 'required',
            'image'             => 'mimes:jpeg,jpg,png|max:500',
        ]);

        $union_id       = trim($request->union_id) ;
        $ward_id        = trim($request->ward_id) ;
        $name           = trim($request->name) ;
        $father_name    = trim($request->father_name) ;
        $mother_name    = trim($request->mother_name) ;
        $gender         = trim($request->gender) ;
        $birth_reg_no   = trim($request->birth_reg_no) ;
        $contact_number = trim($request->contact_number) ;
        $address        = trim($request->address) ;
        $dob            = trim($request->dob) ;
        $dob_final      = date('Y-m-d',strtotime($dob));

        $images = $request->file('image') ;

        $duplicate_check = DB::table('candidates')->where('ward_id',$ward_id)->where('name',$name)->where('father_name',$father_name)->count();

        if ($duplicate_check > 0) {
            Session()->put('failed', 'Sorry ! Child Information Already Exit.');
            return Redirect::to('addChild');
        }

        $data = array() ;
        $data['added_id']       = $this->loged_id ;
        $data['union_id']       = $union_id ;
        $data['ward_id']        = $ward_id ;
        $data['name']           = $name ;
        $data['father_name']    = $father_name ;
        $data['mother_name']    = $mother_name ;
        $data['gender']         = $gender ;
        $data['contact_number'] = $contact_number ;
        $data['address']        = $address ;
        $data['dob']            = $dob_final ;
        $data['birth_reg_no']   = $birth_reg_no ;
        $data['type']           = 2 ;
        $data['status']         = 1 ;
        $data['created_at']     = $this->rcdate;

        if ($images) {
            $image_name        = str_random(20);
            $ext               = strtolower($images->getClientOriginalExtension());
            $image_full_name   ='candidate-'.$image_name.'.'.$ext;
            $upload_path       = "images/";
            $image_url         = $upload_path.$image_full_name;
            $success           = $images->move($upload_path,$image_full_name);
            $data['image']     = $image_url;
        }

       $query = DB::table('candidates')->insert($data) ;
       if ($query) {
            Session()->put('success', 'Thanks ! Child Information Add Successfully Complete.');
            return Redirect::to('addChild');
       }else{
            Session()->put('failed', 'Sorry ! Somthing Went Wrong.');
            return Redirect::to('addChild');
       }
    }

    #-------------------- Manage Child Info ------------------------#
    public function manageChild()
    {
        $result = DB::table('candidates')
                ->join('union','candidates.union_id','=','union.id')
                ->join('ward','candidates.ward_id','=','ward.id')
                ->select('candidates.*','union.union_name','ward.ward_name')
                ->where('candidates.added_id',$this->loged_id)
                ->where('candidates.type',2)
                ->orderBy('candidates.id','desc')
                ->get() ;

        return view('candidate.manageChild')->with('result',$result);
    }

    #-------------------- View Child Info ---------------------#
    public function viewChildInfo($id)
    {
        $value = DB::table('candidates')
                ->join('union','candidates.union_id','=','union.id')
                ->join('ward','candidates.ward_id','=','ward.id')
                ->select('candidates.*','union.union_name','ward.ward_name')
                ->where('candidates.added_id',$this->loged_id)
                ->where('candidates.id',$id)
                ->first() ;

        return view('candidate.viewChildInfo')->with('value',$value);
    }


    #--------------------- Search Candidates ----------------------#
    public function searchCandidates()
    {
        $all_union = DB::table('union')->where('status',1)->get() ;

        return view('candidate.searchCandidates')->with('all_union',$all_union) ;
    }

    #----------------- View Search Candidate Result --------------------#
    public function candidateSearchResultView(Request $request)
    {
        $union_id   = trim($request->union_id) ;
        $ward_id    = trim($request->ward_id) ;
        $name       = trim($request->name) ;

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
            $all_ward_id[] = $ward_id ;
        }

        if ($ward_id != "") {
            $check_count = DB::table('candidates')
                    ->join('union','candidates.union_id','=','union.id')
                    ->leftJoin('ward','candidates.ward_id','=','ward.id')
                    ->leftJoin('institute','candidates.institute_id','=','institute.id')
                    ->select('candidates.*','union.union_name','ward.ward_name','institute.institute_name')
                    ->whereIn('candidates.union_id',$all_union_id)
                    ->whereIn('candidates.ward_id',$all_ward_id)
                    ->where('candidates.name', 'like', '%' . $name . '%')
                    ->count() ;

            if ($check_count > 0) {
                $result = DB::table('candidates')
                        ->join('union','candidates.union_id','=','union.id')
                        ->leftJoin('ward','candidates.ward_id','=','ward.id')
                        ->leftJoin('institute','candidates.institute_id','=','institute.id')
                        ->select('candidates.*','union.union_name','ward.ward_name','institute.institute_name')
                        ->whereIn('candidates.union_id',$all_union_id)
                        ->whereIn('candidates.ward_id',$all_ward_id)
                        ->where('candidates.name', 'like', '%' . $name . '%')
                        ->get() ;

                $settings = DB::table('age_setting')->where('id',1)->first() ;
                return view('candidate.candidateSearchResultView')->with('result',$result)->with('settings',$settings) ;
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
                    ->where('candidates.name', 'like', '%' . $name . '%')
                    ->count() ;

            if ($check_count > 0) {
                $result = DB::table('candidates')
                        ->join('union','candidates.union_id','=','union.id')
                        ->leftJoin('ward','candidates.ward_id','=','ward.id')
                        ->leftJoin('institute','candidates.institute_id','=','institute.id')
                        ->select('candidates.*','union.union_name','ward.ward_name','institute.institute_name')
                        ->whereIn('candidates.union_id',$all_union_id)
                        ->where('candidates.name', 'like', '%' . $name . '%')
                        ->get() ;

                $settings = DB::table('age_setting')->where('id',1)->first() ;
                return view('candidate.candidateSearchResultView')->with('result',$result)->with('settings',$settings) ;
            }else{
                echo "<h4>No Data Found</h4>";
                exit();
            }
        }

        
    }

    #========================= Admin Search Section ============================#
    public function adminManageCandidates()
    {
        $result = DB::table('candidates')
                ->join('union','candidates.union_id','=','union.id')
                ->leftJoin('ward','candidates.ward_id','=','ward.id')
                ->leftJoin('institute','candidates.institute_id','=','institute.id')
                ->select('candidates.*','union.union_name','ward.ward_name','institute.institute_name') 
                ->orderBy('candidates.id','desc')
                ->get() ;
        $settings = DB::table('age_setting')->where('id',1)->first() ;

        return view('candidate.adminManageCandidates')->with('result',$result)->with('settings',$settings) ;
    }

    #------------------------- View Candidates Info ----------------------#
    public function viewCandidatesInfo($id)
    {
        $value = DB::table('candidates')
                ->join('union','candidates.union_id','=','union.id')
                ->leftJoin('ward','candidates.ward_id','=','ward.id')
                ->leftJoin('institute','candidates.institute_id','=','institute.id')
                ->select('candidates.*','union.union_name','ward.ward_name','institute.institute_name')
                ->where('candidates.id',$id)
                ->first() ;
        $settings = DB::table('age_setting')->where('id',1)->first() ;

        return view('candidate.viewCandidatesInfo')->with('value',$value)->with('settings',$settings) ;
    }

    #------------------------- View Candidates Info ----------------------#
    public function editCandidatesInfo($id)
    {
        $all_union = DB::table('union')->where('status',1)->get() ;

        $value = DB::table('candidates')
                ->join('union','candidates.union_id','=','union.id')
                ->leftJoin('ward','candidates.ward_id','=','ward.id')
                ->leftJoin('institute','candidates.institute_id','=','institute.id')
                ->select('candidates.*','union.union_name','ward.ward_name','institute.institute_name')
                ->where('candidates.id',$id)
                ->first() ;
        $settings = DB::table('age_setting')->where('id',1)->first() ;
        $all_institute = DB::table('institute')->get() ;

        return view('candidate.editCandidatesInfo')->with('value',$value)->with('settings',$settings)->with('all_union',$all_union)->with('all_institute',$all_institute) ;
    }

    #---------------------- Update Candidate Info ---------------------#
    public function updateCandidatesInfo(Request $request)
    {
        $this->validate($request,[
            'union_id'          => 'required',
            'ward_id'           => 'required',
            'name'              => 'required',
            'father_name'       => 'required',
            'mother_name'       => 'required',
            'gender'            => 'required',
            'contact_number'    => 'required|size:11',
            'address'           => 'required',
            'dob'               => 'required',
            'image'             => 'mimes:jpeg,jpg,png|max:500',
        ]);

        $union_id       = trim($request->union_id) ;
        $ward_id        = trim($request->ward_id) ;
        $institute_id   = trim($request->institute_id) ;
        $name           = trim($request->name) ;
        $father_name    = trim($request->father_name) ;
        $mother_name    = trim($request->mother_name) ;
        $gender         = trim($request->gender) ;
        $birth_reg_no   = trim($request->birth_reg_no) ;
        $contact_number = trim($request->contact_number) ;
        $address        = trim($request->address) ;
        $dob            = trim($request->dob) ;
        $dob_final      = date('Y-m-d',strtotime($dob));
        $primary_id     = trim($request->primary_id) ;

        $images = $request->file('image') ;

        $duplicate_check = DB::table('candidates')->where('ward_id',$ward_id)->where('name',$name)->where('father_name',$father_name)->whereNotIn('id',[$primary_id])->count();

        if ($duplicate_check > 0) {
            Session()->put('failed', 'Sorry ! Candidate Information Already Exit.');
            return Redirect::to('editCandidatesInfo/'.$primary_id);
        }

        $candiate_info = DB::table('candidates')
                ->join('union','candidates.union_id','=','union.id')
                ->leftjoin('ward','candidates.ward_id','=','ward.id')
                ->leftJoin('institute','candidates.institute_id','=','institute.id')
                ->select('candidates.*','union.union_name','ward.ward_name','institute.institute_name')
                ->where('candidates.id',$primary_id)
                ->first()  ;
        
        if ($candiate_info->dob != $dob_final) {
            
            $union_info = DB::table('union')->where('id',$union_id)->first() ;
            $union_name = $union_info->union_name ;

            if ($ward_id  != 0) {
                $ward_info = DB::table('ward')->where('id',$ward_id)->first() ;
                $ward_name = $ward_info->ward_name ;
            }else{
                $ward_name = "" ;
            }

            $owner_message = "Full Stop Child Marriage Message \n Name: ".$name." \n F.Name : ".$father_name." \n Vill : ".$address." \n Ward No: ".$ward_name." \n Union : ".$union_name." \n Problem : Age Change Prev DOB: ".date('d-m-Y',strtotime($candiate_info->dob)).' Change Date : '.date('d-m-Y',strtotime($dob_final)) ;

            $owner_messages = urlencode($owner_message);


            function curl_get_contents($furl){
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_URL, $furl);
                $data = curl_exec($ch);
                curl_close($ch);
                return $data;
            }

            $messagesss = htmlentities($owner_messages);
            $url = "http://app.planetgroupbd.com/api/sendsms/plain?user=asianitinc&password=5hjxFQ&sender=Friend&SMSText=$messagesss&GSM=8801729377479&type=longSMS&datacoding=8";
            $furl = str_replace(' ', '%20', $url);
            curl_get_contents($furl);
        }


        $data = array() ;
        $data['added_id']       = $this->loged_id ;
        $data['union_id']       = $union_id ;
        $data['ward_id']        = $ward_id ;
        $data['institute_id']   = $institute_id ;
        $data['name']           = $name ;
        $data['father_name']    = $father_name ;
        $data['mother_name']    = $mother_name ;
        $data['gender']         = $gender ;
        $data['contact_number'] = $contact_number ;
        $data['address']        = $address ;
        $data['dob']            = $dob_final ;
        $data['birth_reg_no']   = $birth_reg_no ;
        $data['updated_at']     = $this->rcdate;

        if ($images) {
            $image_name        = str_random(20);
            $ext               = strtolower($images->getClientOriginalExtension());
            $image_full_name   ='candidate-'.$image_name.'.'.$ext;
            $upload_path       = "images/";
            $image_url         = $upload_path.$image_full_name;
            $success           = $images->move($upload_path,$image_full_name);
            $data['image']     = $image_url;
        }

       $query = DB::table('candidates')->where('id',$primary_id)->update($data) ;
       Session()->put('success', 'Thanks ! Candidate Information Update Successfully Complete.');
        return Redirect::to('editCandidatesInfo/'.$primary_id);
    }

    public function adminCandidateSearch()
    {
        $all_union = DB::table('union')->get() ;
        $all_institute = DB::table('institute')
                        ->join('union','institute.union_id','=','union.id')
                        ->select('institute.*','union.union_name')
                        ->get() ;

        return view('candidate.adminCandidateSearch')->with('all_union',$all_union)->with('all_institute',$all_institute) ;
    }

    #---------------- Admin Candidate Search Result View ---------------------#
    public function adminCadidateSearchResultView(Request $request)
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

                return view('candidate.adminCadidateSearchResultView')->with('result',$result)->with('settings',$settings)->with('union_id',$union_id)->with('ward_id',$ward_id)->with('institute_id',$institute_id)->with('address',$address)->with('name',$name) ;
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

                return view('candidate.adminCadidateSearchResultView')->with('result',$result)->with('settings',$settings)->with('union_id',$union_id)->with('ward_id',$ward_id)->with('institute_id',$institute_id)->with('address',$address)->with('name',$name) ;
            }else{
                echo "<h4>No Data Found</h4>";
                exit();
            }
        }
    }

    #=================== ORGANIZATION SECTION =====================#
    public function studentAddForm()
    {
        $result = DB::table('union')->where('status',1)->get() ;

        return view('candidate.studentAddForm')->with('result',$result) ;
    }

    #-------------------- Chandiate Search ---------------------#
    public function instituteSearchCandidates()
    {
        $all_union = DB::table('union')->where('status',1)->get() ;

        return view('candidate.instituteSearchCandidates')->with('all_union',$all_union) ;
    }

    #======================== Kazi Section ==========================#
    public function manageCandidatesByKazi()
    {   
        $admin_info = DB::table('admin')->where('id',$this->loged_id)->first() ;

        $result = DB::table('candidates')
                ->join('union','candidates.union_id','=','union.id')
                ->leftJoin('ward','candidates.ward_id','=','ward.id')
                ->leftJoin('institute','candidates.institute_id','=','institute.id')
                ->select('candidates.*','union.union_name','ward.ward_name','institute.institute_name')
                ->where('candidates.union_id',$admin_info->union_id)
                ->orderBy('candidates.id','desc')
                ->get() ;
        $settings = DB::table('age_setting')->where('id',1)->first() ;

        return view('candidate.manageCandidatesByKazi')->with('result',$result)->with('settings',$settings) ;
    }

    #----------------- Update Candidate Marriage Status -------------------------#
    public function updateCandidateStatusByKazi($id)
    {
        $value = DB::table('candidates')
                ->join('union','candidates.union_id','=','union.id')
                ->leftJoin('ward','candidates.ward_id','=','ward.id')
                ->leftJoin('institute','candidates.institute_id','=','institute.id')
                ->select('candidates.*','union.union_name','ward.ward_name','institute.institute_name') 
                ->where('candidates.id',$id)
                ->first() ;
        $settings = DB::table('age_setting')->where('id',1)->first() ;

        return view('candidate.updateCandidateStatusByKazi')->with('value',$value)->with('settings',$settings) ;
    }

    #---------------------------- Update Candidate Marriage Date Info ---------------------#
    public function updateCandidatesMarriageDateInfo(Request $request)
    {
        $this->validate($request,[
            'marriage_date' => 'required' ,
        ]);

        $marriage_date = date('Y-m-d',strtotime($request->marriage_date)) ;
        $primary_id    = trim($request->primary_id) ;

        if ($marriage_date > $this->rcdate) {
            Session()->put('failed', 'Sorry ! You Select Incorrect Date. Please Select Correct Date.');
            return Redirect::to('updateCandidateStatusByKazi/'.$primary_id);
        }

        $data = array() ;
        $data['updated_id']     = $this->loged_id ;
        $data['married_status'] = 1 ;
        $data['marriage_date']  = $marriage_date;
        $data['updated_at']     = $this->rcdate;

        DB::table('candidates')->where('id',$primary_id)->update($data) ;
        Session()->put('success', 'Thanks ! Marriage Date Update Successfully Completed.');
        return Redirect::to('updateCandidateStatusByKazi/'.$primary_id);
    }


    #======================== ADMIN CANDIDATE SECTION ============================#
    public function adminAddStudent()
    {
        $all_union      = DB::table('union')->where('status',1)->get() ;
        $all_institute  = DB::table('institute')->where('status',1)->get() ;

        return view('candidate.adminAddStudent')->with('all_union',$all_union)->with('all_institute',$all_institute) ;
    }

    #--------------------- Insert Student Info -------------------------#
    public function insertStudentInfoByAdmin(Request $request)
    {
        $this->validate($request,[
            'union_id'          => 'required',
            'name'              => 'required',
            'father_name'       => 'required',
            'mother_name'       => 'required',
            'gender'            => 'required',
            'contact_number'    => 'required|size:11',
            'address'           => 'required',
            'dob'               => 'required',
            'image'             => 'mimes:jpeg,jpg,png|max:500',
        ]);

        $union_id       = trim($request->union_id) ;
        $ward_id        = trim($request->ward_id) ;
        $institute_id   = trim($request->institute_id) ;
        $name           = trim($request->name) ;
        $father_name    = trim($request->father_name) ;
        $mother_name    = trim($request->mother_name) ;
        $gender         = trim($request->gender) ;
        $birth_reg_no   = trim($request->birth_reg_no) ;
        $contact_number = trim($request->contact_number) ;
        $address        = trim($request->address) ;
        $type_here      = trim($request->type_here) ;
        $dob_final      = date('Y-m-d',strtotime($request->dob));

        $images = $request->file('image') ;

        
        $search_array1  = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $replace_array1 = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $birth_reg     = str_replace($search_array1, $replace_array1, $birth_reg_no);
        
        $search_array2  = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $replace_array2 = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $mobile         = str_replace($search_array2, $replace_array2, $contact_number);

        $data = array() ;
        $data['added_id']       = $this->loged_id ;
        $data['union_id']       = $union_id ;
        $data['ward_id']        = $ward_id ;
        $data['institute_id']   =  $institute_id ;
        $data['name']           = $name ;
        $data['father_name']    = $father_name ;
        $data['mother_name']    = $mother_name ;
        $data['gender']         = $gender ;
        $data['contact_number'] = $mobile ;
        $data['address']        = $address ;
        $data['dob']            = $dob_final ;
        $data['birth_reg_no']   = $birth_reg ;
        $data['type']           = 1 ;
        $data['status']         = 1 ;
        $data['created_at']     = $this->rcdate;

        if ($images) {
            $image_name        = str_random(20);
            $ext               = strtolower($images->getClientOriginalExtension());
            $image_full_name   ='candidate-'.$image_name.'.'.$ext;
            $upload_path       = "images/";
            $image_url         = $upload_path.$image_full_name;
            $success           = $images->move($upload_path,$image_full_name);
            $data['image']     = $image_url;
        }

        $query = DB::table('candidates')->insert($data) ;

        if ($query) {
            Session()->put('success', 'Thanks ! Student Information Add Successfully Complete.');
            return Redirect::to('adminAddStudent');
            
        }else{
            Session()->put('failed', 'Sorry ! Somthing Went Wrong.');
            return Redirect::to('adminAddStudent');
       }
    }


    #------------------------ Admin Child Add Info ---------------------------#
    public function adminAddChild()
    {
        $all_union      = DB::table('union')->where('status',1)->get() ;

        return view('candidate.adminAddChild')->with('all_union',$all_union) ;
    }

    #------------------- Insert Child Info By Admin -----------------------#
    public function insertChildInfoByAdmin(Request $request)
    {
        $this->validate($request,[
            'union_id'          => 'required',
            'name'              => 'required',
            'father_name'       => 'required',
            'mother_name'       => 'required',
            'gender'            => 'required',
            'contact_number'    => 'required|size:11',
            'address'           => 'required',
            'dob'               => 'required',
            'image'             => 'mimes:jpeg,jpg,png|max:500',
        ]);

        $union_id       = trim($request->union_id) ;
        $ward_id        = trim($request->ward_id) ;
        $institute_id   = trim($request->institute_id) ;
        $name           = trim($request->name) ;
        $father_name    = trim($request->father_name) ;
        $mother_name    = trim($request->mother_name) ;
        $gender         = trim($request->gender) ;
        $birth_reg_no   = trim($request->birth_reg_no) ;
        $contact_number = trim($request->contact_number) ;
        $address        = trim($request->address) ;
        $type_here      = trim($request->type_here) ;
        $dob_final      = date('Y-m-d',strtotime($request->dob));

        $images = $request->file('image') ;

        $duplicate_check = DB::table('candidates')->where('ward_id',$ward_id)->where('name',$name)->where('father_name',$father_name)->count();

        if ($duplicate_check > 0) {
            Session()->put('failed', 'Sorry ! Child Information Already Exit.');
            return Redirect::to('adminAddChild');
        }
        
        $search_array2  = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $replace_array2 = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $mobile         = str_replace($search_array2, $replace_array2, $contact_number);

        $data = array() ;
        $data['added_id']       = $this->loged_id ;
        $data['union_id']       = $union_id ;
        $data['ward_id']        = $ward_id ;
        $data['name']           = $name ;
        $data['father_name']    = $father_name ;
        $data['mother_name']    = $mother_name ;
        $data['gender']         = $gender ;
        $data['contact_number'] = $mobile ;
        $data['address']        = $address ;
        $data['dob']            = $dob_final ;
        $data['type']           = 2 ;
        $data['status']         = 1 ;
        $data['berth_reg_complete']         = 1 ;
        $data['berth_reg_distribution']         = 1 ;
        $data['created_at']     = $this->rcdate;

        if ($images) {
            $image_name        = str_random(20);
            $ext               = strtolower($images->getClientOriginalExtension());
            $image_full_name   ='candidate-'.$image_name.'.'.$ext;
            $upload_path       = "images/";
            $image_url         = $upload_path.$image_full_name;
            $success           = $images->move($upload_path,$image_full_name);
            $data['image']     = $image_url;
        }

        $query = DB::table('candidates')->insert($data) ;

        if ($query) {
            Session()->put('success', 'Thanks ! Child Information Add Successfully Complete.');
            return Redirect::to('adminAddChild');
            
        }else{
            Session()->put('failed', 'Sorry ! Somthing Went Wrong.');
            return Redirect::to('adminAddChild');
       }
    }


    #======================== UDC SECTION ============================#
    public function searchCandidatesByUdc()
    {
        $admin_info = DB::table('admin')->where('id',$this->loged_id)->first() ;
        $union_id   = $admin_info->union_id ;

        $result = DB::table('candidates')
                ->join('union','candidates.union_id','=','union.id')
                ->leftJoin('ward','candidates.ward_id','=','ward.id')
                ->leftJoin('institute','candidates.institute_id','=','institute.id')
                ->select('candidates.*','union.union_name','ward.ward_name','institute.institute_name') 
                ->where('candidates.union_id',$union_id)
                ->get() ;
        $settings = DB::table('age_setting')->where('id',1)->first() ;

        return view('candidate.searchCandidatesByUdc')->with('result',$result)->with('settings',$settings) ;
    }

    #-----------------------------New Candidate List----------------------------#
    public function newCandidateListByUdc()
    {
        $admin_info = DB::table('admin')->where('id',$this->loged_id)->first() ;
        $union_id   = $admin_info->union_id ;

        $result = DB::table('candidates')
                ->join('union','candidates.union_id','=','union.id')
                ->leftJoin('ward','candidates.ward_id','=','ward.id')
                ->leftJoin('institute','candidates.institute_id','=','institute.id')
                ->select('candidates.*','union.union_name','ward.ward_name','institute.institute_name') 
                ->where('candidates.union_id',$union_id)
                ->where('candidates.berth_reg_complete',1)
                ->get() ;
        $settings = DB::table('age_setting')->where('id',1)->first() ;

        return view('candidate.newCandidateListByUdc')->with('result',$result)->with('settings',$settings)->with('union_id',$union_id);
    }

    #---------------------------View New Candidates by udc-----------------------#
    public function viewNewCandidatesByUdc($id)
    {
        $admin_info = DB::table('admin')->where('id',$this->loged_id)->first() ;
        $union_id   = $admin_info->union_id ;

        $value = DB::table('candidates')
                ->join('union','candidates.union_id','=','union.id')
                ->leftJoin('ward','candidates.ward_id','=','ward.id')
                ->leftJoin('institute','candidates.institute_id','=','institute.id')
                ->select('candidates.*','union.union_name','ward.ward_name','institute.institute_name') 
                ->where('candidates.union_id',$union_id)
                ->where('candidates.berth_reg_complete',1)
                ->where('candidates.id',$id)
                ->first() ;
        $settings = DB::table('age_setting')->where('id',1)->first() ;

        return view('candidate.viewNewCandidatesByUdc')->with('value',$value)->with('settings',$settings) ;
    }

    #-------------------------Edit Candidates by udc--------------------------#
    public function editCandidatesByUdc($id)
    {
        $admin_info = DB::table('admin')->where('id',$this->loged_id)->first() ;
        $union_id   = $admin_info->union_id ;

        $row = DB::table('candidates')
                ->join('union','candidates.union_id','=','union.id')
                ->leftJoin('ward','candidates.ward_id','=','ward.id')
                ->leftJoin('institute','candidates.institute_id','=','institute.id')
                ->select('candidates.*','union.union_name','ward.ward_name','institute.institute_name')
                ->where('candidates.union_id',$union_id)
                ->where('candidates.id',$id)
                ->first();
        $all_institute  = DB::table('institute')->where('status',1)->get();
        return view('candidate.editCandidatesByUdc')->with('row',$row)->with('all_institute',$all_institute);
    }
    #------------------------Update Candidates By Udc-------------------------#
    public function updateCandidatesByUdc(Request $request)
    {
        $this->validate($request,[
            'name'              => 'required',
            'father_name'       => 'required',
            'mother_name'       => 'required',
            'gender'            => 'required',
            'contact_number'    => 'required|size:11',
            'address'           => 'required',
            'image'             => 'mimes:jpeg,jpg,png|max:500',
        ]);

        $institute_id   = trim($request->institute_id) ;
        $name           = trim($request->name) ;
        $father_name    = trim($request->father_name) ;
        $mother_name    = trim($request->mother_name) ;
        $gender         = trim($request->gender) ;
        $contact_number = trim($request->contact_number) ;
        $address        = trim($request->address) ;
        $id             = trim($request->id) ;
        $current_image  = trim($request->current_image) ;
        $images         = $request->file('image') ;

        $duplicate_check = DB::table('candidates')->where('name',$name)->where('father_name',$father_name)->whereNotIn('id',[$id])->count();

        if($duplicate_check > 0){
            Session()->put('failed', 'Sorry ! Candidate Information Already Exists.');
            return Redirect::to('editCandidatesByUdc/'.$id);
        }

        $data = array() ;
        $data['added_id']       = $this->loged_id ;
        $data['name']           = $name ;
        $data['father_name']    = $father_name ;
        $data['mother_name']    = $mother_name ;
        $data['gender']         = $gender;
        $data['contact_number'] = $contact_number ;
        $data['address']        = $address;
        $data['updated_at']     = $this->rcdate;

        if ($images) {
            $image_name        = str_random(20);
            $ext               = strtolower($images->getClientOriginalExtension());
            $image_full_name   ='candidate-'.$image_name.'.'.$ext;
            $upload_path       = "images/";
            $image_url         = $upload_path.$image_full_name;
            $success           = $images->move($upload_path,$image_full_name);

            if ($current_image != "") {
                unlink($current_image);
            }
            $data['image']     = $image_url;
        }

        $query = DB::table('candidates')->where('id',$id)->update($data) ;
        Session()->put('success', 'Thanks ! Candidate Information Update Successfully Complete.');
        return Redirect::to('editCandidatesByUdc/'.$id);
    }

    #------------ Get Canidatei Info For Update Candidates Birth Reg ----------#
    public function updateCandiateBirthReg($id)
    {
        $value = DB::table('candidates')
                ->join('union','candidates.union_id','=','union.id')
                ->leftJoin('ward','candidates.ward_id','=','ward.id')
                ->leftJoin('institute','candidates.institute_id','=','institute.id')
                ->select('candidates.*','union.union_name','ward.ward_name','institute.institute_name') 
                ->where('candidates.id',$id)
                ->first() ;
        $settings = DB::table('age_setting')->where('id',1)->first() ;

        return view('candidate.updateCandiateBirthReg')->with('value',$value)->with('settings',$settings) ;
    }

    #------------- Update Candidate Birth Regisration number By UDC ---------------------#
    public function updateCandidateBirthRegNumber(Request $request)
    {
        $this->validate($request,[
            'birth_reg_no'  => 'required' ,
            'primary_id'    => 'required'
        ]);

        $primary_id     = trim($request->primary_id) ;
        $birth_reg_no   = trim($request->birth_reg_no) ;
        $finger_print   = trim($request->finger_print) ;

        #------------------- Check Duplicate Birth Reg Number -----------------#
        $check_count = DB::table('candidates')
                    ->where('birth_reg_no',$birth_reg_no)
                    ->count() ;
        if ($check_count > 0) {
            Session()->put('failed', 'Sorry ! Invalid Birth registration Number. Try Again ');
            return Redirect::to('updateCandiateBirthReg/'.$primary_id);
        }

        $data = array() ;
        $data['birth_reg_no']         = $birth_reg_no ;
        $data['finger_print']         = $finger_print ;
        $data['berth_reg_complete']   = 0 ;
        $data['updated_at']           = $this->rcdate ;

        DB::table('candidates')->where('id',$primary_id)->update($data) ;


        Session()->put('success', 'Thanks ! Birth registration Number Updated Successfully.');
        return Redirect::to('updateCandiateBirthReg/'.$primary_id);
    }

    #--------------------- Add Canidate By UDC -----------------------------#
    public function addCandidatesByUdc()
    {
        $all_institute  = DB::table('institute')->where('status',1)->get() ;
        return view('candidate.addCandidatesByUdc')->with('all_institute',$all_institute);
    }

    #------------------- Insert Candiate Info By UDC -----------------------#
    public function insertCandidateInfoByUDC(Request $request)
    {
        $this->validate($request,[
            'birth_reg_no'      => 'required',
            'name'              => 'required',
            'father_name'       => 'required',
            'mother_name'       => 'required',
            'gender'            => 'required',
            'contact_number'    => 'required|size:11',
            'address'           => 'required',
            'dob'               => 'required',
            'image'             => 'mimes:jpeg,jpg,png|max:500',
        ]);

        $ward_id        = trim($request->ward_id) ;
        $institute_id   = trim($request->institute_id) ;
        $name           = trim($request->name) ;
        $father_name    = trim($request->father_name) ;
        $mother_name    = trim($request->mother_name) ;
        $gender         = trim($request->gender) ;
        $birth_reg_no   = trim($request->birth_reg_no) ;
        $contact_number = trim($request->contact_number) ;
        $address        = trim($request->address) ;
        $type_here      = trim($request->type_here) ;
        $dob_final      = date('Y-m-d',strtotime($request->dob));
        $images = $request->file('image') ;

        $check_count = DB::table('candidates')
                    ->where('birth_reg_no',$birth_reg_no)
                    ->count() ;
        if ($check_count > 0) {
            Session()->put('failed', 'Sorry ! Invalid Birth registration Number. Try Again ');
            return Redirect::to('addCandidatesByUdc/');
        }

        
        $search_array1  = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $replace_array1 = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $birth_reg     = str_replace($search_array1, $replace_array1, $birth_reg_no);
        
        $search_array2  = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $replace_array2 = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $mobile         = str_replace($search_array2, $replace_array2, $contact_number);

        $admin_info = DB::table('admin')->where('id',$this->loged_id)->first() ;
        $union_id   = $admin_info->union_id ;

        $data = array() ;
        $data['added_id']       = $this->loged_id ;
        $data['union_id']       = $union_id ;
        $data['ward_id']        = $ward_id ;
        $data['institute_id']   = $institute_id ;
        $data['name']           = $name ;
        $data['father_name']    = $father_name ;
        $data['mother_name']    = $mother_name ;
        $data['gender']         = $gender ;
        $data['contact_number'] = $mobile ;
        $data['address']        = $address ;
        $data['dob']            = $dob_final ;
        $data['birth_reg_no']   = $birth_reg ;
        $data['type']           = 1 ;
        $data['status']         = 1 ;
        $data['created_at']     = $this->rcdate;

        if ($images) {
            $image_name        = str_random(20);
            $ext               = strtolower($images->getClientOriginalExtension());
            $image_full_name   ='candidate-'.$image_name.'.'.$ext;
            $upload_path       = "images/";
            $image_url         = $upload_path.$image_full_name;
            $success           = $images->move($upload_path,$image_full_name);
            $data['image']     = $image_url;
        }

        $query = DB::table('candidates')->insert($data) ;

        if ($query) {
            Session()->put('success', 'Thanks ! Candidate Information Add Successfully Complete.');
            return Redirect::to('addCandidatesByUdc');
            
        }else{
            Session()->put('failed', 'Sorry ! Somthing Went Wrong.');
            return Redirect::to('addCandidatesByUdc');
       }
    }



    #====================== ORGANIZAITON SECTION ======================#
    public function addOrgStudent()
    {
        $all_union      = DB::table('union')->where('status',1)->get() ;
        $all_institute  = DB::table('institute')->where('status',1)->get() ;

        return view('candidate.addOrgStudent')->with('all_union',$all_union)->with('all_institute',$all_institute) ;
    }


    #------------------------------ Insert Stuent Info  ----------------------#
    public function insertSutdentInfoByOrganization(Request $request)
    {
        $this->validate($request,[
            'union_id'          => 'required',
            'birth_reg_no'      => 'required',
            'name'              => 'required',
            'father_name'       => 'required',
            'mother_name'       => 'required',
            'gender'            => 'required',
            'contact_number'    => 'required|size:11',
            'address'           => 'required',
            'dob'               => 'required',
            'image'             => 'mimes:jpeg,jpg,png|max:500',
        ]);

        $union_id       = trim($request->union_id) ;
        $ward_id        = trim($request->ward_id) ;
        $institute_id   = trim($request->institute_id) ;
        $name           = trim($request->name) ;
        $father_name    = trim($request->father_name) ;
        $mother_name    = trim($request->mother_name) ;
        $gender         = trim($request->gender) ;
        $birth_reg_no   = trim($request->birth_reg_no) ;
        $contact_number = trim($request->contact_number) ;
        $address        = trim($request->address) ;
        $type_here      = trim($request->type_here) ;
        $dob_final      = date('Y-m-d',strtotime($request->dob));
        $images = $request->file('image') ;

        $check_count = DB::table('candidates')
                    ->where('birth_reg_no',$birth_reg_no)
                    ->count() ;
        if ($check_count > 0) {
            Session()->put('failed', 'Sorry ! Invalid Birth registration Number. Try Again ');
            return Redirect::to('addOrgStudent/');
        }

        
        $search_array1  = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $replace_array1 = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $birth_reg     = str_replace($search_array1, $replace_array1, $birth_reg_no);
        
        $search_array2  = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $replace_array2 = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $mobile         = str_replace($search_array2, $replace_array2, $contact_number);


        $data = array() ;
        $data['added_id']       = $this->loged_id ;
        $data['union_id']       = $union_id ;
        $data['ward_id']        = $ward_id ;
        $data['institute_id']   = $institute_id ;
        $data['name']           = $name ;
        $data['father_name']    = $father_name ;
        $data['mother_name']    = $mother_name ;
        $data['gender']         = $gender ;
        $data['contact_number'] = $mobile ;
        $data['address']        = $address ;
        $data['dob']            = $dob_final ;
        $data['birth_reg_no']   = $birth_reg ;
        $data['type']           = 1 ;
        $data['status']         = 1 ;
        $data['created_at']     = $this->rcdate;

        if ($images) {
            $image_name        = str_random(20);
            $ext               = strtolower($images->getClientOriginalExtension());
            $image_full_name   ='candidate-'.$image_name.'.'.$ext;
            $upload_path       = "images/";
            $image_url         = $upload_path.$image_full_name;
            $success           = $images->move($upload_path,$image_full_name);
            $data['image']     = $image_url;
        }

        $query = DB::table('candidates')->insert($data) ;

        if ($query) {
            Session()->put('success', 'Thanks ! Candidate Information Add Successfully Complete.');
            return Redirect::to('addOrgStudent');
            
        }else{
            Session()->put('failed', 'Sorry ! Somthing Went Wrong.');
            return Redirect::to('addOrgStudent');
       }
    }

    #------------------ Manage Candidate Info -----------------------#
    public function manageCandiatesByOrganization()
    {

        $result = DB::table('candidates')
                ->join('union','candidates.union_id','=','union.id')
                ->leftJoin('ward','candidates.ward_id','=','ward.id')
                ->leftJoin('institute','candidates.institute_id','=','institute.id')
                ->select('candidates.*','union.union_name','ward.ward_name','institute.institute_name') 
                ->where('candidates.added_id',$this->loged_id)
                ->get() ;
        $settings = DB::table('age_setting')->where('id',1)->first() ;

        return view('candidate.manageCandiatesByOrganization')->with('result',$result)->with('settings',$settings) ;
    }

    #------------------ Edit Candidate Info -----------------------#
    public function editCandidatesByOrganization($id)
    {
        $all_union      = DB::table('union')->where('status',1)->get() ;
        $all_institute  = DB::table('institute')->where('status',1)->get() ;
        $row = DB::table('candidates')
                ->join('union','candidates.union_id','=','union.id')
                ->leftJoin('ward','candidates.ward_id','=','ward.id')
                ->leftJoin('institute','candidates.institute_id','=','institute.id')
                ->select('candidates.*','union.union_name','ward.ward_name','institute.institute_name')
                ->where('candidates.added_id',$this->loged_id)
                ->where('candidates.id',$id)
                ->first();

        return view('candidate.editCandidatesByOrganization')->with('row',$row)->with('all_union',$all_union)->with('all_institute',$all_institute);
    }
    #---------------------Update Candidates by Organization---------------------#
    public function updateCandidatesByOrganization(Request $request)
    {
        $this->validate($request,[
            'union_id'          => 'required',
            'name'              => 'required',
            'father_name'       => 'required',
            'mother_name'       => 'required',
            'gender'            => 'required',
            'contact_number'    => 'required|size:11',
            'address'           => 'required',
            'image'             => 'mimes:jpeg,jpg,png|max:500',
        ]);

        $union_id       = trim($request->union_id) ;
        $ward_id        = trim($request->ward_id) ;
        $institute_id   = trim($request->institute_id) ;
        $name           = trim($request->name) ;
        $father_name    = trim($request->father_name) ;
        $mother_name    = trim($request->mother_name) ;
        $gender         = trim($request->gender) ;
        $contact_number = trim($request->contact_number) ;
        $address        = trim($request->address) ;
        $id             = trim($request->id) ;
        $current_image  = trim($request->current_image) ;
        $images         = $request->file('image') ;

        $duplicate_check = DB::table('candidates')->where('union_id',$union_id)->where('ward_id',$ward_id)->where('name',$name)->where('father_name',$father_name)->whereNotIn('id',[$id])->count();

        if($duplicate_check > 0){
            Session()->put('failed', 'Sorry ! Candidate Information Already Exists.');
            return Redirect::to('editCandidatesByOrganization/'.$id);
        }

        $data = array() ;
        $data['added_id']       = $this->loged_id ;
        $data['union_id']       = $union_id ;
        $data['ward_id']        = $ward_id ;
        $data['name']           = $name ;
        $data['father_name']    = $father_name ;
        $data['mother_name']    = $mother_name ;
        $data['gender']         = $gender;
        $data['contact_number'] = $contact_number ;
        $data['address']        = $address;
        $data['updated_at']     = $this->rcdate;

        if ($images) {
            $image_name        = str_random(20);
            $ext               = strtolower($images->getClientOriginalExtension());
            $image_full_name   ='candidate-'.$image_name.'.'.$ext;
            $upload_path       = "images/";
            $image_url         = $upload_path.$image_full_name;
            $success           = $images->move($upload_path,$image_full_name);

            if ($current_image != "") {
                unlink($current_image);
            }
            $data['image']     = $image_url;
        }

        $query = DB::table('candidates')->where('id',$id)->update($data) ;
        Session()->put('success', 'Thanks ! Candidate Information Update Successfully Complete.');
        return Redirect::to('editCandidatesByOrganization/'.$id);
    }

    #----------------- View Ogr Stuent Info -------------------------#
    public function viewOrgStudentInfo($id)
    {
        $value = DB::table('candidates')
                ->join('union','candidates.union_id','=','union.id')
                ->leftJoin('ward','candidates.ward_id','=','ward.id')
                ->leftJoin('institute','candidates.institute_id','=','institute.id')
                ->select('candidates.*','union.union_name','ward.ward_name','institute.institute_name') 
                ->where('candidates.id',$id)
                ->first() ;
        $settings = DB::table('age_setting')->where('id',1)->first() ;

        return view('candidate.viewOrgStudentInfo')->with('value',$value)->with('settings',$settings) ;
    }


    #---------------------- Child Add Form ------------------------#
    public function addOrgChild()
    {
        $all_union      = DB::table('union')->where('status',1)->get() ;

        return view('candidate.addOrgChild')->with('all_union',$all_union) ;
    }

    #----------------- Insert Chlid Info By Health Worker ------#
    public function insertChildInfoByOrganization(Request $request)
    {
        $this->validate($request,[
            'union_id'          => 'required',
            'name'              => 'required',
            'father_name'       => 'required',
            'mother_name'       => 'required',
            'gender'            => 'required',
            'contact_number'    => 'required|size:11',
            'address'           => 'required',
            'dob'               => 'required',
            'image'             => 'mimes:jpeg,jpg,png|max:500',
        ]);

        $union_id        = trim($request->union_id) ;
        $ward_id         = trim($request->ward_id) ;
        $name            = trim($request->name) ;
        $father_name     = trim($request->father_name) ;
        $mother_name     = trim($request->mother_name) ;
        $gender          = trim($request->gender) ;
        $contact_number  = trim($request->contact_number) ;
        $father_nid_no   = trim($request->father_nid_no) ;
        $mother_nid_no   = trim($request->mother_nid_no) ;
        $guardian_nid_no = trim($request->guardian_nid_no) ;
        $address         = trim($request->address) ;
        $type_here       = trim($request->type_here) ;
        $dob_final       = date('Y-m-d',strtotime($request->dob));
        $images = $request->file('image') ;

        if($father_nid_no == '' AND $guardian_nid_no == ''){
            Session()->put('failed', 'Sorry ! Father Or Guardian Nid Must Be Required.');
            return Redirect::to('addOrgChild');
            exit();
        }

        $duplicate_check = DB::table('candidates')->where('dob',$dob_final)->where('name',$name)->where('father_name',$father_name)->count();

        if ($duplicate_check > 0) {
            Session()->put('failed', 'Sorry ! Child Information Already Exit.');
            return Redirect::to('addOrgChild');
        }
    
        
        $search_array2  = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $replace_array2 = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $mobile         = str_replace($search_array2, $replace_array2, $contact_number);


        $data = array() ;
        $data['added_id']        = $this->loged_id ;
        $data['union_id']        = $union_id ;
        $data['ward_id']         = $ward_id ;
        $data['name']            = $name ;
        $data['father_name']     = $father_name ;
        $data['mother_name']     = $mother_name ;
        $data['gender']          = $gender ;
        $data['contact_number']  = $mobile ;
        $data['father_nid_no']   = $father_nid_no ;
        $data['mother_nid_no']   = $mother_nid_no ;
        $data['guardian_nid_no'] = $guardian_nid_no ;
        $data['address']         = $address ;
        $data['dob']             = $dob_final ;
        $data['type']            = 2 ;
        $data['status']                 = 1 ;
        $data['berth_reg_complete']     = 1 ;
        $data['berth_reg_distribution'] = 1 ;
        $data['created_at']             = $this->rcdate;

        if ($images) {
            $image_name        = str_random(20);
            $ext               = strtolower($images->getClientOriginalExtension());
            $image_full_name   ='candidate-'.$image_name.'.'.$ext;
            $upload_path       = "images/";
            $image_url         = $upload_path.$image_full_name;
            $success           = $images->move($upload_path,$image_full_name);
            $data['image']     = $image_url;
        }

        $query = DB::table('candidates')->insert($data) ;

        if ($query) {
            Session()->put('success', 'Thanks ! Candidate Information Add Successfully Complete.');
            return Redirect::to('addOrgStudent');
            
        }else{
            Session()->put('failed', 'Sorry ! Somthing Went Wrong.');
            return Redirect::to('addOrgStudent');
       }
    }


    #----------------------- Manage Institute Candidate Info  -------------------#
    public function manageInstituteCandidates()
    {
        $inst_info = DB::table('admin')->where('id',$this->loged_id)->first() ;

        $result = DB::table('candidates')
                ->join('union','candidates.union_id','=','union.id')
                ->leftJoin('ward','candidates.ward_id','=','ward.id')
                ->leftJoin('institute','candidates.institute_id','=','institute.id')
                ->select('candidates.*','union.union_name','ward.ward_name','institute.institute_name') 
                ->where('candidates.institute_id',$inst_info->institute_id)
                ->get() ;
        $settings = DB::table('age_setting')->where('id',1)->first() ;

        return view('candidate.manageInstituteCandidates')->with('result',$result)->with('settings',$settings) ;
    }

    #------------------------Edit Institute Candidates info ----------------------#
    public function editInstituteCandidates($id)
    {
        $inst_info = DB::table('admin')->where('id',$this->loged_id)->first() ;

        $row = DB::table('candidates')
                ->join('union','candidates.union_id','=','union.id')
                ->leftJoin('ward','candidates.ward_id','=','ward.id')
                ->leftJoin('institute','candidates.institute_id','=','institute.id')
                ->select('candidates.*','union.union_name','ward.ward_name','institute.institute_name') 
                ->where('candidates.institute_id',$inst_info->institute_id)
                ->where('candidates.id',$id)
                ->first();
        $result = DB::table('union')->where('status',1)->get() ;
        return view('candidate.editInstituteCandidates')->with('result',$result)->with('row',$row);
    }

    #--------------------------Update Institute Candidates info --------------------#
    public function updateInstituteCandidates(Request $request)
    {
        $this->validate($request,[
            'union_id'          => 'required',
            'name'              => 'required',
            'father_name'       => 'required',
            'mother_name'       => 'required',
            'gender'            => 'required',
            'contact_number'    => 'required|size:11',
            'address'           => 'required',
            'image'             => 'mimes:jpeg,jpg,png|max:500',
        ]);

        $union_id       = trim($request->union_id) ;
        $ward_id        = trim($request->ward_id) ;
        $name           = trim($request->name) ;
        $father_name    = trim($request->father_name) ;
        $mother_name    = trim($request->mother_name) ;
        $gender         = trim($request->gender) ;
        $contact_number = trim($request->contact_number) ;
        $address        = trim($request->address) ;
        $id             = trim($request->id) ;
        $current_image  = trim($request->current_image) ;
        $images         = $request->file('image') ;

        $duplicate_check = DB::table('candidates')->where('union_id',$union_id)->where('ward_id',$ward_id)->where('name',$name)->where('father_name',$father_name)->whereNotIn('id',[$id])->count();

        if($duplicate_check > 0){
            Session()->put('failed', 'Sorry ! Candidate Information Already Exists.');
            return Redirect::to('editInstituteCandidates/'.$id);
        }

        $data = array() ;
        $data['added_id']       = $this->loged_id ;
        $data['union_id']       = $union_id ;
        $data['ward_id']        = $ward_id ;
        $data['name']           = $name ;
        $data['father_name']    = $father_name ;
        $data['mother_name']    = $mother_name ;
        $data['gender']         = $gender;
        $data['contact_number'] = $contact_number ;
        $data['address']        = $address;
        $data['updated_at']     = $this->rcdate;

        if ($images) {
            $image_name        = str_random(20);
            $ext               = strtolower($images->getClientOriginalExtension());
            $image_full_name   ='candidate-'.$image_name.'.'.$ext;
            $upload_path       = "images/";
            $image_url         = $upload_path.$image_full_name;
            $success           = $images->move($upload_path,$image_full_name);

            if ($current_image != "") {
                unlink($current_image);
            }
            $data['image']     = $image_url;
        }

        $query = DB::table('candidates')->where('id',$id)->update($data) ;
        Session()->put('success', 'Thanks ! Candidate Information Update Successfully Complete.');
        return Redirect::to('editInstituteCandidates/'.$id);
    }

    #--------------------- Birth Registraiton Dutribution Complete ---------------#
    public function candidateBirthRegDustributionComplete($id)
    {
        $canidate_info = DB::table('candidates')
                        ->where('id',$id)
                        ->first() ;
        $data = array() ;
        $data['berth_reg_distribution'] = 0 ;
        $data['birth_re_dis_date']      = $this->rcdate ;
        DB::table('candidates')->where('id',$id)->update($data) ;

        Session()->put('success', 'Thanks ! Candidate Birth Registration Certificate Distribution Successfully Complete. Reg number '.$canidate_info->birth_reg_no);
        return Redirect::to('searchCandidatesByUdc');
    }

    #--------------------Get Founder Info------------------------#
    public function founderInfo()
    {
        $row = DB::table('founder')->first();
        return view('founder.updateFounder')->with('row',$row);
    }

    #------------------------- Update Founder Info -------------------------#
    public function updateFounderInfo(Request $request)
    {
        $this->validate($request,[
            'designation'  => 'required',
            'name'         => 'required',
            'image'        => 'mimes:jpeg,jpg,png|max:500'
        ]);

        $name          = trim($request->name);
        $designation   = trim($request->designation);
        $message       = trim($request->message);
        $image         = $request->file('image');
        $current_image = $request->current_image;

        $count = DB::table('founder')->count();

        $data = array();
        $data['name']        = $name;
        $data['designation'] = $designation;
        $data['message']     = $message;
        if ($image){
            $image_name        = str_random(20);
            $ext               = strtolower($image->getClientOriginalExtension());
            $image_full_name   ='founder-'.$image_name.'.'.$ext;
            $upload_path       = "images/";
            $image_url         = $upload_path.$image_full_name;
            $success           = $image->move($upload_path,$image_full_name);

            if ($current_image != "") {
                unlink($current_image);
            }
            $data['image'] = $image_url;
        }

        if($count == '0'){
            $query = DB::table('founder')->insert($data);
            Session()->put('success', 'Thanks ! Founder Information Added Successfully.');
        }else{
            $query = DB::table('founder')->update($data);
            Session()->put('success', 'Thanks ! Founder Information Added Successfully.');
            return Redirect::to('founderInfo');
        }
    }
    #-----------------------Admin New Candidate list------------------------------#
    public function adminNewCandidates()
    {
        $result = DB::table('candidates')
                ->join('union','candidates.union_id','=','union.id')
                ->leftJoin('ward','candidates.ward_id','=','ward.id')
                ->leftJoin('institute','candidates.institute_id','=','institute.id')
                ->select('candidates.*','union.union_name','ward.ward_name','institute.institute_name')
                ->where('candidates.berth_reg_complete',1)
                ->get();
        $settings = DB::table('age_setting')->where('id',1)->first() ;

        return view('candidate.adminNewCandidates')->with('result',$result)->with('settings',$settings);
    }


}
