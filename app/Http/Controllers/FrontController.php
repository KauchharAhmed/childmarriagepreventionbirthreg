<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use Session;

class FrontController extends Controller
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
	}


	public function index()
	{
        $today_count = DB::table('visitor_history')->where('created_at',$this->rcdate)->count() ;
        if ($today_count > 0) {
            $today_vistor = DB::table('visitor_history')->where('created_at',$this->rcdate)->first() ;
            $today_total_vistor = $today_vistor->today_count ;
        }else{
            $today_total_vistor = 1 ;
        }

        $all_visitor = DB::table('visitor_count')->first() ;
        $all_visitor_number = $all_visitor->total_count ;
		return view('front.home')->with('today_total_vistor',$today_total_vistor)->with('all_visitor_number',$all_visitor_number) ;
	}

	#------------- View Uno Speech --------------------#
	public function unoSpeech()
	{
		return view('front.unoSpeech') ;
	}

	#---------------- Check Age ------------------------#
	public function checkAge()
	{
		$all_union = DB::table('union')->get() ;

		$result = DB::table('candidates')
                    ->join('union','candidates.union_id','=','union.id')
                    ->leftJoin('ward','candidates.ward_id','=','ward.id')
                    ->leftJoin('institute','candidates.institute_id','=','institute.id')
                    ->select('candidates.*','union.union_name','ward.ward_name','institute.institute_name') 
                    ->orderBy('candidates.name','asc')
                    ->get() ;

        $settings = DB::table('age_setting')->where('id',1)->first() ;

		return view('front.checkAge')->with('all_union',$all_union)->with('result',$result)->with('settings',$settings) ;
	}

	#------------------------ View Report -------------------------#
	public function getFontCheckAgeDataView(Request $request)
	{
		$union_id   		= trim($request->union_id) ;
        $name_father_name   = trim($request->name_father_name) ;


        if (empty($union_id) and empty($name_father_name)) {

        	$result = DB::table('candidates')
                ->join('union','candidates.union_id','=','union.id')
                ->leftJoin('ward','candidates.ward_id','=','ward.id')
                ->leftJoin('institute','candidates.institute_id','=','institute.id')
                ->select('candidates.*','union.union_name','ward.ward_name','institute.institute_name') 
                ->get() ;
        	$settings = DB::table('age_setting')->where('id',1)->first() ;


        	return view('candidate.getFontCheckAgeDataView')->with('result',$result)->with('settings',$settings) ;
        }elseif(empty($union_id)){
        	$result = DB::table('candidates')
                ->join('union','candidates.union_id','=','union.id')
                ->leftJoin('ward','candidates.ward_id','=','ward.id')
                ->leftJoin('institute','candidates.institute_id','=','institute.id')
                ->select('candidates.*','union.union_name','ward.ward_name','institute.institute_name') 
                ->where('candidates.name', 'like', '%' . $name_father_name . '%')
                ->get() ;
        	$settings = DB::table('age_setting')->where('id',1)->first() ;


        	return view('candidate.getFontCheckAgeDataView')->with('result',$result)->with('settings',$settings) ;
        }elseif(empty($name_father_name)){
        	$result = DB::table('candidates')
                ->join('union','candidates.union_id','=','union.id')
                ->leftJoin('ward','candidates.ward_id','=','ward.id')
                ->leftJoin('institute','candidates.institute_id','=','institute.id')
                ->select('candidates.*','union.union_name','ward.ward_name','institute.institute_name') 
                ->where('candidates.union_id',$union_id)
                ->get() ;
        	$settings = DB::table('age_setting')->where('id',1)->first() ;


        	return view('candidate.getFontCheckAgeDataView')->with('result',$result)->with('settings',$settings) ;
        }else{
        	$result = DB::table('candidates')
                ->join('union','candidates.union_id','=','union.id')
                ->leftJoin('ward','candidates.ward_id','=','ward.id')
                ->leftJoin('institute','candidates.institute_id','=','institute.id')
                ->select('candidates.*','union.union_name','ward.ward_name','institute.institute_name') 
                ->where('candidates.union_id',$union_id)
                ->where('candidates.name', 'like', '%' . $name_father_name . '%')
                ->get() ;
        	$settings = DB::table('age_setting')->where('id',1)->first() ;

        	return view('candidate.getFontCheckAgeDataView')->with('result',$result)->with('settings',$settings) ;
        }
	}

    #-------------------------- Application Sectionp ------------------------#
    public function application()
    {
        $result = DB::table('union')->get() ;
        return view('front.application')->with('result',$result) ;
    }


    #====================== Send SMS By User ===========================#
    public function sendMessageByUser(Request $request)
    {
        
        $name           = trim($request->name) ;
        $father_name    = trim($request->father_name) ;
        $age            = trim($request->age) ;
        $village        = trim($request->village) ;
        $union_id       = trim($request->union_id) ;
        $ward_id        = trim($request->ward_id) ;
        $institute_name = trim($request->institute_name) ;
        $reason         = trim($request->reason) ;

        $union_info = DB::table('union')->where('id',$union_id)->first() ;
        $union_name = $union_info->union_name ;
        if($ward_id != ""){
            $union_info = DB::table('ward')->where('id',$ward_id)->first() ;
            $ward_name  = $union_info->ward_name ;
        }else{
            $ward_name = "" ;
        }
        

        $owner_message = "Full Stop Child Marriage \n Name : ".$name." \n F.Name : ".$father_name." \n Age : ".$age." \n Vill : ".$village." \n Ward No: ".$ward_name." \n Union : ".$union_name." \n Problem : ".$reason ;

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
        // $url = "http://app.planetgroupbd.com/api/sendsms/plain?user=asianitinc&password=5hjxFQ&sender=Friend&SMSText=$messagesss&GSM=8801710450614&type=longSMS&datacoding=8";
        $url = "http://touchsitbd.com/systemsms/api.php?username=asianitinc@gmail.com&password=121lsr21LaraSoft&recipient=01733335030&message=$messagesss";
        $furl = str_replace(' ', '%20', $url);
        curl_get_contents($furl);

        // echo $furl ;

        $count_msg      = strlen($owner_message) ;
        $now_msg        = $count_msg / 159 ;
        $explode        = explode('.',$now_msg) ;
        $int_number     = $explode[0];
        $after_float    = $explode[1];
        if($after_float > 0){
            $cal_msg = $int_number + 1 ;
        }else{
            $cal_msg = $int_number ;
        }

        $sms_value      = DB::table('sms')->where('id',1)->first();

        $data = array() ;
        $data['union_id']           = $union_id;
        $data['message']            = $owner_message;
        $data['member_mobile']      = '01733335030';
        $data['sms_number']         = $cal_msg;
        $data['total_sms_number']   = $cal_msg;
        $data['created_at']         = $this->rcdate;
        $data['created_time']       = $this->current_time;

        $data2 = array() ;
        $data2['total_send']    = $sms_value->total_send + $cal_msg ;
        $data2['current_sms']   = $sms_value->current_sms - $cal_msg ;

        DB::table('sms_send_history')->insert($data);
        DB::table('sms')->where('id',1)->update($data2);

        
        echo 'Message Successfully Send' ;
    }

    #--------------------------- Child Marriage Low -------------------------#
    public function childMarriageLow()
    {
        return view('front.childMarriageLow') ;
    }


    #------------------------ Child Marriage Vistor Count --------------------#
    public function visitorCount(Request $request)
    {
        $vistor_number = $request->vistor_number  ;

        $check_count = DB::table('visitor_history')
                    ->where('created_at',$this->rcdate)
                    ->count() ;
        if ($check_count > 0) {
            $vistor_history = DB::table('visitor_history')
                    ->where('created_at',$this->rcdate)
                    ->first() ;

            $today_vistor = $vistor_history->today_count ;
            $today_total_visitor = $today_vistor + 1 ;
            $data = array() ;
            $data['today_count']   = $today_total_visitor ;
            
            DB::table('visitor_history')
            ->where('created_at',$this->rcdate)
            ->update($data) ;

            $vistorr_count = DB::table('visitor_count')
                            ->first() ;
            $data2 = array() ;
            $data2['total_count']   = $vistorr_count->total_count + 1 ;

            DB::table('visitor_count')->update($data2) ;
        }else{
            $data = array() ;
            $data['today_count']  = 1 ;
            $data['created_at']   = $this->rcdate ;
            
            DB::table('visitor_history')
            ->insert($data) ;

            $vistorr_count = DB::table('visitor_count')
                            ->first() ;
            $data2 = array() ;
            $data2['total_count']   = $vistorr_count->total_count + 1 ;

            DB::table('visitor_count')->update($data2) ;
        }
    }


}
