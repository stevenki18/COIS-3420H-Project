<?php
  session_start();
  // DOING THIS TO GET AROUND MULTITUDE OF ERRORS WHEN TRYING TO VIEW PUBLIC WHEN NOT LOGGED IN
  if(!isset($_SESSION['user'])){
      $_SESSION['id'] = 0;
  }

  require_once './includes/library.php';

  $errors = [];

  $pdo = connectDB();

  $query = "SELECT * FROM `g10_lists` WHERE fk_userid = ?";
  $stmt = $pdo->prepare($query);
  $stmt->execute([$_SESSION['id']]);
  $myresult = $stmt->fetchAll();


  $query = "SELECT * FROM `g10_lists` WHERE private = ? AND fk_userid != ?";
  $stmt = $pdo->prepare($query);
  $stmt->execute([0, $_SESSION['id']]);
  $publicresults = $stmt->fetchAll();


?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <?php
      $PAGE_TITLE = "Lists";
      include "includes/meta.php";
    ?>
  </head>

  <body>
    <!-- HEADER -->
    <header>
      <?php include 'includes/nav.php' ?>
    </header>

    <main>
      <header>
        <!-- LIST NAME -->
        <h1>Lists</h1>
      </header>

    <!-- PERSONAL LISTS (ONLY IF LOGGED IN)-->
    <?php if(isset($_SESSION['user'])): ?>
      <!-- DISPLAY LIST -->
      <h2>My Lists</h2>
        <ul>
          <?php foreach($myresult as $row):?>
          <li>
            <h3>
              <?php if($row['private'] == 1):?>
                <span><i class="fa fa-lock"></i></span>
              <?php else: ?>
                  <span><i class="fa fa-unlock"></i></span>
              <?php endif ?>
              <?= $row['listname']?>
              <a href = "view_list.php?list=<?= $row['id']?>"><i class="fa fa-eye"></i></a>
            </h3>
          </li>
          <?php endforeach ?>
          <!-- BUTTON TO ADD ITEMS -->
          <li><button id="addlist"><i class="fa fa-plus"></i></button></li>

        </ul>

      <!-- Add item Button -->
      <!-- <button onclick="document.getElementById('create-modal').style.display='block'"> -->
        <!-- <i class="fa fa-plus"></i> -->
      <!-- </button> -->
    <?php endif ?>

    <!-- PUBLIC LISTS -->
    <h2>Public Lists</h2>
      <ul>
        <?php foreach($publicresults as $rows):?>
        <li>
          <h3>
            <?= $rows['listname']?>
            <a href = "view_list.php?list=<?= $rows['id']?>"><i class="fa fa-eye"></i></a>
          </h3>
        </li>
        <?php endforeach ?>
      </ul>
    </main>

    <!-- FOOTER -->
    <?php include 'includes/footer.php' ?>

  </body>

</html>
