<!-- The Modal -->
<div id="removeitem-modal" class="modal">

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
                <form id="removeFromList" action="<?= $_SERVER['PHP_SELF'] ?>?list=<?= $listid?>" method = "post">

                    <p>Are you sure?</p>
                    <input type="text" id="listItemNo" name="itemNo" class="hidden" />

                    <!-- SUBMIT -->
                    <button id="removeItemFromDB" name="remove_item">Yes</button>
                </form>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="modal-footer">
            <p>&copy; Group 10</p>
        </div>

      </div>
    </div>
