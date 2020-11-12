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
                                <h5 class="card-title text-uppercase">Add New Committee Member</h5>
                            </div>
                        </div>
                    </div>
                    {!! Form::open(['url' =>'addCommitteeMemberInfo','method' => 'post','role' => 'form','class'=>'form-horizontal','files' => true]) !!}
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
                                <label class="text-secondary">Union<span style="color: red;">*</span></label>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <select class="form-control" name="union_id" required="">
                                      <option value="">Select Union</option>
                                      <?php foreach ($all_union as $value) { ?>
                                          <option value="<?php echo $value->id ; ?>"><?php echo $value->union_name ; ?></option>
                                      <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Committee Designation<span style="color: red;">*</span></label>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <select class="form-control" name="designation_id" required="">
                                      <option value="">Select Designation</option>
                                      <?php foreach ($all_designation as $value2) { ?>
                                          <option value="<?php echo $value2->id ; ?>"><?php echo $value2->designation_name ; ?></option>
                                      <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>        
                        <div class="row">
                            <div class="col-12 w-100">
                            <label class="text-secondary">Member Name<span style="color: red;">*</span></label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                 <input type="text" class="form-control active" name="member_name" required="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Organization Name <span style="color: red;">*</span></label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <input type="text" class="form-control active" name="organization_name">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Designation <span style="color: red;">*</span></label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <input type="text" class="form-control active" name="designation">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Mobile Number<span style="color: red;">*</span></label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <input type="number" class="form-control active" name="mobile" required="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Village</label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <input type="text" class="form-control active" name="village" >
                                </div>
                            </div>
                        </div>

                        <br>
                        <button class="btn btn-primary mb-1 btn-block">SUBMIT</button>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
</div>
@endsection
