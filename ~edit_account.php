<?php
// Check for a valid session (if not redirect back to login)
session_start();
 if(!isset($_SESSION['user'])){
   header("Location:login.php");
 }

 require_once './includes/library.php';


 $user = $_SESSION['user'];
 $updateCount= 0;
 $changepass = 0;

  /* $errors starts as an empty array */
  $errors = [];

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
     }else{
       $query = "UPDATE `g10_users` SET first= ?, last= ?, email= ?, dob=? WHERE username = ?";
       $statement = $pdo->prepare($query);

       $statement->execute([$fname, $lname, $email, $dob, $user]);
       $updateCount = $statement->rowCount();
   }
  }
}


 $pdo = connectDB();

 $query = "SELECT * FROM g10_users WHERE username = ?";
 $stmt = $pdo->prepare($query);
 $stmt->execute([$user]);

 $results = $stmt->fetch();

?>
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
    <?php include 'includes/nav.php' ?>
  </header>

  <main>
    <header>
      <!-- EDIT ACCOUNT -->
      <h1>Edit Account Information</h1>
    </header>

    <!-- FORM -->
    <form id="register-form" action="<?= $_SERVER['PHP_SELF'];?>" method="post">
      <div>
        <label for="username">Username:</label>
        <input id="username" name="username" type="text" value = "<?= $results['username'] ?>" readonly>
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
        <input id="firstname" name="firstname" type="text" value = "<?= $results['first'] ?>" required>
      </div>

      <div>
        <label for="lastname">Last Name:</label>
        <input id="lastname" name="lastname" type="text" value = "<?= $results['last']?>" required>
      </div>

      <div>
        <label for="email">Email Address:</label>
        <input id="email" name="email" type="text" value = "<?= $results['email']?>" required>
      </div>

      <!-- MINIMUM = JAN 1, 1900, MAXIMUM = TODAY (SET IN SCRIPT AT BOTTOM) -->
      <div>
        <label for="birthdate">Date of Birth:</label>
        <input id="birthdate" type="date" name="birthdate" value = "<?= $results['dob']?>" min="1900-01-01" required>
      </div>

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

      <button type="submit" name="update"> Save Changes</button>
      <button type="button" name="delete"> Delete Account</button>
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
