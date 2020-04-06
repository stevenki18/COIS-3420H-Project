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

    
    
?>