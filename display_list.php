<?php
  /*-----------------------------------------------------------
  |
  |   PAGE:         display_list.php
  |
  |   DESCRIPTION:  Front facing page of all personal lists
  |                 and public lists that are able to be
  |                 viewed. Personal lists will appear before
  |                 public ones and will not appear again on
  |                 public lists section
  |
  -----------------------------------------------------------*/

  // DOING THIS TO GET AROUND MULTITUDE OF ERRORS WHEN TRYING TO VIEW PUBLIC WHEN NOT LOGGED IN
  session_start();
  if(!isset($_SESSION['user'])){
      $_SESSION['id'] = 0;
  }

  require_once 'includes/library.php';
  $pdo = connectDB();

  // GET ALL USER LISTS
  $query = "SELECT * FROM `g10_lists` WHERE fk_userid = ?";
  $stmt = $pdo->prepare($query);
  $stmt->execute([$_SESSION['id']]);
  $myresult = $stmt->fetchAll();

  // GET ALL PUBLIC LISTS (EXCLUDE USER LISTS)
  $query = "SELECT * FROM `g10_lists` WHERE private = ? AND fk_userid != ?";
  $stmt = $pdo->prepare($query);
  $stmt->execute([0, $_SESSION['id']]);
  $publicresults = $stmt->fetchAll();


?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <?php
      $PAGE_TITLE = "All Lists";
      include "includes/meta.php";
    ?>
  </head>

  <body>
    <header>
      <?php include 'includes/nav.php' ?>
    </header>

    <main>
      <header>
        <h1>All Lists</h1>
      </header>

      <!-- PERSONAL LISTS (ONLY IF LOGGED IN)-->
      <?php if(isset($_SESSION['user'])): ?>
        <section>
          <!-- DISPLAY LIST -->
          <h2>My Lists</h2>
          <ul>
            <?php foreach($myresult as $row):?>
            <li>
              <h3>
                <?php if($row['private'] == 1):?>
                  <span><i class="fa fa-lock"></i> <?= $row['listname']?></span>
                <?php else: ?>
                    <span><i class="fa fa-unlock"></i> <?= $row['listname']?></span>
                <?php endif ?>
                <div>
                  <button class="viewList" value="<?= $row['id']?>"><i class="fa fa-eye"></i></button>
                </div>
              </h3>
            </li>
            <?php endforeach ?>
            <!-- BUTTON TO ADD ITEMS -->
            <li><button id="addlist"><i class="fa fa-plus"></i></button></li>
          </ul>
        </section>
      <?php endif ?>
      <section>
        <!-- PUBLIC LISTS -->
        <h2>Public Lists</h2>
        <ul>
          <?php foreach($publicresults as $rows):?>
          <li>
            <h3>
              <?= $rows['listname']?>
              <div>
                <button class="viewList" value="<?= $rows['id']?>"><i class="fa fa-eye"></i></button>
              </div>
            </h3>
          </li>
          <?php endforeach ?>
        </ul>
      </section>
    </main>

    <!-- FOOTER -->
    <?php include 'includes/footer.php' ?>

  </body>

</html>
