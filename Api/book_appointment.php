<?php
require_once 'dbconfig.php';

require "sendnotification.php";




// mysql_set_charset($conn, "utf8");
date_default_timezone_set("Asia/Calcutta");
$today = date("d-m-Y H:i:s");


if(isset($_POST['user_id']))  		{ 	$user_id =$_POST['user_id'];	}	else	{	$user_id="";	}
if(isset($_POST['business_id']))  		{ 	$business_id =$_POST['business_id'];	}	else	{	$business_id="";	}
if(isset($_POST['slot']))  			{ 	$slot =$_POST['slot'];		}	else	{	$slot="";	}
if(isset($_POST['slot_date']))   		{ 	$slot_date =$_POST['slot_date'];	}	else	{	$slot_date="";	}

$output= array();

	if($user_id!="" && $user_id!="" && $slot!="" && $slot_date!="" )
	{	
		$sql = "INSERT INTO tbl_appointment(business_id , user_id ,appointment_date, appointment_time_slot  , created ) VALUES ('$business_id','$user_id','$slot_date','$slot','$today')";				
		if(mysqli_query($conn,$sql))
		
		{
							
			$output['result'] ='Yes';
			$output['msg'] ='Sucess';	
			
			$query = "SELECT firebase_id FROM tbl_business WHERE business_id='$business_id'";
			$result = mysqli_query($conn,$query);

			if (mysqli_num_rows($result) > 0) 
			{
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
					
				$firebase_id = 	$row['firebase_id'];	
				
				$title = "New Appointment Request";
				$message = "You received new appointment Request";
				SendNotification::send($firebase_id, $title, $message, array("open_type"=>"msg_open"));				
			}			
			else
			{
				$output['result'] ='No';
				$output['msg'] ='Error';	
			}						
		}	
		else
		{
			$output['result'] ='No';
			$output['msg'] ='Error';
		}
	}
	else
	{
		$output['result'] ='No';
		$output['msg'] ='NoData';
	}

	$output1['data'][] = $output;
	
	if($output!=null)
	{
		print(json_encode($output1));
	}
	
mysqli_close($conn);
?>