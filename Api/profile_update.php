<?php
require_once 'dbconfig.php';



if(isset($_POST['user_id']))   { 	$user_id =$_POST['user_id'];	}	else	{	$user_id="";	}
if(isset($_POST['user_type']))   { 	$user_type =$_POST['user_type'];	}	else	{	$user_type="";	}

if(isset($_POST['name']))   	{ 	$name =$_POST['name'];		}	else	{	$name="";	}
if(isset($_POST['email']))   	{ 	$email =$_POST['email'];	}	else	{	$email="";	}
if(isset($_POST['mobile']))   	{ 	$mobile =$_POST['mobile'];	}	else	{	$mobile="";	}

if(isset($_POST['address']))   	{ 	$address =$_POST['address'];	}	else	{	$address="";	}
if(isset($_POST['city_id']))   	{ 	$city_id =$_POST['city_id'];	}	else	{	$city_id="";	}
if(isset($_POST['category_id']))   	{ 	$category_id =$_POST['category_id'];	}	else	{	$category_id="";	}
 
$output = array();

if($name!="" && $email!="" && $mobile!="" && $address!="" && $city_id!="" && $user_id!="" && $category_id!="" && $user_type!="" )
	{	
		if($user_type =="User")
		{
			$sql = "SELECT * FROM tbl_user WHERE email ='$email' AND user_id != '$user_id'";
		}
		else
		{
			$sql = "SELECT * FROM tbl_user WHERE email ='$email'";
		}
		
		$result = mysqli_query($conn,$sql);
		if(mysqli_num_rows($result) > 0)
		{
			$output['result'] ='No';
			$output['msg'] ='Email';
		}
		else
		{
			if($user_type =="Business")
			{
				$sql = "SELECT * FROM tbl_business WHERE business_email ='$email' AND business_id != '$user_id'";
			}
			else
			{
				$sql = "SELECT * FROM tbl_business WHERE business_email ='$email'";
			}
			$result = mysqli_query($conn,$sql);
			if(mysqli_num_rows($result) > 0)
			{
				$output['result'] ='No';
				$output['msg'] ='Email';
			}
			else
			{
				if($user_type =="User")
				{
					$sql = "SELECT * FROM tbl_user WHERE mobile ='$mobile' AND user_id != '$user_id'";
				}
				else
				{
					$sql = "SELECT * FROM tbl_user WHERE mobile ='$mobile'";
				}
				
				$result = mysqli_query($conn,$sql);
				if(mysqli_num_rows($result) > 0)
				{
					$output['result'] ='No';
					$output['msg'] ='Mobile';
				}
				else
				{
				
					if($user_type =="Business")
					{
						$sql = "SELECT * FROM tbl_business WHERE business_contact ='$mobile' AND business_id != '$user_id'";
					}
					else
					{
						$sql = "SELECT * FROM tbl_business WHERE business_contact ='$mobile'";
					}
					
					$result = mysqli_query($conn,$sql);
					if(mysqli_num_rows($result) > 0)
					{
						
						$output['result'] ='No';
						$output['msg'] ='Mobile';
					}
					else
					{
						
						if($user_type == "User")
						{
							$sql = "UPDATE  tbl_user SET name = '$name', email = '$email', mobile = '$mobile' WHERE user_id = '$user_id'";				
							if(mysqli_query($conn,$sql))
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
							else
							{
								$output['result'] ='No';
								$output['msg'] ='Error';
							}
						}
						else if($user_type == "Business")
						{
								
			 
							 $sql = "UPDATE tbl_business SET category_id = '$category_id' , city_id = '$city_id'  , business_name = '$name'  , business_contact = '$mobile'  , business_email = '$email'  , business_address = '$address'  WHERE business_id = '$user_id' ";				
							if(mysqli_query($conn,$sql))
							{
								$query = "SELECT business_id , category_id , city_id , business_name , business_contact , business_email , business_address  , business_logo ,business_latitude , business_longitude FROM tbl_business WHERE business_id = '$user_id' ";
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
								$output['msg'] ='Error1';
							}
						}
						else
						{
							$output['result'] ='No';
							$output['msg'] ='Error';
						}
					}
				}					
			}
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