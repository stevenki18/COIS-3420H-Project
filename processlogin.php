<?php
/* require or include the library */
// require './includes/library.php';

/* ------ <from-the-last-lab> ------- */
/* Redirect if $_POST has nothing in it */
if (!isset($_POST) || count($_POST) <= 0) {
  header("Location: login.php");
}

/* $errors starts as an empty array */
$errors = [];

/* Get everything from $_POST */
$username = $_POST['username'] ?? NULL;
$password = $_POST['password'] ?? NULL;


/* Error Validation (from last lab) */
if (!isset($username) || strlen($username) === 0) array_push($errors, "Please enter a valid username.");
if (!isset($password)) array_push($errors, "Incorrect Password.");

if (count($errors) === 0) {
  if($username=="master" and $password=="test"){
    session_start();
    $_SESSION['user'] = $username;
  }
  header("Location: index.php");
  exit();
} else {
  header("Location: login.php");
  exit();
}

?>
