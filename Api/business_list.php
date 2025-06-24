<?php

require_once 'dbconfig.php';



$category_id = $_POST['category_id'];
$center_lat = $_POST['center_lat'];
$center_lng = $_POST['center_lng'];
$radius_km = $_POST['radius'];

$radius = $radius_km * 0.621371 ;

		if($category_id == "0")
		{
			$sql = "SELECT  business_id , category_id , tbl_business.city_id , business_name , business_contact , business_email , business_address  , business_logo ,business_latitude , business_longitude , 
				( 3959 * acos( cos( radians($center_lat) ) * cos( radians( business_latitude ) ) * cos( radians( business_longitude ) - radians($center_lng) ) + sin( radians($center_lat) ) * sin( radians( business_latitude ) ) ) ) AS distance
				, tbl_city.city_name
				FROM tbl_business
				INNER JOIN tbl_city ON tbl_city.city_id = tbl_business.city_id HAVING distance < $radius";
		}
		else
		{
			$sql = "SELECT  business_id , category_id , tbl_business.city_id , business_name , business_contact , business_email , business_address  , business_logo ,business_latitude , business_longitude , 
				( 3959 * acos( cos( radians($center_lat) ) * cos( radians( business_latitude ) ) * cos( radians( business_longitude ) - radians($center_lng) ) + sin( radians($center_lat) ) * sin( radians( business_latitude ) ) ) ) AS distance
				, tbl_city.city_name
				FROM tbl_business
				INNER JOIN tbl_city ON tbl_city.city_id = tbl_business.city_id
				WHERE tbl_business.category_id = $category_id HAVING distance < $radius";
		}
		 


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
			echo "";
		}

?>

