<?php
  session_start();
  // FROM lecture notes
  include "includes/library.php";

  $pdo = connectdb();

  if(isset($_POST['search'])){
    $search = $_POST['searchData'];

    if($search == "")
      $errors = true;
    else {
      $errors = false;
    }

    if(!$errors){
      //Sanitize search
      $sanitizedsearch = filter_var($search, FILTER_SANITIZE_STRING);
      // Wrap in wildcards (don't let user)
      $wildcardsearch = "%".$search."%";

      // Search to include users lists/items
      if(isset($_SESSION['user'])){
        $query1 = "SELECT id,listname,private FROM `g10_lists` WHERE listname LIKE ? AND fk_userid = ?";
        $stmt1=$pdo->prepare($query1);
        $stmt1->execute([$wildcardsearch,$_SESSION['id']]);

        $query2 = "SELECT items.id,items.private,name FROM `g10_listitems` AS items
                  INNER JOIN `g10_lists` AS lists ON lists.id = items.fk_listid
                  WHERE name LIKE ? AND fk_userid = ?";
        $stmt2=$pdo->prepare($query2);
        $stmt2->execute([$wildcardsearch,$_SESSION['id']]);

        $query3 = "SELECT id,listname FROM `g10_lists` WHERE listname LIKE ? AND private = ? AND fk_userid != ?";
        $stmt3=$pdo->prepare($query3);
        $stmt3->execute([$wildcardsearch,"0",$_SESSION['id']]);

        $query4 = "SELECT items.id,name FROM `g10_listitems` AS items
                  INNER JOIN `g10_lists` AS lists on lists.id = items.fk_listid
                  WHERE name LIKE ? AND items.private = ? AND fk_userid != ?";
        $stmt4=$pdo->prepare($query4);
        $stmt4->execute([$wildcardsearch,"0",$_SESSION['id']]);


      }else{
        $query3 = "SELECT id,listname FROM `g10_lists` WHERE listname LIKE ? AND private = ?";
        $stmt3=$pdo->prepare($query3);
        $stmt3->execute([$wildcardsearch,"0"]);

        $query4 = "SELECT id,name FROM `g10_listitems` WHERE name LIKE ? AND private = ?";
        $stmt4=$pdo->prepare($query4);
        $stmt4->execute([$wildcardsearch,"0"]);

      }
    } // end if errors

  }// end if isset($_POST[searchData])
  else {
    header("Location: index.php");
    exit();
  }
?>
<!DOCTYPE HTML>
<html lang="en">

<head>
  <?php
      $PAGE_TITLE = "Results";
      include "includes/meta.php"
    ?>

  <link type="text/css" rel="stylesheet" href="css/terms.css" />
</head>

<body>

  <header>
    <?php include 'includes/nav.php' ?>
  </header>

  <main>
    <header>
      <h1>Search Results</h1>
    </header>

    <span>Results for: <?= $search ?></span>

    <?php if(isset($_SESSION['user'])): ?>
      <!-- MY LISTS -->
      <h2>My List(s)</h2>
      <?php if($stmt1->rowCount() <= 0): ?>
        <p>No Results found</p>

      <?php else: ?>
        <ul>
          <?php foreach($stmt1 as $list): ?>
            <li>
              <?php if ($list['private'] == 1):?>
                  <span><i class="fa fa-lock"></i> <?= $list['listname']?></span>
              <?php else: ?>
                  <span><i class="fa fa-unlock"></i> <?= $list['listname']?></span>
              <?php endif ?>
              <div>
                <button><a href = "view_list.php?list=<?= $list['id']?>"><i class="fa fa-eye"></i></a></button>
              </div>
            </li>
          <?php endforeach ?>
        </ul>
      <?php endif; ?>
      
      <!-- MY ITEMS -->
      <h2>My Item(s)</h2>
      <?php if($stmt2->rowCount() <= 0): ?>
        <p>No Results found</p>

      <?php else: ?>
        <ul>
          <?php foreach($stmt2 as $item): ?>
            <li>
              <?php if ($item['private'] == 1):?>
                  <span><i class="fa fa-lock"></i> <?= $item['name']?></span>
              <?php else: ?>
                  <span><i class="fa fa-unlock"></i> <?= $item['name']?></span>
              <?php endif ?>
              <div>
                  <button class="viewbutton" value="<?= $item['id']?>"><i class="fa fa-eye"></i></button>
              </div>
            </li>
          <?php endforeach ?>
        </ul>
      <?php endif; ?>

    <?php endif; ?>

    <!-- PUBLIC LISTS -->
    <h2>Public List(s)</h2>
    <?php if($stmt3->rowCount() <= 0): ?>
      <p>No Results found</p>

    <?php else: ?>
      <ul>
        <?php foreach($stmt3 as $list): ?>
          <li>
            <span><i class="fa fa-unlock"></i> <?= $list['listname'] ?></span>
            <div>
                <button><a href = "view_list.php?list=<?= $list['id']?>"><i class="fa fa-eye"></i></a></button>
            </div>
          </li>
        <?php endforeach ?>
      </ul>
    <?php endif; ?>
    
    <!-- PUBLIC LISTS -->
    <h2>Public Item(s)</h2>
    <?php if($stmt4->rowCount() <= 0): ?>
      <p>No Results found</p>

    <?php else: ?>
      <ul>
        <?php foreach($stmt4 as $item): ?>
          <li>
            <span><i class="fa fa-unlock"></i> <?= $item['name']?></span>
            <div>
                <button class="viewbutton" value="<?= $item['id']?>"><i class="fa fa-eye"></i></button>
            </div>
          </li>
        <?php endforeach ?>
        <li>
            <button type="button" name="Return" ><a href="display_list.php">View Lists</a></button>
        </li>
      </ul>
    <?php endif; ?>


    <?php include 'modals/view_item.php' ?>


  </main>

  <?php include 'includes/footer.php' ?>

</body>

</html>
