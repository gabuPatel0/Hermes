<?php
require_once 'dbconfig.php';





if($_SERVER['REQUEST_METHOD']=='POST')
{
		$file_name = $_FILES['myFile']['name'];
		$file_size = $_FILES['myFile']['size'];
		$file_type = $_FILES['myFile']['type'];
		$temp_name = $_FILES['myFile']['tmp_name'];
		$ext = pathinfo($file_name, PATHINFO_EXTENSION);
		
		$user_id = $_POST['user_id'];
		$user_type = $_POST['user_type'];

		
	if($user_id !="" && $user_type != "")
	{
		if($user_type == "User")
		{
			$location = "uploads/user_dp/";
			$filename1= "dp".$user_id.'.'.$ext;
			move_uploaded_file($temp_name,$location.$filename1);
			
			$sql = "UPDATE tbl_user SET photo = '$location$filename1' WHERE user_id='$user_id'";
	 
					if(mysqli_query($conn,$sql))
					{
						echo $file_name;
					}
					else
					{
						echo "error124";
					}
		}
		else if($user_type == "Business")
		{
			$location = "uploads/business_dp/";
			$filename1= "dp".$user_id.'.'.$ext;
			move_uploaded_file($temp_name,$location.$filename1);
			
			$sql = "UPDATE tbl_business SET business_logo = '$location$filename1' WHERE business_id = '$user_id'";
	 
					if(mysqli_query($conn,$sql))
					{
						echo $file_name;
					}
					else
					{
						echo "error124";
					}
		}
		
			 
	}
}

?>