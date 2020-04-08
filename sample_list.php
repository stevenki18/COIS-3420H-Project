<?php 

  session_start(); 
  require_once './includes/library.php';

  $pdo = connectDb();
  // GET LIST INFO
  $query = "SELECT * FROM `g10_lists` WHERE id = ?";
  $stmt = $pdo->prepare($query);
  $stmt->execute([1]);
  $list = $stmt->fetch();

  $query =  "SELECT id, name, completion, private FROM `g10_listitems` WHERE fk_listid = ?";
  $stmt = $pdo->prepare($query);
  $stmt->execute([$list['id']]);
  $listitems = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            $PAGE_TITLE = "Sample List";
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
            </header>

            <!-- IN PROGRESS -->
            <h2>In Progress</h2>
            <ul>
                <?php foreach($listitems as $row): ?>
                    <!-- PRIVATE ITEM AND NOT OWNER OF LIST -->
                    <?php if($row['completion'] != null)
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
                    <?php if($row['completion'] == null)
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

        </main>

        <!-- FOOTER -->
        <?php include 'includes/footer.php' ?>

    </body>
</html>
