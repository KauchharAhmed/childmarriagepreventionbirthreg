@extends('udc.masterUdc')
@section('content')
<div class="content-sticky-footer">
    <div class="container">
        <div class="row">
            <div class="col-4">
                <div class="card rounded-0 border-0 mb-3">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-7">
                                <h5 class="card-title text-uppercase">Send SMS</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        
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
                        {!! Form::open(['id' =>'ss','method' => 'post','role' => 'form','class'=>'form-horizontal','files' => true]) !!}
                        <div class="row">
                            <div class="col-md-12">
                                <textarea class="form-control" name="message" id="message" style="height: 150px;width:250px;" required=""></textarea>
                            </div>
                            <div class="col-md-12" style="margin-top: 20px;">
                                <button type="submit" class="btn btn-success" id="send_sms">Send</button>
                                <img src="{{URL::to('images/sending.gif')}}" width="50" height="50" style="display:none;" id="loader2">
                            </div>
                        </div>
                        </form>
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
    $('body').on('click',"#send_sms",function(e){
        e.preventDefault() ;
        var message         = $('#message').val();

        if (message == "") {
            alert("Write SMS Body First");
            return false ;
        }

        $( "#send_sms" ).prop( "disabled", true );

        $('#loader2').removeAttr( 'style' );

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/sendSMSByUDCForCandidates') }}",
            'type':'post',
            'dataType':'text',
            data:{  
                message:message,
            },
            success:function(data)
            {   
                if (data == "success") {
                    alert("Message Successfully Send.");
                    location.reload();
                }else{
                    alert("Not Available SMS Balance Check It.");
                    $('#loader2').attr("style", "display: none;");
                   // Enable #x
                    $( "#send_sms" ).prop( "disabled", false );
                   return false ;
                }

            }
        });
    });
</script>
@endsection
