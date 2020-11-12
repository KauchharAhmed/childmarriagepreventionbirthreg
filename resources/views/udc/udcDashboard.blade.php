@extends('udc.masterUdc')
@section('content')
<div class="content-sticky-footer">

    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <p class="text-uppercase font-weight-bold text-primary">Take First</p>
                <div class="text-center justify-content-between d-flex">
                    <a href="{{URL::to('udcDashboard')}}" class="btn btn-danger rounded sq-btn text-white" title="Home"><i class="material-icons w-25px">home_outline</i></a>

                    <a href="{{URL::to('addCandidatesByUdc')}}" class="btn btn-success rounded sq-btn text-white" title="Profile"><i class="material-icons w-25px">supervisor_account</i></a>
                    
                    <a href="{{URL::to('sendSMSByUDC')}}" class="btn btn-primary rounded sq-btn text-white" title="Send SMS"><i class="material-icons w-25px">mail_outline</i></a>

                    <a href="{{URL::to('searchCandidatesByUdc')}}" class="btn btn-info rounded sq-btn text-white" title="Profile"><i class="material-icons w-25px">search</i></a>

                    <a href="{{URL::to('udcProfile')}}" class="btn btn-warning rounded sq-btn text-white" title="Profile"><i class="material-icons w-25px">account_box</i></a>

                    <a href="{{URL::to('adminLogout/')}}"> 
                        <button type="button"  class="btn btn-info rounded sq-btn text-white" title="Change Password" onclick="return confirm('Are You Sure You Want To Logout ?')" ><i class="material-icons w-25px">power_settings_new</i></button>
                    </a>
                </div>

            </div>
        </div>
    </div>

    <div class="col-12 mb-4">
        <div class="row">

            <div class="col-6 col-md-4 col-lg-4 pb-2">
                <div class="card">
                    <div class="card-body text-center pb-2">
                        <div class="row">
                            <div class="col pr-0 text-left">
                                <p class="text-uppercase font-weight-bold text-primary">Total Candidates</p>
                            </div>
                        </div>
                        <div class="w-100">
                            <h2 class="font-weight-light mb-0"><?php echo $total_candidate ; ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-4 pb-2">
                <div class="card">
                    <div class="card-body text-center pb-2">
                        <div class="row">
                            <div class="col pr-0 text-left">
                                <p class="text-uppercase font-weight-bold text-primary">Total Male Canidates</p>
                            </div>
                        </div>
                        <div class="w-100">
                            <h2 class="font-weight-light mb-0"><?php echo $male_candiates ; ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-4 pb-2">
                <div class="card">
                    <div class="card-body text-center pb-2">
                        <div class="row">
                            <div class="col pr-0 text-left">
                                <p class="text-uppercase font-weight-bold text-primary">Total Female Canidates</p>
                            </div>
                        </div>
                        <div class="w-100">
                            <h2 class="font-weight-light mb-0"><?php echo $female_candiates ; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-6 col-md-4 col-lg-4 pb-2">
                <div class="card">
                    <div class="card-body text-center pb-2">
                        <div class="row">
                            <div class="col pr-0 text-left">
                                <p class="text-uppercase font-weight-bold text-primary">This Month Born Child</p>
                            </div>
                        </div>
                        <div class="w-100">
                            <h2 class="font-weight-light mb-0"><?php echo $monthly_enter_total_child ; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-6 col-md-4 col-lg-4 pb-2">
                <div class="card">
                    <div class="card-body text-center pb-2">
                        <div class="row">
                            <div class="col pr-0 text-left">
                                <p class="text-uppercase font-weight-bold text-primary">This Month Reg Complete</p>
                            </div>
                        </div>
                        <div class="w-100">
                            <h2 class="font-weight-light mb-0"><?php echo $monthly_reg_complete ; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-6 col-md-4 col-lg-4 pb-2">
                <div class="card">
                    <div class="card-body text-center pb-2">
                        <div class="row">
                            <div class="col pr-0 text-left">
                                <p class="text-uppercase font-weight-bold text-primary">Total Reg Complete</p>
                            </div>
                        </div>
                        <div class="w-100">
                            <h2 class="font-weight-light mb-0"><?php echo $total_reg_complete ; ?></h2>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
