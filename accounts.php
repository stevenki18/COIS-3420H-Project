<?php 
  
  session_start();
  require_once './includes/library.php';

  if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];
    $pdo = connectDB();

    $query = "SELECT * FROM g10_users WHERE username = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user]);
    $results = $stmt->fetch();
  }
    
  $updateCount= 0;
  $changepass = 0;

  /* $errors starts as an empty array */
  $errors = [];

  // REGISTER
  if (isset($_POST['register'])){
    /* Redirect if $_POST has nothing in it */
    if (!isset($_POST) || count($_POST) <= 0) {
      header("Location: register.php");
      exit();
    }

    /* Error Validation */
    // USERNAME
    if (!isset($_POST['username']) || strlen($_POST['username']) == 0)
      array_push($errors, "Please enter a username");

    // Check if user exists in Database

    // PASSWORD SET
    if(!isset($_POST['password'])||strlen($_POST['password']) < 8)
      array_push($errors, "Please enter a password that is at least 8 characters long");

    // PASSWORD MATCH
    if (!isset($_POST['password_confirm']) || $_POST['password']!== $_POST['password_confirm'])
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

    // BIRTHDATE ??? NEED TO DOUBLE CHECK
    if(!isset($_POST['birthdate']) || strlen($_POST['birthdate']) == 0)
      array_push($errors, "Please enter a birthdate that is between 1900-01-01 and " + date("Y-m-d"));

    // TERMS AND CONDITIONS
    if(!isset($_POST['agreebox']))
      array_push($errors, "Please accept the Terms and Conditions");

    // No errors do the work with the datbase
    if(sizeof($errors) == 0){
      // Get all POST data (all information has been SANITIZED above or thown error)
      $username = $_POST['username'];

      $pass = $_POST['password'];
      $hash = password_hash($pass, PASSWORD_DEFAULT);

      $fname = $_POST['firstname'];
      $lname = $_POST['lastname'];

      $email = $_POST['email'];

      $dob = $_POST['birthdate'];

      // Connect to the database
      $pdo = connectDB();

      /* Add the new user */
      $query = "INSERT INTO `g10_users` (username, pass, first, last, email, dob) VALUES (?, ?, ?, ?, ?, ?)";
      $statement = $pdo->prepare($query);

      $statement->execute([$username, $hash, $fname, $lname, $email, $dob]);

      // redirect to log in
      header("Location: login.php");
      exit();
    }
  }

  // EDIT ACCOUNT
  if(isset($_POST['update'])){
    /* Redirect if $_POST has nothing in it */
    if (!isset($_POST) || count($_POST) <= 0) {
      header("Location: ~edit_account.php");
      exit();
    }
 
    /* Error Validation */
    // USERNAME (UNCHANGEABLE)
 
    if((strlen($_POST['new_password']) != 0)){
      // PASSWORD MATCH
      if (strlen($_POST['password_confirm']) < 8 || $_POST['new_password']!== $_POST['password_confirm'])
        array_push($errors, "Passwords do not match");
      else {
        $changepass = 1;
      }
    }
 
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
 
    // BIRTHDATE ??? NEED TO DOUBLE CHECK
    if(!isset($_POST['birthdate']) || strlen($_POST['birthdate']) == 0)
      array_push($errors, "Please enter a birthdate that is between 1900-01-01 and " + date("Y-m-d"));
 
    // No errors do the work with the datbase
    if(sizeof($errors) == 0){
      // Get all POST data (all information has been SANITIZED above or thown error)
      $user = $_SESSION['user'];
      $fname = $_POST['firstname'];
      $lname = $_POST['lastname'];
 
      $email = $_POST['email'];
 
      $dob = $_POST['birthdate'];
 
 
      // Connect to the database
      $pdo = connectDB();
 
      /* Update the account (with/without password change) */
      if($changepass){
        $pass = $_POST['new_password'];
        $hash = password_hash($pass, PASSWORD_DEFAULT);
 
        $query = "UPDATE `g10_users` SET pass = ?, first= ?, last= ?, email= ?, dob=? WHERE username = ?";
        $statement = $pdo->prepare($query);
 
        $statement->execute([$hash, $fname, $lname, $email, $dob, $user]);
        $updateCount = $statement->rowCount();
      }
      else{
        $query = "UPDATE `g10_users` SET first= ?, last= ?, email= ?, dob=? WHERE username = ?";
        $statement = $pdo->prepare($query);
 
        $statement->execute([$fname, $lname, $email, $dob, $user]);
        $updateCount = $statement->rowCount();
      }
    }
  }

?>
<!DOCTYPE HTML>
<html lang="en">

<head>
  <?php
      $PAGE_TITLE = "Account Information";
      include "includes/meta.php"
    ?>
</head>

