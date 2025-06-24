<?php
require_once 'dbconfig.php';


if(isset($_POST['user_id']))   { 	$user_id =$_POST['user_id'];	}	else	{	$user_id="";	}
if(isset($_POST['user_type']))   { 	$user_type =$_POST['user_type'];	}	else	{	$user_type="";	}
 
$output = array();

if($user_id!="" && $user_type!="")
{
	if($user_type == "User")
	{
		$query = "SELECT user_id , name , email , mobile , photo FROM tbl_user WHERE user_id = '$user_id' ";
								$result = mysqli_query($conn,$query);

								if (mysqli_num_rows($result) > 0) 
								{
									$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
									$output['user_id'] =$row['user_id'];		
									$output['name'] =$row['name'];		
									$output['user_type'] ='User';
									$output['user_image'] =$row['photo'];
									$output['mobile'] =$row['mobile'];
									$output['email'] =$row['email'];
									
									$output['result'] ='Yes';
									$output['msg'] ='Sucess';		
								}	
								else
								{
									$output['result'] ='No';
									$output['msg'] ='Error';
								}
	}
	else if($user_type == "Business")
	{
		$query = "SELECT business_id , category_id , city_id , business_name , business_contact , business_email , business_address  , business_logo ,business_latitude , business_longitude FROM tbl_business WHERE business_id ='$user_id'";
								$result = mysqli_query($conn,$query);

								if (mysqli_num_rows($result) > 0) 
								{
									$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
									
									$output['business_id'] =$row['business_id'];		
									$output['category_id'] =$row['category_id'];		
									$output['user_type'] ='Business';
									$output['city_id'] =$row['city_id'];
									$output['business_name'] =$row['business_name'];
									$output['business_contact'] =$row['business_contact'];
									$output['business_email'] =$row['business_email'];
									$output['business_address'] =$row['business_address'];
									$output['business_logo'] =$row['business_logo'];
									$output['business_latitude'] =$row['business_latitude'];
									$output['business_longitude'] =$row['business_longitude'];
									
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