<?php session_start();

  if(isset($_COOKIE['bucket'])){
    $username=$_COOKIE['bucket'];
  }else {
    $username="";
  }
  /* require or include the library */
  // require './includes/library.php';

  /* ------ <from-the-last-lab> ------- */
if(isset($_POST['login'])){
    /* $errors starts as an empty array */
    $errors = [];

    /* Get everything from $_POST */
    $username = $_POST['username'] ?? NULL;
    $password = $_POST['password'] ?? NULL;


    /* Error Validation (from last lab) */
    if (!isset($username) || strlen($username) === 0) array_push($errors, "Please enter a valid username.");
    if (!isset($password)) array_push($errors, "Incorrect Password.");

    if (isset($_POST['remember']))
      setcookie("bucket",$username,time()+60*60*24);

    if (count($errors) === 0) {
      if($username=="master" and $password=="test"){
        session_start();
        $_SESSION['user'] = $username;

        header("Location: index.php");
        exit();
      }
      else {
        header("Location: login.php");
        exit();
      }
    }
  }
?>
<!DOCTYPE HTML>
<html lang="en">

<head>
  <?php
      $PAGE_TITLE = "Login";
      include "includes/meta.php"
    ?>
</head>

<body>

  <header>
    <?php include 'nav.php' ?>
  </header>

  <main>
    <header>
      <!-- Register -->
      <h1>Login</h1>
    </header>

    <!-- FORM -->
    <form id="login" action="<?= $_SERVER['PHP_SELF']; ?>" method = "post">
      <!-- col align logins -->
      <div class="login-methods">
        <h3>Login with Social Media</h3>

        <!-- row align -->
        <div class="social-options">
          <a href="#" class="fb btn">
            <i class="fa fa-facebook fa-fw"></i>
          </a>
          <a href="#" class="twitter btn">
            <i class="fa fa-twitter fa-fw"></i>
          </a>
          <a href="#" class="google btn">
            <i class="fa fa-google fa-fw"></i>
          </a>
        </div >

        <h4>or Manually</h4>

        <div class="manual-login">
          <input type="text" name="username" placeholder="Username" value="<?= $username ?>" required>
          <input type="password" name="password" placeholder="Password" required>

          <div id="remember-me-sect">
            <label for="remember_me">Remember Me</label>
            <input type="checkbox" id="remember_me" name="remember" value="0"/>
          </div>

          <div class="register-login">
             <a href="register.php">Create Account</a>
             <button type="submit" name="login">Login</button>
          </div>

          <div id="forgot-pass">
            <a href="#forgotpass" class="modBtn">Forgot password?</a>
          </div>
        </div>

      </div>
    </form>


  </main>

  <?php include 'forgotpass.php' ?>

  <script>
      // Get the modal
      var modal = document.getElementsByClassName('modal');

      // Get the button that opens the modal
      var btn = document.getElementsByClassName("modBtn");

      // Get the <span> element that closes the modal
      var span = document.getElementsByClassName("close");

      // When the user clicks the button, open the modal
      btn[0].onclick = function() {
          modal[1].style.display = "block";
      }

      // When the user clicks on <span> (x), close the modal
      span[1].onclick = function() {
          modal[1].style.display = "none";
      }

      // When the user clicks anywhere outside of the modal, close it
      window.onclick = function(event) {
          if (event.target == modal[1]) {
              modal[1].style.display = "none";
          }
      }
  </script>

  <?php include 'includes/footer.php' ?>

</body>

</html>
