<?php

require_once 'dbconfig.php';



		$sql = "SELECT * FROM tbl_city";

		$result = mysqli_query($conn,$sql);

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


?>

