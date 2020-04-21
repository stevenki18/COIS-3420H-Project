<?php
  /*-----------------------------------------------------------
  |
  |   PAGE:         login.php
  |
  |   DESCRIPTION:  Login page which gives the user the option
  |                 to login to an existing account or create
  |                 a new one either manually or by linking
  |                 their Google account.
  |
  -----------------------------------------------------------*/
  session_start();

  if(isset($_COOKIE['bucket']))
    $user=$_COOKIE['bucket'];
  
  else
    $user="";

  // If redirected to login page and already logged in
  // Handle also if logout
  if(isset($_SESSION['user']) && !isset($_POST['logout'])){
    header("Location: display_list.php");
    exit();
  }

  require_once './includes/library.php';
  $pdo = connectDB();

  $errors = [];
  $usererror = false;

  /*---------------------------
  |
  |           LOGIN
  |
  ---------------------------*/
  if(isset($_POST['login'])){

    // Get everything from $_POST
    $user = $_POST['username'] ?? NULL;
    $pass = $_POST['password'] ?? NULL;

    // SANITIZE USERNAME INPUT (USING THIS TO CHECK LOGIN)
    $sanitizedUser = filter_var($user, FILTER_SANITIZE_STRING);
    
    // USERNAME
    if (!$sanitizedUser || strlen($sanitizedUser) == 0)
      array_push($errors, "Please enter a valid username.");
    // PASSWORD
    if (!isset($pass)) 
      array_push($errors, "Incorrect Password.");
    // No errors do the work with the database
    if (count($errors) == 0) {
      $query = "SELECT * FROM g10_users WHERE username = ?";
      $stmt = $pdo->prepare($query);
      $results=$stmt->execute([$sanitizedUser]);

      if($row=$stmt->fetch()){
        //verify password
        if(password_verify($pass, $row['pass'])){
          session_start();
          $_SESSION['user'] = $sanitizedUser;
          $_SESSION['id'] = $row['id'];

          if (isset($_POST['remember']))
            setcookie("bucket",$user,time()+60*60*24);

          header("Location: display_list.php");
          exit();

        }
        else
          $usererror=true;

      }
      
      //Fetch failed (No row for username)
      else 
        $usererror=true;
    }// END OF DB WORK
  }// END OF LOGIN


  /*---------------------------
  |
  |       GOOGLE LOGIN
  |
  ---------------------------*/
  if(isset($_POST['g-login'])){
    // NO SANITIZE AS GOOGLE HANDLES IT ON THEIR END
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $query = "SELECT * FROM g10_users WHERE username = ?";
    $stmt = $pdo->prepare($query);
    $results=$stmt->execute([$email]);

    if($row=$stmt->fetch()){
      //verify password
      if(password_verify($pass, $row['pass'])){
        $_SESSION['user'] = $row['username'];
        $_SESSION['id'] = $row['id'];

        if (isset($_POST['remember']))
          setcookie("bucket",$user,time()+60*60*24);

        echo "Success";
        exit();

      }

      else
        $usererror=true;
    }
    
    //Fetch failed (No row for username)
    else
      $usererror=true;

    exit();
  }// END OF GOOGLE LOGIN

  
  /*---------------------------
  |
  |          LOGOUT
  |
  ---------------------------*/
  if(isset($_POST['logout'])){
    session_unset($_SESSION['user']);
    echo "Logged Out";
    exit();
  }// END OF LOGOUT

?>
<!DOCTYPE HTML>
<html lang="en">

<head>
  <?php
      $PAGE_TITLE = "Login";
      require "includes/meta.php"
    ?>
    <!-- ADDITIONAL SCRIPTS FOR GOOGLE SIGN IN  -->
    <script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
    <!-- <script defer src="scripts/zxcvbn.js"></script> -->
</head>

<body>

  <header>
    <?php include 'includes/nav.php' ?>
  </header>

  <main>
    <header>
      <h1>Login</h1>
    </header>

    <!-- LOGIN FORM -->
    <form id="login" action="<?= $_SERVER['PHP_SELF']; ?>" method = "post">
      <!-- col align logins -->
      <div class="login-methods">
        <!-- row align -->
        <div class="social-options">
          <!-- REQUIRED FOR GOOGLE SIGN ON -->
          <div class="g-signin2" id="my-signin2" data-onsuccess="onSignIn"></div>
          <a href="#" class="hidden" id="g-signout">Sign out</a>
          <a href="#" class="hidden" id="g-login">Continue as ...</a>
        </div >


        <div class="manual-login">
          <!-- LOGIN -->
          <input type="text" name="username" placeholder="Username" value="<?= $user ?>" required>
          <input type="password" name="password" placeholder="Password" required>
          
          <!-- notice variable which triggers output of error message if sticky processing fails -->
          <?php if ($usererror):?>
            <span class="error">Your username or password was invalid</span> 
          <?php endif ?>

          <!-- REMEMBER ME -->
          <div id="remember-me-sect">
            <label for="remember_me">Remember Me</label>
            <input type="checkbox" id="remember_me" name="remember" value="0"/>
          </div>

          <!-- Error list -->
          <div class="errors">
            <ul id="errors">
              <?php foreach ($errors as $error): ?>
                <li><?= $error ?></li>
              <?php endforeach ?>
            </ul>
          </div>
          
          <!-- LOGIN -->
          <button type="submit" name="login">Login</button>
          
          <!-- FORGOT PASSWORD -->
          <button id="forgot" class="modBtn" type="button">Forgot Password</button>

          <!-- REGISTER -->
          <button id="register" name="register">Register Here</button>

        </div>
      </div>
    </form>

  </main>

  <?php 
    include 'modals/forgotpass.php';
    include 'includes/footer.php' 
  ?>

</body>

</html>
