@extends('admin.masterAdmin')
@section('content')
<div class="content-sticky-footer">

    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <p class="text-uppercase font-weight-bold text-primary">Take First</p>
                <div class="text-center justify-content-between d-flex">
                    <a href="{{URL::to('adminDashboard')}}" class="btn btn-danger rounded sq-btn text-white" title="Home"><i class="material-icons w-25px">home_outline</i></a>

                    <a href="{{URL::to('sendSms')}}" class="btn btn-primary rounded sq-btn text-white" title="Send SMS"><i class="material-icons w-25px">mail_outline</i></a>

                    <a href="{{URL::to('addCommitteeMember')}}" class="btn btn-success rounded sq-btn text-white" title="Add Member"><i class="material-icons w-25px">people</i></a>

                    <a href="{{URL::to('profile')}}" class="btn btn-warning rounded sq-btn text-white" title="Profile"><i class="material-icons w-25px">account_box</i></a>

                    <a href="{{URL::to('adminLogout/')}}"> 
                        <button type="button"  class="btn btn-info rounded sq-btn text-white" title="Change Password" onclick="return confirm('Are You Sure You Want To Logout ?')" ><i class="material-icons w-25px">power_settings_new</i></button> 
                    </a>
                </div>

            </div>
        </div>
    </div>

    <h2 class="block-title">Latest Message</h2>
    <div class="w-100">
        <div class="carosel">
            <div class="swiper-container swiper-init swipermultiple">
                <div class="swiper-pagination"></div>
                <div class="swiper-wrapper">
                    <?php foreach ($recent_message as $value2) { ?>
                    <div class="swiper-slide">
                        <div class="swiper-content-block gradient-primary text-white shadow-15">
                            <h4 class="text-white title-small-carousel"><?php echo $value2->message ; ?></h4>
                            <p class="text-white"><?php echo date('d M Y',strtotime($value2->created_at)) ; ?> <?php echo date('h:i:s A',strtotime($value2->created_time)) ; ?></p>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 mb-4">
        <div class="row">
            <div class="col-6 col-md-4 col-lg-2 pb-2">
                <div class="card">
                    <div class="card-body text-center pb-2">
                        <div class="row">
                            <div class="col pr-0 text-left">
                                <p class="text-uppercase font-weight-bold text-primary">Total Users</p>
                            </div>
                        </div>
                        <div class="w-100">
                            <h2 class="font-weight-light mb-0"><?php echo $check_user_count ; ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2 pb-2">
                <div class="card">
                    <div class="card-body text-center pb-2">
                        <div class="row">
                            <div class="col pr-0 text-left">
                                <p class="text-uppercase font-weight-bold text-primary">Total Members</p>
                            </div>
                        </div>
                        <div class="w-100">
                            <h2 class="font-weight-light mb-0"><?php echo $check_committee_count+$check_upazila_committee_count ; ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2 pb-2">
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

            <div class="col-6 col-md-4 col-lg-2 pb-2">
                <div class="card">
                    <div class="card-body text-center pb-2">
                        <div class="row">
                            <div class="col pr-0 text-left">
                                <p class="text-uppercase font-weight-bold text-primary">Total Male</p>
                            </div>
                        </div>
                        <div class="w-100">
                            <h2 class="font-weight-light mb-0"><?php echo $total_male ; ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2 pb-2">
                <div class="card">
                    <div class="card-body text-center pb-2">
                        <div class="row">
                            <div class="col pr-0 text-left">
                                <p class="text-uppercase font-weight-bold text-primary">Total Female</p>
                            </div>
                        </div>
                        <div class="w-100">
                            <h2 class="font-weight-light mb-0"><?php echo $total_female ; ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2 pb-2">
                <div class="card">
                    <div class="card-body text-center pb-2">
                        <div class="row">
                            <div class="col pr-0 text-left">
                                <p class="text-uppercase font-weight-bold text-primary">Total Institute</p>
                            </div>
                        </div>
                        <div class="w-100">
                            <h2 class="font-weight-light mb-0"><?php echo $total_insitute ; ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2 pb-2">
                <div class="card">
                    <div class="card-body text-center pb-2">
                        <div class="row">
                            <div class="col pr-0 text-left">
                                <p class="text-uppercase font-weight-bold text-primary">This Month Marriage</p>
                            </div>
                        </div>
                        <div class="w-100">
                            <h2 class="font-weight-light mb-0"><?php echo $total_marriage_this_month ; ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2 pb-2">
                <div class="card">
                    <div class="card-body text-center pb-2">
                        <div class="row">
                            <div class="col pr-0 text-left">
                                <p class="text-uppercase font-weight-bold text-primary">Total Marriage</p>
                            </div>
                        </div>
                        <div class="w-100">
                            <h2 class="font-weight-light mb-0"><?php echo $total_marriage_this_month ; ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2 pb-2">
                <div class="card">
                    <div class="card-body text-center pb-2">
                        <div class="row">
                            <div class="col pr-0 text-left">
                                <p class="text-uppercase font-weight-bold text-primary">Today Born Child</p>
                            </div>
                        </div>
                        <div class="w-100">
                            <h2 class="font-weight-light mb-0"><?php echo $today_enter_total_child ; ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2 pb-2">
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

            <div class="col-6 col-md-4 col-lg-2 pb-2">
                <div class="card">
                    <div class="card-body text-center pb-2">
                        <div class="row">
                            <div class="col pr-0 text-left">
                                <p class="text-uppercase font-weight-bold text-primary">Today Birth Reg Complete</p>
                            </div>
                        </div>
                        <div class="w-100">
                            <h2 class="font-weight-light mb-0"><?php echo $today_reg_complete ; ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2 pb-2">
                <div class="card">
                    <div class="card-body text-center pb-2">
                        <div class="row">
                            <div class="col pr-0 text-left">
                                <p class="text-uppercase font-weight-bold text-primary">This Month Birth Reg Complete</p>
                            </div>
                        </div>
                        <div class="w-100">
                            <h2 class="font-weight-light mb-0"><?php echo $monthly_reg_complete ; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-6 col-md-4 col-lg-2 pb-2">
                <div class="card">
                    <div class="card-body text-center pb-2">
                        <div class="row">
                            <div class="col pr-0 text-left">
                                <p class="text-uppercase font-weight-bold text-primary">Total Birth Reg Complete</p>
                            </div>
                        </div>
                        <div class="w-100">
                            <h2 class="font-weight-light mb-0"><?php echo $total_reg_complete ; ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2 pb-2">
                <div class="card">
                    <div class="card-body text-center pb-2">
                        <div class="row">
                            <div class="col pr-0 text-left">
                                <p class="text-uppercase font-weight-bold text-primary">Total Birth Reg Distribute</p>
                            </div>
                        </div>
                        <div class="w-100">
                            <h2 class="font-weight-light mb-0"><?php echo $total_birth_registration_distribute ; ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2 pb-2">
                <div class="card">
                    <div class="card-body text-center pb-2">
                        <div class="row">
                            <div class="col pr-0 text-left">
                                <p class="text-uppercase font-weight-bold text-primary">This Month Birth Reg Distribute</p>
                            </div>
                        </div>
                        <div class="w-100">
                            <h2 class="font-weight-light mb-0"><?php echo $this_month_birth_registration_distribute ; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
            
            

            <div class="col-6 col-md-4 col-lg-2 pb-2">
                <div class="card">
                    <div class="card-body text-center pb-2">
                        <div class="row">
                            <div class="col pr-0 text-left">
                                <p class="text-uppercase font-weight-bold text-primary">SMS Credit</p>
                            </div>
                        </div>
                        <div class="w-100">
                            <h2 class="font-weight-light mb-0"><?php echo $sms_value->current_sms ; ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2 pb-2">
                <div class="card">
                    <div class="card-body text-center pb-2">
                        <div class="row">
                            <div class="col pr-0 text-left">
                                <p class="text-uppercase font-weight-bold text-primary">Total Send SMS</p>
                            </div>
                        </div>
                        <div class="w-100">
                            <h2 class="font-weight-light mb-0"><?php echo $sms_value->total_send ; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
