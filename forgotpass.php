<!-- The Modal -->
<div id="forgotpass" class="modal">

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
      <h3>Forgot your password</h3>
      <div class="login-container">
        <form id="login" action="processforgotpass.php" method = "post">
          <!-- col align logins -->
            <div class="manual-login">
              <input type="text" name="username" placeholder="Username" required>
              <input type="text" name="email" placeholder="john@gmail.com" required>
              <input type="submit" value="Submit">
            </div>
        </form>
      </div>

    </div>
    <div class="modal-footer">
      <p>&copy; Group 10</p>
    </div>
  </div>

</div>
