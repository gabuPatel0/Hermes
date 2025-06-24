<?php
require_once 'dbconfig.php';





$title= $_POST['complaintitle']; 	
$descr = $_POST['complaindesc']; 	
	
$user_id = $_POST['user_id']; 	

//$date='24-4-2024';

$date = date('Y-m-d H:i:s');

	

if($title!="")
{	
	$sql = "INSERT INTO complain(Complain_Title,Description,Date,user_id) VALUES ('$title','$descr','$date','$user_id')";
					
	if(mysqli_query($conn,$sql))
	{
		echo "Complain Added...!";
	}
	else
	{
		echo "Error";
	}
	 
}

?>