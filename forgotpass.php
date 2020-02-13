<?php
/* require or include the library */
// require './includes/library.php';

/* ------ <from-the-last-lab> ------- */
if(isset($_POST["Submit"])){/* Redirect if $_POST has nothing in it */
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
}

?>
<!-- The Modal -->
<div id="forgotpass" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span onclick="document.getElementById('forgotpass').style.display='none'" class="close">&times;</span>
      <div class="logo">
        <figure>
          <img src="img/bucket.png" alt="Bucket List Logo" height=50 />
        </figure>
      </div>
    </div>


    <div class="modal-body">
      <h3>Forgot your password</h3>
        <form id="forgot-pass-modal" action="<?= $_SERVER['PHP_SELF']; ?>" method = "post">
          <!-- col align logins -->
            <div class="manual-login">
              <input type="text" name="username" placeholder="Username" required>
              <input type="text" name="email" placeholder="john@gmail.com" required>
              <button type="submit" name="Submit">Submit</button>
            </div>
        </form>
    </div>

    <div class="modal-footer">
      <p>&copy; Group 10</p>
    </div>

  </div>

</div>
