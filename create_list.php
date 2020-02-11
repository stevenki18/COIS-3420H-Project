<!-- The Modal -->
<div id="create-modal" class="modal">

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

                <!-- CREATE LIST -->
                <form id="create-list" action="manage_list.php" method = "post">
                    <div>
                        <label for="add-list">Add Bucket List:</label>
                        <input type="text" id="add-list" name="add-list" placeholder="List Name" required/>
                        <button type="button" name="add-list" id="add-list"><i class="fa fa-unlock"></i></button>
                    </div>

                    <!-- SUBMIT -->
                    <input type="submit" value="Create List"/>

                </form>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="modal-footer">
            <p>&copy; Group 10</p>
        </div>

</div>
