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
                                <h5 class="card-title text-uppercase">Add Unit</h5>
                            </div>
                        </div>
                    </div>
                    {!! Form::open(['url' =>'addUnitInfo','method' => 'post','role' => 'form','class'=>'form-horizontal','files' => true]) !!}
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
                                      <?php foreach ($all_union as $value) { ?>
                                          <option value="<?php echo $value->id ; ?>"><?php echo $value->union_name ; ?></option>
                                      <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Select Ward <span style="color: red;">*</span></label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label" >
                                    <select class="form-control spinner" name="ward_id" id="ward_id" >
                                    </select>
                                </div>
                            </div>
                        </div>

                        

                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Unit Name <span style="color: red;">*</span></label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                    <input type="text" class="form-control active" name="unit_name" placeholder="Unit Name" required="">
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
    })
</script>
@endsection
