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
                                <h5 class="card-title text-uppercase">Manage Mentor List</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
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

                        <div class="table table-responsive">
                            <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#sl</th>
                                    <th>Full Name</th>
                                    <th>Designation</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Image</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $j = 1 ; foreach ($result as $value) { ?>
                                    <tr>
                                        <td><?php echo $j++ ; ?></td>
                                        <td><?php echo $value->name; ?></td>
                                        <td><?php echo $value->designation ; ?></td>
                                        <td><?php echo $value->mobile ; ?></td>
                                        <td><?php echo $value->email ; ?></td>
                                        <td><img src="{{URL::to('')}}/<?php echo $value->image ; ?>" alt="" style="width: 50px;height:50px;"></td>
                                        <td>
                                            <?php if($value->type == 1){echo "Admin"; }else{echo "User"; } ?>
                                        </td>

                                        <td>
                                            <a href="{{URL::to('changeUserStatus/'.$value->id)}}">
                                                <button type="button" class="btn <?php if($value->status == 1){echo "btn-success btn-sm"; }else{echo "btn-danger btn-sm"; } ?>" onclick="return confirm('Are You Sure You Want To Change Status ?')"><?php if($value->status == 1){echo "Active"; }else{echo "In Active"; } ?></button>
                                            </a>
                                        </td>

                                        <td>
                                            <a href="{{URL::to('editUser/'.$value->id)}}" title="">
                                                <button type="button" class="btn btn-info btn-sm">EDIT</button>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
</div>
@endsection
