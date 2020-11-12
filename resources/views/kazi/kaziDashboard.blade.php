@extends('kazi.masterKazi')
@section('content')
<div class="content-sticky-footer">

    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <p class="text-uppercase font-weight-bold text-primary">Take First</p>
                <div class="text-center justify-content-between d-flex">
                    <a href="{{URL::to('kaziDashboard')}}" class="btn btn-danger rounded sq-btn text-white" title="Home"><i class="material-icons w-25px">home_outline</i></a>


                    <a href="{{URL::to('searchCandidates')}}" class="btn btn-success rounded sq-btn text-white" title="Search Candidates"><i class="material-icons w-25px">search</i></a>

                    <a href="{{URL::to('manageCandidatesByKazi')}}" class="btn btn-warning rounded sq-btn text-white" title="All Canidates"><i class="material-icons w-25px">supervisor_account</i></a>


                    <a href="{{URL::to('adminLogout/')}}"> 
                        <button type="button"  class="btn btn-info rounded sq-btn text-white" title="Logout" onclick="return confirm('Are You Sure You Want To Logout ?')" ><i class="material-icons w-25px">power_settings_new</i></button>
                    </a>
                </div>

            </div>
        </div>
    </div>

    <div class="col-12 mb-4">
        <div class="row">
            
            <div class="col-6 col-md-6 col-lg-4 pb-2">
                <div class="card">
                    <div class="card-body text-center pb-2">
                        <div class="row">
                            <div class="col pr-0 text-left">
                                <p class="text-uppercase font-weight-bold text-primary">Total Marriage</p>
                            </div>
                        </div>
                        <div class="w-100">
                            <h2 class="font-weight-light mb-0"><?php echo $female_marriage + $male_marriage ; ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-6 col-lg-4 pb-2">
                <div class="card">
                    <div class="card-body text-center pb-2">
                        <div class="row">
                            <div class="col pr-0 text-left">
                                <p class="text-uppercase font-weight-bold text-primary">Total Male Marriage</p>
                            </div>
                        </div>
                        <div class="w-100">
                            <h2 class="font-weight-light mb-0"><?php echo $male_marriage ; ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-6 col-lg-4 pb-2">
                <div class="card">
                    <div class="card-body text-center pb-2">
                        <div class="row">
                            <div class="col pr-0 text-left">
                                <p class="text-uppercase font-weight-bold text-primary">Total Female Marriage</p>
                            </div>
                        </div>
                        <div class="w-100">
                            <h2 class="font-weight-light mb-0"><?php echo $female_marriage ; ?></h2>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
