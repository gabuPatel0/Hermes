<?php
require_once 'dbconfig.php';



if(isset($_POST['user_id']))   { 	$user_id =$_POST['user_id'];	}	else	{	$user_id="";	}

if(isset($_POST['latitude']))   	{ 	$latitude =$_POST['latitude'];	}	else	{	$latitude="";	}
if(isset($_POST['longitude']))   	{ 	$longitude =$_POST['longitude'];	}	else	{	$longitude="";	}
 
$output = array();

if($user_id!="" && $latitude!="" && $longitude!="")
{	
		$query = "UPDATE tbl_business  SET business_latitude = '$latitude' , business_longitude  = '$longitude'  WHERE business_id ='$user_id' ";
		$result = mysqli_query($conn,$query);

		if(mysqli_query($conn,$query))
		{
			$output['result'] ='Yes';
			$output['msg'] ='Sucess';
				
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