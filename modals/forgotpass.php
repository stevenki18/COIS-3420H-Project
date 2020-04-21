<!-- Page name: forgot_pass.php
Description: Modal window used to change a user's account password if they
forget it. -->

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
        <form id="forgot-pass-modal" action="#" method = "post">
            <!-- ASKS FOR USERNAME AND EMAIL TO LOCATE THE ACCOUNT -->
            <div id="forgotCheck" class="manual-login">
              <input type="text" name="forgotusername" placeholder="Username" required>
              <span class = "error hidden">Please enter a username</span>
              <input type="text" name="forgotemail" placeholder="john@gmail.com" required>
              <span class = "error hidden">Email is invalid</span>
              <button type="submit" name="forgot-check" id="forgot-check">Submit</button>
            </div>
            <!-- ASKS USER TO INPUT NEW PASSWORD -->
            <div id="forgotChange" class="manual-login">
                <label for="forgotpassword">Password (at least 8 characters):</label>
                <input id="forgotpassword" name="forgotpassword" type="password" minlength="8" required>
                <span class = "error hidden">Please enter valid password</span>
                <meter max="4" value="0" id="forgotpassword-strength"></meter>
                <p id="forgotpassword-strength-text"></p>
                <label for="fogotconfirmpassword">Confirm Password:</label>
                <input id="fogotconfirmpassword" name="forgotconfirmpassword" type="password" minlength="8" required>
                <span class = "error hidden">Passwords do not match</span>
              <button type="submit" name="forgot-change" id="forgot-change">Submit</button>
            </div>
        </form>
    </div>

    <div class="modal-footer">
      <p>&copy; Group 10</p>
    </div>

  </div>

</div>
