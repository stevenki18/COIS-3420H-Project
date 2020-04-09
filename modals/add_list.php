<!-- The Modal -->
<div id="create-modal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
        <!-- HEADER -->
        <div class="modal-header">
            <span onclick="document.getElementById('create-modal').style.display='none'" class="close">&times;</span>
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
                <form id="create-list" action="process/process_add_list.php" method = "post">
                    <div>
                        <label for="listName">Add Bucket List:</label>
                        <input type="text" id="listName" name="listName" placeholder="List Name" required/>
                        <span class = "error hidden">Please Enter An List Name</span>
                    </div>

                    <div>
                        <label for="viewableList">Publicly Viewable?</label>
                        <input id="viewableList" type="checkbox" name="viewableList">
                    </div>

                    <!-- SUBMIT -->
                    <button id="addListToDB" name="submitList">Add List</button>

                </form>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="modal-footer">
            <p>&copy; Group 10</p>
        </div>

</div>
