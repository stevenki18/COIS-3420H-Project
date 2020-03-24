<?php
    require "results.php";

    if(!empty($_GET['itemid'])){
        $param=$_GET['itemid'];
        $item = getItemDetails($param);

        if(empty($item))
            response(200, "No List Item Found", NULL);
        else
            response(200, "List Item", $item);
    }

    // INVALID REQUEST
    else
        response(400, "Invalid Request", NULL);
        
    function response($status, $status_message, $data){
        // SEND APPROPRIATE HEADERS
        // JSON
        // STATUS CODES
        header("Content-Type:application/json");
        header("HTTP/1.1".$status);

        // BUILD RESPONSE ARRAY
        $response['status']=$status;
        $response['status_message']=$status_message;
        
        // COULD BE A DATABASE RESULT
        $response['data']=$data;

        // TURNS ARRAY INTO JSON OBJECT
        // SEND TO BROWSER
        $json_response = json_encode($response);
        echo $json_response;
    }
    
?>