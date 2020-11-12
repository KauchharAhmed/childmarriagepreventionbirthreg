@extends('health.masterOrganization')
@section('content')
<div class="content-sticky-footer">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card rounded-0 border-0 mb-3">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-7">
                                <h5 class="card-title text-uppercase">Update Profile Info</h5>
                            </div>
                        </div>
                    </div>
                    {!! Form::open(['url' =>'updateOrganizationProfileInfo','method' => 'post','role' => 'form','class'=>'form-horizontal','files' => true]) !!}
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
                                <label class="text-secondary">Full Name <span style="color: red;">*</span></label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <input type="text" class="form-control active" name="name" value="<?php echo $value->name ; ?>" required="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Designation</label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <input type="text" class="form-control active" name="designation" value="<?php echo $value->designation ; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Mobile Number <span style="color: red;">( User Login Id ) *</span></label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <input type="text" class="form-control active" name="mobile" value="<?php echo $value->mobile ; ?>" required="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Email</label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <input type="text" class="form-control active" name="email" value="<?php echo $value->email ; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Profile Image</label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <img src="{{URL::to('')}}/<?php echo $value->image ; ?>" alt="" style="width: 80px;height:80px;">
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Profile Image <span style="color: red;">( Image Size Maximum 500kb and Image type jpg,jpeg,png ) *</span></label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                   <input type="file" class="form-control" name="images">
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="primary_id" value="<?php echo $value->id ; ?>">

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