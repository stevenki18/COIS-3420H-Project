<!-- The Modal -->
<div id="login-modal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
      <div class="logo">
        <figure>
          <img src="img/bucket.png" alt="Bucket List Logo" height=50 />
        </figure>
      </div>
    </div>
    <div class="modal-body">
      <div class="login-container">
        <form id="login" action="#" method = "post">
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
              <input type="password" name="password" placeholder="Password" required>
              <input type="submit" value="Login">
              <div id="forgot-pass">
                <a href="#">Forgot password?</a>
              </div>
            </div>

          </div>
        </form>
      </div>

      <div class="register-container">
         <a href="register.php">Sign up</a>
      </div>

    </div>
    <div class="modal-footer">
      <p>&copy; Group 10</p>
    </div>
  </div>

</div>

<script>
  // Get the modal
  var modal = document.getElementById("login-modal");

  // Get the button that opens the modal
  var btn = document.getElementById("login-btn");

  // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("close")[0];

  // When the user clicks the button, open the modal
  btn.onclick = function() {
    modal.style.display = "block";
  }

  // When the user clicks on <span> (x), close the modal
  span.onclick = function() {
    modal.style.display = "none";
  }

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
</script>
