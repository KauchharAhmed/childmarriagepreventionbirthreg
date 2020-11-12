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
                                <h5 class="card-title text-uppercase">Send Message</h5>
                            </div>
                        </div>
                    </div>
                    {!! Form::open(['id' => 'send_button','method' => 'post','role' => 'form','class'=>'form-horizontal','files' => true]) !!}
                    <div class="card-body">
                        <h6 class="f-light mb-3" style="color: red">Star Mark Filed Is Requried.</h6>
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

                        <p class="text-success" id="success_message" style="display: none;">Message Successfully Send</p>

                        <div class="row">
                            <div class="col-12 w-100">
                                <label class="text-secondary">Union / Pourosova<span style="color: red;">*</span></label>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <select class="form-control" id="union_id" name="union_id" required="">
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
                                <label class="text-secondary">Message<span style="color: red;">*</span></label>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-label">
                                   <textarea class="form-control" rows="3" id="message" name="message" required=""></textarea>
                                </div>
                            </div>
                        </div>

                        <br>
                        <button class="btn btn-primary mb-1 btn-block" id="send_submit">SEND</button>
                        <center>
                            <img src="{{URL::to('images/sending.gif')}}" id="sending" alt="" style="display: none ;">
                        </center>
                        
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
    $("#send_submit").click(function(e){
        e.preventDefault();

        var union_id    = $("#union_id").val() ;
        var message     = $("#message").val() ;

        $("#sending").removeAttr("style");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:'post',
            url:"{{ url('/smsSendingInfo') }}",
            async: false,
            dataType:'text',
            cache: false,
            data:{
                'union_id':union_id,
                'message':message,
            },
            success:function(data){
                if (data == 2) {
                    alert("Sorry ! Not Sufficient Sms Credit") ;
                    return false;
                }else if(data == 3){
                    alert("Sorry ! No Committee Member Found.") ;
                    return false ;
                }else{
                    alert("Message Successfully Send") ;
                    location.reload();
                } 
            }
        });
    })
</script>
@endsection