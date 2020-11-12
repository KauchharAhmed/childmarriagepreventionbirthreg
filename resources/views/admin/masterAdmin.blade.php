<?php
    $admin_id       = Session::get('admin_id');
    $type           = Session::get('type');
 
    if($admin_id == null && $type == null){
        return Redirect::to('/')->send();
        exit();
    }

    if($admin_id == null){
        return Redirect::to('/')->send();
        exit();
    }

    if($type != 1){
        return Redirect::to('/')->send();
        exit();
    }

    $profile_info = DB::table('admin')->where('id',$admin_id)->where('type',$type)->first();

?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, shrink-to-fit=no, viewport-fit=cover">

    <link rel="apple-touch-icon" href="{{URL::to('public/assets/img/favicon.ico')}}">
    <link rel="icon" href="{{URL::to('public/assets/img/apple-touch-icon.png')}}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{URL::to('public/assets/vendor/bootstrap-4.1.3/css/bootstrap.min.css')}}">

    <!-- Material design icons CSS -->
    <link rel="stylesheet" href="{{URL::to('public/assets/vendor/materializeicon/material-icons.css')}}">

    <!-- swiper carousel CSS -->
    <link rel="stylesheet" href="{{URL::to('public/assets/vendor/swiper/css/swiper.min.css')}}">

    <!-- app CSS -->
    <link id="theme" rel="stylesheet" href="{{URL::to('public/assets/css/style.css')}}" type="text/css">

    <!-- app CSS -->
    <link id="theme" rel="stylesheet" href="{{URL::to('https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css')}}" type="text/css">
    <link id="theme" rel="stylesheet" href="{{URL::to('https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css')}}" type="text/css">
    <link id="theme" rel="stylesheet" href="{{URL::to('https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css')}}" type="text/css">
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

    <title>Chiled Marriage Protect System Dashboard</title>
</head>

