<!-- The Modal -->
<div id="edit-modal" class="modal">

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
      <div class="edit-container">
        
        <!-- EDIT LIST -->
        <form id="edit-item" action="#" method="post">
          <!-- BUCKET LIST ITEM -->
          <div>
              <label for="item">Bucket List Item:</label>
              <input type="text" id="item" name="item" placeholder="Enter a Bucket List Item..."/>
          </div>

          <!-- ITEM DESCRIPTION -->
          <div>
              <label for="description">Bucket List Item:</label>
              <input type="text" id="description" name="description" placeholder="Enter a description about your item..."/>
          </div>

          <!-- IMAGE -->
          <form enctype="multipart/form-data" action="upload.php" method="post">
              <!-- IMAGE UPLOAD -->
              <div>
                  <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
                  <label for="file">File Name:</label>
                  <input type="file" name="fileToProcess" id="file"/>
              </div>
          </form>

          <!-- SUBMIT -->
          <input type="submit" value="Edit"/>
        </form>
        
      </div>
    </div>

    <!-- FOOTER -->
    <div class="modal-footer">
      <p>&copy; Group 10</p>
    </div>
  </div>

</div>

<script>
  // Get the modal
  var modal = document.getElementById("edit-modal");

  // Get the button that opens the modal
  var btn = document.getElementById("edit-btn");

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
