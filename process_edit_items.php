<?php
/* Redirect if $_POST has nothing in it */
if (!isset($_POST) || count($_POST) <= 0) {
  header("Location: edit_item.php");
}

/* $errors starts as an empty array */
$errors = [];

/* Error Validation */
// ITEM NAME
if (!isset($_POST['item']) || strlen($_POST['item']) == 0)
  array_push($errors, "Please enter an item name for your bucket list item");

if(sizeof($errors) == 0)
  header("Location: edit_list.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    $PAGE_TITLE = "Edit List Item Form Errors";
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
