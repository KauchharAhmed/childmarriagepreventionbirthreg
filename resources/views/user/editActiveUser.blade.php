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
                                <h5 class="card-title text-uppercase">Edit App User</h5>
                            </div>
                        </div>
                    </div>
                    {!! Form::open(['url' =>'updateActiveUserInfo','method' => 'post','role' => 'form','class'=>'form-horizontal','files' => true]) !!}
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
                                    <input type="text" class="form-control active" name="name" value="<?php echo $row->name; ?>" required="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Designation <span style="color: red;">*</span></label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <input type="text" class="form-control active" name="designation" value="<?php echo $row->designation; ?>" required="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Email</label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <input type="text" class="form-control active" name="email" value="<?php echo $row->email; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Mobile</label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <input type="text" class="form-control active" name="mobile" value="<?php echo $row->mobile; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Address </label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <textarea name="address" class="form-control" placeholder="Address"><?php echo $row->address; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Current Profile Image </label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                   <img src="{{URL::to('')}}/<?php echo $row->image ; ?>" alt="" style="width: 100px;height:100px;border-radius:50%;">
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
