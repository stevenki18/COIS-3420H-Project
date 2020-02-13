<!-- The Modal -->
<div id="add-modal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
        <!-- HEADER -->
        <div class="modal-header">
            <span onclick="document.getElementById('add-modal').style.display='none'" class="close">&times;</span>
            <div class="logo">
                <figure>
                <img src="img/bucket.png" alt="Bucket List Logo" height=50 />
                </figure>
            </div>
        </div>

        <!-- BODY -->
        <div class="modal-body">
            <div class="create-container">

                <!-- ADD ITEM TO LIST -->
                <form id="add-item" action="edit_item.php" method = "post">
                    <div>
                        <label for="add-item">Add Bucket Item:</label>
                        <input type="text" id="add-item" name="add-item" placeholder="Item Name" required/>
                        <button type="button" name="add-item" id="add-item"><i class="fa fa-unlock"></i></button>
                    </div>

                    <!-- SUBMIT -->
                    <input type="submit" value="Add Items"/>
                </form>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="modal-footer">
            <p>&copy; Group 10</p>
        </div>

      </div>
    </div>
