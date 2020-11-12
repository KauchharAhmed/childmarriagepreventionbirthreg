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

    $profile_info = DB::table('admin')->where('id',$admin_id)->where('type',$type)->first();

    if($type != 4){
        return Redirect::to('/')->send();
        exit();
    }

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
                        <figure class="avatar avatar-40">
                            <img src="{{URL::to('')}}/<?php echo $profile_info->image; ?>" alt="" style="display: <?php if($profile_info->image == ""){echo "none";}else{echo "";} ?>"> 
                            <img src="{{URL::to('images/avatar.png')}}" alt="" style="display: <?php if($profile_info->image == ""){echo "";}else{echo "none";} ?>"> 
                        </figure>
                    </div>
                    <div class="media-body">
                        <h5 class=" mb-0"><?php echo $profile_info->name ; ?><span class="status-online bg-success"></span></h5>
                    </div>
                </a>
            </div>
            <nav class="navbar">
                <ul class="navbar-nav">                    
                    <li class="nav-item">
                        <a href="{{URL::to('organizationDashboard')}}" class="sidebar-close">
                            <div class="item-title">
                                <i class="material-icons">home</i> Home
                            </div>
                        </a>
                    </li>


                    <li class="nav-item dropdown">
                        <a href="javascript:void(0)" class="item-link item-content dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="item-title">
                                <i class="material-icons">supervisor_account</i> Candidates
                            </div>
                        </a>
                        <div class="dropdown-menu">
                            <a href="{{URL::to('addOrgStudent')}}" class="sidebar-close  dropdown-item">
                            Add Student
                            </a>
                            <a href="{{URL::to('addOrgChild')}}" class="sidebar-close  dropdown-item">
                            Add Child
                            </a>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a href="{{URL::to('manageCandiatesByOrganization')}}" class="sidebar-close">
                            <div class="item-title">
                                <i class="material-icons">search</i> Search Candidates
                            </div>
                        </a>
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
                    <a href="{{URL::to('organizationDashboard')}}" class="logo">
                        <figure><img src="{{URL::to('public/assets/img/bd_logo.png')}}" alt=""></figure></a>
                </div>
                <div class="right">
                    <a href="{{URL::to('organizationProfile')}}"><i class="material-icons">person</i></a>
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
