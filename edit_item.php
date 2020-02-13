<?php require "checklogin.php" ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            $PAGE_TITLE = "Edit List Item";
            include 'includes/meta.php';
        ?>
    </head>
    <body>
        <!-- HEADER -->
        <header>
            <?php include 'nav.php' ?>
        </header>

        <main>
            <header>
                <!-- LIST Item Name -->
                <h1>Edit <?php //listname ?> Item</h1>
            </header>

            <!-- EDIT LIST -->
            <form id="edit-item" action="process_edit_items.php" method="post" enctype="multipart/form-data">
                <!-- BUCKET LIST ITEM -->
                <div>
                    <label for="item">Item Name:</label>
                    <input type="text" id="item" name="item" placeholder="Enter an item to add to the list..." required/>
                    <button type="button"><i class="fa fa-lock"></i></button>
                </div>

                <!-- ITEM DESCRIPTION -->
                <div>
                    <label for="description">Bucket List Item:</label>
                    <textarea id="description" name="description" rows="5" cols="30" placeholder = "Enter a description for your bucket list item..."></textarea>
                </div>

                <!-- DATE OF COMPLETION -->
                <div>
                    <label for="complete">Date of Completion:</label>
                    <input id="complete" type="date" name="complete" min="1900-01-01">
                </div>

                <!-- IMAGE -->
                <!-- <form enctype="multipart/form-data" action="upload.php" method="post"> -->
                    <!-- IMAGE UPLOAD -->
                    <div>
                        <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
                        <label for="file">File Name:</label>
                        <input type="file" name="fileToProcess" id="file"/>
                    </div>
                <!-- </form> -->

                <!-- SUBMIT -->
                <button type="submit" name="Save">Save</button>
                <button onclick="goback()" type="button" name="Cancel" >Cancel</button>
                <script>
function goBack() {
  window.history.back();
}
</script>
            </form>
        </main>

        <!-- FOOTER -->
        <?php include 'includes/footer.php' ?>

        <!-- SET MAXIMUM DATE THAT LIST ITEM CAN BE COMPLETED -->
        <script>
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; //January is 0!
            var yyyy = today.getFullYear();
            if (dd < 10) {
                dd = '0' + dd
            }
            if (mm < 10) {
                mm = '0' + mm
            }

            today = yyyy + '-' + mm + '-' + dd;
            document.getElementById("complete").setAttribute("max", today);
        </script>
    </body>
</html>
