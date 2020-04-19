<?php
    // Check for a valid session (if not redirect back to login)
    session_start();
    if(!isset($_SESSION['user'])){
        header("Location:login.php");
        exit();
    }

    require_once './includes/library.php';

    $errors = [];
    $itemid = $_GET['item'];
    $viewable = 1;
    $img = 0;

    $pdo = connectDB();

    // GET LIST ITEM INFO
    $query = "SELECT * FROM `g10_listitems` WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$itemid]);
    $result = $stmt->fetch();

    // CHECK FOR IMAGE
    if($result['picpath'] != null){
      $img = 1;
    }

    // Get List information (PREVENT UNAUTHORIZED ACCESS TO EDIT)
    $query2 = "SELECT fk_userid FROM `g10_lists` WHERE id = ? AND fk_userid = ?";
    $stmt2 = $pdo->prepare($query2);
    $stmt2->execute([$result['fk_listid'],$_SESSION['id']]);
    // if no result redirect
    $result2 = $stmt2->fetch();
    if(!$result2){
      header("Location:view_list.php?list=".$result['fk_listid']);
      exit();
    }



    //defines function to create filename
    function createFilename($file, $path, $prefix,$uniqueID){
        $filename=$_FILES[$file]['name'];
        $exts=explode(".", $filename);
        $ext=$exts[count($exts)-1];
        $filename=$prefix.$uniqueID.".".$ext;
        $newname=$path.$filename;
        return $newname;
    }

    //defines function to check and move file
    function checkAndMoveFile($file, $limit, $newname){
        //modified from http://www.php.net/manual/en/features.file-upload.php
        try{
          // Undefined | Multiple Files | $_FILES Corruption Attack
          // If this request falls under any of them, treat it invalid.
          if(!isset($_FILES[$file]['error']) || is_array($_FILES[$file]['error'])) {
             thrownewRuntimeException('Invalid parameters.');
           }

          // Check Error value.
          switch ($_FILES[$file]['error']) {
            case UPLOAD_ERR_OK:
              break;
            case UPLOAD_ERR_NO_FILE:
              thrownewRuntimeException('No file sent.');
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
              thrownewRuntimeException('Exceeded filesize limit.');
            default: thrownewRuntimeException('Unknown errors.');
          }

          // You should also check filesize here.
          if ($_FILES[$file]['size'] >$limit) {
             thrownewRuntimeException('Exceeded filesize limit.');
           }

           // Check the File type
           if (exif_imagetype( $_FILES[$file]['tmp_name']) != IMAGETYPE_GIF
           and exif_imagetype( $_FILES[$file]['tmp_name']) != IMAGETYPE_JPEG
           and exif_imagetype( $_FILES[$file]['tmp_name']) != IMAGETYPE_PNG){
              thrownewRuntimeException('Invalid file format.');
            }

            // $newname should be unique and tested
            if (!move_uploaded_file($_FILES[$file]['tmp_name'], $newname)){
              thrownewRuntimeException('Failed to move uploaded file.');
            }

            echo'File is uploaded successfully.';

          } catch (RuntimeException $e) {
            echo $e->getMessage();
          }
    }

    if(isset($_POST['remove-image'])){
        $query = "UPDATE `g10_listitems` SET picpath = ? WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([null, $itemid]);

        if($stmt->rowCount() > 0)
          $img = 0;
    }


    if(isset($_POST['save'])){
        if(!isset($_POST['itemname']) || strlen($_POST['itemname']) == 0){
            array_push($errors, "Please enter an item name");
        }

        if(isset($_POST['viewable']))
            $viewable = 0;

        if($img == 0){
            //creates new file name for 1 uploaded image, and copies it to loki
          $dbID=uniqid();  //database id for item
          if(is_uploaded_file($_FILES['fileToProcess']['tmp_name'])){
             $newname=createFilename('fileToProcess','../../www_data/', 'img', $dbID);
             checkAndMoveFile('fileToProcess', 1000000, $newname);
           }
         }

        if(sizeof($errors) == 0){
          // Set image path
          if($img == 0){
            $query = "UPDATE `g10_listitems` SET name = ?, description = ?, picpath = ?, completion = ?, private = ? WHERE id = ?";
            $stmt = $pdo->prepare($query);
            if(strlen($_POST['complete']) == 0)
                $stmt->execute([$_POST['itemname'], $_POST['description'], $newname, null, $viewable, $itemid]);
            else
                $stmt->execute([$_POST['itemname'], $_POST['description'], $newname, $_POST['complete'], $viewable, $itemid]);

            header("Location: view_list.php?list=".$result['fk_listid']);
            exit();
          }
          else // Leave image path alone
          {
            $query = "UPDATE `g10_listitems` SET name = ?, description = ?, completion = ?, private = ? WHERE id = ?";
            $stmt = $pdo->prepare($query);
            if(strlen($_POST['complete']) == 0)
                $stmt->execute([$_POST['itemname'], $_POST['description'], null, $viewable, $itemid]);
            else
                $stmt->execute([$_POST['itemname'], $_POST['description'], $_POST['complete'], $viewable, $itemid]);

            header("Location: view_list.php?list=".$result['fk_listid']);
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
                  <?php if($img != 0): ?>
                    <!-- ITEM PHOTO -->
                    <figure class="sampleImage">
                      <img id="image" src="<?= $result['picpath'] ?>" alt="<?= $result['name'] ?>-image"/>
                    </figure>
                    <button type="button" class="delete" name="remove-image">Remove Image</a>
                    
                  <?php else: ?>
                    <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
                    <label for="file">File Name:</label>
                    <input type="file" name="fileToProcess" id="file" multiple/>
                  <?php endif; ?>
                </div>

                <span class="hidden"><?= $result['fk_listid']?></span>
                <!-- SUBMIT -->
                <button type="submit" name="save">Save</button>
                <button type="button" name="Cancel">Cancel</button>
            </form>

            <?php include 'modals/image_view.php' ?>

        </main>

        <!-- FOOTER -->
        <?php include 'includes/footer.php' ?>


    </body>
</html>
