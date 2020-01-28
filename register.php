<!DOCTYPE HTML>
<html lang="en">
    <?php include 'head_include.php' ?>

    <body>
            <?php include 'header.php' ?>

            <main>
                <!-- FORM -->
                <form id="register-form" action="./processregistration.php" method="post">
                <!-- INPUT -->
                <!-- INSERT UNIQUE IN DB -->
                <!-- CREATE ACCOUNT -->
                  <div>
                    <!-- how would i check if the usrname is unique? -->
                    <label for="usrname">Username:</label>
                    <input id="usrname" type="text" placeholder="Thrillseeker99" required>
                  </div>

                  <div class="container">
                    <label for="password">Password (at least 8 characters):</label>
                    <input name="password" type="password" id="password" minlength="8" required>
                    <meter max="4" id="password-strength"></meter>
                    <p id="password-strength-text"></p>
                    <script type="text/javascript">
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

                    password.addEventListener('input', function() {
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
                  </div>

                  <!-- I think password confirm needs javascript or jquery to work -->
                  <div class="container">
                    <label for="password_confirm">Confirm Password:</label>
                    <input name="password_confirm" type="password" id="password_confirm" minlength="8" required>
                  </div>

                  <div>
                    <label for="firstname">First Name:</label>
                    <input id="firstname" type="text" placeholder="Mary" required>
                  </div>

                  <div>
                    <label for="lastname">Last Name:</label>
                    <input id="lastname" type="text" placeholder="Sue" required>
                  </div>

                  <div>
                    <label for="email">Email Address:</label>
                    <input id="email" type="email" placeholder="mary.sue@gmail.com" required>
                  <div>

                    <!-- can ppl under 13 years use our website? -->
                    <!-- it also still needs validation. (cant have any 200 year olds) -->
                  <div>
                    <label for="birthdate">Date of Birth:</label>
                    <input id="birthdate" type="date" name="birthdate" max=<"1900-01-01" min="2015-01-01" required>
                  </div>

                  <div>
                    <input id="agreebox" type="checkbox" name="agreebox" required>
                    <label for="agreebox">I agree to the <a href="yolo">Terms and Conditions</a>.</label>
                  </div>

                    <button id="submit" name="Create Account"> Create Account</button>
                </form>
            </main>

            <?php include 'footer.php' ?>
    </body>
</html>
