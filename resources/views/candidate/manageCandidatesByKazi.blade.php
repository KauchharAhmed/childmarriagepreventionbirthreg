@extends('kazi.masterKazi')
@section('content')
<div class="content-sticky-footer">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card rounded-0 border-0 mb-3">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-7">
                                <h5 class="card-title text-uppercase">Manage All Candidates List</h5>
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
                                    <th>Name</th>
                                    <th>Father Name</th>
                                    <th>Institute</th>
                                    <th>Village</th>
                                    <th>Age</th>
                                    <th>Status</th>
                                    <th>Mobile</th>
                                    <th>Union</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $j = 1 ; foreach ($result as $value) { ?>
                                    <tr>
                                        <td><?php echo $j++ ; ?></td>
                                        <td><?php echo $value->name ; ?></td>
                                        <td><?php echo $value->father_name ; ?></td>
                                        <td><?php echo $value->institute_name ; ?></td>
                                        <td><?php echo $value->address ; ?></td>
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
                                        <td><?php echo $value->contact_number ; ?></td>
                                        <td><?php echo $value->union_name ; ?></td>
                                        <td>

                                            <?php if($value->gender == 1) : ?>
                                                <a href="{{URL::to('updateCandidateStatusByKazi/'.$value->id)}}" title="" style="display: <?php if($year >= $settings->male and $value->married_status == 0){echo "";}else{echo "none";} ?>">
                                                    <button type="button" class="btn btn-warning btn-sm">Update</button>
                                                </a>
                                            <?php else : ?>
                                                <a href="{{URL::to('updateCandidateStatusByKazi/'.$value->id)}}" title="" style="color:red;display: <?php if($year >= $settings->female and $value->married_status == 0){echo "";}else{echo "none";} ?>">
                                                    <button type="button" class="btn btn-warning btn-sm">Update</button>
                                                </a>
                                            <?php endif; ?>
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
</div>
<br>
<br>
<br>
@endsection
