<?php
/*
Page name: process_add.php
Description: Accepts and processes user input from add_list.php. Used to create
and edit lists.
*/

    // Check for a valid session (if not redirect back to login)
    session_start();

    if(!isset($_SESSION['user'])){
        header("Location: ../login.php");
    }

    require_once '../includes/library.php';
    $pdo = connectDB();

    //declares array to contain errors and list's privacy setting
    $errors = [];
    $viewable = 1;

    //ADD LIST
    if(isset($_POST['submitList'])){
        // SANITIZE LIST NAME
        $listname = filter_var($_POST['listName'], FILTER_SANITIZE_STRING);

        if(!$listname || strlen($listname) == 0)
            array_push($errors, "Please Enter A List Name");

        if(isset($_POST['viewableList']))
            $viewable = 0;

        //if no errors insers list information into database
        if(sizeof($errors == 0)){
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
        // SANITIZE LIST NAME
        $listname = filter_var($_POST['listName'], FILTER_SANITIZE_STRING);

        if(!$listname || strlen($listname) == 0)
            array_push($errors, "Please Enter A List Name");

        if(isset($_POST['viewableList']))
            $viewable = 0;

        //if not errors, succesfully edits list
        if(sizeof($errors == 0)){
            $query = "UPDATE `g10_lists` SET listname = ?, private = ? WHERE id = ?";
            $statement = $pdo->prepare($query);
            $statement->execute([$listname, $viewable, $_POST['listNo']]);

            //redirects to previous page and exits this process
            header("Location: ../view_list.php?list=".$listid);
            exit();
        }
    }

?>
