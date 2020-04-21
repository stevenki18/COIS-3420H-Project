<?php
    /*-----------------------------------------------------------
    |
    |   PAGE:         accounts.php
    |
    |   DESCRIPTION:  Allow a user to register an account and
    |                 edit or delete an existing account. This
    |                 page also handles account creation when
    |                 a user signs in with their Google account
    |
    -----------------------------------------------------------*/

    session_start();
    require_once 'includes/library.php';
    $pdo = connectDB();

    // GET ALL USER INFORMATION IF THEY ARE LOGGED IN
    if(isset($_SESSION['user'])){
      $user = $_SESSION['user'];

      $query = "SELECT * FROM g10_users WHERE username = ?";
      $stmt = $pdo->prepare($query);
      $stmt->execute([$user]);
      $results = $stmt->fetch();
    }

    $updateCount = 0;
    $changepass = 0;
    $errors = [];

    /*---------------------------
    |
    |       REGISTRATION
    |
    ---------------------------*/
    if (isset($_POST['register'])){
      /* Redirect if $_POST has nothing in it */
      if (!isset($_POST) || count($_POST) <= 0) {
        header("Location: register.php");
        exit();
      }

      $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
      $fname = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
      $lname = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
      $dob = filter_var($_POST['birthdate'], FILTER_SANITIZE_STRING);

      /* Error Validation */
      // USERNAME
      if (!$username || strlen($username) == 0)
        array_push($errors, "Please enter a username");
      // PASSWORD SET
      if(!isset($_POST['password'])||strlen($_POST['password']) < 8)
        array_push($errors, "Please enter a password that is at least 8 characters long");

      // PASSWORD MATCH
      if (!isset($_POST['password_confirm']) || $_POST['password']!== $_POST['password_confirm'])
        array_push($errors, "Passwords do not match");

      // FIRST NAME
      if(!$fname || strlen($fname) == 0)
        array_push($errors, "Please enter a first name");

      // LAST NAME
      if(!$lname || strlen($lname) == 0)
        array_push($errors, "Please enter a last name");

      // EMAIL
      $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
      if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        array_push($errors, "Please enter a valid email address");
      // BIRTHDATE
      if(strlen($_POST['birthdate']) != 0 && !$dob)
        array_push($errors, "Please enter a valid birthdate");
      // TERMS AND CONDITIONS
      if(!isset($_POST['agreebox']))
        array_push($errors, "Please accept the Terms and Conditions");

      // No errors do the work with the database
      if(sizeof($errors) == 0){
        // Get all POST data (all information has been SANITIZED above or thrown error)
        $pass = $_POST['password'];
        $hash = password_hash($pass, PASSWORD_DEFAULT);

        /* Add the new user */
        $query = "INSERT INTO `g10_users` (username, pass, first, last, email, dob) VALUES (?, ?, ?, ?, ?, ?)";
        $statement = $pdo->prepare($query);

        if(strlen($dob) == 0)
            $statement->execute([$username, $hash, $fname, $lname, $email, null]);
        else
            $statement->execute([$username, $hash, $fname, $lname, $email, $dob]);

        // redirect to log in
        header("Location: login.php");
        exit();
      }// END OF DB WORK
    }// END OF REGISTER

    /*---------------------------
    |
    |       UPDATE ACCOUNT
    |
    ---------------------------*/
    if(isset($_POST['update'])){

      /* Error Validation */
      // USERNAME (UNCHANGEABLE)
      $fname = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
      $lname = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
      $dob = filter_var($_POST['birthdate'], FILTER_SANITIZE_STRING);

      // CHECK FOR PASSWORD CHANGE
      if((strlen($_POST['new_password']) != 0)){
        // PASSWORD MATCH
        if (strlen($_POST['password_confirm']) < 8 || $_POST['new_password']!== $_POST['password_confirm'])
          array_push($errors, "Passwords do not match");
        else
          $changepass = 1;
      }

      // FIRST NAME
      if(!$fname || strlen($fname) == 0)
        array_push($errors, "Please enter a first name");

      // LAST NAME
      if(!$lname || strlen($lname) == 0)
        array_push($errors, "Please enter a last name");

      // EMAIL
      $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
      if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        array_push($errors, "Please enter a valid email address");

      // BIRTHDATE
      if(strlen($_POST['birthdate']) != 0 && !$dob)
        array_push($errors, "Please enter a valid birthdate");

      // No errors do the work with the datbase
      if(sizeof($errors) == 0){
        // Get all POST data (all information has been SANITIZED above or thown error)
        $user = $_SESSION['user'];

        /* Update the account (with/without password change) */
        if($changepass){
          $pass = $_POST['new_password'];
          $hash = password_hash($pass, PASSWORD_DEFAULT);

          $query = "UPDATE `g10_users` SET pass = ?, first= ?, last= ?, email= ?, dob=? WHERE username = ?";
          $statement = $pdo->prepare($query);

          if(strlen($_POST['birthdate']) == 0)
            $statement->execute([$hash, $fname, $lname, $email, null, $user]);
          else
            $statement->execute([$hash, $fname, $lname, $email, $dob, $user]);

          $updateCount = $statement->rowCount();
        }
        else{
          $query = "UPDATE `g10_users` SET first= ?, last= ?, email= ?, dob=? WHERE username = ?";
          $statement = $pdo->prepare($query);

          if(strlen($_POST['birthdate']) == 0)
            $statement->execute([$fname, $lname, $email, null, $user]);
          else
            $statement->execute([$fname, $lname, $email, $dob, $user]);

          $updateCount = $statement->rowCount();
        }
      }// END OF DB WORK

      // Get newest values to update form
      $query = "SELECT * FROM g10_users WHERE username = ?";
      $stmt = $pdo->prepare($query);
      $stmt->execute([$user]);
      $results = $stmt->fetch();


    }// END OF UPDATE


    /*---------------------------
    |
    |       GOOGLE ACCOUNT
    |
    ---------------------------*/
    if(isset($_POST['g-create'])){
      // Get all POST data (passed by java and Google)
      // Don't sanitize as Google has already done that for us
      $username = $_POST['username'];
      $pass = $_POST['password'];
      $hash = password_hash($pass, PASSWORD_DEFAULT);
      $fname = $_POST['firstname'];
      $lname = $_POST['lastname'];
      $email = $_POST['email'];

      /* Add the new user */
      $query = "INSERT INTO `g10_users` (username, pass, first, last, email) VALUES (?, ?, ?, ?, ?)";
      $statement = $pdo->prepare($query);
      $statement->execute([$username, $hash, $fname, $lname, $email]);

      if(!$statement){
        echo "ERROR ON CREATION";
        exit();
      }
      else {
        $_SESSION['user'] = $username;
        $_SESSION['id'] = $pdo->lastInsertId();

        echo "Success";
        exit();
      }

    }// END OF GOOGLE ACCOUNT


    /*---------------------------
    |
    |       DELETE ACCOUNT
    |
    | ** POST COMES FROM JS
    ---------------------------*/
    if(isset($_POST['deleteAccount'])){

      $query = "DELETE FROM g10_users WHERE id = ?";
      $stmt = $pdo->prepare($query);
      $stmt->execute([$_SESSION['id']]);

      unset($_SESSION['id']);
      unset($_SESSION['user']);

      header("Location: login.php");
      exit();
    }// END OF DELETE ACCOUNT
