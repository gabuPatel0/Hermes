<?php
require_once 'dbconfig.php';

require "sendnotification.php";




if(isset($_POST['app_id']))   { 	$app_id =$_POST['app_id'];	}	else	{	$app_id="";	}
if(isset($_POST['response']))   { 	$response =$_POST['response'];	}	else	{	$response="";	}
 
$output = array();

if($app_id!="" && $response!="" )
{
	$sql = "UPDATE tbl_appointment  SET is_approved = '$response'  WHERE appointment_id='$app_id'";
	 
	if(mysqli_query($conn,$sql))
	{
		$output['result'] ='Yes';
		$output['msg'] ='Sucess';	
		
		$query = "SELECT firebase_id FROM tbl_appointment
				INNER JOIN tbl_user ON tbl_appointment.user_id = tbl_user.user_id 
				WHERE tbl_appointment.appointment_id='$app_id'";
			$result = mysqli_query($conn,$query);

			if (mysqli_num_rows($result) > 0) 
			{
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
					
				$firebase_id = 	$row['firebase_id'];	
				
				$title = "Appointment Response";
				$message = "You received appointment Resonse";
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