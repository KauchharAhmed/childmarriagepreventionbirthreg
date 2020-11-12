<div class="card rounded-0 border-0 mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-7">
                <h5 class="card-title text-uppercase">Search Result</h5>
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
        {!! Form::open(['id' =>'ss','method' => 'post','role' => 'form','class'=>'form-horizontal','files' => true]) !!}
            <div class="col-md-4">
                <textarea class="form-control" name="message" id="message" style="height: 150px;width:250px;" required=""></textarea>
                <input type="hidden" name="institute_id" id="institute_id" value="<?php echo $institute_id ; ?>"> 
                <input type="hidden" name="union_id" id="union_id" value="<?php echo $union_id ; ?>" > 
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-success" id="send_sms">Send</button>
                <img src="{{URL::to('images/sending.gif')}}" width="50" height="50" style="display:none;" id="loader2">
            </div>
        
            
        <div class="table table-responsive" style="margin-top: 20px;">
            <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Name</th>
                    <th>Father Name</th>
                    <th>Mother Name</th>
                    <th>Village</th>
                    <th>Mobile</th>
                    <th>DOB</th>
                    <th>Age</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="radio" class="checkall" ></td>
                    <td>Select All</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <?php $j = 1 ; foreach ($result as $value) { ?>
                    <tr>
                        <td><input type="checkbox" name="member_id[]" value="<?php echo $value->id.'.'.$value->contact_number; ?>"></td>
                        <td><?php echo $value->name ; ?></td>
                        <td><?php echo $value->father_name ; ?></td>
                        <td><?php echo $value->mother_name ; ?></td>
                        <td><?php echo $value->address ; ?></td>
                        <td><?php echo $value->contact_number ; ?></td>
                        <td><?php echo date('Y-m-d',strtotime($value->dob)) ; ?></td>
                        <td style="font-weight: bold;"><?php 

                        date_default_timezone_set('Asia/Dhaka');

                        $exDob  = date('Y-m-d',strtotime($value->dob));

                        $interval = date_diff(date_create(), date_create($exDob));
                        echo $interval->format("%Y Year, %M Months, %d Days Old");
                        $year = $interval->format("%Y");
                         ?></td>
                        <td>
                            <?php if($value->gender == 1) : ?>
                                <img src="{{URL::to('images/check.png')}}" style="color:red;display: <?php if($year >= $settings->male){echo "";}else{echo "none";} ?>" alt="" >
                                <img src="{{URL::to('images/cross.png')}}" style="color:red;display: <?php if($year < $settings->male){echo "";}else{echo "none";} ?>" alt="" >
                            <?php else : ?>
                                <img src="{{URL::to('images/check.png')}}" style="color:red;display: <?php if($year >= $settings->female){echo "";}else{echo "none";} ?>" alt="" >
                                <img src="{{URL::to('images/cross.png')}}" style="color:red;display: <?php if($year < $settings->female){echo "";}else{echo "none";} ?>" alt="" >
                            <?php endif; ?>
                        </td>
                        
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        </div>
        </form>
    </div>
</div>
</div>