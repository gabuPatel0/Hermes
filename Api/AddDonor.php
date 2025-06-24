<?php
require_once 'dbconfig.php';


$uname = $_POST['uname']; 	
$gender = $_POST['gender'];
$address=$_POST['address'];
$city=$_POST['city'];
$bloodgr=$_POST['bloodgr'];
$cno=$_POST['cno'];
$email = $_POST['email']; 	
$password=$_POST['password'];




if($uname!="")
{	

	$sql = "INSERT INTO donorregistration(name,gender,address,city,bloodgr,cno,email,password,status) VALUES ('$uname','$gender','$address','$city','$bloodgr','$cno','$email','$password','Active')";
    // echo		$sql;			
	if(mysqli_query($conn,$sql))
		
	{

		echo "Added...!";
	}
					
	else
	{
			echo "Error1";
	}
}
	

?>