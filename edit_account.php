<?php require "checklogin.php" ?>
<!DOCTYPE HTML>
<html lang="en">

<head>
  <?php
      $PAGE_TITLE = "Edit Account";
      include "includes/meta.php"
    ?>
</head>

<body>

  <header>
    <?php include 'nav.php' ?>
  </header>

  <main>
    <header>
      <!-- EDIT ACCOUNT -->
      <h1>Edit Account Information</h1>
    </header>

    <!-- FORM -->
    <form id="register-form" action="process_edit_account.php" method="post">
      <div>
        <label for="username">Username:</label>
        <input id="username" name="username" type="text" value = <?php //username ?> readonly>
      </div>

      <div>
        <p>Reset Password</p>
      </div>

      <div>
        <label for="old_password">Current Password:</label>
        <input name="old_password" type="password" id="old_password">
      </div>

      <div>
        <label for="new_password">New Password:</label>
        <input name="new_password" type="password" id="new_password" minlength="8">
      </div>

      <div>
        <label for="password_confirm">Confirm Password:</label>
        <input name="password_confirm" type="password" id="password_confirm" minlength="8">
      </div>

      <div>
        <label for="firstname">First Name:</label>
        <input id="firstname" name="firstname" type="text" value = <?php //first name ?> required>
      </div>

      <div>
        <label for="lastname">Last Name:</label>
        <input id="lastname" name="lastname" type="text" value = <?php //last name ?> required>
      </div>

      <div>
        <label for="email">Email Address:</label>
        <input id="email" name="email" type="text" value = <?php //email ?> required>
      </div>

      <!-- MINIMUM = JAN 1, 1900, MAXIMUM = TODAY (SET IN SCRIPT AT BOTTOM) -->
      <div>
        <label for="birthdate">Date of Birth:</label>
        <input id="birthdate" type="date" name="birthdate" value = <?php //birthday ?> min="1900-01-01" required>
      </div>

      <button type="submit" name="Update Account"> Save Changes</button>
      <button type="button" name="Delete Account"> Delete Account</button>
    </form>
  </main>

  <?php include 'includes/footer.php' ?>

  <!-- SET MAXIMUM DATE THAT CAN BE SELECTED FOR BIRTHDAY AS CURRENT DATE -->
  <script>
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!
    var yyyy = today.getFullYear();
    if (dd < 10) {
      dd = '0' + dd
    }
    if (mm < 10) {
      mm = '0' + mm
    }

    today = yyyy + '-' + mm + '-' + dd;
    document.getElementById("birthdate").setAttribute("max", today);
  </script>
</body>

</html>