?>
<!DOCTYPE HTML>
<html lang="en">

<head>
  <?php
    $PAGE_TITLE = "Account Information";
    include "includes/meta.php"
  ?>
  <!-- Source https://github.com/dropbox/zxcvbn -->
  <script defer src="scripts/zxcvbn.js"></script>
  <script defer src="scripts/datedropper.js"></script>

</head>

<body>

  <header>
    <?php include 'includes/nav.php' ?>
  </header>

  <main>
    <header>
      <!-- EDIT ACCOUNT -->
      <?php if(isset($_SESSION['user'])): ?>
      <h1>Edit Account Information</h1>
      <!-- REGISTER -->
      <?php else: ?>
      <h1>Register</h1>
      <?php endif ?>
    </header>

    <!-- FORM -->
    <form id="register-form" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">

      <!-- USERNAME -->
      <!-- Once created a username cannot be changed -->
      <div>
        <label for="username">Username:</label>
        <input id="username" name="username" type="text"
        <?php if(isset($_SESSION['user'])): ?>
          value="<?= $results['username'] ?>" readonly>
        <?php else: ?>
          placeholder="Thrillseeker99" required>
        <?php endif ?>
        <span class="error hidden">Please enter a username</span>
      </div>

      <!-- PASSWORDS -->
      <!-- EDIT ACCOUNT -->
      <?php if(isset($_SESSION['user'])): ?>
        <!-- UPDATE PASSWORD -->
        <div>
          <label for="new_password">New Password:</label>
          <input name="new_password" type="password" id="new_password" minlength="8">
          <meter max="4" id="newpassword-strength"></meter>
          <p id="newpassword-strength-text"></p>
          <span class="error hidden">Password not strong enough</span>
        </div>
        <!-- UPDATE CONFIRM -->
        <div>
          <label for="password_confirm">Confirm Password:</label>
          <input name="password_confirm" type="password" id="password_confirm" minlength="8">
          <span class="error hidden">Passwords do not match</span>
        </div>
      <!-- REGISTER -->
      <?php else: ?>
        <!-- PASSWORD -->
        <div>
          <label for="password">Password (at least 8 characters):</label>
          <input name="password" type="password" id="password" minlength="8" required>
          <meter max="4" value="0" id="password-strength"></meter>
          <p id="password-strength-text"></p>
          <span class="error hidden">Password not strong enough</span>
        </div>
        <!-- CONFIRM -->
        <div>
          <label for="password_confirm">Confirm Password:</label>
          <input name="password_confirm" type="password" id="password_confirm" minlength="8" required>
          <span class="error hidden">Passwords do not match</span>
        </div>
      <?php endif ?>

      <!-- FIRST NAME -->
      <div>
        <label for="firstname">First Name:</label>
        <input id="firstname" name="firstname" type="text" <?php if(isset($_SESSION['user'])): ?>
          value="<?= $results['first'] ?>" required>
        <?php else: ?>
          placeholder="Mary" required>
        <?php endif ?>
        <span class="error hidden">Please enter a first name</span>
      </div>

      <!-- LAST NAME -->
      <div>
        <label for="lastname">Last Name:</label>
        <input id="lastname" name="lastname" type="text"
        <?php if(isset($_SESSION['user'])): ?>
          value="<?= $results['last'] ?>" required>
        <?php else: ?>
          placeholder="Sue" required>
        <?php endif ?>
        <span class="error hidden">Please enter a last name</span>
      </div>

      <!-- EMAIL -->
      <div>
        <label for="email">Email Address:</label>
        <input id="email" name="email" type="text"
        <?php if(isset($_SESSION['user'])): ?>
          value="<?= $results['email'] ?>" required>
        <?php else: ?>
          placeholder="mary.sue@gmail.com" required>
        <?php endif ?>
        <span class="error hidden">Please enter an email address</span>
      </div>

      <!-- BIRTHDATE -->
      <!-- MINIMUM = JAN 1, 1900, MAXIMUM = TODAY (SET IN SCRIPT.JS) -->
      <div>
        <label for="birthdate">Date of Birth:</label>
        <input data-dd-theme="bucket" class="datedropper-init" data-dd-format="Y-m-d" type="text" id="birthdate" name="birthdate"
        <?php if(isset($_SESSION['user'])): ?>
          value="<?= $results['dob'] ?>">
          <button <?php if($results['dob'] != ""): ?>
            class="delete"
          <?php else: ?>
            class="delete hidden"
          <?php endif; ?>
          type="button" name="ClearDate">Clear Date</button>
        <?php else: ?>
          >
        <?php endif ?>
        <span class="error hidden">Please enter a valid birthdate</span>
      </div>

      <!-- BUTTONS -->
      <!-- EDIT ACCOUNT -->
      <?php if(isset($_SESSION['user'])): ?>
        <!-- ERROR LIST -->
        <!-- Only shows if JS validation fails -->
        <div class="errors">
          <ul id="errors">
            <?php foreach ($errors as $error): ?>
              <li><?= $error ?></li>
            <?php endforeach ?>
          </ul>
        </div>

        <!-- LET USER KNOW THEIR ACCOUNT HAS BEEN UPDATED -->
        <div class="updated">
          <?php if($updateCount > 0): ?>
            <span>Account Updated</span>
          <?php endif ?>
        </div>

        <button id="update" name="update"> Save Changes</button>
        <button type="button" name="deleteAccount"> Delete Account</button>

      <!-- REGISTER -->
      <?php else: ?>
        <div>
          <input id="agreebox" type="checkbox" name="agreebox" required>
          <label for="agreebox">I agree to the <a href="terms.php">Terms and Conditions</a></label>
          <span class="error hidden">Please agree to terms and conditions</span>
        </div>

        <button id="register" name="register"> Create Account</button>
      <?php endif ?>
    </form>
  </main>

  <?php include 'includes/footer.php' ?>

</body>

</html>
