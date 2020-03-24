<?php
    // Check for a valid session (if not redirect back to login)
    session_start();
    if(!isset($_SESSION['user'])){
        header("Location:login.php");
    }

    require_once './includes/library.php';

    $errors = [];
    $viewable = 1;

    $pdo = connectDB();
    $query = "SELECT * FROM `g10_listitems` WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_SESSION['itemid']]);
    $result = $stmt->fetch();

    if(isset($_POST['save'])){
        if(!isset($_POST['itemname']) || strlen($_POST['itemname']) == 0){
            array_push($errors, "Please enter an item name");
        }

        if(isset($_POST['viewable']))
            $viewable = 0;
        
        if(sizeof($errors) == 0){
            $query = "UPDATE `g10_listitems` SET name = ?, description = ?, completion = ?, private = ? WHERE id = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$_POST['itemname'], $_POST['description'], $_POST['completion'], $viewable, $_SESSION['itemid']]);
            
            if($stmt->rowCount() == 0){
                array_push($errors, "Error updating list item");
            }

            else{
                header("Location: manage_list.php");
                exit();
            }
        }
        
    }
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
                <h1>Edit Item</h1>
            </header>

            <!-- EDIT LIST -->
            <form id="edit-item" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                <!-- BUCKET LIST ITEM -->
                <div>
                    <label for="itemname">Item Name:</label>
                    <input type="text" id="itemname" name="itemname" value= "<?= $result['name']?>" required/>
                </div>

                <div>
                    <label for="viewable">Publicly Viewable?</label>
                    <?php if($result['private'] == 1): ?>
                        <input id="viewable" type="checkbox" name="viewable" value="off">
                    <?php elseif($result['private'] == 0): ?>
                        <input id="viewable" type="checkbox" name="viewable" value="on">
                    <?php endif ?>
                </div>

                <!-- ITEM DESCRIPTION -->
                <div>
                    <label for="description">Bucket List Item:</label>
                    <textarea id="description" name="description" rows="5" value = "<?= $result['description']?>"></textarea>
                </div>

                <!-- DATE OF COMPLETION -->
                <div>
                    <label for="complete">Date of Completion:</label>
                    <input id="complete" type="date" name="complete" value = "<?= $result['completion'] ?>" min="1900-01-01">
                </div>

                <!-- IMAGES -->
                <div>
                    <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
                    <label for="file">File Name:</label>
                    <input type="file" name="my_file[]" id="file" multiple/>
                </div>

                <!-- SUBMIT -->
                <button type="submit" name="save">Save</button>
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
