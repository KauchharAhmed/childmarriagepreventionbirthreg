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
                                <h5 class="card-title text-uppercase">Send SMS Health Organization</h5>
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
                            <div class="col-md-3">
                                <textarea class="form-control" name="message" id="message" style="height: 150px;width:250px;" required=""></textarea>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-success" id="send_sms">Send</button>
                                <img src="{{URL::to('images/sending.gif')}}" width="50" height="50" style="display:none;" id="loader2">
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="table table-responsive">
                            <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Select</th>
                                    <th>Organization Name</th>
                                    <th>Mobile</th>
                                    <th>Union</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="radio" class="checkall"></td>
                                    <td>Select All</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <?php $j = 1 ; foreach ($result as $value) { ?>
                                    <tr>
                                        <td><input type="checkbox" name="member_id[]" value="<?php echo $value->id.'.'.$value->contact_number; ?>"></td>
                                        <td><?php echo $value->organization_name; ?></td>
                                        <td><?php echo $value->contact_number ; ?></td>
                                        <td><?php echo $value->union_name ; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        </form>
                        </div>
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

    $(document).ready(function(){
        $('body').on('click',".checkall",function(e){
            $('input[type="checkbox"]').not(this).prop('checked', this.checked);
        });
    })  
</script>

<script>
    $('body').on('click',"#send_sms",function(e){
        e.preventDefault() ;
        var message         = $('#message').val();

        var selected = new Array();
        //Reference the CheckBoxes and insert the checked CheckBox value in Array.
        $("#example input[type=checkbox]:checked").each(function () {
            selected.push(this.value);
        });

        var length1 = selected.length;

        if (length1 == 0) {
            alert("Select At list One Person");
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
            'url':"{{ url('/sendSMSbyAdminOrganization') }}",
            'type':'post',
            'dataType':'text',
            data:{  
                selected:selected,
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
