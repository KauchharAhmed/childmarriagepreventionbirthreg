<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use Session;

class SmsController extends Controller
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

    #---------------------- Send Sms Form ------------------------#
    public function sendSms()
    {
    	$all_union = DB::table('union')->where('status',1)->get();

    	return view('sms.sendSms')->with('all_union',$all_union);
    }

    #------------------- Sms Sending History ----------------------#
    public function smsSendingInfo(Request $request)
    {
    	$this->validate($request,[
    		'union_id'	=> 'required',
    		'message'	=> 'required'
    	]);

    	$union_id 	= trim($request->union_id);
    	$message 	= trim($request->message);

    	$check_count = DB::table('committee_member')
			    	->where('union_id',$union_id)
			    	->where('status',1)
			    	->count();

        $total_upazila_committee_member = DB::table('upazila_committee')->where('status',1)->count() ;

    	if ($check_count == 0) {
    		echo "3";
            exit() ;
    	}

    	$get_committee_members = DB::table('committee_member')
			    	->where('union_id',$union_id)
			    	->where('status',1)
			    	->get();
		foreach ($get_committee_members as $value) {
			$committee_member_id[] 		= $value->id;
			$committee_member_mobile[] 	= $value->mobile;
		}

		$member_id 		        = implode(',', $committee_member_id) ;
		$member_mobile 	        = implode(',', $committee_member_mobile) ;


        $count_msg      = strlen($message) ;
        $now_msg        = $count_msg / 159 ;
        $explode        = explode('.',$now_msg) ;
        $int_number     = $explode[0];
        $after_float    = $explode[1];
        if($after_float > 0){
            $cal_msg = $int_number + 1 ;
        }else{
            $cal_msg = $int_number ;
        }

        $total_committee_send = $total_upazila_committee_member * $cal_msg ;

        $message_body   = urlencode($message);
        $total_message    = $cal_msg * $check_count ;

        $sms_value      = DB::table('sms')->where('id',1)->first();

        $total_send = $total_committee_send + $total_message ; 

        if ($total_send > $sms_value->current_sms) {
            echo "2";
            exit() ;
        }

        $get_upazila_committee = DB::table('upazila_committee')->where('status',1)->get() ;

        foreach ($get_upazila_committee as $value) {
            $c_mobile_number = $value->mobile ;
            echo $url = file_get_contents("http://touchsitbd.com/systemsms/api.php?username=asianitinc@gmail.com&password=121lsr21LaraSoft&recipient=$c_mobile_number&message=$message_body");
        }

        foreach ($get_committee_members as $value2) {
            $memebr_mobile_number = $value2->mobile ;
            $url = file_get_contents("http://touchsitbd.com/systemsms/api.php?username=asianitinc@gmail.com&password=121lsr21LaraSoft&recipient=$memebr_mobile_number&message=$message_body");
        }


        $data = array() ;
        $data['added_id']           = $this->loged_id;
        $data['union_id']           = $union_id;
        $data['message']            = $message;
        $data['member_id']          = $member_id;
        $data['member_mobile']      = $member_mobile;
        $data['sms_number']         = $cal_msg;
        $data['total_sms_number']   = $total_send;
        $data['created_at']         = $this->rcdate;
        $data['created_time']       = $this->current_time;

        $data2 = array() ;
        $data2['total_send']    = $sms_value->total_send + $total_send ;
        $data2['current_sms']   = $sms_value->current_sms - $total_send ;

        DB::table('sms_send_history')->insert($data);
        DB::table('sms')->where('id',1)->update($data2);
    }

    #------------------------- Message Sending History ------------------------#
    public function manageSendSmsHistory()
    {
        $result = DB::table('sms_send_history')
                ->join('union','sms_send_history.union_id','=','union.id')
                ->select('sms_send_history.*','union.union_name')
                ->orderBy('sms_send_history.id','desc')
                ->get();

        return view('sms.manageSendSmsHistory')->with('result',$result);
    }

    #------------------------ Canidate SMS Send -----------------------#
    public function candidatesSmsSend()
    {
        $all_union = DB::table('union')->get() ;
        $all_institute = DB::table('institute')
                        ->join('union','institute.union_id','=','union.id')
                        ->select('institute.*','union.union_name')
                        ->get() ;

        return view('sms.candidatesSmsSend')->with('all_union',$all_union)->with('all_institute',$all_institute) ;

    }


    #----------------- Get Search Result ------------------------#
    public function getCanidateBySearchValue(Request $request)
    {
        $union_id           = trim($request->union_id) ;
        $institute_id       = trim($request->institute_id) ;
        $name               = trim($request->name) ;

        if($union_id == ""){
            $all_union = DB::table('union')->where('status',1)->get() ;
            foreach ($all_union as $union_value) {
                $all_union_id[] = $union_value->id ;
            }
        }else{
            $all_union_id[] = $union_id ;
        }

        if ($institute_id == "") {
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

                return view('sms.getCanidateBySearchValue')->with('result',$result)->with('settings',$settings)->with('union_id',$union_id)->with('institute_id',$institute_id)->with('name',$name) ;
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
                        ->get() ;
                $settings = DB::table('age_setting')->where('id',1)->first() ;

                return view('sms.getCanidateBySearchValue')->with('result',$result)->with('settings',$settings)->with('union_id',$union_id)->with('institute_id',$institute_id)->with('name',$name) ;
            }else{
                echo "<h4>No Data Found</h4>";
                exit();
            }
        }

    }

    #---------------------- Send SMS By Admin For Candidates ------------------------#
    public function sendSMSbyAdminSearch(Request $request)
    {
        $selected       = $request->selected ;
        $message        = $request->message ;
        $institute_id   = $request->institute_id ;
        $union_id       = $request->union_id ;

        foreach ($selected as $value) {
            $valueExplode = explode('.', $value) ;
            $candiate_id[]       = $valueExplode[0];
            $candidate_mobile[]  = $valueExplode[1];
        }

        $total_candidate = count($selected) ;

        $all_canidate_id     = implode(',', $candiate_id) ;
        $all_mobile          = implode(',', $candidate_mobile) ;

        $count_msg      = strlen($message) ;
        $now_msg        = ceil($count_msg / 159) ;
        if($now_msg == 0){
            $cal_msg = 1 ;
        }else{
            $cal_msg = $now_msg ;
        }


        $message_body   = urlencode($message);
        $total_message  = $cal_msg * $total_candidate ;

        $sms_value      = DB::table('sms')->where('id',1)->first();

        $total_sends = $total_message ; 


        if ($total_sends > $sms_value->current_sms) {
            echo "not_av_msg";
            exit() ;
        }

        foreach ($selected as $value3) {
            $valueExplode2          = explode('.', $value3) ;
            $memebr_mobile_number   = $valueExplode2[1];
            $url = file_get_contents("http://touchsitbd.com/systemsms/api.php?username=asianitinc@gmail.com&password=121lsr21LaraSoft&recipient=$memebr_mobile_number&message=$message_body");
        }

        $data = array() ;
        $data['added_id']           = $this->loged_id;
        $data['union_id']           = $union_id;
        $data['institute_id']       = $institute_id;
        $data['message']            = $message;
        $data['candidate_id']       = $all_canidate_id;
        $data['member_mobile']      = $all_mobile;
        $data['sms_number']         = $cal_msg;
        $data['total_sms_number']   = $total_sends;
        $data['type']               = 2;
        $data['created_at']         = $this->rcdate;
        $data['created_time']       = $this->current_time;

        $query1 = DB::table('sms_send_history')->insert($data);

        $data2 = array() ;
        $data2['total_send']    = $sms_value->total_send + $total_sends ;
        $data2['current_sms']   = $sms_value->current_sms - $total_sends ;
        $query = DB::table('sms')->where('id',1)->update($data2);

        if ($query) {
            echo "success";
            exit() ;
        }
    }

    #========================== USER SEND SMS =========================#
    public function userSmsSend()
    {
        $result = DB::table('admin')
                ->leftJoin('institute','admin.institute_id','=','institute.id')
                ->leftJoin('health_organization','admin.organization_id','=','health_organization.id')
                ->leftJoin('union','admin.union_id','=','union.id')
                ->select('admin.*','institute.institute_name','health_organization.organization_name','union.union_name')
                ->whereNotIn('admin.type',[1,2])
                ->where('admin.status',1)
                ->get() ;
        return view('sms.userSmsSend')->with('result',$result) ;
    }

    #-------------------- Sending SMS By User ---------------------#
    public function sendSMSbyAdminAppUser(Request $request)
    {
        $selected       = $request->selected ;
        $message        = $request->message ;

        foreach ($selected as $value) {
            $valueExplode = explode('.', $value) ;
            $candiate_id[]       = $valueExplode[0];
            $candidate_mobile[]  = $valueExplode[1];
        }

        $total_candidate = count($selected) ;

        $all_canidate_id     = implode(',', $candiate_id) ;
        $all_mobile          = implode(',', $candidate_mobile) ;

        $count_msg      = strlen($message) ;
        $now_msg        = ceil($count_msg / 159) ;
        if($now_msg == 0){
            $cal_msg = 1 ;
        }else{
            $cal_msg = $now_msg ;
        }


        $message_body   = urlencode($message);
        $total_message  = $cal_msg * $total_candidate ;

        $sms_value      = DB::table('sms')->where('id',1)->first();

        $total_sends = $total_message ; 

        if ($total_sends > $sms_value->current_sms) {
            echo "not_av_msg";
            exit() ;
        }

        foreach ($selected as $value3) {
            $valueExplode2          = explode('.', $value3) ;
            $memebr_mobile_number   = $valueExplode2[1];
            $url = file_get_contents("http://touchsitbd.com/systemsms/api.php?username=asianitinc@gmail.com&password=121lsr21LaraSoft&recipient=$memebr_mobile_number&message=$message_body");
        }

        $data = array() ;
        $data['added_id']           = $this->loged_id;
        $data['message']            = $message;
        $data['member_mobile']      = $all_mobile;
        $data['sms_number']         = $cal_msg;
        $data['total_sms_number']   = $total_sends;
        $data['type']               = 3;
        $data['created_at']         = $this->rcdate;
        $data['created_time']       = $this->current_time;

        $query1 = DB::table('sms_send_history')->insert($data);

        $data2 = array() ;
        $data2['total_send']    = $sms_value->total_send + $total_sends ;
        $data2['current_sms']   = $sms_value->current_sms - $total_sends ;
        $query = DB::table('sms')->where('id',1)->update($data2);

        if ($query) {
            echo "success";
            exit() ;
        }
    }

    #==================== Child Sms Send =====================#
    public function childSmsSend()
    {
        return view('sms.childSmsSend') ;
    }

    public function sendSmsByAdminForChild(Request $request)
    {
        $age       = $request->age ;
        $message   = $request->message ;

        $date = date('Y-m-d') ;
        $back_date = date("Y-m-d", strtotime($date ." -$age day") );

        $count_msg      = strlen($message) ;
        $now_msg        = ceil($count_msg / 159) ;
        if($now_msg == 0){
            $cal_msg = 1 ;
        }else{
            $cal_msg = $now_msg ;
        }

        $total_child = DB::table('candidates')
                    ->whereNotIn('contact_number',[00000000000])
                    ->whereBetween('dob',[$back_date,$date])
                    ->count() ;

        $message_body   = urlencode($message);
        $total_message  = $cal_msg * $total_child ;

        $sms_value      = DB::table('sms')->where('id',1)->first();

        $total_sends = $total_message ; 

        if ($total_sends > $sms_value->current_sms) {
            echo "not_av_msg";
            exit() ;
        }

        if ($total_child > 0) {
            $result = DB::table('candidates')
                    ->whereNotIn('contact_number',[00000000000])
                    ->whereBetween('dob',[$back_date,$date])
                    ->get() ;

            foreach ($result as $value3) {
                $candidate_mobile[]     = $value3->contact_number ;
                $memebr_mobile_number   = $value3->contact_number;
                $url = file_get_contents("http://touchsitbd.com/systemsms/api.php?username=asianitinc@gmail.com&password=121lsr21LaraSoft&recipient=$memebr_mobile_number&message=$message_body");
            }

            $all_mobile          = implode(',', $candidate_mobile) ;
            $data = array() ;
            $data['added_id']           = $this->loged_id;
            $data['message']            = $message;
            $data['member_mobile']      = $all_mobile;
            $data['sms_number']         = $cal_msg;
            $data['total_sms_number']   = $total_sends;
            $data['type']               = 4;
            $data['created_at']         = $this->rcdate;
            $data['created_time']       = $this->current_time;

            $query1 = DB::table('sms_send_history')->insert($data);

            $data2 = array() ;
            $data2['total_send']    = $sms_value->total_send + $total_sends ;
            $data2['current_sms']   = $sms_value->current_sms - $total_sends ;
            $query = DB::table('sms')->where('id',1)->update($data2);

            if ($query) {
                echo "success";
                exit() ;
            }
        }else{
            echo "no_child_found" ;
            exit() ;
        }
    }

    #===================== All Institute Info ======================#
    public function instituteSmsSend()
    {
        $result = DB::table('institute')
                ->leftJoin('union','institute.union_id','=','union.id')
                ->select('institute.*','union.union_name')
                ->where('institute.status',1)->get() ;

        return view('sms.instituteSmsSend')->with('result',$result) ;
    }

    #-------------------- Sending SMS By Institute ---------------------#
    public function sendSMSbyAdminInstitute(Request $request)
    {
        $selected       = $request->selected ;
        $message        = $request->message ;

        foreach ($selected as $value) {
            $valueExplode = explode('.', $value) ;
            $candidate_mobile[]  = $valueExplode[1];
        }

        $total_candidate = count($selected) ;

        $all_mobile          = implode(',', $candidate_mobile) ;

        $count_msg      = strlen($message) ;
        $now_msg        = ceil($count_msg / 159) ;
        if($now_msg == 0){
            $cal_msg = 1 ;
        }else{
            $cal_msg = $now_msg ;
        }


        $message_body   = urlencode($message);
        $total_message  = $cal_msg * $total_candidate ;

        $sms_value      = DB::table('sms')->where('id',1)->first();

        $total_sends = $total_message ; 

        if ($total_sends > $sms_value->current_sms) {
            echo "not_av_msg";
            exit() ;
        }

        foreach ($selected as $value3) {
            $valueExplode2          = explode('.', $value3) ;
            $memebr_mobile_number   = $valueExplode2[1];
            $url = file_get_contents("http://touchsitbd.com/systemsms/api.php?username=asianitinc@gmail.com&password=121lsr21LaraSoft&recipient=$memebr_mobile_number&message=$message_body");
        }

        $data = array() ;
        $data['added_id']           = $this->loged_id;
        $data['message']            = $message;
        $data['member_mobile']      = $all_mobile;
        $data['sms_number']         = $cal_msg;
        $data['total_sms_number']   = $total_sends;
        $data['type']               = 5;
        $data['created_at']         = $this->rcdate;
        $data['created_time']       = $this->current_time;

        $query1 = DB::table('sms_send_history')->insert($data);

        $data2 = array() ;
        $data2['total_send']    = $sms_value->total_send + $total_sends ;
        $data2['current_sms']   = $sms_value->current_sms - $total_sends ;
        $query = DB::table('sms')->where('id',1)->update($data2);

        if ($query) {
            echo "success";
            exit() ;
        }
    }

    #=================== Organization SMS Sending ====================#
    public function organizationSmsSend(Request $request)
    {
        $result = DB::table('health_organization')
                ->leftJoin('union','health_organization.union_id','=','union.id')
                ->select('health_organization.*','union.union_name')
                ->where('health_organization.status',1)->get() ;

        return view('sms.organizationSmsSend')->with('result',$result) ;
    }

    public function sendSMSbyAdminOrganization(Request $request)
    {
        $selected       = $request->selected ;
        $message        = $request->message ;

        foreach ($selected as $value) {
            $valueExplode = explode('.', $value) ;
            $candidate_mobile[]  = $valueExplode[1];
        }

        $total_candidate = count($selected) ;

        $all_mobile          = implode(',', $candidate_mobile) ;

        $count_msg      = strlen($message) ;
        $now_msg        = ceil($count_msg / 159) ;
        if($now_msg == 0){
            $cal_msg = 1 ;
        }else{
            $cal_msg = $now_msg ;
        }


        $message_body   = urlencode($message);
        $total_message  = $cal_msg * $total_candidate ;

        $sms_value      = DB::table('sms')->where('id',1)->first();

        $total_sends = $total_message ; 

        if ($total_sends > $sms_value->current_sms) {
            echo "not_av_msg";
            exit() ;
        }

        foreach ($selected as $value3) {
            $valueExplode2          = explode('.', $value3) ;
            $memebr_mobile_number   = $valueExplode2[1];
            $url = file_get_contents("http://touchsitbd.com/systemsms/api.php?username=asianitinc@gmail.com&password=121lsr21LaraSoft&recipient=$memebr_mobile_number&message=$message_body");
        }

        $data = array() ;
        $data['added_id']           = $this->loged_id;
        $data['message']            = $message;
        $data['member_mobile']      = $all_mobile;
        $data['sms_number']         = $cal_msg;
        $data['total_sms_number']   = $total_sends;
        $data['type']               = 6;
        $data['created_at']         = $this->rcdate;
        $data['created_time']       = $this->current_time;

        $query1 = DB::table('sms_send_history')->insert($data);

        $data2 = array() ;
        $data2['total_send']    = $sms_value->total_send + $total_sends ;
        $data2['current_sms']   = $sms_value->current_sms - $total_sends ;
        $query = DB::table('sms')->where('id',1)->update($data2);

        if ($query) {
            echo "success";
            exit() ;
        }
    }


    #------------------------ Send SMS By Udc -----------------------#
    public function sendSMSByUDC()
    {
        

        return view ('sms.sendSMSByUDC') ;
    }

    #================== Send SMS ==========================#
    public function sendSMSByUDCForCandidates(Request $request)
    {
        $admin_info = DB::table('admin')->where('id',$this->loged_id)->first() ;
        $union_id = $admin_info->union_id ;


        $message        = $request->message ;

        $total_candidate = DB::table('candidates')
                        ->where('union_id',$union_id)
                        ->where('berth_reg_complete',0)
                        ->where('berth_reg_distribution',1)
                        ->whereNotIn('contact_number',[00000000000])
                        ->count() ;
        $total_candidate_info = DB::table('candidates')
                        ->where('union_id',$union_id)
                        ->where('berth_reg_complete',0)
                        ->where('berth_reg_distribution',1)
                        ->whereNotIn('contact_number',[00000000000])
                        ->get() ;

        $count_msg      = strlen($message) ;
        $now_msg        = ceil($count_msg / 159) ;
        if($now_msg == 0){
            $cal_msg = 1 ;
        }else{
            $cal_msg = $now_msg ;
        }


        $message_body   = urlencode($message);
        $total_message  = $cal_msg * $total_candidate ;

        $sms_value      = DB::table('sms')->where('id',1)->first();

        $total_sends = $total_message ; 

        if ($total_sends > $sms_value->current_sms) {
            echo "not_av_msg";
            exit() ;
        }

        foreach ($total_candidate_info as $value3) {
            $contact_number[]       = $value3->contact_number ;
            $memebr_mobile_number   = $value3->contact_number;
            $url = file_get_contents("http://touchsitbd.com/systemsms/api.php?username=asianitinc@gmail.com&password=121lsr21LaraSoft&recipient=$memebr_mobile_number&message=$message_body");
        }
        $all_mobile = implode(',', $contact_number) ;
        $data = array() ;
        $data['added_id']           = $this->loged_id;
        $data['message']            = $message;
        $data['member_mobile']      = $all_mobile;
        $data['sms_number']         = $cal_msg;
        $data['total_sms_number']   = $total_sends;
        $data['type']               = 7;
        $data['created_at']         = $this->rcdate;
        $data['created_time']       = $this->current_time;

        $query1 = DB::table('sms_send_history')->insert($data);

        $data2 = array() ;
        $data2['total_send']    = $sms_value->total_send + $total_sends ;
        $data2['current_sms']   = $sms_value->current_sms - $total_sends ;
        $query = DB::table('sms')->where('id',1)->update($data2);

        if ($query) {
            echo "success";
            exit() ;
        }
    }



}
