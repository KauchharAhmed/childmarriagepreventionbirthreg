@extends('health.masterOrganization')
@section('content')
<div class="content-sticky-footer">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card rounded-0 border-0 mb-3">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-7">
                                <h5 class="card-title text-uppercase">Candidate Details</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <center>
                            <img src="{{URL::to('')}}/<?php echo $value->image; ?>" alt="" style="width: 150px;height: 150px;display: <?php if($value->image == ""){echo "none";}else{echo "";} ?>" > 
                            <img  src="{{URL::to('images/avatar.png')}}" alt="" style="width: 150px;height: 150px;display: <?php if($value->image == ""){echo "";}else{echo "none";} ?>"> 
                        </center>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <td>Union</td>
                                    <td>:</td>
                                    <td><?php echo $value->union_name; ?></td>
                                </tr>

                                <tr>
                                    <td>Ward</td>
                                    <td>:</td>
                                    <td><?php echo $value->ward_name; ?></td>
                                </tr>

                                <tr>
                                    <td>Institute Name</td>
                                    <td>:</td>
                                    <td><?php echo $value->institute_name; ?></td>
                                </tr>

                                <tr>
                                    <td>Name</td>
                                    <td>:</td>
                                    <td><?php echo $value->name ; ?></td>
                                </tr>

                                <tr>
                                    <td>Father Name</td>
                                    <td>:</td>
                                    <td><?php echo $value->father_name ; ?></td>
                                </tr>

                                <tr>
                                    <td>Mother Name</td>
                                    <td>:</td>
                                    <td><?php echo $value->mother_name ; ?></td>
                                </tr>

                                <tr>
                                    <td>Mother Name</td>
                                    <td>:</td>
                                    <td><?php echo $value->mother_name ; ?></td>
                                </tr>

                                <tr>
                                    <td>Gender</td>
                                    <td>:</td>
                                    <td>
                                        <?php 
                                        if ($value->gender == 1) {
                                            echo "Male";
                                        }elseif($value->gender == 2){echo "Female";}else{echo "Other";} ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Date Of Birth</td>
                                    <td>:</td>
                                    <td><?php echo date('d/m/Y',strtotime($value->dob)) ; ?></td>
                                </tr>

                                <tr>
                                    <td>Age</td>
                                    <td>:</td>
                                    <td><?php 

                                        date_default_timezone_set('Asia/Dhaka');

                                        $exDob  = date('Y-m-d',strtotime($value->dob));

                                        $interval = date_diff(date_create(), date_create($exDob));
                                        echo $interval->format("%Y Year, %M Months, %d Days Old");
                                         ?></td>
                                </tr>
                                <tr>
                                    <td>Birth Registration</td>
                                    <td>:</td>
                                    <td><?php echo $value->birth_reg_no ; ?></td>
                                </tr>

                                <tr>
                                    <td>Contact Number</td>
                                    <td>:</td>
                                    <td><?php echo $value->contact_number ; ?></td>
                                </tr>
                                <tr>
                                    <td>Father Nid No</td>
                                    <td>:</td>
                                    <td><?php echo $value->father_nid_no ; ?></td>
                                </tr>
                                <tr>
                                    <td>Mother Nid No</td>
                                    <td>:</td>
                                    <td><?php echo $value->mother_nid_no ; ?></td>
                                </tr>
                                <tr>
                                    <td>Guardian Nid No</td>
                                    <td>:</td>
                                    <td><?php echo $value->guardian_nid_no ; ?></td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>:</td>
                                    <td><?php echo $value->address ; ?></td>
                                </tr>
                                <tr>
                                    <td>Married Status</td>
                                    <td>:</td>
                                    <td><?php if ($value->married_status == 0) {
                                        echo "Single";
                                    }else{echo "Married";} ?></td>
                                </tr>
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

