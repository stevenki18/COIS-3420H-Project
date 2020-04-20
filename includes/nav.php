<?php
/*
Page name: nav.php
Description: Website's navigation bar in the header of each page.
Includes homepage button, dropdown menu of all user's lists, the search bar,
and login/signout/account edit button.
*/

  //retrieves lists owned by user
  if(isset($_SESSION['user'])){
    $queryLists = "SELECT listname, id, private FROM g10_lists WHERE fk_userid = ?";
    $stmtLists = $pdo->prepare($queryLists);
    $stmtLists->execute([$_SESSION['id']]);
    $resultLists = $stmtLists->fetchAll();
  }
?>

<nav class="topnav" id="myTopnav">
  <ul>

    <!-- HOME PAGE BUTTON -->
    <li>
      <a href="index.php"><div class="logo">
        <figure>
          <img src="img/bucket.png" alt="Bucket List Logo" height=75 />
        </figure>
        <span>My Bucket List(s)</span>
      </div></a>
    </li>

    <!-- DROPDOWN BUCKET LISTS MENU  -->
    <!-- ACTIVATES WHEN USER HOVERS OVER LISTS BUTTON IN HEADER -->
    <li class="dropdown">
      <button class="dropbtn">Lists</button>
      <ul class="dropdown-content">

        <!-- LINK TO PAGE LISTING ALL BOTH PERSONAL AND PUBLIC LITS -->
        <li><a href="display_list.php">View All</a></li>

        <!-- PROVIDES LINKS TO ALL OF A USER'S PERSONAL LISTS -->
        <?php if(isset($_SESSION['user'])): ?>
        <?php foreach ($resultLists as $row):?>
            <li class="personal"><i class="fa fa-chevron-right"></i><a href="view_list.php?list=<?= $row['id']?>">
          <?php if($row['private'] == 1): ?>
            <i class="fa fa-lock"></i> <?= $row['listname'] ?>
          <?php else: ?>
            <i class="fa fa-unlock"></i> <?= $row['listname'] ?>
          <?php endif ?>
        </a></li>
        <?php endforeach ?>

        <!-- LINK TO ADD LIST MODAL WINDOW -->
        <li><a href="#" id="add-list-nav"><i class="fa fa-plus"></i> Create New List</a></li>
        <?php endif; ?>

        <!-- LINK TO SAMPLE BUCKET LIST -->
        <li><a href="sample_list.php">Sample Bucket List</a></li>
      </ul>
    </li> <!-- ENDCASE DROPDOWN BUCKET LISTS MENU -->

    <!-- SEARCHBAR -->
    <li>
        <form method="post" action="searchresults.php" id="search-container">
          <input type="text" placeholder="Search.." name="searchData" maxlength="20" required>
          <button id="search-btn" type="submit" name="search"><i class="fa fa-search"></i></button>
        </form>
    </li>

    <!-- LOGIN BUTTON -->
    <!-- CLICKING IT WHILE LOGGED OUT LEADS TO LOGIN PAGE -->
    <?php if(isset($_SESSION['user'])): ?>
      <!-- ACCOUNT DROPDOWN MENU -->
      <!-- IF LOGGED IN, IT IS ACTIVATED BY HOVERING OVER LOGIN BUTTON -->
      <li class="dropdown">
        <button class="dropbtn"><?= $_SESSION['user'] ?></button>
        <ul class="dropdown-content">
          <!-- SIGN OUT LINK -->
          <li><a id="signOut" href="logout.php">Sign Out</a></li>
          <!-- EDIT ACCOUNT LINK -->
          <li><a href="accounts.php">Edit Account</a></li>
        </ul>
      </li>
    <?php else: ?>
      <li>
        <a id="login-link" href = "login.php">Login</a>
      </li>
    <?php endif; ?>

    <!-- NAVIGATION BUTTON ICON -->
    <li class="icon"><a id="nav-icon" href="#" >&#9776;</a></li>

  </ul>

  <!-- CALLS add_list.php TO BE USED BY ADD LIST BUTTON-->
  <?php include "modals/add_list.php" ?>

</nav>
