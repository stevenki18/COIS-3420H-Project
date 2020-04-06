<!-- The Modal -->
<div id="add-modal" class="modal">

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

                <!-- ADD ITEM TO LIST -->
                <form id="addToList" action="<?php echo $_SERVER['PHP_SELF'] ?>" method = "post">
                    <div>
                        <label for="itemname">Add Bucket Item:</label>
                        <input type="text" id="itemname" name="itemname" placeholder="Item Name" required/>
                        <span class = "error hidden">Please Enter An Item Name</span>
                    </div>

                    <div>
                        <label for="viewable">Publicly Viewable?</label>
                        <input id="viewable" type="checkbox" name="viewable">
                    </div>
                    
                    <!-- SUBMIT -->
                    <button id="addItemToDB" name="submit">Add Item</button>
                </form>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="modal-footer">
            <p>&copy; Group 10</p>
        </div>

      </div>
    </div>
