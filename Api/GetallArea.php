<?php

require_once 'dbconfig.php';



$cid=$_GET['cid'];

if($cid!=''){
		$sql = "SELECT * FROM area where cid='$cid'";

		$result = mysqli_query($con,$sql);

		if(mysqli_num_rows($result) > 0)
		{
		while( $row = mysqli_fetch_assoc($result)) 
		{	
		$output['data'][] = $row;
		}
	
		print(json_encode($output));
		}
		else
		{
			echo"";
		}
}

?>

