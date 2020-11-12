<?php
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
    <title>বাল্য বিবাহ প্রতিরোধ ব্যবস্থা</title>
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

<body class="color-theme-blue" style="font-family: SolaimanLipi ;">
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
                <div class="background theme-header" style="height: 850px"></div>
                <div class="row mx-0 justify-content-center">
                    <div class="col-10 col-md-6 col-lg-4 my-3 mx-auto text-center align-self-center">
                    	<h3 style="color:#fff;">বাল্য বিবাহ প্রতিরোধ</h3>
                    	<hr>
                        <h6 style="color:#ff8585;text-align: left;">সকল তথ্য ইংলিশ এ লিখতে হবে</h6>

                         @if (count($errors) > 0)
                            <div class="alert alert-danger">
                            <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                             @endforeach
                            </ul>
                        </div>
                        @endif
                        <?php if(Session::get('success') != null) { ?>
                           <div class="alert alert-info alert-dismissible" role="alert">
                          <a href="#" class="fa fa-times" data-dismiss="alert" aria-label="close"></a>
                          <strong><?php echo Session::get('success') ;  ?></strong>
                          <?php Session::put('success',null) ;  ?>
                        </div>
                        <?php } ?>
                        <?php
                        if(Session::get('failed') != null) { ?>
                         <div class="alert alert-danger alert-dismissible" role="alert">
                          <a href="#" class="fa fa-times" data-dismiss="alert" aria-label="close"></a>
                         <strong><?php echo Session::get('failed') ; ?></strong>
                         <?php echo Session::put('failed',null) ; ?>
                        </div>
                        <?php } ?>

                        {!! Form::open(['id' =>'sendMessage','method' => 'post','role' => 'form','class'=>'form-horizontal','files' => true]) !!}

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <input type="text" class="form-control active" name="name" placeholder="নাম" required="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <input type="text" class="form-control active" name="father_name" placeholder="পিতার নাম" required="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <input type="text" class="form-control active" name="age" placeholder="বয়স" required="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <input type="text" class="form-control active" name="village" placeholder="গ্রাম" required="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <select class="form-control" name="union_id" id="union_id" required="">
                                      <option value="">ইউনিয়ন নির্বাচন করুন</option>
                                      <?php foreach ($result as $value) { ?>
                                          <option value="<?php echo $value->id ; ?>"><?php echo $value->union_name ; ?></option>
                                      <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group float-label" >
                                    <select class="form-control spinner" name="ward_id" id="ward_id">
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <input type="text" class="form-control active" name="institute_name" placeholder="শিক্ষাপ্রতিষ্ঠান এর নাম">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                            	<div class="radio" style="float: left;">
								  <label style="color: white"><input type="radio" name="reason" value="Forcibly marrying from family." checked="">&nbsp;&nbsp;জোর করে পরিবার থেকে বিয়ে দিচ্ছে</label>
								</div>
								<div class="radio" style="float: left;">
								  <label style="color: white"><input type="radio" name="reason" value="Culprit Problem">&nbsp;&nbsp;এলাকার বখাটেদের উৎপাতে বিয়ে দিতে হচ্ছে</label>
								</div>
								<br>
								<br>
								<br>
								<div class="radio" style="float: left;">
								  <label style="color: white"><input type="radio" name="reason" value="Others">&nbsp;&nbsp;অন্যান্য</label>
								</div>
                            </div>
                        </div>



                        <br>
                        <button class="btn btn-primary mb-1 btn-block">পাঠান</button>
                        <img src="{{URL::to('images/6.gif')}}" alt="" style="display: none;" id="loading">


                        {!! Form::close() !!}
                    </div>
                </div>
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

    <script>
    $("#union_id").click(function(e){
        e.preventDefault();

        var union_id    = $(this).val() ;

        $("#sending").removeAttr("style");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:'post',
            url:"{{ url('/getWardByUnionForFront') }}",
            async: false,
            dataType:'text',
            cache: false,
            data:{
                'union_id':union_id
            },
            success:function(data){
                $("#ward_id").empty() ;
                $("#ward_id").html(data) ;
            }
        });
    });

    $("#sendMessage").submit(function(e){
        e.preventDefault();

        var name            = $("[name=name]").val() ;
        var father_name     = $("[name=father_name]").val() ;
        var age             = $("[name=age]").val() ;
        var village         = $("[name=village]").val() ;
        var union_id        = $("[name=union_id]").val() ;
        var ward_id         = $("[name=ward_id]").val() ;
        var institute_name  = $("[name=institute_name]").val() ;
        var reason          = $("[name=reason]").val() ;

        $("#loading").removeAttr("style");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:'post',
            url:"{{ url('/sendMessageByUser') }}",
            async: false,
            dataType:'text',
            cache: false,
            data:{
                'name':name,
                'father_name':father_name,
                'age':age,
                'village':village,
                'union_id':union_id,
                'ward_id':ward_id,
                'institute_name':institute_name,
                'reason':reason
            },
            success:function(data){
                alert(data);
                window.location.reload();
            }
        });
    });
</script>

</body>
</html>