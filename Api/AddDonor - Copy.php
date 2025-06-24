<?php
require_once 'dbconfig.php';


$uname = $_POST['uname']; 	
$gender = $_POST['gender'];
$cno=$_POST['cno'];
$email = $_POST['email']; 	
$password=$_POST['password'];
$city=$_POST['city'];
$bloodgr=$_POST['bloodgr'];
$address=$_POST['address'];


if($uname!="")
{	
	$sql = "INSERT INTO AddDonor(name,gender,address,city,cno,email,password,status) VALUES ('$uname','$gender','$address','$city','$cno','$email','$password','Active')";
					
	if(mysqli_query($conn,$sql))
		
	{

		$sql1 = "INSERT INTO login(uname,password,role) VALUES ('$email','$password','u')";
					
		if(mysqli_query($con,$sql1))
		{
			//echo "Added...!";

			$sql2 = "SELECT MAX(id) as ltid FROM uregistration";

			$result2 = mysqli_query($con,$sql2);

			if(mysqli_num_rows($result2) > 0)
			{
				while( $row = mysqli_fetch_assoc($result2)) 
				{	
			
					$maxid=$row['ltid'];
				}
			
				$sql3="INSERT INTO payment(uid,amount) VALUES ('$maxid','0')";
			
				if(mysqli_query($con,$sql3))
				{
					echo "Added...!";	
				
				}
			}else{
				echo "Error 3";
			}

//end here
		}else{
			echo "Error1";
		}
	}
	else
	{
		echo "Error";
	}
	 
}

?>