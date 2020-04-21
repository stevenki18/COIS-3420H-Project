<?php
    /*-----------------------------------------------------------
    |
    |   PAGE:         view_list.php
    |
    |   DESCRIPTION:  Displays the a lists details and items. 
    |                 Used for both user lists and public lists.
    |                 This page will populate with additional
    |                 buttons if the owner of the list is logged
    |                 in. This includes edit and delete buttons
    |                 for both the list and all list items and 
    |                 an add list item button which opens the 
    |                 add list modal
    |
    -----------------------------------------------------------*/
    session_start();
    // DOING THIS TO GET AROUND MULTITUDE OF ERRORS WHEN TRYING TO VIEW PUBLIC WHEN NOT LOGGED IN
    if(!isset($_SESSION['user']))
        $_SESSION['id'] = 0;
    

    require_once './includes/library.php';
    $pdo = connectDB();

    $errors = [];
    $listitem = "";
    $viewable = 1;
    $user = $_SESSION['id'];
    $listid = $_GET['list'];

    
    /*---------------------------
    |
    |          LIST INFO
    |
    ---------------------------*/
    $query = "SELECT * FROM `g10_lists` WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$listid]);
    $list = $stmt->fetch();

    // Check to make sure user is either logged in and list is theirs
    // or the list is public and available
    if($list['private'] == 1 && $list['fk_userid'] != $user || !$list){
        header("Location: display_list.php");
        exit();
    }


    /*---------------------------
    |
    |       LIST ITEMS
    |
    ---------------------------*/
    $query =  "SELECT id, name, completion, private FROM `g10_listitems` WHERE fk_listid = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$listid]);
    $listitems = $stmt->fetchAll();


    /*---------------------------
    |
    |       DELETE LIST
    |
    |   ** POST COMES FROM JS
    ---------------------------*/
    if(isset($_POST['deleteList'])) {
        // SANITIZE POST TO COMPARE WITH SANITIZED LIST NAME
        $deletedList = filter_var($_POST['listName'], FILTER_SANITIZE_STRING);

        if($deletedList == $list['listname']){
            $query = "DELETE FROM `g10_lists` WHERE id = ?";
            $statement = $pdo->prepare($query);
            $statement->execute([$listid]);

            unset($_POST);
            header("Location: display_list.php");
            exit();
        }
    }// END OF DELETE LIST


    /*---------------------------
    |
    |      DELETE LIST ITEM
    |
    |   ** POST COMES FROM JS
    ---------------------------*/
    if(isset($_POST['deleteItem'])) {
        $id = $_POST['itemDeleted'];
        // SANITIZE POST TO COMPARE WITH SANITIZED ITEM NAME
        $deletedItem = filter_var($_POST['itemName'], FILTER_SANITIZE_STRING);

        $query = "SELECT name FROM `g10_listitems` WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id]);
        $itemName = $stmt->fetch();

        if($deletedItem == $itemName['name']){
            $query = "DELETE FROM `g10_listitems` WHERE id = ?";
            $statement = $pdo->prepare($query);
            $statement->execute([$_POST['itemDeleted']]);

            unset($_POST);
            header("Location: view_list.php?list=".$listid);
            exit();
        }
    }// END OF DELETE LIST ITEM


    /*---------------------------
    |
    |       ADD LIST ITEM
    |
    ---------------------------*/
    if(isset($_POST['add_item'])){
        $listitem = filter_var($_POST['itemname'], FILTER_SANITIZE_STRING);
        // ITEM NAME
        if(!$listitem || strlen($listitem) == 0)
            array_push($errors, "Please Enter An Item Name");
        // VIEWABLE
        if(isset($_POST['viewable']))
            $viewable = 0;
        // I"M FEELING LUCKY
        if(isset($_POST['lukcydescription']))
          $desc = $_POST['lukcydescription'];
        // No errors do the work with the datbase
        if(sizeof($errors == 0)){
            $pdo = connectDB();
            $query = "INSERT INTO `g10_listitems` (id, fk_listid, name, description, private) VALUES (NULL, ?, ?, ?, ?)";
            $statement = $pdo->prepare($query);
            $statement->execute([$listid, $listitem, $desc, $viewable]);
            $last_id = $pdo->lastInsertId();

            unset($_POST);
            header("Location: edit_item.php?item=".$last_id);
            exit();
        }// END OF DB WORK
    }// END OF ADD LIST ITEM

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <?php
            $PAGE_TITLE = "View List";
            include "includes/meta.php";
        ?>
    </head>

    <body>
        <header>
            <?php include 'includes/nav.php' ?>
        </header>

        <main>
            <header>
                <!-- LIST NAME -->
                <h1>
                    <?= $list['listname'] ?>
                    <?php if($list['private'] == 1):?>
                        <span><i class="fa fa-lock"></i></span>
                    <?php else: ?>
                        <span><i class="fa fa-unlock"></i></span>
                    <?php endif ?>
                </h1>

                <!-- START DATE -->
                <div>
                    <span><?= $list['start'] ?></span>
                    <p>START DATE</p>
                </div>

                <!-- END DATE -->
                <?php if($list['end'] != null):?>
                    <div>
                        <span><?= $list['end'] ?></span>
                        <p>END DATE</p>
                    </div>
                <?php endif ?>

                <!-- EDIT LIST -->
                <!-- DELETE LIST -->
                <?php if($list['fk_userid'] == $_SESSION['id']):?>
                    <div>
                        <button type="button" id = "editList"><i class="fa fa-edit"></i></button>
                        <button type="button" class="delete" id = "removeList"><i class="fa fa-trash"></i></button>
                    </div>
                <?php endif ?>
            </header>

        <section>
            <h2>In Progress</h2>
            <ul>
                <?php foreach($listitems as $row): ?>
                    <!-- SKIP COMPLETED ITEMS AND PRIVATE ITEM WHERE USER IS NOT OWNER OF LIST -->
                    <!-- DISPLAYED IN COMPLETED SECTION -->
                    <?php 
                        if(($row['private'] == 1 && $list['fk_userid'] != $_SESSION['id']) || $row['completion'] != null)
                            continue;
                    ?>

                    <li>
                        <!-- PRIVATE ITEM -->
                        <?php if ($row['private'] == 1):?>
                            <span><i class="fa fa-lock"></i> <?= $row['name']?></span>
                        <!-- PUBLIC ITEM -->
                        <?php else: ?>
                            <span><i class="fa fa-unlock"></i> <?= $row['name']?></span>
                        <?php endif ?>
                        <div>
                            <button class="viewbutton" value="<?= $row['id']?>"><i class="fa fa-eye"></i></button>
                            <!-- EDIT AND DELETE BUTTON -->
                            <?php if($list['fk_userid'] == $_SESSION['id']):?>
                                <button type="button" name="edititem" value="<?= $row['id']?>" class="editbutton"><i class="fa fa-edit"></i></button>
                                <button type="button" name="deleteitem" value="<?= $row['id']?>" class="delete removebutton"><i class="fa fa-trash"></i></button>
                            <?php endif ?>
                        </div>
                    </li>
                <?php endforeach ?>

                <!-- BUTTON TO ADD ITEMS -->
                <?php if($list['fk_userid'] == $_SESSION['id']):?>
                    <li><button id = "additem"><i class="fa fa-plus"></i></button></li>
                <?php endif ?>
            </ul>
        </section>

        <section>
            <h2>Completed</h2>
            <ul>
                <?php foreach($listitems as $row): ?>
                    <!-- SKIP INCOMPLETE ITEMS AND PRIVATE ITEM WHERE USER IS NOT OWNER OF LIST -->
                    <!-- DISPLAYED IN PROGRESS SECTION -->
                    <?php 
                        if(($row['private'] == 1 && $list['fk_userid'] != $_SESSION['id']) || $row['completion'] == null)
                            continue;
                    ?>

                    <li>
                        <!-- PRIVATE ITEM -->
                        <?php if ($row['private'] == 1):?>
                            <span><i class="fa fa-lock"></i> <?= $row['name']?></span>
                        <!-- PUBLIC ITEM -->
                        <?php else: ?>
                            <span><i class="fa fa-unlock"></i> <?= $row['name']?></span>
                        <?php endif ?>
                        <div>
                            <button class="viewbutton" value="<?= $row['id']?>"><i class="fa fa-eye"></i></button>
                            <!-- EDIT AND DELETE BUTTONS -->
                            <?php if($list['fk_userid'] == $_SESSION['id']):?>
                                <button type="button" name="edititem" value="<?= $row['id']?>" class="editbutton"><i class="fa fa-edit"></i></button>
                                <button type="button" name="deleteitem" value="<?= $row['id']?>" class="delete removebutton"><i class="fa fa-trash"></i></button>
                            <?php endif ?>
                        </div>
                    </li>
                <?php endforeach ?>
                <li>
                    <button type="button" name="Return" ><a href="display_list.php">Return</a></button>
                </li>

            </ul>
        </section>
        <?php 
            include 'modals/add_item.php';
            include 'modals/view_item.php';
            include 'modals/image_view.php'
        ?>

        </main>

        <?php include 'includes/footer.php' ?>

    </body>

</html>
