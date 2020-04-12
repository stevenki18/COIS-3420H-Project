<?php
    require_once "../includes/library.php";


    function getItemDetails($itemid){

        $pdo = connectDB();
        $query = "SELECT * FROM `g10_listitems` WHERE id = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$itemid]);
        $results = $statement->fetch();

        if(isset($results))
            return $results;
        else
            return NULL;
    }

    function getRandomPublicItem(){
      $pdo = connectDB();
      $query = "SELECT id FROM `g10_listitems` WHERE private = ?";
      $statement = $pdo->prepare($query);
      $statement->execute(["0"]);
      $results = $statement->fetchAll(PDO::FETCH_COLUMN);

      $max = sizeof($results) - 1;

      if(isset($results))
          return $results[rand(0,$max)];
      else
          return NULL;
    }



?>
