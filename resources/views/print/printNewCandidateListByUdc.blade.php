<?php
$admin_id       = Session::get('admin_id');
$type           = Session::get('type');
       
       if($admin_id == null && $type == null){
       return Redirect::to('/admin')->send();
       exit();
        }

       if($admin_id == null && $type != '2'){
       return Redirect::to('/admin')->send();
       exit();
        }       
        ?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Print New Candidate List</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
		<style>
		@media print {
			body {-webkit-print-color-adjust: exact;}
		}
        .font_sml{ font-size:11px;}
        .table_tr_td {
            border-top: 1px solid #dddddd;
            line-height: 1.42857;
            padding: 7px;
            vertical-align: top;
        }
		table.nila {
			border-collapse: collapse;
		}

		table.nila, td.nila, th.nila {
			border: 1px solid black;
			padding: 5px;
		}
		
		table.roni {
			border-collapse: none;
		}

		table.roni, td.roni, th.roni {
			border: none;
		}	
		.siam ul li{
			float:left;
		}
		div.fixed {
			position: fixed;
			bottom: 0;
			right: 0;
			width:100%;
		}	
		</style>	
</head>
<body style="font-family: 'Roboto', sans-serif;">	
			
			<center>
				<img src="{{URL::to('public/assets/img/bd_logo.png')}}" alt="" width="100" height="100">
				<h4>Full Stop Child Marriage</h4>
				<p>Sirajganj Sadar,Sirajganj</p>

			</center>
			<center><h3><span style="font-family:tahoma;border:1px solid #000;padding-top:4px;padding-bottom:4px;padding-left:27px;padding-right:27px;">CANDIDATE REPORTS</span></h3></center>		
			<div class="row">
				


				<div style="overflow: hidden;width: 100%;padding-top: 20px;font-size: 12px;">
					<table width="100%" class="nila">
						<thead>
							<tr>
								<th class="nila" style="background: #d0d7d8;font-size: 18px">#SL</th>
								<th class="nila" style="background: #d0d7d8;font-size: 18px">Name</th>
					            <th class="nila" style="background: #d0d7d8;font-size: 18px">Father Name</th>
					            <th class="nila" style="background: #d0d7d8;font-size: 18px">Mother Name</th>
					            <th class="nila" style="background: #d0d7d8;font-size: 18px">Village</th>
					            <th class="nila" style="background: #d0d7d8;font-size: 18px">Union</th>
					            <th class="nila" style="background: #d0d7d8;font-size: 18px">Institute</th>
					            <th class="nila" style="background: #d0d7d8;font-size: 18px">Mobile</th>
					            <th class="nila" style="background: #d0d7d8;font-size: 18px">DOB</th>
					            <th class="nila" style="background: #d0d7d8;font-size: 18px">Age</th>
					            <th class="nila" style="background: #d0d7d8;font-size: 18px">Status</th>
					            <th class="nila" style="background: #d0d7d8;font-size: 18px">Image</th>
							</tr>
						</thead>
						<?php $i = 1 ;
				        foreach ($result as $value) { ?>
					        <tbody>
						        <tr>
						        	<td class="nila"><?php echo $i++ ; ?></td>
						        	<td class="nila"><?php echo $value->name ; ?></td>
			                        <td class="nila"><?php echo $value->father_name ; ?></td>
			                        <td class="nila"><?php echo $value->mother_name ; ?></td>
			                        <td class="nila"><?php echo $value->address ; ?></td>
			                        <td class="nila"><?php echo $value->union_name ; ?></td>
			                        <td class="nila"><?php echo $value->institute_name ; ?></td>
			                        <td class="nila"><?php echo $value->contact_number ; ?></td>
			                        <td class="nila"><?php echo date('Y-m-d',strtotime($value->dob)) ; ?></td>
			                        <td style="font-weight: bold;" class="nila"><?php 

			                        date_default_timezone_set('Asia/Dhaka');

			                        $exDob  = date('Y-m-d',strtotime($value->dob));

			                        $interval = date_diff(date_create(), date_create($exDob));
			                        echo $interval->format("%Y Year, %M Months, %d Days Old");
			                        $year = $interval->format("%Y");
			                         ?></td>
			                        <td class="nila">
			                            <?php if($value->gender == 1) : ?>
			                                <img src="{{URL::to('images/check.png')}}" style="color:red;display: <?php if($year >= $settings->male){echo "";}else{echo "none";} ?>" alt="" >
			                                <img src="{{URL::to('images/cross.png')}}" style="color:red;display: <?php if($year < $settings->male){echo "";}else{echo "none";} ?>" alt="" >
			                            <?php else : ?>
			                                <img src="{{URL::to('images/check.png')}}" style="color:red;display: <?php if($year >= $settings->female){echo "";}else{echo "none";} ?>" alt="" >
			                                <img src="{{URL::to('images/cross.png')}}" style="color:red;display: <?php if($year < $settings->female){echo "";}else{echo "none";} ?>" alt="" >
			                            <?php endif; ?>
			                        </td>
			                        <td class="nila">
			                            <?php if($value->image != "") : ?>
			                                <img src="{{URL::to('/'.$value->image)}}" style="width: 50px;height: 50px;" alt="" >
			                            <?php else : ?>
			                                <img src="{{URL::to('images/avatar.png')}}" style="width: 50px;height: 50px;" alt="" >
			                            <?php endif; ?>
			                        </td>
						        </tr>
					        </tbody>
				        <?php } ?>

					</table>
				</div>
			</div>
		
		
	</div>

	</body>
</html>	  
      <!--inovice print-->
	<script type="text/javascript">
	window.print();
	</script>	  