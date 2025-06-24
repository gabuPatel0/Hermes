<?php
require_once 'dbconfig.php';



//mysqli_set_charset($conn, "utf8");
date_default_timezone_set("Asia/Calcutta");
$today = date("d-m-Y H:i:s");


if(isset($_POST['utype']))  		{ 	$utype =$_POST['utype'];	}	else	{	$utype="";	}
if(isset($_POST['name']))  			{ 	$name =$_POST['name'];		}	else	{	$name="";	}
if(isset($_POST['email']))   		{ 	$email =$_POST['email'];	}	else	{	$email="";	}
if(isset($_POST['mobile']))  	 	{ 	$mobile =$_POST['mobile'];	}	else	{	$mobile="";	}

if(isset($_POST['address']))  		{ 	$address =$_POST['address'];}	else	{	$address="";	}
if(isset($_POST['city_id']))   		{ 	$city_id =$_POST['city_id'];		}	else	{	$city_id="";	}
if(isset($_POST['password']))   	{ 	$password =$_POST['password'];	}	else	{	$password="";	}
if(isset($_POST['category_id']))  	 { 	$category_id =$_POST['category_id'];	}	else	{	$category_id="";	}

if(isset($_POST['firebase_id']))   { 	$firebase_id =$_POST['firebase_id'];	}	else	{	$firebase_id="";	}
 
$output= array();

	if($name!="" && $email!="" && $mobile!="" && $address!="" && $city_id!="" && $password!="" && $category_id!="" && $utype!="" && $firebase_id!="" )
	{	
		$sql = "SELECT * FROM tbl_user WHERE email ='$email'";
		$result = mysqli_query($conn,$sql);
		if(mysqli_num_rows($result) > 0)
		{
			$output['result'] ='No';
			$output['msg'] ='Email';
		}
		else
		{
			$sql = "SELECT * FROM tbl_business WHERE  business_email ='$email'";
			$result = mysqli_query($conn,$sql);
			if(mysqli_num_rows($result) > 0)
			{
				$output['result'] ='No';
				$output['msg'] ='Email';
			}
			else
			{
				$sql = "SELECT * FROM tbl_user WHERE mobile ='$mobile'";
				$result = mysqli_query($conn,$sql);
				if(mysqli_num_rows($result) > 0)
				{
					$output['result'] ='No';
					$output['msg'] ='Mobile';
				}
				else
				{
				
					$sql = "SELECT * FROM tbl_business WHERE business_contact ='$mobile'";
					$result = mysqli_query($conn,$sql);
					if(mysqli_num_rows($result) > 0)
					{
						
						$output['result'] ='No';
						$output['msg'] ='Mobile';
					}
					else
					{
						
						if($utype == "User")
						{
							//$firebase_id="12345";
							$sql = "INSERT INTO tbl_user(name,email, mobile , password , created , photo , otp ,firebase_id) VALUES ('$name','$email','$mobile','$password','$today','uploads/user_dp/user_default.png','0' , '$firebase_id')";				
							
							
							if(mysqli_query($conn,$sql))
							{
								$query = "SELECT user_id , name , email , mobile , photo FROM tbl_user WHERE email ='$email' AND password='$password' ";
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
						else if($utype == "Business")
						{
								
			 
							 $sql = "INSERT INTO tbl_business(category_id ,city_id , business_name , business_contact , business_email , business_address , business_logo , password , created , firebase_id ) VALUES 
							('$category_id','$city_id','$name','$mobile','$email','$address','uploads/business_dp/business_default.png','$password', '$today' , '$firebase_id')";				
							if(mysqli_query($conn,$sql))
							{
								$query = "SELECT business_id , category_id , city_id , business_name , business_contact , business_email , business_address  , business_logo ,business_latitude , business_longitude FROM tbl_business WHERE business_email ='$email' AND password='$password' ";
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