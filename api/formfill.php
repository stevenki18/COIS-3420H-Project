<?php
    require "results.php";

    if(!empty($_GET['itemid'])){
        $param=$_GET['itemid'];
        $item = getItemDetails($param);

        if(empty($item))
            response(200, NULL);
        else
            response(200, $item);
    }

    else if(!empty($_GET['randid'])){
      if($_GET['randid'] >= 0){
        $itemid = getRandomPublicItem();
        $item = getItemDetails($itemid);

        if(empty($item))
            response(200, NULL);
        else
            response(200, $item);
      };

    }

    // INVALID REQUEST
    else
        response(400, NULL);

    function response($status, $data){
        // SEND APPROPRIATE HEADERS
        // JSON
        // STATUS CODES
        header("Content-Type:application/json");
        header("HTTP/1.1".$status);

        // TURNS ARRAY INTO JSON OBJECT
        // SEND TO BROWSER
        $json_response = json_encode($data);
        echo $json_response;
    }

?>
