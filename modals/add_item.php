<!-- Page name: add_item.php
Description: Modal window used to add a item to a bucket list. Includes item
name, description, and item privacy. -->

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
                <form id="addToList" action="<?= $_SERVER['PHP_SELF'] ?>?list=<?= $listid?>" method = "post">
                    <!-- BUCKET LIST NAME -->
                    <div>
                        <label for="itemname">Add Bucket Item:</label>
                        <input type="text" id="itemname" name="itemname" placeholder="Item Name" required/>
                        <span class = "error hidden">Please Enter An Item Name</span>
                    </div>

                    <!-- ITEM DESCRIPTION (only show during feeling lucky) -->
                    <div class="hidden">
                        <label for="luckydescription">Description:</label>
                        <textarea id="luckydescription" name="lukcydescription" rows="5" cols="30" readonly></textarea>
                    </div>

                    <!-- ITEM PRIVACY SETTING -->
                    <div>
                        <label for="viewable">Publicly Viewable?</label>
                        <input id="viewable" type="checkbox" name="viewable">
                    </div>

                    <!-- SUBMIT -->
                    <button id="addItemToDB" name="add_item">Add Item</button>
                    <button id="feelingLucky" name="feel_lucky">I Feel Lucky</button>
                </form>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="modal-footer">
            <p>&copy; Group 10</p>
        </div>

      </div>
    </div>
