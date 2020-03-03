<?php session_start();

  if(isset($_COOKIE['bucket'])){
    $user=$_COOKIE['bucket'];
  }else {
    $user="";
  }
  /* require or include the library */
  require_once './includes/library.php';

  /* $errors starts as an empty array */
  $errors = [];
  $usererror = false;

  /* ------ <from-the-last-lab> ------- */
  if(isset($_POST['login'])){


    /* Get everything from $_POST */
    $user = $_POST['username'] ?? NULL;
    $pass = $_POST['password'] ?? NULL;


    /* Error Validation (from last lab) */
    if (!isset($user) || strlen($user) === 0) array_push($errors, "Please enter a valid username.");
    if (!isset($pass)) array_push($errors, "Incorrect Password.");

    if (count($errors) === 0) {
      $pdo = connectDB();

      $query = "SELECT * FROM g10_users WHERE username = ?";
      $stmt = $pdo->prepare($query);
      $results=$stmt->execute([$user]);

      if($row=$stmt->fetch()){
        //verify password
        if(password_verify($pass, $row['pass'])){
          session_start();
          $_SESSION['user'] = $user;
          $_SESSION['id'] = $row['id'];

          if (isset($_POST['remember']))
            setcookie("bucket",$user,time()+60*60*24);

          header("Location: display_list.php");
          exit();

        }else{ // password_verify
          $usererror=true;
        }// END IF (password_verify)

      }else{ //Fetch failed (No row for username)
        $usererror=true;
      } // END IF (row fetch)
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
    <?php include 'includes/nav.php' ?>
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
          <input type="text" name="username" placeholder="Username" value="<?= $user ?>" required>
          <input type="password" name="password" placeholder="Password" required>
          <!--notice variable which triggers output of error message if sticky processing fails-->
          <?php if ($usererror){?><span class="error">Your username or password was invalid</span> <?php }?>

          <div id="remember-me-sect">
            <label for="remember_me">Remember Me</label>
            <input type="checkbox" id="remember_me" name="remember" value="0"/>
          </div>

          <!-- Error list -->
          <div class="errors">
            <ul id="errors">
              <?php foreach ($errors as $error): ?>
                <li><?= $error ?></li>
              <?php endforeach; ?>
            </ul>
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

  <?php include 'modals/forgotpass.php' ?>


  <?php include 'includes/footer.php' ?>

</body>

</html>
