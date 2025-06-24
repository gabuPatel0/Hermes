<?php
class SendNotification
{
    public static function send($device_id, $title, $message, $open_data)
    {
                            $url_fcm = "https://fcm.googleapis.com/fcm/send";
                            $server_key = "AAAArS84PFA:APA91bFr03d1nHh48d7yja_GZF8RL9DWfHVnDqcaPEAV6Rxc9CqT4BQ4tJLiA8aVkg4VK6zUQo4ZGjXuVLvaqnZV6cdR93o4ZdxmXgQQuBXU1OER8fylhcWotuQtpQSHeiet3Bdvs-C5";
                            $header = array('Authorization: key='.$server_key, 'Content-Type: application/json');
                            $field = array('to'=>$device_id,
                                    	'priority'=>'high',
                                    	'data'=>array('title'=>$title, 'message'=>$message, 'open_data'=>$open_data)
                                    );
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, $url_fcm);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($field));
                            $result_curl = curl_exec($ch);
                            if ($result_curl === FALSE) 
                            {
                            	die('Curl failed: ' . curl_error($ch));
                            }
                            curl_close($ch);
        
    }
} 
?>