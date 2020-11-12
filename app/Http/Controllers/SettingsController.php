<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use Session;

class SettingsController extends Controller
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


    #------------------- Age Settings ----------------------#
    public function ageSettings()
    {
    	$value = DB::table('age_setting')->where('id',1)->first() ;

    	return view('settings.ageSettings')->with('value',$value) ;
    }

    #---------------- Update Age Setting -------------------#
    public function updateAgeSettings(Request $request)
    {
    	$this->validate($request,[
    		'male'		=> 'required',
    		'female'	=> 'required'
    	]);

    	$male 		= trim($request->male) ;
    	$female 	= trim($request->female) ;
    	$primary_id = trim($request->primary_id) ;

    	$data = array() ;
    	$data['male']	= $male ;
    	$data['female']	= $female ;

    	DB::table('age_setting')->where('id',1)->update($data) ;
        Session()->put('success', 'Thanks ! Age Setting Successfully Update.');
        return Redirect::to('ageSettings');

    }

}
