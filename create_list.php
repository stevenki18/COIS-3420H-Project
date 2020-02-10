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
                <form id="create-list" action="#" method = "post">
                    <div>
                        <label for="add-list">Add Bucket List:</label>
                        <input type="text" id="add-list" name="add-list" placeholder="List Name"/>
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

<script>
    // Get the modal
    var modal = document.getElementById("create-modal");

    // Get the button that opens the modal
    var btn = document.getElementById("create-btn");

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
