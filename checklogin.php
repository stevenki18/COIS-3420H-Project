<?php

// Check for a valid session (if not redirect back to login)
session_start();
 if(!isset($_SESSION['user'])){
   header("Location:login.php");
 }


?>
