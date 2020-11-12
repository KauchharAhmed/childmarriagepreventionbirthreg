<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use Session;

class DashboardController extends Controller
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

    #--------------------- Admin Dashboard --------------------#
    public function adminDashboard()
    {
        $recent_message         = DB::table('sms_send_history')->orderBy('id','desc')->take(12)->get();
        $check_committee_count  = DB::table('committee_member')->count();
        $check_upazila_committee_count = DB::table('upazila_committee')->count();
        $check_user_count       = DB::table('admin')->whereNotIn('type',[1])->count();
        $total_candidate        = DB::table('candidates')->count();
        $total_male             = DB::table('candidates')->where('gender',1)->count();
        $total_female             = DB::table('candidates')->where('gender',2)->count();
        $total_insitute         = DB::table('institute')->count();
        $sms_value              = DB::table('sms')->first();

        $month = date('Y-m') ;

        $total_marriage_this_month = DB::table('candidates')->where('marriage_date','like','%'. $month .'%')->count();
        $total_marriage        = DB::table('candidates')->where('married_status',1)->count();

        $today_enter_total_child = DB::table('candidates')->where('type',2)->where('created_at',$this->rcdate)->count() ;
        $monthly_enter_total_child = DB::table('candidates')->where('type',2)->where('created_at','like','%'. $month .'%')->count() ;
        $today_reg_complete = DB::table('candidates')->where('type',2)->where('berth_reg_complete',0)->where('updated_at',$this->rcdate)->count() ;
        $monthly_reg_complete = DB::table('candidates')->where('type',2)->where('berth_reg_complete',0)->where('created_at','like','%'. $month .'%')->count() ;
        $total_reg_complete = DB::table('candidates')->where('berth_reg_complete',0)->count() ;
        $total_birth_registration_distribute = DB::table('candidates')->where('berth_reg_distribution',1)->count();
        $this_month_birth_registration_distribute = DB::table('candidates')->where('berth_reg_distribution',1)->where('created_at','like','%'. $month .'%')->count();

        return view('admin.adminDashboard')->with('recent_message',$recent_message)->with('check_committee_count',$check_committee_count)->with('check_user_count',$check_user_count)->with('sms_value',$sms_value)->with('total_candidate',$total_candidate)->with('total_insitute',$total_insitute)->with('total_marriage_this_month',$total_marriage_this_month)->with('total_marriage',$total_marriage)->with('total_male',$total_male)->with('total_female',$total_female)->with('monthly_enter_total_child',$monthly_enter_total_child)->with('today_enter_total_child',$today_enter_total_child)->with('today_reg_complete',$today_reg_complete)->with('monthly_reg_complete',$monthly_reg_complete)->with('total_reg_complete',$total_reg_complete)->with('check_upazila_committee_count',$check_upazila_committee_count)->with('total_birth_registration_distribute',$total_birth_registration_distribute)->with('this_month_birth_registration_distribute',$this_month_birth_registration_distribute);
    }

    #--------------------- Admin Dashboard --------------------#
    public function userDashboard()
    {
        $recent_message         = DB::table('sms_send_history')->orderBy('id','desc')->take(12)->get();
        $check_committee_count  = DB::table('committee_member')->count();
        $check_user_count       = DB::table('admin')->where('type',2)->count();
        $sms_value              = DB::table('sms')->first();

        return view('admin.userDashboard')->with('recent_message',$recent_message)->with('check_committee_count',$check_committee_count)->with('check_user_count',$check_user_count)->with('sms_value',$sms_value) ;
    }

    #--------------------- Admin Dashboard --------------------#
    public function instituteDashboard()
    {
        $admin_info = DB::table('admin')->where('id',$this->loged_id)->first() ;
        $total_candidate_count = DB::table('candidates')->where('institute_id',$admin_info->institute_id)->count() ;
        $total_male_count = DB::table('candidates')->where('institute_id',$admin_info->institute_id)->where('gender',1)->count() ;
        $total_female_count = DB::table('candidates')->where('institute_id',$admin_info->institute_id)->where('gender',2)->count() ;

        return view('institute.instituteDashboard')->with('total_candidate_count',$total_candidate_count)->with('total_male_count',$total_male_count)->with('total_female_count',$total_female_count);
    }

    #--------------------- Organizatoin Dashboard --------------------#
    public function organizationDashboard()
    {
        $total_candidate_count = DB::table('candidates')->where('added_id',$this->loged_id)->count() ;
        $total_male_count = DB::table('candidates')->where('added_id',$this->loged_id)->where('gender',1)->count() ;
        $total_female_count = DB::table('candidates')->where('added_id',$this->loged_id)->where('gender',2)->count() ;

        $month = date('Y-m') ;
        $runing_month_count = DB::table('candidates')->where('added_id',$this->loged_id)->where('created_at','like','%'. $month .'%')->count() ;

    	return view('health.organizationDashboard')->with('total_candidate_count',$total_candidate_count)->with('total_male_count',$total_male_count)->with('total_female_count',$total_female_count)->with('runing_month_count',$runing_month_count);
    }

    #----------------- Kazi Dashboard ------------------------#
    public function kaziDashboard()
    {
        $male_marriage = DB::table('candidates')
                    ->where('married_status',1)
                    ->where('gender',1)
                    ->where('updated_id',$this->loged_id)
                    ->count() ;
        $female_marriage = DB::table('candidates')
                    ->where('married_status',1)
                    ->where('gender',2)
                    ->where('updated_id',$this->loged_id)
                    ->count() ;

        return view('kazi.kaziDashboard')->with('male_marriage',$male_marriage)->with('female_marriage',$female_marriage);
    }

    #------------------ UDC Dashboard ------------------------#
    public function udcDashboard()
    {
        $admin_info = DB::table('admin')->where('id',$this->loged_id)->first() ;
        $union_id   = $admin_info->union_id ;

        $total_candidate  = DB::table('candidates')->where('union_id',$union_id)->count() ;

        $male_candiates   = DB::table('candidates')
                    ->where('gender',1)
                    ->where('union_id',$union_id)
                    ->count() ;
        $female_candiates = DB::table('candidates')
                    ->where('gender',2)
                    ->where('union_id',$union_id)
                    ->count() ;
                    
        $month = date('Y-m') ;
        $monthly_enter_total_child = DB::table('candidates')->where('union_id',$union_id)->where('type',2)->where('created_at','like','%'. $month .'%')->count() ;
        $monthly_reg_complete = DB::table('candidates')->where('union_id',$union_id)->where('type',2)->where('berth_reg_complete',0)->where('created_at','like','%'. $month .'%')->count() ;
        $total_reg_complete = DB::table('candidates')->where('union_id',$union_id)->where('berth_reg_complete',0)->count() ;
        
        

        return view('udc.udcDashboard')->with('male_candiates',$male_candiates)->with('female_candiates',$female_candiates)->with('total_candidate',$total_candidate)->with('monthly_enter_total_child',$monthly_enter_total_child)->with('monthly_reg_complete',$monthly_reg_complete)->with('total_reg_complete',$total_reg_complete);
    }

}
