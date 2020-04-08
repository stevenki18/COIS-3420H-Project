<?php
    // Check for a valid session (if not redirect back to login)
    session_start();
    // DOING THIS TO GET AROUND MULTITUDE OF ERRORS WHEN TRYING TO VIEW PUBLIC WHEN NOT LOGGED IN
    if(!isset($_SESSION['user'])){
        $_SESSION['id'] = 0;
    }

    require_once './includes/library.php';

    $errors = [];
    $listitem = "";
    $viewable = 1;
    $user = $_SESSION['id'];
    $listid = $_GET['list'];


    $pdo = connectDB();

    // GET LIST INFO
    $query = "SELECT * FROM `g10_lists` WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$listid]);
    $list = $stmt->fetch();

    if($list['private'] == 1 && $list['fk_userid'] != $user){
        header("Location: display_list.php");
        exit();
    }

    // GET ALL LIST ITEMS
    $query =  "SELECT id, name, completion, private FROM `g10_listitems` WHERE fk_listid = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$listid]);
    $listitems = $stmt->fetchAll();

    if(isset($_POST['submit'])){
        $listitem = $_POST['itemname'];

        if($listitem == null || strlen($listitem) == 0)
            array_push($errors, "Please Enter An Item Name");

        if(isset($_POST['viewable']))
            $viewable = 0;

        if(sizeof($errors == 0)){
            $pdo = connectDB();
            $query = "INSERT INTO `g10_listitems` (id, fk_listid, name, private) VALUES (NULL, ?, ?, ?)";
            $statement = $pdo->prepare($query);
            $statement->execute([$listid, $listitem, $viewable]);
            $last_id = $pdo->lastInsertId();

            unset($_POST);
            header("Location: edit_item.php?item=".$last_id);
            exit();
        }
    }

    if(isset($_POST['']))
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <?php
            $PAGE_TITLE = "Manage List";
            include "includes/meta.php";
        ?>
    </head>

    <body>
        <!-- HEADER -->
        <header>
            <?php include 'includes/nav.php' ?>
        </header>

        <main>
            <!-- DISPLAYS LIST -->
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
                <?php if($list['fk_userid'] == $_SESSION['id']):?>
                    <div>
                        <button type="button"><i class="fa fa-edit"></i></button>
                        <button type="button" class="delete"><i class="fa fa-trash"></i></button>
                    </div>
                <?php endif ?>
            </header>

            <!-- IN PROGRESS -->
            <h2>In Progress</h2>
            <ul>
                <?php foreach($listitems as $row): ?>
                    <!-- PRIVATE ITEM AND NOT OWNER OF LIST -->
                    <?php if(($row['private'] == 1 && $list['fk_userid'] != $_SESSION['id'])||$row['completion'] != null)
                            continue;
                    ?>

                    <li>
                        <?php if ($row['private'] == 1):?>
                                <span><i class="fa fa-lock"></i> <?= $row['name']?></span>
                        <?php else: ?>
                            <span><i class="fa fa-unlock"></i> <?= $row['name']?></span>
                        <?php endif ?>
                        <div>
                            <button class="viewbutton" value="<?= $row['id']?>"><i class="fa fa-eye"></i></button>
                            <?php if($list['fk_userid'] == $_SESSION['id']):?>
                                <button type="button" name="edititem" value="<?= $row['id']?>" class="editbutton"><i class="fa fa-edit"></i></button>
                                <button type="button" class="delete"><i class="fa fa-trash"></i></button>
                            <?php endif ?>
                        </div>
                    </li>
                <?php endforeach ?>

                <!-- BUTTON TO ADD ITEMS -->
                <?php if($list['fk_userid'] == $_SESSION['id']):?>
                    <li><button id = "additem"><i class="fa fa-plus"></i></button></li>
                <?php endif ?>
                <li>
                    <button type="button" name="Return" ><a href="display_list.php">Return</a></button>
                </li>

            </ul>

            <h2>Completed</h2>
            <ul>
                <?php foreach($listitems as $row): ?>
                    <!-- PRIVATE ITEM AND NOT OWNER OF LIST -->
                    <?php if(($row['private'] == 1 && $list['fk_userid'] != $_SESSION['id']) || $row['completion'] == null)
                            continue;
                    ?>

                    <li>
                        <?php if ($row['private'] == 1):?>
                                <span><i class="fa fa-lock"></i> <?= $row['name']?></span>
                        <?php else: ?>
                            <span><i class="fa fa-unlock"></i> <?= $row['name']?></span>
                        <?php endif ?>
                        <div>
                            <button class="viewbutton" value="<?= $row['id']?>"><i class="fa fa-eye"></i></button>
                            <?php if($list['fk_userid'] == $_SESSION['id']):?>
                                <button type="button" name="edititem" value="<?= $row['id']?>" class="editbutton"><i class="fa fa-edit"></i></button>
                                <button type="button" class="delete"><i class="fa fa-trash"></i></button>
                            <?php endif ?>
                        </div>
                    </li>
                <?php endforeach ?>
                <li>
                    <button type="button" name="Return" ><a href="display_list.php">Return</a></button>
                </li>

            </ul>

            <?php include 'modals/add_item.php' ?>
            <?php include 'modals/view_item.php' ?>

            <?php //include 'delete_item.php' ?>
            <!-- Self process delete item -->

        </main>

        <!-- FOOTER -->
        <?php include 'includes/footer.php' ?>

    </body>

</html>
