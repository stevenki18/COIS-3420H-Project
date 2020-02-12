<?php
/* Redirect if $_POST has nothing in it */
if (!isset($_POST) || count($_POST) <= 0) {
  header("Location: edit_account.php");
}

/* $errors starts as an empty array */
$errors = [];

/* Get everything from $_POST */
$username = $_POST['username'] ?? NULL;
$password = $_POST['password'] ?? NULL;


/* Error Validation (from last lab) */
if (!isset($username) || strlen($username) === 0) array_push($errors, "Please enter a valid username.");
if (!isset($password)) array_push($errors, "Incorrect Password.");


if(sizeof($errors) == 0)
{
    // CHECK DATABASE FOR LOGIN CREDENTIALS
    if($username=="master" and $password=="test")
    {
      // DELETE ACCOUNT
  
      header("Location: index.php");
      exit();
    }

    else 
    {
        // REDIRECT TO EDIT ACCOUNT?
      header("Location: edit_account.php");
      exit();
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    $PAGE_TITLE = "Delete Account Errors";
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
