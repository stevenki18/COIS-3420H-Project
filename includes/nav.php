<?php

  if(isset($_SESSION['user'])){    
    $query = "SELECT listname, id, private FROM g10_lists WHERE fk_userid = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_SESSION['id']]);
    $results = $stmt->fetchAll();
  }
?>
<nav>
  <ul>
    <li>
      <a href="index.php"><div class="logo">
        <figure>
          <img src="img/bucket.png" alt="Bucket List Logo" height=75 />
        </figure>
        <span>My Bucket List(s)</span>
      </div></a>
    </li>
    <li class="dropdown">Lists
      <ul class="dropdown-content">
        <li><a href="display_list.php">View All</a></li>
        <?php if(isset($_SESSION['user'])): ?>
        <?php foreach ($results as $row):?>
            <li class="personal"><i class="fa fa-chevron-right"></i><a href="view_list.php?list=<?= $row['id']?>">
          <?php if($row['private'] == 1): ?>
            <i class="fa fa-lock"></i> <?= $row['listname'] ?>
          <?php else: ?>
            <i class="fa fa-unlock"></i> <?= $row['listname'] ?>
          <?php endif ?>
          </a></li>
        <?php endforeach ?>
        <li><a href="#" id="add-list-nav"><i class="fa fa-plus"></i> Create New List</a></li>
        <?php endif; ?>
        <li><a href="sample_list.php">Sample Bucket List</a></li>
      </ul>
    </li>
    <li>
        <form method="post" action="searchresults.php" id="search-container">
          <input type="text" placeholder="Search.." name="searchData" maxlength="20" required>
          <button id="search-btn" type="submit" name="search"><i class="fa fa-search"></i></button>
        </form>
    </li>

    <?php if(isset($_SESSION['user'])): ?>
      <li class="dropdown"><?= $_SESSION['user'] ?>
          <ul class="dropdown-content">
            <li><a id="signOut" href="logout.php">Sign Out</a></li>
            <li><a href="accounts.php">Edit Account</a></li>
          </ul>
        </li>
    <?php else: ?>
      <li>
        <a href = "login.php">Login</a>
      </li>
    <?php endif; ?>

  </ul>

  <?php include "modals/add_list.php" ?>

</nav>
