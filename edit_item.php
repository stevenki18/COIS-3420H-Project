<?php
    // Check for a valid session (if not redirect back to login)
    session_start();
    if(!isset($_SESSION['user'])){
        header("Location:login.php");
    }

    require_once './includes/library.php';

    $errors = [];
    $itemid = $_GET['item'];
    $viewable = 1;

    $pdo = connectDB();

    // GET LIST ITEM INFO
    $query = "SELECT * FROM `g10_listitems` WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$itemid]);
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
            if(strlen($_POST['complete']) == 0)
                $stmt->execute([$_POST['itemname'], $_POST['description'], null, $viewable, $itemid]);
            else
                $stmt->execute([$_POST['itemname'], $_POST['description'], $_POST['complete'], $viewable, $itemid]);
            
            header("Location: manage_list.php");
            exit();
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
            <form id="edit-item" action="<?= $_SERVER['PHP_SELF'] ?>?item=<?=$itemid?>" method="post" enctype="multipart/form-data">
                <!-- BUCKET LIST ITEM -->
                <div>
                    <label for="itemname">Item Name:</label>
                    <input type="text" id="itemname" name="itemname" value= "<?= $result['name']?>" required/>
                </div>

                <div>
                    <label for="viewable">Publicly Viewable?</label>
                    <input id="viewable" type="checkbox" name="viewable" 
                        <?php if($result['private'] == 0): ?>
                        checked>
                    <?php else: ?>
                        >
                    <?php endif ?>
                </div>

                <!-- ITEM DESCRIPTION -->
                <div>
                    <label for="description">Bucket List Item:</label>
                    <textarea id="description" name="description" rows="5"><?= $result['description']?></textarea>
                </div>

                <!-- DATE OF COMPLETION -->
                <div>
                    <label for="complete">Date of Completion:</label>
                    <input id="complete" type="date" name="complete" min="1900-01-01" value= "<?= $result['completion']?>">
                </div>

                <!-- IMAGES -->
                <div>
                    <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
                    <label for="file">File Name:</label>
                    <input type="file" name="my_file[]" id="file" multiple/>
                </div>

                <!-- SUBMIT -->
                <button type="submit" name="save">Save</button>
                <button onclick="window.history.back()" type="button" name="Cancel">Cancel</button>
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
