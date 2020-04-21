<?php
  /*-----------------------------------------------------------
  |
  |   PAGE:         edit_item.php
  |
  |   DESCRIPTION:  Page designed to edit an items details. 
  |                 Allows a description of the item, date of
  |                 completion and a single image upload of max
  |                 size 1MB in addition to the item name and 
  |                 viewable status (public/private)
  |
  -----------------------------------------------------------*/

  // Check for a valid session (if not redirect back to login)
  session_start();
  if(!isset($_SESSION['user'])){
      header("Location:login.php");
      exit();
  }

  require_once './includes/library.php';
  $pdo = connectDB();

  $errors = [];
  $itemid = $_GET['item'];
  $viewable = 1;
  $img = 0;

  // GET LIST ITEM INFO
  $query = "SELECT * FROM `g10_listitems` WHERE id = ?";
  $stmt = $pdo->prepare($query);
  $stmt->execute([$itemid]);
  $result = $stmt->fetch();

  // CHECK FOR IMAGE
  if($result['picpath'] != null){
    $img = 1;
  }

  // PREVENT UNAUTHORIZED ACCESS TO EDIT
  $query = "SELECT fk_userid FROM `g10_lists` WHERE id = ? AND fk_userid = ?";
  $stmt = $pdo->prepare($query);
  $stmt->execute([$result['fk_listid'],$_SESSION['id']]);
  $auth = $stmt->fetch();
  if(!$auth){
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
      if ($_FILES[$file]['size'] >$limit){
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

    }
    catch (RuntimeException $e){
      echo $e->getMessage();
    }
  }

  /*---------------------------
  |
  |       REMOVE IMAGE
  |
  ---------------------------*/
  if(isset($_POST['remove-image'])){
    //DELETE THE FILE
    unlink($result['picpath']);
    // UPDATE SQL
    $query = "UPDATE `g10_listitems` SET picpath = ? WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([null, $itemid]);
    if($stmt->rowCount() > 0)
      $img = 0;
  }// END OF REMOVE IMAGE

  /*---------------------------
  |
  |       SAVE CHANGES
  |
  ---------------------------*/
  if(isset($_POST['save'])){
    $itemname = filter_var($_POST['itemname'], FILTER_SANITIZE_STRING);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);

    // ITEM NAME
    if(!$itemname || strlen($itemname) == 0)
      array_push($errors, "Please enter an item name");
    
    // VIEWABLE
    if(isset($_POST['viewable']))
      $viewable = 0;

    // DESCRIPTION
    if(strlen($description) != 0 && !$description)
      array_push($errors, "Cannot add this description");

    // IMAGE
    if($img == 0){
      //creates new file name for 1 uploaded image, and copies it to loki
      $dbID=uniqid();  //database id for item
      if(is_uploaded_file($_FILES['fileToProcess']['tmp_name'])){
        $newname=createFilename('fileToProcess','../../www_data/', 'img', $dbID);
        checkAndMoveFile('fileToProcess', 1000000, $newname);
      }
    }
    // No errors do the work with the database
    if(sizeof($errors) == 0){
      // Set image path
      if($img == 0){
        $query = "UPDATE `g10_listitems` SET name = ?, description = ?, picpath = ?, completion = ?, private = ? WHERE id = ?";
        $stmt = $pdo->prepare($query);
        if(strlen($_POST['complete']) == 0)
          $stmt->execute([$itemname, $description, $newname, null, $viewable, $itemid]);
        else
          $stmt->execute([$itemname, $description, $newname, $_POST['complete'], $viewable, $itemid]);

        header("Location: view_list.php?list=".$result['fk_listid']);
        exit();
      }
      // Leave image path alone
      else{
        $query = "UPDATE `g10_listitems` SET name = ?, description = ?, completion = ?, private = ? WHERE id = ?";
        $stmt = $pdo->prepare($query);
        if(strlen($_POST['complete']) == 0)
            $stmt->execute([$itemname, $description, null, $viewable, $itemid]);
        else
            $stmt->execute([$itemname, $description, $_POST['complete'], $viewable, $itemid]);

        header("Location: view_list.php?list=".$result['fk_listid']);
        exit();
      }
    }// END OF DB WORK

  }// END OF SAVE CHANGES
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
  <header>
    <?php include 'includes/nav.php' ?>
  </header>

  <main>
    <header>
      <h1>Edit Item</h1>
    </header>

    <!-- EDIT LIST FORM -->
    <form id="edit-item" action="<?= $_SERVER['PHP_SELF'] ?>?item=<?=$itemid?>" method="post" enctype="multipart/form-data">
      <!-- BUCKET LIST ITEM -->
      <div>
        <label for="itemname">Item Name:</label>
        <input type="text" id="itemname" name="itemname" value="<?= $result['name']?>" required />
        <span class="error hidden">Please enter an item name</span>
      </div>

      <!-- VIEWABLE -->
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
        <input id="complete" type="date" name="complete" min="1900-01-01" value="<?= $result['completion']?>">
        <span class="error hidden">Please enter a valid date</span>
      </div>

      <!-- IMAGES -->
      <div>
        <!-- ITEM PHOTO -->
        <?php if($img != 0): ?>
          <figure class="sampleImage">
            <img id="image" src="<?= $result['picpath'] ?>" alt="<?= $result['name'] ?>-image" />
          </figure>
          <button type="button" class="delete" name="remove-image">Remove Image</a>
        <!-- IMAGE UPLOAD -->
        <?php else: ?>
          <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
          <label for="file">File Name:</label>
          <input type="file" accept="image/*" name="fileToProcess" id="file" />
          <button class="delete hidden" type="button" name="Clear">Clear File</button>
          <span class="error hidden">Please select a smaller image</span>
        <?php endif ?>
      </div>

      <!-- SUBMIT -->
      <button type="submit" name="save">Save</button>
      <button type="button" value="<?= $result['fk_listid']?>" name="Cancel">Cancel</button>
    </form>

    <?php include 'modals/image_view.php' ?>

  </main>

  <!-- FOOTER -->
  <?php include 'includes/footer.php' ?>


</body>

</html>