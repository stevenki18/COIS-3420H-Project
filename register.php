<!DOCTYPE HTML>
<html lang="en">

<head>
  <?php 
      $PAGE_TITLE = "Registration";
      include "includes/meta.php"
    ?>
  <link type="text/css" rel="stylesheet" href="css/form.css" />
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
    <form id="register-form" action="process/processregistration.php" method="post">
      <div>
        <!-- how would i check if the usrname is unique? -->
        <label for="username">Username:</label>
        <input id="username" name="username" type="text" placeholder="Thrillseeker99" required>
      </div>

      <div>
        <label for="password">Password (at least 8 characters):</label>
        <input name="password" type="password" id="password" minlength="8" required>
        <meter max="4" id="password-strength"></meter>
        <p id="password-strength-text"></p>
      </div>

      <!-- I think password confirm needs javascript or jquery to work -->
      <div>
        <label for="password_confirm">Confirm Password:</label>
        <input name="password_confirm" type="password" id="password_confirm" minlength="8" required>
      </div>

      <div>
        <label for="firstname">First Name:</label>
        <input id="firstname" name="firstname" type="text" placeholder="Mary" required>
      </div>

      <div>
        <label for="lastname">Last Name:</label>
        <input id="lastname" name="lastname" type="text" placeholder="Sue" required>
      </div>

      <div>
        <label for="email">Email Address:</label>
        <input id="email" name="email" type="text" placeholder="mary.sue@gmail.com" required>
      </div>

      <!-- can ppl under 13 years use our website? -->
      <!-- it also still needs validation. (cant have any 200 year olds) -->
      
      <!-- MINIMUM = JAN 1, 1900, MAXIMUM = TODAY (SET IN SCRIPT AT BOTTOM) -->
      <div>
        <label for="birthdate">Date of Birth:</label>
        <input id="birthdate" type="date" name="birthdate" min="1900-01-01" required>
      </div>

      <div>
        <input id="agreebox" type="checkbox" name="agreebox" required>
        <label for="agreebox">I agree to the <a href="terms.php">Terms and Conditions</a>.</label>
      </div>

      <button id="submit" name="Create Account"> Create Account</button>
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