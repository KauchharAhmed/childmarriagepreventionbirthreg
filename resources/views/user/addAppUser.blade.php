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
                                <h5 class="card-title text-uppercase">Add New App User</h5>
                            </div>
                        </div>
                    </div>
                    {!! Form::open(['url' =>'addAppUserInfo','method' => 'post','role' => 'form','class'=>'form-horizontal','files' => true]) !!}
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
                                <label class="text-secondary">Select Type<span style="color: red;">*</span></label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <select class="form-control"  id="type" name="type" required="" style="border-radius: 0px;"> 
                                        <option value="">Select User Type</option>
                                        <option value="3">Educational institutions</option>
                                        <option value="4">Health Organization</option>
                                        <option value="6">Union Digital Center</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="udc" style="display: none;">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Select Union <span style="color: red;">*</span></label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <select class="form-control" name="union_id" >
                                        <option value="">Select Union</option>
                                        <?php foreach ($all_union as $union_value) { ?>
                                            <option value="<?php echo $union_value->id ; ?>"><?php echo $union_value->union_name ; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="institute_name" style="display: none;">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Select Institute <span style="color: red;">*</span></label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <select class="form-control" name="institute_id" >
                                      <option value="">Select Institute</option>
                                        <?php foreach ($all_institute as $in_value) { ?>
                                        <option value="<?php echo $in_value->id ; ?>"><?php echo $in_value->institute_name ; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="healthOrganization" style="display: none;">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Select Health Organization <span style="color: red;">*</span></label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <select class="form-control" name="organization_id">
                                        <option value="">Select Health Organization</option>
                                        <?php foreach ($all_organization as $or_value) { ?>
                                            <option value="<?php echo $or_value->id ; ?>"><?php echo $or_value->organization_name ; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Full Name <span style="color: red;">*</span></label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <input type="text" class="form-control active" name="name" required="">
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
                                <label class="text-secondary">Mobile Number <span style="color: red;">( User Login Id ) *</span></label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <input type="text" class="form-control active" name="mobile" required="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Email</label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <input type="text" class="form-control active" name="email">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Address </label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <textarea name="address" class="form-control" placeholder="Address"></textarea>
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

@section('js')
<script>
    $("#type").change(function(e){
        e.preventDefault() ;
        var type = $(this).val() ;

        if (type == 3) {
            $("#institute_name").removeAttr('style') ;
            $("#healthOrganization").attr('style', 'display: none');
            $("#udc").attr('style', 'display: none');
        }else if(type == 4){
            $("#healthOrganization").removeAttr('style') ;
            $("#institute_name").attr('style', 'display: none');
            $("#udc").attr('style', 'display: none');
        }else{
            $("#udc").removeAttr('style') ;
            $("#institute_name").attr('style', 'display: none');
            $("#healthOrganization").attr('style', 'display: none');
        }
    });
</script>
@endsection
