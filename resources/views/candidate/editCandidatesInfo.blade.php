@extends('admin.masterAdmin')
@section('content')
<div class="content-sticky-footer">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card rounded-0 border-0 mb-3">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-7">
                                <h5 class="card-title text-uppercase">Edit Candidates Info</h5>
                            </div>
                        </div>
                    </div>
                    {!! Form::open(['url' =>'updateCandidatesInfo','method' => 'post','role' => 'form','class'=>'form-horizontal','files' => true]) !!}
                    <div class="card-body">
                        <h6 class="f-light mb-3" style="color: red;padding-left: 18px;">Star Mark Filed Is Requried.</h6>
                            <br>
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
                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Select Union <span style="color: red;">*</span></label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <select class="form-control" name="union_id" id="union_id" required="">
                                      <option value="">Select Union</option>
                                      <?php foreach ($all_union as $value2) { ?>
                                          <option value="<?php echo $value2->id ; ?>" <?php if($value->union_id == $value2->id){echo "selected" ;} ?>><?php echo $value2->union_name ; ?></option>
                                      <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Select Ward </label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label" >
                                    <select class="form-control spinner" name="ward_id" id="ward_id" >
                                        <option value="<?php echo $value->ward_id ?>"><?php echo $value->ward_name ; ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Select Institute</label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label" >
                                    <select class="form-control spinner" name="institute_id" id="institute_id" >
                                        <option value="">Select Institute</option>
                                        <?php foreach ($all_institute as $value3) { ?>
                                            <option value="<?php echo $value3->id ?>" <?php if($value->institute_id == $value3->id){echo "selected" ;} ?>><?php echo $value3->institute_name ; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Student Name<span style="color: red;">*</span></label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <input type="text" class="form-control active" name="name" value="<?php echo $value->name ; ?>" required="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Father Name<span style="color: red;">*</span></label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <input type="text" class="form-control active" name="father_name" value="<?php echo $value->father_name ; ?>" required="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Mother Name<span style="color: red;">*</span></label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <input type="text" class="form-control active" name="mother_name" value="<?php echo $value->mother_name ; ?>" required="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Select Gender <span style="color: red;">*</span></label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label" >
                                    <select class="form-control spinner" name="gender" required="">
                                        <option value="">Gender</option>
                                        <option value="1" <?php if($value->gender == 1){echo "selected" ;} ?>>Male</option>
                                        <option value="2" <?php if($value->gender == 2){echo "selected" ;} ?>>Female</option>
                                        <option value="3" <?php if($value->gender == 3){echo "selected" ;} ?>>Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Birth Registration </label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <input type="text" class="form-control active" name="birth_reg_no" value="<?php echo $value->birth_reg_no ; ?>" >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Date Of Birth (Date/Month/Year)<span style="color: red;">*</span></label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <input type="text" class="form-control active" name="dob" id="datepicker" value="<?php echo date('d/m/Y',strtotime($value->dob)) ?>" required="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Contact Number<span style="color: red;">*</span></label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <input type="text" class="form-control active" name="contact_number" value="<?php echo $value->contact_number ; ?>" required="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Village<span style="color: red;">*</span></label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                   <input type="text" class="form-control active" name="address" value="<?php echo $value->address ; ?>" required="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Current Image<span style="color: red;">*</span></label>
                            </div>
                            <div class="col-12">
                                <img src="{{URL::to('')}}/<?php echo $value->image; ?>" alt="" style="width: 150px;height: 150px;display: <?php if($value->image == ""){echo "none";}else{echo "";} ?>" > 
                                <img  src="{{URL::to('images/avatar.png')}}" alt="" style="width: 150px;height: 150px;display: <?php if($value->image == ""){echo "";}else{echo "none";} ?>"> 
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 w-100">
                                <label style="font-size: 15px;">Profile Image <span style="color: #ff5555;">( Image Size Maximum 500kb and Image type jpg,jpeg,png ) *</span></label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <input type="file" class="form-control active" name="image">
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="primary_id" value="<?php echo $value->id ; ?>">

                        <br>
                        <button class="btn btn-primary mb-1 btn-block">Update</button>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
</div>
@endsection

@section('js')
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
            url:"{{ url('/getWardByUnion') }}",
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
</script>
@endsection
