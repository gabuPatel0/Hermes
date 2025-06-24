<?php
require_once 'dbconfig.php';




if(isset($_POST['user_id']))   { 	$user_id =$_POST['user_id'];	}	else	{	$user_id="";	}
if(isset($_POST['user_type']))   { 	$user_type =$_POST['user_type'];	}	else	{	$user_type="";	}

if(isset($_POST['password']))   	{ 	$password =$_POST['password'];		}	else	{	$password="";	}
if(isset($_POST['opassword']))   	{ 	$opassword =$_POST['opassword'];	}	else	{	$opassword="";	}
 
$output = array();

if($password!="" && $opassword!=""  && $user_id!="" && $user_type!="" )
{	
		if($user_type =="User")
		{
			$query = "SELECT user_id , password FROM tbl_user WHERE user_id = '$user_id' ";
			$result = mysqli_query($conn,$query);

			if (mysqli_num_rows($result) > 0) 
			{
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			
				$pass1  =$row['password'];
				
				if($pass1 == $opassword)
				{
					$sql = "UPDATE  tbl_user SET password = '$password' WHERE user_id = '$user_id'";				
					if(mysqli_query($conn,$sql))
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
					$output['msg'] ='Password';
				}
									
			}
			else
			{
				$output['result'] ='No';
				$output['msg'] ='Error';
			}
		}		
		else if($user_type =="Business")
		{
			$query = "SELECT business_id , password FROM tbl_business WHERE business_id = '$user_id' ";
			$result = mysqli_query($conn,$query);

			if (mysqli_num_rows($result) > 0) 
			{
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			
				$pass1  =$row['password'];
				
				if($pass1 == $opassword)
				{
					$sql = "UPDATE  tbl_business SET password = '$password' WHERE business_id = '$user_id'";				
					if(mysqli_query($conn,$sql))
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
					$output['msg'] ='Password';
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