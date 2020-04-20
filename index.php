<?php session_start();
  require_once 'includes/library.php';
  $pdo = connectDB();

  $private = 0;
  $limit = 10;
  $limitlists = 3;

  // GET SAMPLE LIST INFO
  $query = "SELECT * FROM `g10_lists` WHERE private = ? LIMIT ?";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(1, $private,PDO::PARAM_INT);
  $stmt->bindParam(2, $limitlists,PDO::PARAM_INT);
  $stmt->execute();
  $list = $stmt->fetchAll();

  // GET 5 List Items
  $query =  "SELECT id, name, completion FROM `g10_listitems` WHERE private = ? LIMIT ?";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(1, $private,PDO::PARAM_INT);
  $stmt->bindParam(2, $limit,PDO::PARAM_INT);
  $stmt->execute();
  $listitems = $stmt->fetchAll();
?>
<!DOCTYPE HTML>
<!-- ******************************** Filename: index.html, uses default.css
 *
 * Usage: Bucket List Splash PAGE
 *        This is the first page when coming to the website to create or modify
 *        a bucket list. Work in progress
 *
 *
 * Note: reset.css is also being used by the q3.html files in order to wipe settings
 *
 * Created by: Group 10 for COIS-3420H Project
 ******************************************************************************
 -->
<html lang="en">
  <head>
    <?php
      $PAGE_TITLE = "Welcome!";
      include "includes/meta.php"
    ?>
  </head>

  <body>
    <!-- SPLASH PAGE -->
    <header>
      <?php include 'includes/nav.php' ?>
    </header>

    <main>
      <article>
        <header>
          <!-- LOGO -->
          <div class="logo">
            <figure>
              <img src="img/bucket.png" alt="Bucket List Logo" height=200 />
            </figure>
          </div>

          <h1>Welcome to My Bucket List(s)</h1>
        </header>

        <section id="about">
          <h2>About</h2>
          <p>
            At this site you will be able to create your own bucket list, and keep track on the progress.
          </p>
        </section>

        <section id="ideas">
          <h2>Sample Public Lists</h2>
          <ul>
            <?php foreach($list as $row): ?>
              <li>
                <span><i class="fa fa-unlock"></i> <?= $row['listname'] ?></span>
                <div>
                  <button><a href = "view_list.php?list=<?= $row['id']?>"><i class="fa fa-eye"></i></a></button>
                </div>
              </li>
            <?php endforeach ?>
          </ul>
        </section>

        <section id="top-ten">
          <h2>Top 10</h2>
          <ol>
            <?php foreach($listitems as $row): ?>
                <!-- PUBLIC ITEMS ONLY -->
                <li>
                  <button class="viewbutton" value="<?= $row['id']?>">
                  <?php if($row['completion'] != null): ?>
                    <i class="fa fa-check-square-o"></i>
                  <?php else: ?>
                    <i class="fa fa-square-o"></i>
                  <?php endif; ?>
                  <?= $row['name']?></button>
                </li>
            <?php endforeach ?>
          </ol>
        </section>

      </article>

      <?php include 'modals/view_item.php' ?>
      <?php include 'modals/image_view.php' ?>

    </main>


    <?php include 'includes/footer.php' ?>

  </body>

</html>
