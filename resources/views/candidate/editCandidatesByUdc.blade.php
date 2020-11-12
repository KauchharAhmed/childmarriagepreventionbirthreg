@extends('udc.masterUdc')
@section('content')
<div class="content-sticky-footer">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card rounded-0 border-0 mb-3">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-7">
                                <h5 class="card-title text-uppercase">Edit Canidates</h5>
                            </div>
                        </div>
                    </div>
                    {!! Form::open(['url' =>'updateCandidatesByUdc','method' => 'post','role' => 'form','class'=>'form-horizontal','files' => true]) !!}
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
                                <label class="text-secondary">Select Institute</label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label" >
                                    <select class="form-control" name="institute_id">
                                      <option value="">Select Institute</option>
                                      <?php foreach ($all_institute as $value2) { ?>
                                          <option  value="<?php echo $value2->id ; ?>"<?php if($row->institute_id == $value2->id){echo "selected";}else{echo ""; } ?>><?php echo $value2->institute_name ; ?></option>
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
                                    <input type="text" class="form-control active" name="name" value="<?php echo $row->name; ?>" required="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Father Name<span style="color: red;">*</span></label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <input type="text" class="form-control active" name="father_name" value="<?php echo $row->father_name; ?>" required="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Mother Name<span style="color: red;">*</span></label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <input type="text" class="form-control active" name="mother_name" value="<?php echo $row->mother_name; ?>" required="">
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
                                        <option value="1" <?php if($row->gender == 1){echo "selected" ;} ?>>Male</option>
                                        <option value="2" <?php if($row->gender == 2){echo "selected" ;} ?>>Female</option>
                                        <option value="3" <?php if($row->gender == 3){echo "selected" ;} ?>>Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Contact Number<span style="color: red;">(Must Be English)*</span></label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <input type="text" class="form-control active" name="contact_number" value="<?php echo $row->contact_number; ?>" required="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Birth Reg No </label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <input type="text" class="form-control active" name="contact_number" value="<?php echo $row->birth_reg_no; ?>" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Village<span style="color: red;">*</span></label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                   <input type="text" class="form-control active" name="address" value="<?php echo $row->address; ?>" required="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Current Image </label>
                            </div>
                            <div class="col-12">
                                <img src="{{URL::to('')}}/<?php echo $row->image; ?>" alt="" style="width: 150px;height: 150px;display: <?php if($row->image == ""){echo "none";}else{echo "";} ?>" > 
                                <img  src="{{URL::to('images/avatar.png')}}" alt="" style="width: 150px;height: 150px;display: <?php if($row->image == ""){echo "";}else{echo "none";} ?>"> 
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

                        <input type="hidden" name="id" value="<?php echo $row->id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $row->image; ?>">

                        <br>
                        <button class="btn btn-primary mb-1 btn-block">UPDATE</button>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
</div>
@endsection

