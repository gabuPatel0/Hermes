<?php

require_once 'dbconfig.php';



$user_id = $_POST['user_id'];

if($user_id != "")
{
	 $sql = "SELECT appointment_id , tbl_business.business_id , user_id , appointment_date, appointment_time_slot, appointment_response , is_approved , is_cancelled , tbl_appointment.created 
			, tbl_business.business_name , tbl_business.business_address , tbl_business.business_contact
			FROM tbl_appointment 
			INNER JOIN tbl_business ON tbl_appointment.business_id = tbl_business.business_id
			WHERE user_id = '$user_id' ORDER BY appointment_id DESC";

		$result = mysqli_query($conn,$sql);

		if(mysqli_num_rows($result) > 0)
		{
			while( $row = mysqli_fetch_assoc($result)) 
			{	
				$output['data'][] = $row;
			}
			print(json_encode($output));
		}
		else
		{
			echo "";
		}
}
?>

