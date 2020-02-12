<?php
/* Redirect if $_POST has nothing in it */
if (!isset($_POST) || count($_POST) <= 0) {
  header("Location: edit_account.php");
}

/* $errors starts as an empty array */
$errors = [];

/* Error Validation */

// CHANGE PASSWORD
if(isset($_POST['old_password']))
{
    // check password

    // PASSWORD SET
    if(!isset($_POST['password'])||strlen($_POST['password']) < 8)
        array_push($errors, "Please enter a password that is at least 8 characters long");

    // PASSWORD MATCH
    if (!isset($_POST['password_confirm']) || $_POST['password']!= $_POST['password_confirm'])
        array_push($errors, "Passwords do not match");

}

if(sizeof($errors) == 0)
  header("Location: edit_account.php");
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
