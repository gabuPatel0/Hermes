<?php
require_once 'dbconfig.php';


$title = $_POST['feedbacktitle']; 	
$descr = $_POST['feedbackdesc']; 	
//$date = '24-4-2024'; 	
$user_id = $_POST['user_id']; 	
$date = date('Y-m-d H:i:s');
	

if($title!="")
{	
	$sql = "INSERT INTO feedback(Feedback_Title,Description,Date,user_id) VALUES ('$title','$descr','$date','$user_id')";
					
	if(mysqli_query($conn,$sql))
	{
		echo "Feedback Added...!";
	}
	else
	{
		echo "Error";
	}
	 
}

?>