<?php
    // Check for a valid session (if not redirect back to login)
    session_start();
    if(!isset($_SESSION['user'])){
        header("Location:login.php");
    }
    
    require_once './includes/library.php';
    
    $errors = [];
    $listitem = "";
    $viewable = 1;
    $user = $_SESSION['user'];
    $listid = $_SESSION['listid'];

    
    $pdo = connectDB();

    // GET LIST INFO
    $query = "SELECT * FROM `g10_lists` WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$listid]);
    $list = $stmt->fetch();

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

            $query = "SELECT id FROM `g10_listitems` WHERE fk_listid = ? AND name = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$listid, $listitem]);
            $result = $stmt->fetch();

            $_SESSION['itemid'] = $result['id'];
            unset($_POST);
            header("Location: edit_item.php");
            exit();
        }
    }
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
                <!-- shrink sizing!! -->
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

            <!-- LIST ITEMS -->
            <ul>
                <?php foreach($listitems as $row): ?>
                    <!-- PRIVATE ITEM AND NOT OWNER OF LIST -->
                    <?php if($row['private'] == 1 && $list['fk_userid'] != $_SESSION['id'])
                            continue; 
                    ?>

                    <li>
                        <?php if ($row['private'] == 1):?>
                                <span><i class="fa fa-lock"></i> <?= $row['name']?></span>
                        <?php else: ?>
                            <span><i class="fa fa-unlock"></i> <?= $row['name']?></span>
                        <?php endif ?>
                        <div>
                            <button onclick="document.getElementById('view-modal').style.display='block'"><i class="fa fa-eye"></i></button>
                            <?php if($list['fk_userid'] == $_SESSION['id']):?>
                                <button type="button" name="edititem" value="<?= $row['id']?>" id="editbuttons"><i class="fa fa-edit"></i></button>
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
                    <button onclick="window.history.back()" type="button" name="Return" >Return</button>
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