<?php foreach ($result as $value) { ?>
    <tr>
        <td><?php echo $value->name ; ?></td>
        <td><?php echo $value->father_name ; ?></td>
        <td><?php echo $value->mother_name ; ?></td>
        <td><?php echo $value->address ; ?></td>
        <td><?php echo $value->institute_name ; ?></td>
        <td><?php echo date('d M Y',strtotime($value->dob)) ; ?></td>
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

        <td>
            <?php if($value->image != "") : ?>
                <img src="{{URL::to('/'.$value->image)}}" style="width: 50px;height: 50px;" alt="" >
            <?php else : ?>
                <img src="{{URL::to('images/avatar.png')}}" style="width: 50px;height: 50px;" alt="" >
            <?php endif; ?>
        </td>
    </tr>
<?php } ?>