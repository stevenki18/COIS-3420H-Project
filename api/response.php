<?php
    /*-----------------------------------------------------------
    |
    |   PAGE:         response.php
    |
    |   DESCRIPTION:  Turns a database query into a JSON
    |                 formatted response message
    |
    -----------------------------------------------------------*/
    require "results.php";

    /*---------------------------
    |
    |       ITEM DETAILS
    |
    ---------------------------*/
    if(!empty($_GET['itemid'])){
        $param=$_GET['itemid'];
        $item = getItemDetails($param);

        if(empty($item))
            response(200, NULL);
        else
            response(200, $item);
    }


    /*---------------------------
    |
    |     RANDOM PUBLIC ITEM
    |
    ---------------------------*/
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

    /*---------------------------
    |
    |       CHECK USERNAME
    |
    ---------------------------*/
    else if(!empty($_GET['username'])){
        $param = $_GET['username'];
        $user = checkUsername($param);

        if(empty($user))
            response(200, NULL);
        else
            response(200, $user);
    }

    // INVALID REQUEST
    else
        response(400, NULL);

    
    /*---------------------------
    |
    |      FORMAT RESPONSE
    |
    ---------------------------*/
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
