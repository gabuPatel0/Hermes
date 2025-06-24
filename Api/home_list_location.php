<?php
require "conn.php";
require "myconfig.php";


$category_id = $_POST['category_id'];
$center_lat = $_POST['center_lat'];
$center_lng = $_POST['center_lng'];
$radius_km = $_POST['radius'];

$radius = $radius_km * 0.621371 ;

mysqli_set_charset($conn, "utf8");

$web_url1 = $web_url."media_files/homes/";


$response = array();
$data = array();

    $sql = "SELECT id, category_id, name, description,address, city, state, pincode, email, phone, website, open_from, open_till, latitude, longitude, description, created, photo
            ,( 3959 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance
            FROM aaham_homes
            WHERE category_id = ? AND is_deleted = 0 AND is_deactivated = 0 HAVING distance < ?";
    
        $stmt_vehicle = $conn->prepare($sql);
        $stmt_vehicle->bind_param('sssis',,,, ,);
        $stmt_vehicle->execute();
        $result_vehicle = $stmt_vehicle->get_result();
        $stmt_vehicle->close();

    if(mysqli_num_rows($result_vehicle) > 0)
    {
        $status = "success";
	    
        while($row = $result_vehicle->fetch_assoc())
        {
            $h_id = $row['id'];
            $h_name = $row['name'];
            $h_description = $row['description'];
            $h_address = $row['address'];
            $h_city = $row['city'];
            $h_state = $row['state'];
            $h_pincode = $row['pincode'];
            $h_email = $row['email'];
            $h_phone = $row['phone'];
            $h_website = $row['website'];
            $h_open_from = $row['open_from'];
            $h_open_to = $row['open_till'];
            $h_latitude = $row['latitude'];
            $h_longitude = $row['longitude'];
            $h_created = $row['created'];
            $h_photo1 = $row['photo'];
            $h_distance = $row['distance'];
            
            $distance = $h_distance * 1.60934; 
            
            $h_photo = $web_url1 . $h_photo1;
            $distance = round($distance,2);
            
            array_push($data, array("id"=>$h_id,"name"=>$h_name,"description"=>$h_description,"address"=>$h_address, "city"=>$h_city ,"state"=>$h_state , 
                                        "pincode"=>$h_pincode,"email"=>$h_email,"phone"=>$h_phone, "website"=>$h_website ,"open_from"=>$h_open_from ,
                                        "open_till"=>$h_open_to,"latitude"=>$h_latitude,"longitude"=>$h_longitude,"created"=>$h_created, "photo"=>$h_photo ,"distance"=>$distance." KM" ));
        }
        array_push($response, array("status"=>$status,"data"=>$data));

        utf8_encode_deep($response);
        echo json_encode($response);
    }
    else if(mysqli_num_rows($result_vehicle) == 0)
    {
        $status = "empty";
        array_push($response, array("status"=>$status));
        utf8_encode_deep($response);
        echo json_encode($response);
    }
    else
    {
        $status = "failed";
        array_push($response, array("status"=>$status));
        utf8_encode_deep($response);
        echo json_encode($response);
    }
    
mysqli_close($conn);
?>