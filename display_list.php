<?php
  session_start();
  // DOING THIS TO GET AROUND MULTITUDE OF ERRORS WHEN TRYING TO VIEW PUBLIC WHEN NOT LOGGED IN
  if(!isset($_SESSION['user'])){
      $_SESSION['id'] = 0;
  }

  require_once './includes/library.php';

  $errors = [];

  $pdo = connectDB();

  if(isset($_SESSION['id'])){
    $query = "SELECT * FROM `g10_lists` WHERE fk_userid = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_SESSION['id']]);
    $result = $stmt->fetchAll();
  }

  $query = "SELECT * FROM `g10_lists` WHERE private = ?";
  $stmt = $pdo->prepare($query);
  $stmt->execute([0]);
  $results = $stmt->fetchAll();
  

?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <?php
      $PAGE_TITLE = "Public Lists";
      include "includes/meta.php";
    ?>
  </head>

  <body>
    <!-- HEADER -->
    <header>
      <?php include 'includes/nav.php' ?>
    </header>

    <main>
    <!-- PERSONAL LISTS -->
    <?php if(isset($_SESSION['id'])): ?>
      <!-- DISPLAY LIST -->
      <header>
        <!-- LIST NAME -->
        <h1>My Lists</h1>
      </header>

      <div class="lists">
        <ul>
          <?php foreach($result as $row):?>
          <li>
            <h2>
              <?= $row['listname']?>
              <a href = "view_list.php?list=<?= $row['id']?>"><i class="fa fa-eye"></i></a>
            </h2>
          </li>
          <?php endforeach ?>
        </ul>
      </div>
  
      <!-- Add item Button -->
      <button onclick="document.getElementById('create-modal').style.display='block'">
        <i class="fa fa-plus"></i>
      </button>
    <?php endif ?>

    <!-- PUBLIC LISTS -->
    <header>
      <h1>Public Lists</h1>
    </header>

    <div class="lists">
      <ul>
        <?php foreach($results as $rows):?>
        <li>
          <h2>
            <?= $rows['listname']?>
            <a href = "view_list.php?list=<?= $rows['id']?>"><i class="fa fa-eye"></i></a>
          </h2>
        </li>
        <?php endforeach ?>  
      </ul>
    </div>
    </main>

    <!-- FOOTER -->
    <?php include 'includes/footer.php' ?>

  </body>

</html>