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
                <form id="view-item" action="#" method="post">
                    <!-- BUCKET LIST ITEM -->
                    <div>
                        <label for="item">Item Name:</label>
                        <input type="text" id="item" name="item" readonly/>
                    </div>

                    <!-- ITEM DESCRIPTION -->
                    <div>
                        <label for="description">Bucket List Item:</label>
                        <textarea id="description" name="description" rows="5" cols="30" readonly></textarea>
                    </div>

                    <!-- DATE OF COMPLETION -->
                    <div>
                        <label for="complete">Date of Completion:</label>
                        <input id="complete" type="date" name="complete" readonly>
                    </div>
                </form>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="modal-footer">
            <p>&copy; Group 10</p>
        </div>
    </div>
</div>
