@extends('institute.masterInstitute')
@section('content')
<div class="content-sticky-footer">

    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <p class="text-uppercase font-weight-bold text-primary">Take First</p>
                <div class="text-center justify-content-between d-flex">
                    <a href="{{URL::to('instituteDashboard')}}" class="btn btn-danger rounded sq-btn text-white" title="Home"><i class="material-icons w-25px">home_outline</i></a>

                    <a href="{{URL::to('addStudent')}}" class="btn btn-success rounded sq-btn text-white" title="Profile"><i class="material-icons w-25px">supervisor_account</i></a>

                    <a href="{{URL::to('manageInstituteCandidates')}}" class="btn btn-info rounded sq-btn text-white" title="Profile"><i class="material-icons w-25px">search</i></a>

                    <a href="{{URL::to('instituteProfile')}}" class="btn btn-warning rounded sq-btn text-white" title="Profile"><i class="material-icons w-25px">account_box</i></a>

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
                            <h2 class="font-weight-light mb-0"><?php  echo $total_candidate_count ; ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-4 pb-2">
                <div class="card">
                    <div class="card-body text-center pb-2">
                        <div class="row">
                            <div class="col pr-0 text-left">
                                <p class="text-uppercase font-weight-bold text-primary">Male Candidates</p>
                            </div>
                        </div>
                        <div class="w-100">
                            <h2 class="font-weight-light mb-0"><?php echo $total_male_count ; ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-4 pb-2">
                <div class="card">
                    <div class="card-body text-center pb-2">
                        <div class="row">
                            <div class="col pr-0 text-left">
                                <p class="text-uppercase font-weight-bold text-primary">Female Canidates</p>
                            </div>
                        </div>
                        <div class="w-100">
                            <h2 class="font-weight-light mb-0"><?php echo $total_female_count ; ?></h2>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>

</div>
@endsection