<body class="color-theme-blue push-content-right theme-light">
    <div class="loader justify-content-center ">
        <div class="maxui-roller align-self-center">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <div class="wrapper">
        <!-- sidebar left start -->
        <div class="sidebar sidebar-left">
            <div class="profile-link">
                <a href="#" class="media">
                    <div class="w-auto h-100">
                        <figure class="avatar avatar-40"><img src="{{URL::to('')}}/<?php echo $profile_info->image; ?>" alt=""> </figure>
                    </div>
                    <div class="media-body">
                        <h5 class=" mb-0"><?php echo $profile_info->name ; ?><span class="status-online bg-success"></span></h5>
                    </div>
                </a>
            </div>
            <nav class="navbar">
                <ul class="navbar-nav">                    
                    <li class="nav-item">
                        <a href="{{URL::to('adminDashboard')}}" class="sidebar-close">
                            <div class="item-title">
                                <i class="material-icons">home</i> Home
                            </div>
                        </a>
                    </li>

                    <li class="nav-item dropdown" style="display: <?php if($type == 1){echo "";}else{echo "none"; } ?>">
                        <a href="javascript:void(0)" class="item-link item-content dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="item-title">
                                <i class="material-icons">perm_identity</i> Mentor
                            </div>
                        </a>
                        <div class="dropdown-menu">
                            <a href="{{URL::to('addUser')}}" class="sidebar-close  dropdown-item">
                            Add Mentor
                            </a>
                            <a href="{{URL::to('manageUser')}}" class="sidebar-close dropdown-item">
                             Manage Mentor
                            </a>
                        </div>
                    </li>

                    <li class="nav-item dropdown" style="display: <?php if($type == 1){echo "";}else{echo "none"; } ?>">
                        <a href="javascript:void(0)" class="item-link item-content dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="item-title">
                                <i class="material-icons">perm_identity</i> User
                            </div>
                        </a>
                        <div class="dropdown-menu">
                            <?php 
                                $count = DB::table('admin')->where('status',0)->count() ;

                             ?>
                            <a href="{{URL::to('pendingUserList')}}" class="sidebar-close  dropdown-item">
                            Pending User <span style="border-radius: 50%;border:1px solid yellow;padding: 5px; height: 35px;color: red;font-weight: bold;float: right;"><?php echo $count ; ?></span>
                            </a>
                            <a href="{{URL::to('addAppUser')}}" class="sidebar-close dropdown-item">
                                Add User
                            </a>
                            <a href="{{URL::to('rejectUserList')}}" class="sidebar-close dropdown-item">
                                Reject User List
                            </a>
                            <a href="{{URL::to('activeUserList')}}" class="sidebar-close dropdown-item">
                            Active User List
                            </a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a href="javascript:void(0)" class="item-link item-content dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="item-title">
                                <i class="material-icons">description</i> Designation
                            </div>
                        </a>
                        <div class="dropdown-menu">
                            <a href="{{URL::to('addDesignation')}}" class="sidebar-close  dropdown-item">
                            Add Designation
                            </a>
                            <a href="{{URL::to('manageDesignation')}}" class="sidebar-close dropdown-item">
                             Manage Designation
                            </a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a href="javascript:void(0)" class="item-link item-content dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="item-title">
                                <i class="material-icons">menu</i> Union
                            </div>
                        </a>
                        <div class="dropdown-menu">
                            <a href="{{URL::to('addUnion')}}" class="sidebar-close  dropdown-item">
                            Add Union
                            </a>
                            <a href="{{URL::to('manageUnion')}}" class="sidebar-close dropdown-item">
                             Manage Union
                            </a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a href="javascript:void(0)" class="item-link item-content dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="item-title">
                                <i class="material-icons">menu</i> Ward
                            </div>
                        </a>
                        <div class="dropdown-menu">
                            <a href="{{URL::to('addWard')}}" class="sidebar-close  dropdown-item">
                            Add Ward
                            </a>
                            <a href="{{URL::to('manageWard')}}" class="sidebar-close dropdown-item">
                             Manage Ward
                            </a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a href="javascript:void(0)" class="item-link item-content dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="item-title">
                                <i class="material-icons">menu</i> Unit
                            </div>
                        </a>
                        <div class="dropdown-menu">
                            <a href="{{URL::to('addUnit')}}" class="sidebar-close  dropdown-item">
                            Add Unit
                            </a>
                            <a href="{{URL::to('manageUnit')}}" class="sidebar-close dropdown-item">
                             Manage Unit
                            </a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a href="javascript:void(0)" class="item-link item-content dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="item-title">
                                <i class="material-icons">school</i> Institute
                            </div>
                        </a>
                        <div class="dropdown-menu">
                            <a href="{{URL::to('addInstitute')}}" class="sidebar-close  dropdown-item">
                            Add Institute
                            </a>
                            <a href="{{URL::to('manageInstitute')}}" class="sidebar-close dropdown-item">
                             Manage Institute
                            </a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a href="javascript:void(0)" class="item-link item-content dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="item-title">
                                <i class="material-icons">local_hospital</i> Health Organization 
                            </div>
                        </a>
                        <div class="dropdown-menu">
                            <a href="{{URL::to('addHealthOrganization')}}" class="sidebar-close  dropdown-item">
                            Add Health Organization
                            </a>
                            <a href="{{URL::to('manageHealthOrganization')}}" class="sidebar-close dropdown-item">
                             Manage Health Organization
                            </a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a href="javascript:void(0)" class="item-link item-content dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="item-title">
                                <i class="material-icons">device_hub</i> Marriage Register
                            </div>
                        </a>
                        <div class="dropdown-menu">
                            <a href="{{URL::to('addKazi')}}" class="sidebar-close  dropdown-item">
                            Add Marriage Register
                            </a>
                            <a href="{{URL::to('manageKazi')}}" class="sidebar-close dropdown-item">
                             Manage Marriage Register
                            </a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a href="javascript:void(0)" class="item-link item-content dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="item-title">
                                <i class="material-icons">people</i> Founder
                            </div>
                        </a>
                        <div class="dropdown-menu">
                            <a href="{{URL::to('founderInfo')}}" class="sidebar-close  dropdown-item">
                            Founder
                            </a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a href="javascript:void(0)" class="item-link item-content dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="item-title">
                                <i class="material-icons">people</i> Committee
                            </div>
                        </a>
                        <div class="dropdown-menu">
                            <a href="{{URL::to('addCommitteeMember')}}" class="sidebar-close  dropdown-item">
                            Add Committee Member
                            </a>
                            <a href="{{URL::to('manageCommitteeMember')}}" class="sidebar-close dropdown-item">
                             Manage Committee Member
                            </a>
                            <a href="{{URL::to('unionWiseCommitteeMember')}}" class="sidebar-close dropdown-item">
                             Union Wise Committee
                            </a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a href="javascript:void(0)" class="item-link item-content dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="item-title">
                                <i class="material-icons">people</i> Upazila Committee
                            </div>
                        </a>
                        <div class="dropdown-menu">
                            <a href="{{URL::to('addUpazilaCommitteeMember')}}" class="sidebar-close  dropdown-item">
                            Add Committee Member
                            </a>
                            <a href="{{URL::to('manageUpazilaCommitteeMember')}}" class="sidebar-close dropdown-item">
                             Manage Committee Member
                            </a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a href="javascript:void(0)" class="item-link item-content dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="item-title">
                                <i class="material-icons">mail_outline</i> Sms
                            </div>
                        </a>
                        <div class="dropdown-menu">
                            <a href="{{URL::to('sendSms')}}" class="sidebar-close  dropdown-item">
                                Committee Send Sms
                            </a>

                            <a href="{{URL::to('candidatesSmsSend')}}" class="sidebar-close  dropdown-item" >
                                Candidates Send Sms
                            </a>

                            <a href="{{URL::to('childSmsSend')}}" class="sidebar-close  dropdown-item" >
                                Child Send Sms
                            </a>

                            <a href="{{URL::to('userSmsSend')}}" class="sidebar-close  dropdown-item" >
                                App User Send Sms
                            </a>

                            <a href="{{URL::to('instituteSmsSend')}}" class="sidebar-close  dropdown-item" >
                                Institute Send Sms
                            </a>

                            <a href="{{URL::to('organizationSmsSend')}}" class="sidebar-close  dropdown-item" >
                                Organization Send Sms
                            </a>

                            <a href="{{URL::to('manageSendSmsHistory')}}" class="sidebar-close dropdown-item">
                                Manage Send Sms
                            </a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a href="javascript:void(0)" class="item-link item-content dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="item-title">
                                <i class="material-icons">people</i> Candidates
                            </div>
                        </a>
                        <div class="dropdown-menu">
                            <a href="{{URL::to('adminAddStudent')}}" class="sidebar-close  dropdown-item">
                                Add Student
                            </a>
                            <a href="{{URL::to('adminAddChild')}}" class="sidebar-close  dropdown-item">
                                Add Child
                            </a>
                            <a href="{{URL::to('adminCandidateSearch')}}" class="sidebar-close  dropdown-item">
                                Search Candidates
                            </a>
                            <a href="{{URL::to('adminManageCandidates')}}" class="sidebar-close  dropdown-item">
                                Manage Candidates
                            </a>
                            <a href="{{URL::to('adminNewCandidates')}}" class="sidebar-close  dropdown-item">
                                New Candidates
                            </a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a href="javascript:void(0)" class="item-link item-content dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="item-title">
                                <i class="material-icons">settings</i> Settings
                            </div>
                        </a>
                        <div class="dropdown-menu">
                            <a href="{{URL::to('ageSettings')}}" class="sidebar-close  dropdown-item">
                            Age Settings
                            </a>
                        </div>
                    </li>

                </ul>
            </nav>
            <div class="profile-link text-center">
                <a href="{{URL::to('adminLogout/')}}">
                    <button type="button" class="btn btn-success" onclick="return confirm('Are You Sure You Want To Logout ?')" >Logout</button>
                </a>
            </div>
        </div>
        <!-- sidebar left ends -->

        <!-- page main start -->
        <div class="page">
            <form class="searchcontrol">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button type="button" class="input-group-text close-search"><i class="material-icons">keyboard_backspace</i></button>
                    </div>
                    <input type="email" class="form-control border-0" placeholder="Search..." aria-label="Username">
                </div>
            </form>
            <header class="row m-0 fixed-header">
                <div class="left">
                    <a href="javascript:void(0)" class="menu-left"><i class="material-icons">menu</i></a>
                </div>
                <div class="col center">
                    <a href="{{URL::to('adminDashboard')}}" class="logo">
                        <figure><img src="{{URL::to('public/assets/img/bd_logo.png')}}" alt=""></figure></a>
                </div>
                <div class="right">
                    <a href="{{URL::to('profile')}}"><i class="material-icons">person</i></a>
                </div>
            </header>

            <div class="page-content">

                <!-- get content  -->
                @yield ('content')

                <div class="footer-wrapper shadow-15">
                    <div class="footer dark">
                        <div class="row mx-0">
                            <div class="col  text-center">
                                Copyright @<?php echo date('Y') ; ?> UNO Sirajganj, Developed By : Asian It Inc .
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- page main ends -->

    </div>




    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{URL::to('public/assets/js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{URL::to('public/assets/js/popper.min.js')}}"></script>
    <script src="{{URL::to('public/assets/vendor/bootstrap-4.1.3/js/bootstrap.min.js')}}"></script>

    <!-- Cookie jquery file -->
    <script src="{{URL::to('public/assets/vendor/cookie/jquery.cookie.js')}}"></script>

    <!-- sparklines chart jquery file -->
    <script src="{{URL::to('public/assets/vendor/sparklines/jquery.sparkline.min.js')}}"></script>

    <!-- Circular progress gauge jquery file -->
    <script src="{{URL::to('public/assets/vendor/circle-progress/circle-progress.min.js')}}"></script>

    <!-- Swiper carousel jquery file -->
    <script src="{{URL::to('public/assets/vendor/swiper/js/swiper.min.js')}}"></script>

    <!-- Application main common jquery file -->
    <script src="{{URL::to('public/assets/js/main.js')}}"></script>
    <!-- page specific script -->

    <!-- data table js  -->
    <script src="{{URL::to('https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::to('https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{URL::to('https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::to('https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{URL::to('public/assets/js/gijgo.min.js')}}"></script>

    <!-- page specific script -->
    <script>
        $(window).on('load', function() {
            /* sparklines */
            $(".dynamicsparkline").sparkline([5, 6, 7, 2, 0, 4, 2, 5, 6, 7, 2, 0, 4, 2, 4], {
                type: 'bar',
                height: '25',
                barSpacing: 2,
                barColor: '#a9d7fe',
                negBarColor: '#ef4055',
                zeroColor: '#ffffff'
            });

            /* gauge chart circular progress */
            $('.progress_profile1').circleProgress({
                fill: '#169cf1',
                lineCap: 'butt'
            });
            $('.progress_profile2').circleProgress({
                fill: '#f4465e',
                lineCap: 'butt'
            });
            $('.progress_profile4').circleProgress({
                fill: '#ffc000',
                lineCap: 'butt'
            });
            $('.progress_profile3').circleProgress({
                fill: '#00c473',
                lineCap: 'butt'
            });
            $('.progress_profile5').circleProgress({
                fill: '#ffffff',
                lineCap: 'butt'
            });

            /*Swiper carousel */
            var mySwiper = new Swiper('.swiper-container', {
                slidesPerView: 2,
                spaceBetween: 0,
                autoplay: {
                    delay: 1500,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                }
            });
            /* tooltip */
            $(function() {
                $('[data-toggle="tooltip"]').tooltip()
            });
        });

        $(document).ready(function() {
            $('#example').DataTable();
        } );

        $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4'
        });

    </script>
</body>
</html>
 @yield ('js')
