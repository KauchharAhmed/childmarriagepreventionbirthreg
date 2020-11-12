@extends('institute.masterInstitute')
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
                                    <label class="text-secondary">Select Ward</label>
                                </div>
                                <div class="col-12">
                                    <div class="form-group float-label" >
                                        <select class="form-control spinner" name="ward_id" id="ward_id" >
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="col-12 w-100">
                                    <label class="text-secondary">Name </label>
                                </div>
                                <div class="col-12">
                                    <div class="form-group float-label">
                                        <input type="text" class="form-control active" name="name" id="name" placeholder="Name">
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
    });

    $('#candidateSearchResultView').click(function(e){
       e.preventDefault();
       var union_id = $('#union_id').val();
       var ward_id  = $('#ward_id').val();
       var name     = $('#name').val();

        $('#loader').removeAttr( 'style' );
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/adminCadidateSearchResultView') }}",
            'type':'post',
            'dataType':'text',
            data:{  
            union_id:union_id ,
            ward_id:ward_id ,
            name:name 
            },
            success:function(data)
            {
              $('#loader').attr("style", "display: none;");
              $('#get_content').html(data);
            }
        });
    });
</script>
@endsection
