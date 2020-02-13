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

        header("Location: display_list.php");
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
            <button onclick="document.getElementById('forgotpass').style.display='block'" class="modBtn" type="button">Forgot password?</button>
          </div>
        </div>

      </div>
    </form>


  </main>

  <?php include 'forgotpass.php' ?>


  <?php include 'includes/footer.php' ?>

</body>

</html>
