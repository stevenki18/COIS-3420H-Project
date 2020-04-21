<?php
    /*-----------------------------------------------------------
    |
    |   PAGE:         results.php
    |
    |   DESCRIPTION:  Performs database queries as determined by
    |                 response.php
    |
    |                 GetItemDetails returns all item details 
    |                 of a specified item id
    |
    |                 GetRandomPublicItem returns the id of a
    |                 randomly selected public list item
    |                 (used with I Feel Lucky option)
    |
    |                 CheckUsername returns a the username
    |                 provided if it is found
    |
    |                 All functions will return NULL if nothing
    |                 is found
    |
    -----------------------------------------------------------*/
    require_once "../includes/library.php";
    $pdo = connectDB();    
    

    /*---------------------------
    |
    |       GET ITEM DETAILS
    |
    ---------------------------*/
    function getItemDetails($itemid){
        $query = "SELECT * FROM `g10_listitems` WHERE id = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$itemid]);
        $results = $statement->fetch();

        if(isset($results))
            return $results;
        else
            return NULL;
    }// END OF GET ITEM DETAILS


    /*---------------------------
    |
    |    GET RANDOM PUBLIC ITEM
    |
    ---------------------------*/
    function getRandomPublicItem(){
      $query = "SELECT id FROM `g10_listitems` WHERE private = ?";
      $statement = $pdo->prepare($query);
      $statement->execute(["0"]);
      $results = $statement->fetchAll(PDO::FETCH_COLUMN);

      $max = sizeof($results) - 1;

      if(isset($results))
          return $results[rand(0,$max)];
      else
          return NULL;
    }// END OF GET RANDOM PUBLIC ITEM


    /*---------------------------
    |
    |       CHECK USERNAME
    |
    ---------------------------*/
    function checkUsername($username){
        $query = "SELECT username FROM `g10_users` WHERE username = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$username]);
        $result = $statement->fetch();

        if(isset($result))
            return $result;
        else
            return NULL;
    }// END OF CHECK USERNAME

?>
