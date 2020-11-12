<?php
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
        $device = "phone";
    }else{
        $device = "pc";
    }
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <title>Chiled Marriage Prevention System</title>
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
    <script src="https://kit.fontawesome.com/00f716036d.js" crossorigin="anonymous"></script>

</head>

<body class="color-theme-blue">
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
        <!-- page main start -->
        <div class="page">
            <div class="page-content h-100">
                <div class="background theme-header" style="height: 1000px;"></div>
                <div class="row mx-0  justify-content-center">
                    <div class="col-10 col-md-6 col-lg-4 my-3 mx-auto text-center align-self-center">

                        <img src="{{URL::to('images/unoSir.png')}}" width="120" height="auto" alt="">
                        <br>
                        <br>
                        <p style="color:#fff;text-align:justify;">
                        বাল্যবিবাহ একটা সামাজিক ব্যাধি, দেশ ও জাতির উন্নয়ন সমৃদ্ধিতে এক বড় অন্তরায়; লোভে পড়ে, আবেগের বশে, সচেতনতার অভাবে, সামাজিক সমস্যা কবলিত হয়ে, উৎপাতের মুখে পড়ে অনেক সময়ই অভিভাবকগণ বাল্যবিবাহ দিয়ে থাকেন; কিন্তু অল্প কিছুদিন যেতে না যেতেই নববিবাহিত সংসারে নানাবিধ শারীরিক ও মানসিক সমস্যা দানা বাঁধে, জার করুণ পরিণতি হয় নিরজাতন, ডিভোর্স কিংবা মৃত্যু, পড়ালেখা করে প্রাপ্ত বয়স্ক হয়ে যে সংসার করে হাস্যজ্জ্বল পরিবার গড়ার কথা সে এখন দিন গুনে সমাজ থেকে পালিয়ে বেড়ানোর চেষ্টায়, অনেক সময় অভিভাবকদের বোধোদয় হয় কিন্তু তখন আর সময় থাকে না / বিয়ে যেহেতু সামাজিক ব্যাপার তাই সমাজ যখন সহযোগিতা করবেনা তখন আমরা প্রতিরোধ বা প্রতিকারের ব্যবস্থা নেব/ আমরা যারা ছেলে আছি তারা শপথ নিই যে, “নাবালিকা কোন মেয়েকে বিয়ে করবনা, বিয়ে দিতে প্ররোচনা দিবনা এবং ছেলের অভিভাবক হিসেবে কোন অবস্থাতেই নাবালিকা মেয়ের সাথে বিয়ে দিবনা”/ আর আমরা যারা মেয়ে আছি তারা দৃঢ় শপথ নিই যে, “ সাবালিকা(১৮ বছর) না হওয়া পর্যন্ত কোন ক্রমেই বিয়ে করবনা, মেয়েকে বিয়ে দিতে বাধ্য করবনা”/ আমরা চেষ্টা করে যখন বিয়ে বন্ধ করতে পারবনা তখন এই অ্যাপস এর সহযোগিতা নিব, আমরা সবসময়ই পাশে আছি, কেবলমাত্র একটা মেসেজ আসলেই আমরা তাৎক্ষণিক ব্যবস্থা গ্রহণ করব। জাতির পিতা বঙ্গবন্ধু শেখ মুজিবুর রহমানের স্বপ্নের সোনার বাংলা, বর্তমান সরকারের ভিশন ডিজিটাল বাংলাদেশ বিনির্মাণ এবং আমার আপনার প্রিয় বাংলাদেশকে উন্নত বাংলাদেশ হিসেবে গড়ে তুলতে আপনাদের সবার সহযোগিতা কামনা করছি/ অ্যাপস তৈরিতে মূল্যবান পরামর্শ ও আন্তরিক সহযোগিতা প্রদানের জন্য শ্রদ্ধেয় জেলা প্রশাসক সিরাজগঞ্জ ড. ফারুক আহাম্মদ স্যারকে জানাই আন্তরিক কৃতজ্ঞতা ও ধন্যবাদ ।
                        </p>
                        <p style="color:#fff;text-align:right;padding:0px;">সরকার অসীম কুমার<br>উপজেলা নির্বাহী অফিসার<br>সিরাজগঞ্জ সদর, সিরাজগঞ্জ।</p>
                    </div>
                </div>
                <hr>
                <div class="row" style="margin-top: 20px;"> 
                    <div class="col-10 col-md-6 col-lg-4 my-3 mx-auto text-center align-self-center">
                        <div class="row">
                            <div class="col-md-6" style="color: white;">
                              কারিগরি সহযোগিতায়ঃ <br>
                              আমিনুল ইসলাম <br>
                              (উপজেলা টেকনিশিয়ান)
                            </div>
                            <div class="col-md-6 developer" style="color: white;font-family: arial;">
                                Developed By:
                                <a href="http://www.asianitinc.com" target="_new"><b>ASIAN IT INC.</b></a>
                                <center><img src="{{URL::to('images/logo.png')}}" style="margin-top: 5px;"></center>
                            </div>
                        </div>
                    </div>
                </div>

                <br>
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

</body>
</html>