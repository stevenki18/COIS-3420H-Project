<?php
/* Redirect if $_POST has nothing in it */
if (!isset($_POST) || count($_POST) <= 0) {
  header("Location: register.php");
}

/* $errors starts as an empty array */
$errors = [];

/* Error Validation */
// USERNAME
if (!isset($_POST['username']) || strlen($_POST['username']) == 0)
  array_push($errors, "Please enter a username");

// PASSWORD SET
if(!isset($_POST['password'])||strlen($_POST['password']) < 8)
  array_push($errors, "Please enter a password that is at least 8 characters long");

// PASSWORD MATCH
if (!isset($_POST['password_confirm']) || $_POST['password']!= $_POST['password_confirm'])
  array_push($errors, "Passwords do not match");

// FIRST NAME
if(!isset($_POST['firstname']) || strlen($_POST['firstname']) == 0)
  array_push($errors, "Please enter a first name");

// LAST NAME
if(!isset($_POST['lastname']) || strlen($_POST['lastname']) == 0)
  array_push($errors, "Please enter a last name");

// EMAIL
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false)
  array_push($errors, "Please enter a valid email address");

//BIRTHDATE
if(!isset($_POST['lastname']) || strlen($_POST['lastname']) == 0)
  array_push($errors, "Please enter a birthdate that is between 2019-01-01 and " + date("Y-m-d"));

// TERMS AND CONDITIONS
if(!isset($_POST['agreebox']))
  array_push($errors, "Please accept the Terms and Conditions");

if(sizeof($errors) == 0)
  header("Location: manage_list.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    $PAGE_TITLE = "Registration Form Errors";
    include "meta.php"
  ?>
</head>
<body>
  <?php include "header.php" ?>
  <main>
    <h1>Errors</h1>
    <ul id="errors">
      <?php foreach ($errors as $error): ?>
        <li><?= $error ?></li>
      <?php endforeach; ?>
    </ul>
  </main>
  <?php include "footer.php" ?>

  <!-- Fix for Chrome bug, leave this. https://stackoverflow.com/a/42969608 -->
  <script> </script>
</body>

</html>
