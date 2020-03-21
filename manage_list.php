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
                    <!-- h3 styling -->
                    <span><?= $list['start'] ?></span>
                    <p>START DATE</p>
                </div>

                <!-- END DATE -->
                <?php if($list['end'] != null):?>
                    <div>
                        <!-- h3 styling -->
                        <span id="todaysdate"></span>
                        <p>END DATE</p>
                    </div>
                <?php endif ?>
                
                <?php if($list['fk_userid'] == $_SESSION['id']):?>
                    <!-- EDIT LIST -->
                    <div>
                        <!-- h1 styling -->
                        <button type="button"><i class="fa fa-edit"></i></button>
                        <button type="button" class="delete"><i class="fa fa-trash"></i></button>
                    </div>
                <?php endif ?>
            </header>

            <ul>
                <?php foreach($listitems as $row): ?>
                    <!-- FIRST ITEM -->
                    <li>
                        <?php if ($row['private'] == 1):?>
                            <span><i class="fa fa-lock"></i> <?= $row['name']?></span>
                        <?php else: ?>
                            <span><i class="fa fa-unlock"></i> <?= $row['name']?></span>
                        <?php endif ?>
                        <div>
                            <button onclick="document.getElementById('view-modal').style.display='block'"><i class="fa fa-eye"></i></button>
                            <?php if($list['fk_userid'] == $_SESSION['id']):?>
                                <button type="button" name="Edit Item" onclick="location.href='edit_item.php'"><i class="fa fa-edit"></i></button>
                                <button type="button" class="delete"><i class="fa fa-trash"></i></button>    
                            <?php endif ?>
                        </div>
                    </li>
                <?php endforeach ?>

                <!-- BUTTON TO ADD ITEMS -->
                <li>
                    <button onclick="document.getElementById('add-modal').style.display='block'">
                        <i class="fa fa-plus"></i>
                    </button>
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

    <script>
        var dt = new Date();
        document.getElementById("todaysdate").innerHTML = dt.toLocaleDateString();
    </script>

</html>