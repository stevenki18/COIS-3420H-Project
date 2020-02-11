<?php session_start(); ?>
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
      <h1>Register</h1>
    </header>

    <!-- FORM -->
    <div class="login-container">
      <form id="login" action="processlogin.php" method = "post">
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
            <a href="#" class="google btn"><i class="fa fa-google fa-fw"></i>
            </a>
          </div>

          <h4>or Manually</h4>

          <div class="manual-login">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password">

            <div>
              <label for="remember_me">Remember Me</label>
              <input type="checkbox" id="remember_me" name="remember" value="1"/>
            </div>
            <input type="submit" value="Login">
            <div id="forgot-pass">
              <a href="#forgotpass" class="modBtn">Forgot password?</a>
            </div>
          </div>

        </div>
      </form>
    </div>

    <div class="register-container">
       <a href="register.php">Sign up</a>
    </div>
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
          modal[0].style.display = "block";
      }

      // When the user clicks on <span> (x), close the modal
      span[0].onclick = function() {
          modal[0].style.display = "none";
      }

      // When the user clicks anywhere outside of the modal, close it
      window.onclick = function(event) {
          if (event.target == modal[0]) {
              modal[0].style.display = "none";
          }
      }
  </script>

  <?php include 'includes/footer.php' ?>

</body>

</html>
