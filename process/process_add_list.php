<?php
    // Check for a valid session (if not redirect back to login)
    session_start();
    // DOING THIS TO GET AROUND MULTITUDE OF ERRORS WHEN TRYING TO VIEW PUBLIC WHEN NOT LOGGED IN
    if(!isset($_SESSION['user'])){
        header("Location: ../login.php");
    }

    require_once '../includes/library.php';

    $errors = [];
    $viewable = 1;

    if(isset($_POST['submitList'])){
        $listname = $_POST['listName'];

        if($listname == null || strlen($listname) == 0)
            array_push($errors, "Please Enter A List Name");

        if(isset($_POST['viewableList']))
            $viewable = 0;

        if(sizeof($errors == 0)){
            $pdo = connectDB();
            $query = "INSERT INTO `g10_lists` (id, fk_userid, listname, start, private) VALUES (NULL, ?, ?, ?, ?)";
            $statement = $pdo->prepare($query);
            $statement->execute([$_SESSION['id'], $listname, date("Y-m-d"), $viewable]);
            $last_id = $pdo->lastInsertId();

            unset($_POST);
            header("Location: ../view_list.php?list=".$last_id);
            exit();
        }
    }

    // EDIT LIST
    if(isset($_POST['edit_list'])){
        $listname = $_POST['listName'];

        if($listname == null || strlen($listname) == 0)
            array_push($errors, "Please Enter A List Name");

        if(isset($_POST['viewableList']))
            $viewable = 0;

        if(sizeof($errors == 0)){
            $pdo = connectDB();
            $query = "UPDATE `g10_lists` SET listname = ?, private = ? WHERE id = ?";
            $statement = $pdo->prepare($query);
            $statement->execute([$listname, $viewable, $_POST['listNo']]);

            //unset($_POST);
            header("Location: ../view_list.php?list=".$listid);
            exit();
        }
    }

?>