<body>

  <header>
    <?php include 'includes/nav.php' ?>
  </header>

  <main>
    <header>
      <!-- Register -->
      <?php if(isset($_SESSION['user'])): ?>
        <h1>Edit Account Information</h1>
      <?php else: ?>
        <h1>Register</h1>
      <?php endif ?>
    </header>

    <!-- FORM -->
    <form id="register-form" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
      
    <!-- USERNAME -->
      <div>
        <label for="username">Username:</label>
        <input id="username" name="username" type="text" 
        <?php if(isset($_SESSION['user'])): ?>
          value = "<?= $results['username'] ?>" readonly>
        <?php else: ?>
          placeholder = "Thrillseeker99" required>
        <?php endif ?>
      </div>
      
      <!-- PASSWORDS -->
      <!-- edit -->
      <?php if(isset($_SESSION['user'])): ?>
        <div>
          <label for="new_password">New Password:</label>
          <input name="new_password" type="password" id="new_password" minlength="8">
        </div>
        <div>
          <label for="password_confirm">Confirm Password:</label>
          <input name="password_confirm" type="password" id="password_confirm" minlength="8">
        </div>
      <!-- register -->
      <?php else: ?>
        <div>
          <label for="password">Password (at least 8 characters):</label>
          <input name="password" type="password" id="password" minlength="8" required>
          <meter max="4" id="password-strength"></meter>
          <p id="password-strength-text"></p>
        </div>
        <div>
          <label for="password_confirm">Confirm Password:</label>
          <input name="password_confirm" type="password" id="password_confirm" minlength="8" required>
        </div>
      <?php endif ?>

      <!-- FIRST NAME -->
      <div>
        <label for="firstname">First Name:</label>
        <input id="firstname" name="firstname" type="text" 
        <?php if(isset($_SESSION['user'])): ?>
          value = "<?= $results['first'] ?>" required>
        <?php else: ?>
          placeholder = "Mary" required>
        <?php endif ?>
      </div>

      <!-- LAST NAME -->
      <div>
        <label for="lastname">Last Name:</label>
        <input id="lastname" name="lastname" type="text" 
        <?php if(isset($_SESSION['user'])): ?>
          value = "<?= $results['last'] ?>" required>
        <?php else: ?>
          placeholder = "Sue" required>
        <?php endif ?>
      </div>

      <!-- EMAIL -->
      <div>
        <label for="email">Email Address:</label>
        <input id="email" name="email" type="text" 
        <?php if(isset($_SESSION['user'])): ?>
          value = "<?= $results['email'] ?>" required>
        <?php else: ?>
          placeholder = "mary.sue@gmail.com" required>
        <?php endif ?>
      </div>

      <!-- BIRTHDATE -->
      <!-- MINIMUM = JAN 1, 1900, MAXIMUM = TODAY (SET IN SCRIPT AT BOTTOM) -->
      <div>
        <label for="birthdate">Date of Birth:</label>
        <input id="birthdate" type="date" name="birthdate" min="1900-01-01" 
        <?php if(isset($_SESSION['user'])): ?>
          value = "<?= $results['dob'] ?>" required>
        <?php else: ?>
          required>
        <?php endif ?>
      </div>
        
      <!-- edit -->
      <?php if(isset($_SESSION['user'])): ?>
        <!-- Error list -->
        <div class="errors">
          <ul id="errors">
            <?php foreach ($errors as $error): ?>
              <li><?= $error ?></li>
            <?php endforeach; ?>
          </ul>
        </div>

        <div class="updated">
          <?php if($updateCount > 0): ?>
              <span>Account Updated</span>
            <?php endif; ?>
        </div>

        <button id="update" name="update"> Save Changes</button>
        <button type="button" name="delete"> Delete Account</button>
      <!-- register -->
      <?php else: ?>
        <div>
          <input id="agreebox" type="checkbox" name="agreebox" required>
          <label for="agreebox">I agree to the <a href="terms.php">Terms and Conditions</a>.</label>
        </div>

        <button id="register" name="register"> Create Account</button>
      <?php endif ?>
    </form>
  </main>

  <?php include 'includes/footer.php' ?>

  <!-- CHECKS PASSWORD STRENGTH -->
  <script>
    var strength = {
      0: "Weakest",
      1: "Weak",
      2: "OK",
      3: "Good",
      4: "Strong"
    }

    var password = document.getElementById('password');
    var meter = document.getElementById('password-strength');
    var text = document.getElementById('password-strength-text');

    password.addEventListener('input', function () {
      var val = password.value;
      var result = zxcvbn(val);

      // This updates the password strength meter
      meter.value = result.score;

      // This updates the password meter text
      if (val !== "") {
        text.innerHTML = "Password Strength: " + strength[result.score];
      } else {
        text.innerHTML = "";
      }
    });
  </script>

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
