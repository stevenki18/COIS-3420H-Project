<?php
    /*-----------------------------------------------------------
    |
    |   PAGE:         sample_list.php
    |
    |   DESCRIPTION:  Displays the sample list that is assigned
    |                 to the master account.
    |
    -----------------------------------------------------------*/

    session_start();
    require_once './includes/library.php';
    $pdo = connectDb();

    // GET LIST INFO
    // STATIC SET LIST 1 (MASTER SAMPLE LIST)
    $query = "SELECT * FROM `g10_lists` WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([1]);
    $list = $stmt->fetch();

    // GET LIST ITEMS
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
    <header>
        <?php include 'includes/nav.php' ?>
    </header>

    <main>
        <header>
            <!-- LIST NAME -->
            <h1>
                <?= $list['listname'] ?>
                <!-- PRIVATE -->
                <?php if($list['private'] == 1):?>
                    <span><i class="fa fa-lock"></i></span>
                <!-- PUBLIC -->
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
        <section>
            <!-- IN PROGRESS -->
            <h2>In Progress</h2>
            <ul>
                <?php foreach($listitems as $row): ?>
                    <!-- SKIP COMPLETED ITEMS -->
                    <!-- DISPLAYED IN COMPLETED SECTION -->
                    <?php 
                        if($row['completion'] != null)
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
                        </div>
                    </li>
                <?php endforeach ?>

                <!-- REDIRECTS TO DISPLAY LIST IF LOGGED IN -->
                <!-- REDIRECTS TO LOGIN IF NOT LOGGED IN -->
                <li><button id = "additem"><i class="fa fa-plus"></i></button></li>
            </ul>
        </section>
        <section>
            <h2>Completed</h2>
            <ul>
                <?php foreach($listitems as $row): ?>
                    <!-- SKIP INCOMPLETE ITEMS -->
                    <!-- DISPLAYED IN PROGRESS SECTION -->
                    <?php 
                        if($row['completion'] == null)
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
                        <div><button class="viewbutton" value="<?= $row['id']?>"><i class="fa fa-eye"></i></button></div>
                    </li>
                <?php endforeach ?>
                <li>
                    <button type="button" name="Return" ><a href="display_list.php">Return</a></button>
                </li>
            </ul>
        </section>
    </main>

    <?php 
        include 'modals/view_item.php';
        include 'modals/image_view.php';
        include 'includes/footer.php' 
    ?>

</body>
</html>
