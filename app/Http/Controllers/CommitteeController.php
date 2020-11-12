<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use Session;

class CommitteeController extends Controller
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

    #----------------- Committee Member Designation ----------------------#
    public function addDesignation()
    {
    	return view('committee.addDesignation') ;
    }

    #-------------------------- Designation -------------------------#
    public function addDesignationInfo(Request $request)
    {
    	$this->validate($request,[
    		'designation_name'	=> 'required'
    	]);

    	$designation_name = trim($request->designation_name);

    	$check_count = DB::table('designation')->where('designation_name',$designation_name)->count();
    	if ($check_count > 0) {
    		Session()->put('failed', 'Sorry ! Designation Already Exit.');
            return Redirect::to('addDesignation');
    	}

    	$data = array() ;
    	$data['designation_name']	= $designation_name;
    	$data['status']				= 1 ;
    	$data['created_at']			= $this->rcdate ;

    	DB::table('designation')->insert($data);

    	Session()->put('success', 'Thanks ! Designation Add Successfully Completed.');
        return Redirect::to('addDesignation');
    }

    #---------------------- Manage Designation -----------------------#
    public function manageDesignation()
    {
    	$result = DB::table('designation')->get();

    	return view('committee.manageDesignation')->with('result',$result);
    }

    #---------------------------- Change Designation Status ----------------------------#
    public function changeDesignationStatus($id)
    {
        $get_designation_status = DB::table('designation')
                        ->where('id',$id)
                        ->first();

        $status = $get_designation_status->status ;

        if($status == 1){
            $nstatus = 2 ;
        }else{
            $nstatus = 1 ;
        }

        $data               = array();
        $data['status']     = $nstatus ;
        $data['updated_at'] = $this->rcdate ;

        DB::table('designation')
        ->where('id',$id)
        ->update($data);

        Session::put('success','Thanks ! Desigantion Status Change Successfully Completed .');
        return Redirect::to('manageDesignation');
    }

    #-------------------------------- Edit Designation info -------------------------#
    public function editDesignation($id)
    {
        $value = DB::table('designation')
                ->where('id',$id)
                ->first();
        return view('committee.editDesignation')->with('value',$value) ;
    }

    #------------------- Update Designation Info -------------------------#
    public function updateDesignationInfo(Request $request)
    {
        $this->validate($request,[
            'designation_name'  => 'required'
        ]);

        $designation_name = trim($request->designation_name);
        $primary_id       = $request->primary_id ;

        $check_count = DB::table('designation')
                    ->where('designation_name',$designation_name)
                    ->whereNotIn('id',[$primary_id])
                    ->count();
        if ($check_count > 0) {
            Session()->put('failed', 'Sorry ! Designation Already Exit.');
            return Redirect::to('editDesignation/'.$primary_id);
        }

        $data = array() ;
        $data['designation_name']   = $designation_name;
        $data['status']             = 1 ;
        $data['updated_at']         = $this->rcdate ;

        DB::table('designation')->where('id',$primary_id)->update($data);

        Session()->put('success', 'Thanks ! Designation Update Successfully Completed.');
        return Redirect::to('editDesignation/'.$primary_id);
    }

    #============================= End Designation section ==============================#

    #============================= Start Union Section ==================================#
    public function addUnion()
    {
    	return view('committee.addUnion') ;
    }

    #----------------------- Add Union Info --------------------#
    public function addUnionInfo(Request $request)
    {
    	$this->validate($request,[
    		'union_name'	=> 'required'
    	]);

    	$union_name = trim($request->union_name);

    	$check_count = DB::table('union')->where('union_name',$union_name)->count();
    	if ($check_count > 0) {
    		Session()->put('failed', 'Sorry ! Union Already Exit.');
            return Redirect::to('addDesignation');
    	}

    	$data = array() ;
    	$data['union_name']	= $union_name;
    	$data['status']				= 1 ;
    	$data['created_at']			= $this->rcdate ;

    	DB::table('union')->insert($data);

    	Session()->put('success', 'Thanks ! Union Add Successfully Completed.');
        return Redirect::to('addUnion');
    }

    #-------------------- Manage Union ----------------------------#
    public function manageUnion()
    {
    	$result = DB::table('union')
    			->get() ;

    	return view('committee.manageUnion')->with('result',$result);
    }

    #-------------------------- Change Union Status -----------------------#
    public function changeUnionStatus($id)
    {
        $get_designation_status = DB::table('union')
                        ->where('id',$id)
                        ->first();

        $status = $get_designation_status->status ;

        if($status == 1){
            $nstatus = 2 ;
        }else{
            $nstatus = 1 ;
        }

        $data               = array();
        $data['status']     = $nstatus ;
        $data['updated_at'] = $this->rcdate ;

        DB::table('union')
        ->where('id',$id)
        ->update($data);

        Session::put('success','Thanks ! Union Status Change Successfully Completed .');
        return Redirect::to('manageUnion');
    }
    
    #-------------------- Edit Union Info ----------------------#
    public function editUnion($id)
    {
        $value = DB::table('union')
                ->where('id',$id)
                ->first();

        return view('committee.editUnion')->with('value',$value);
    }

    #-------------------- Update Committee Info --------------------------#
    public function updateUnionInfo(Request $request)
    {
        $this->validate($request,[
            'union_name'    => 'required'
        ]);

        $union_name = trim($request->union_name);
        $primary_id = trim($request->primary_id);

        $check_count = DB::table('union')
                    ->where('union_name',$union_name)
                    ->whereNotIn('id',[$primary_id])
                    ->count();
        if ($check_count > 0) {
            Session()->put('failed', 'Sorry ! Union Already Exit.');
            return Redirect::to('editUnion/'.$primary_id);
        }

        $data = array() ;
        $data['union_name'] = $union_name;
        $data['updated_at'] = $this->rcdate ;

        DB::table('union')->where('id',$primary_id)->update($data);

        Session()->put('success', 'Thanks ! Union Update Successfully Completed.');
        return Redirect::to('editUnion/'.$primary_id);
    }

    #========================== Committee ================================#
    public function addCommitteeMember()
	{
		$all_union 			= DB::table('union')->where('status',1)->get();
		$all_designation 	= DB::table('designation')->where('status',1)->get();

		return view('committee.addCommitteeMember')->with('all_union',$all_union)->with('all_designation',$all_designation);
	}

	#--------------------- Insert Committee Member Info ------------------------#
	public function addCommitteeMemberInfo(Request $request)
	{
		$this->validate($request,[
			'union_id'			=> 'required',
			'designation_id'	=> 'required',
			'member_name'		=> 'required',
			'organization_name'	=> 'required',
			'designation'		=> 'required',
			'mobile'			=> 'required|size:11',
		]);

		$union_id 			= $request->union_id ;
		$designation_id 	= $request->designation_id ;
		$member_name 		= $request->member_name ;
		$organization_name 	= $request->organization_name ;
		$designation 		= $request->designation ;
		$village 			= $request->village ;
		$mobile 			= $request->mobile ;

		#--------------------- Check Duplicate Mobile Number ------------------------#
// 		$check_count = DB::table('committee_member')->where('mobile',$mobile)->count();

// 		if ($check_count > 0) {
//     		Session()->put('failed', 'Sorry ! Mobile Number Already Exit.');
//             return Redirect::to('addCommitteeMember');
//     	}

    	$data = array();
    	$data['added_id']			= $this->loged_id ;
    	$data['union_id']			= $union_id ;
    	$data['designation_id']		= $designation_id ;
    	$data['member_name']		= $member_name ;
    	$data['organization_name']	= $organization_name ;
    	$data['designation']		= $designation ;
    	$data['village']			= $village ;
    	$data['mobile']				= $mobile ;
    	$data['status']				= 1 ;
    	$data['created_at']			= $this->rcdate ;

    	DB::table('committee_member')->insert($data);

    	Session()->put('success', 'Thanks ! Committee Member Add Successfully Completed.');
        return Redirect::to('addCommitteeMember');
	}

	#--------------------- Manage Committee Member ----------------------#
	public function manageCommitteeMember()
	{
		$result = DB::table('committee_member')
				->join('admin','committee_member.added_id','=','admin.id')
				->join('designation','committee_member.designation_id','=','designation.id')
				->join('union','committee_member.union_id','=','union.id')
				->select('committee_member.*','admin.name','designation.designation_name','union.union_name')
				->orderBy('id','desc')
				->get();

		return view('committee.manageCommitteeMember')->with('result',$result) ;
	}

    #------------------------ Update Committee Member Info ---------------------#
    public function editCommitteeMember($id)
    {
        $value = DB::table('committee_member')
                ->join('admin','committee_member.added_id','=','admin.id')
                ->join('designation','committee_member.designation_id','=','designation.id')
                ->join('union','committee_member.union_id','=','union.id')
                ->select('committee_member.*','admin.name','designation.designation_name','union.union_name')
                ->where('committee_member.id',$id)
                ->first();

        $all_union          = DB::table('union')->where('status',1)->get();
        $all_designation    = DB::table('designation')->where('status',1)->get();

        return view('committee.editCommitteeMember')->with('value',$value)->with('all_union',$all_union)->with('all_designation',$all_designation) ;
    }

    #------------------ Update Committee Member Info ----------------------#
    public function updateCommitteeMemberInfo(Request $request)
    {
        $this->validate($request,[
            'union_id'          => 'required',
            'designation_id'    => 'required',
            'member_name'       => 'required',
            'organization_name' => 'required',
            'designation'       => 'required',
            'village'           => 'required',
            'mobile'            => 'required',
        ]);

        $union_id           = $request->union_id ;
        $designation_id     = $request->designation_id ;
        $member_name        = $request->member_name ;
        $organization_name  = $request->organization_name ;
        $designation        = $request->designation ;
        $village            = $request->village ;
        $mobile             = $request->mobile ;
        $primary_id         = $request->primary_id ;

        #--------------------- Check Duplicate Mobile Number ------------------------#
        $check_count = DB::table('committee_member')
                    ->where('mobile',$mobile)
                    ->whereNotIn('id',[$primary_id])
                    ->count();

        if ($check_count > 0) {
            Session()->put('failed', 'Sorry ! Mobile Number Already Exit.');
            return Redirect::to('editCommitteeMember/'.$primary_id);
        }

        $data = array();
        $data['added_id']           = $this->loged_id ;
        $data['union_id']           = $union_id ;
        $data['designation_id']     = $designation_id ;
        $data['member_name']        = $member_name ;
        $data['organization_name']  = $organization_name ;
        $data['designation']        = $designation ;
        $data['village']            = $village ;
        $data['mobile']             = $mobile ;
        $data['status']             = 1 ;
        $data['created_at']         = $this->rcdate ;

        DB::table('committee_member')->where('id',$primary_id)->update($data);

        Session()->put('success', 'Thanks ! Committee Member Update Successfully Completed.');
        return Redirect::to('editCommitteeMember/'.$primary_id);
    }

    #-------------------------- Change Member Status --------------------------#
    public function changeMemberStatus($id)
    {
        $get_designation_status = DB::table('committee_member')
                        ->where('id',$id)
                        ->first();

        $status = $get_designation_status->status ;

        if($status == 1){
            $nstatus = 2 ;
        }else{
            $nstatus = 1 ;
        }

        $data               = array();
        $data['status']     = $nstatus ;
        $data['updated_at'] = $this->rcdate ;

        DB::table('committee_member')
        ->where('id',$id)
        ->update($data);

        Session::put('success','Thanks ! Member Status Change Successfully Completed .');
        return Redirect::to('manageCommitteeMember');
    }

    #------------------------ Get Union Wise Committee List -----------------------#
    public function unionWiseCommitteeMember()
    {
        $all_union = DB::table('union')->get() ;

        return view('committee.unionWiseCommitteeMember')->with('all_union',$all_union) ;
    }

    #-------------------- Get Union Committee Wise Member List --------------------#
    public function getCommitteeWiseMemberList(Request $request)
    {
        $this->validate($request,[
            'union_id'  => 'required'
        ]);

        $union_id = trim($request->union_id) ;

        $check_count = DB::table('committee_member')->where('union_id',$union_id)->count();
        if ($check_count == 0) {
            Session()->put('failed', 'Sorry ! No Committee Member Found.');
            return Redirect::to('unionWiseCommitteeMember');
        }

        $result = DB::table('committee_member')
                ->join('admin','committee_member.added_id','=','admin.id')
                ->join('designation','committee_member.designation_id','=','designation.id')
                ->join('union','committee_member.union_id','=','union.id')
                ->select('committee_member.*','admin.name','designation.designation_name','union.union_name')
                ->where('union_id',$union_id)
                ->get();

        return view('committee.getCommitteeWiseMemberList')->with('result',$result) ;
    }

    #---------------------- Add Upazila Committee Member ----------------------------#
    public function addUpazilaCommitteeMember()
    {
        $all_designation    = DB::table('designation')->where('status',1)->get();
        return view('committee.addUpazilaCommitteeMember')->with('all_designation',$all_designation) ;
    }

    #----------------------- Insert Upazila Committee Member Info ----------------------------#
    public function addUpazilaCommitteeMemberInfo(Request $request)
    {
        $this->validate($request,[
            'designation_id'    => 'required',
            'member_name'       => 'required',
            'organization_name' => 'required',
            'designation'       => 'required',
            'mobile'            => 'required',
        ]) ;

        $designation_id     = $request->designation_id ;
        $member_name        = $request->member_name ;
        $organization_name  = $request->organization_name ;
        $designation        = $request->designation ;
        $mobile             = $request->mobile ;

        #--------------------- Check Duplicate Mobile Number ------------------------#
        $check_count = DB::table('upazila_committee')->where('mobile',$mobile)->count();

        if ($check_count > 0) {
            Session()->put('failed', 'Sorry ! Mobile Number Already Exit.');
            return Redirect::to('addUpazilaCommitteeMember');
        }

        $data = array();
        $data['added_id']           = $this->loged_id ;
        $data['designation_id']     = $designation_id ;
        $data['member_name']        = $member_name ;
        $data['organization_name']  = $organization_name ;
        $data['designation']        = $designation ;
        $data['mobile']             = $mobile ;
        $data['status']             = 1 ;
        $data['created_at']         = $this->rcdate ;

        DB::table('upazila_committee')->insert($data);

        Session()->put('success', 'Thanks ! Committee Member Add Successfully Completed.');
        return Redirect::to('addUpazilaCommitteeMember');
    }

    #-------------------- Manage Upazila Committee Member Info ---------------------------#
    public function manageUpazilaCommitteeMember()
    {
        $result = DB::table('upazila_committee')
                ->join('admin','upazila_committee.added_id','=','admin.id')
                ->join('designation','upazila_committee.designation_id','=','designation.id')
                ->select('upazila_committee.*','admin.name','designation.designation_name')
                ->orderBy('upazila_committee.id','asc')
                ->get();

        return view('committee.manageUpazilaCommitteeMember')->with('result',$result) ;
    }

    #------------------------- Change Upazila Committee Member Info ---------------------------#
    public function changeUpazilaMemberStatus($id)
    {
        $get_designation_status = DB::table('upazila_committee')
                        ->where('id',$id)
                        ->first();

        $status = $get_designation_status->status ;

        if($status == 1){
            $nstatus = 2 ;
        }else{
            $nstatus = 1 ;
        }

        $data               = array();
        $data['status']     = $nstatus ;
        $data['updated_at'] = $this->rcdate ;

        DB::table('upazila_committee')
        ->where('id',$id)
        ->update($data);

        Session::put('success','Thanks ! Upazila Committee Member Status Change Successfully Completed .');
        return Redirect::to('manageUpazilaCommitteeMember');
    }

    #------------------------- Edit Upazila Member Info -------------------------------#
    public function editUpazilaCommitteeMember($id)
    {
        $result = DB::table('upazila_committee')
                ->join('admin','upazila_committee.added_id','=','admin.id')
                ->join('designation','upazila_committee.designation_id','=','designation.id')
                ->select('upazila_committee.*','admin.name','designation.designation_name')
                ->where('upazila_committee.id',$id)
                ->first();

        $all_designation    = DB::table('designation')->where('status',1)->get();

        return view('committee.editUpazilaCommitteeMember')->with('value',$result)->with('all_designation',$all_designation) ;
    }

    #--------------------- Update Upazila Committee Member info -----------------------#
    public function updateUpazilaCommitteeMemberInfo(Request $request)
    {
        $this->validate($request,[
            'designation_id'    => 'required',
            'member_name'       => 'required',
            'organization_name' => 'required',
            'designation'       => 'required',
            'mobile'            => 'required',
        ]) ;

        $designation_id     = $request->designation_id ;
        $member_name        = $request->member_name ;
        $organization_name  = $request->organization_name ;
        $designation        = $request->designation ;
        $mobile             = $request->mobile ;
        $primary_id         = $request->primary_id ;

        #--------------------- Check Duplicate Mobile Number ------------------------#
        $check_count = DB::table('upazila_committee')->where('mobile',$mobile)->whereNotIn('id',[$primary_id])->count();

        if ($check_count > 0) {
            Session()->put('failed', 'Sorry ! Mobile Number Already Exit.');
            return Redirect::to('editUpazilaCommitteeMember/'.$primary_id);
        }

        $data = array();
        $data['added_id']           = $this->loged_id ;
        $data['designation_id']     = $designation_id ;
        $data['member_name']        = $member_name ;
        $data['organization_name']  = $organization_name ;
        $data['designation']        = $designation ;
        $data['mobile']             = $mobile ;
        $data['updated_at']         = $this->rcdate ;

        DB::table('upazila_committee')->where('id',$primary_id)->update($data);

        Session()->put('success', 'Thanks ! Committee Member Info Update Successfully Completed.');
        return Redirect::to('editUpazilaCommitteeMember/'.$primary_id);
    }




}
