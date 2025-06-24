<?php
require_once 'dbconfig.php';

require "sendnotification.php";




if(isset($_POST['app_id']))   { 	$app_id =$_POST['app_id'];	}	else	{	$app_id="";	}
if(isset($_POST['response']))   { 	$response =$_POST['response'];	}	else	{	$response="";	}
 
$output = array();

if($app_id!="" && $response!="" )
{
	$sql = "UPDATE tbl_appointment  SET is_cancelled = '$response'  WHERE appointment_id='$app_id'";
	 
	if(mysqli_query($conn,$sql))
	{
		$output['result'] ='Yes';
		$output['msg'] ='Sucess';

		 $query = "SELECT firebase_id FROM tbl_appointment
				INNER  JOIN tbl_business ON tbl_appointment.business_id = tbl_business.business_id 
				WHERE appointment_id = '$app_id'";
				
			$result = mysqli_query($conn,$query);

			if (mysqli_num_rows($result) > 0) 
			{
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
					
				$firebase_id = 	$row['firebase_id'];	
				
				$title = "New Appointment Response";
				$message = "User Cancelled appointment Request";
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

?>