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
$email = $_POST['email'] ?? NULL;


/* Error Validation (from last lab) */
if (!isset($username) || strlen($username) === 0) array_push($errors, "Please enter a valid username.");
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) array_push($errors, "Please enter a valid email address.");

header("Location: login.php");
exit();

?>
