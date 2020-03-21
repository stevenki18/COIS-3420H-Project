<?php
    // Check for a valid session (if not redirect back to login)
    session_start();
    if(!isset($_SESSION['user'])){
        header("Location:login.php");
    }

    require_once './includes/library.php';
    
    $user = $_SESSION['user'];
    $listid = $_SESSION['listid'];

    $pdo = connectDB();
?>
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
            <?php include 'includes/nav.php' ?>
        </header>

        <main>
            <header>
                <!-- LIST Item Name -->
                <h1>Edit <?php //listname ?> Item</h1>
            </header>

            <!-- EDIT LIST -->
            <form id="edit-item" action="#" method="post" enctype="multipart/form-data">
                <!-- BUCKET LIST ITEM -->
                <div>
                    <label for="item">Item Name:</label>
                    <input type="text" id="item" name="item" placeholder="Enter an item to add to the list..." required/>
                    <button type="button"><i class="fa fa-lock"></i></button>
                </div>

                <!-- ITEM DESCRIPTION -->
                <div>
                    <label for="description">Bucket List Item:</label>
                    <textarea id="description" name="description" rows="5" placeholder = "Enter a description for your bucket list item..."></textarea>
                </div>

                <!-- DATE OF COMPLETION -->
                <div>
                    <label for="complete">Date of Completion:</label>
                    <input id="complete" type="date" name="complete" min="1900-01-01">
                </div>

                <!-- IMAGES -->
                <div>
                    <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
                    <label for="file">File Name:</label>
                    <input type="file" name="my_file[]" id="file" multiple/>
                </div>

                <!-- SUBMIT -->
                <button type="submit" name="Save">Save</button>
                <button onclick="window.history.back()" type="button" name="Cancel" >Cancel</button>
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
