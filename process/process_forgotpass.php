<?php
/*
Page name: process_forgotpass.php
Description: Changes user's password if forgotten. First checks if user's
account exists.
*/

    // Check for a valid session (if not redirect back to login)
    session_start();

    require_once '../includes/library.php';

    // Handle the forgot password modal
    $forgotvalid = 0;

    if(isset($_POST["forgot-check"])){/* Redirect if $_POST has nothing in it */
      if (!isset($_POST) || count($_POST) <= 0) {
        header("Location: login.php");
        exit();
      }

      /* $errors starts as an empty array */
      $forgoterrors = [];

      /* Get everything from $_POST */
      $forgotusername = $_POST['username'] ?? NULL;
      $forgotemail = $_POST['email'] ?? NULL;


      /* Error Validation (from last lab) */
      if (!isset($forgotusername) || strlen($forgotusername) === 0) array_push($forgoterrors, "Please enter a valid username.");
      if (!filter_var($forgotemail, FILTER_VALIDATE_EMAIL)) array_push($forgoterrors, "Please enter a valid email address.");

      // checks if user exists in site's database
      if(sizeof($forgoterrors) == 0){
        $pdo = connectDB();

        $query = "SELECT * FROM g10_users WHERE username = ? AND email = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$forgotusername, $forgotemail]);
        $results = $stmt->rowCount();

        // if account is found with correct username and PASSWORD
        if($results <= 0){
          echo "User Not Found";
          unset($_POST);
          exit();
        }else{
          echo "User Found";
          unset($_POST);
          exit();
        }
      }else{
        foreach($forgoterrors as $error){
          echo $error;
        }
      }

      // change window to change password fields
      echo "END OF PAGE";
      exit();
    }

    if(isset($_POST['forgot-change'])){
      /* Update the account (with/without password change) */
      $username = $_POST['username'];
      $pass = $_POST['new_password'];
      $hash = password_hash($pass, PASSWORD_DEFAULT);

      $pdo = connectDB();

      $query = "UPDATE `g10_users` SET pass = ? WHERE username = ?";
      $statement = $pdo->prepare($query);

      $statement->execute([$hash, $username]);
      $updateCount = $statement->rowCount();

      if($updateCount >= 0){
        unset($_POST);
        echo "Success";
        exit();
      }else{
        unset($_POST);
        echo "Error";
        exit();
      }
    }


?>
