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
                                <h5 class="card-title text-uppercase">Search Candidates</h5>
                            </div>
                        </div>
                    </div>
                    <form class="form-horizontal">

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-4">      
                                <div class="col-12 w-100">
                                    <label class="text-secondary">Select Union / Pourosova</label>
                                </div>
                                <div class="col-12">
                                    <div class="form-group float-label">
                                        <select class="form-control" name="union_id" id="union_id">
                                          <option value="">Select Union / Pourosova</option>
                                          <?php foreach ($all_union as $value) { ?>
                                              <option value="<?php echo $value->id ; ?>"><?php echo $value->union_name ; ?></option>
                                          <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">      
                                <div class="col-12 w-100">
                                    <label class="text-secondary">Select Institute</label>
                                </div>
                                <div class="col-12">
                                    <div class="form-group float-label">
                                        <select class="form-control" name="institute_id" id="institute_id">
                                          <option value="">Select Institute</option>
                                          <?php foreach ($all_institute as $value2) { ?>
                                              <option value="<?php echo $value2->id ; ?>"><?php echo $value2->institute_name.' - '.$value2->union_name ; ?></option>
                                          <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">      
                                <div class="col-12 w-100">
                                    <label class="text-secondary">Candidate Name</label>
                                </div>
                                <div class="col-12">
                                    <div class="form-group float-label">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Candidate Name">
                                    </div>
                                </div>
                            </div>

                        </div>


                        <button id="candidateSearchResultView" class="btn btn-primary mb-1 btn-block">Search</button>

                    
                    </div>
                </div>
                </form>

                <div style="display:none;" id="loader"></div>
                <div id="get_content"></div>
                

            </div>
        </div>
    </div>
    <br>
</div>
<br>
<br>
<br>
@endsection

@section('js')
<script>


    $('#candidateSearchResultView').click(function(e){
       e.preventDefault();
       var union_id         = $('#union_id').val();
       var name             = $('#name').val();
       var institute_id     = $('#institute_id').val();

        $('#loader').removeAttr( 'style' );
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/getCanidateBySearchValue') }}",
            'type':'post',
            'dataType':'text',
            data:{  
            union_id:union_id ,
            institute_id:institute_id ,
            name:name 
            },
            success:function(data)
            {
              $('#loader').attr("style", "display: none;");
              $('#get_content').html(data);
            }
        });
    });

    $(document).ready(function(){

        $('body').on('click',".checkall",function(e){
            $('input[type="checkbox"]').not(this).prop('checked', this.checked);
        });
    })  
</script>

<script>
    $('body').on('click',"#send_sms",function(e){
        e.preventDefault() ;
        var union_id        = $('#union_id').val();
        var institute_id    = $('#institute_id').val();
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
            'url':"{{ url('/sendSMSbyAdminSearch') }}",
            'type':'post',
            'dataType':'text',
            data:{  
            message:message,
            selected:selected,
            institute_id:institute_id,
            union_id:union_id,
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
