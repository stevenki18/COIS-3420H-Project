<!-- The Modal -->
<div id="view-modal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
        <!-- HEADER -->
        <div class="modal-header">
            <span class="close">&times;</span>
            <div class="logo">
                <figure>
                <img src="img/bucket.png" alt="Bucket List Logo" height=50 />
                </figure>
            </div>
        </div>

        <!-- BODY -->
        <div class="modal-body">
            <div class="create-container">

                <!-- EDIT LIST -->
                <form id="view-item" action="process_delete_account.php" method="post">
                    <h3>Delete Account</h3>
                    <p>Are you sure that you want to delete your account? This 
                        action cannot be undone and all associated account information will be lost.</p>
                    <p>Enter your login information to continue...</p>
                    
                    <!-- USER CREDENTIALS -->
                    <input type="text" name="username" placeholder="Username" value="<?= $username ?>" required>
                    <input type="password" name="password" placeholder="Password">
                    
                    <button type="submit" name="Delete Account"> Delete Account</button>
                </form>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="modal-footer">
            <p>&copy; Group 10</p>
        </div>

</div>
