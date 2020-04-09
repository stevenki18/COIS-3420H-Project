<?php

  if(isset($_POST['logout'])){
    session_unset();
    header("Location: login.php");
    exit();
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
        <li><a href="display_list.php">View Lists</a></li>
        <!-- <li><a href="display_list.php">Public Lists</a></li> -->
        <li><a href="sample_list.php">Our Sample List</a></li>
        <?php if(isset($_SESSION['user'])): ?>
        <li>
          <a href="#" id="add-list-nav">Add List</a>
          <!-- <a href = "#create_modal" id="create-btn" class="mod-btn">Add List</a> -->
        </li>
        <?php endif; ?>
      </ul>
    </li>
    <li>
        <form action="searchresults.php" id="search-container">
          <input type="text" placeholder="Search.." name="search" maxlength="20">
          <button id="search-btn" type="submit"><i class="fa fa-search"></i></button>
        </form>
    </li>

    <?php if(isset($_SESSION['user'])): ?>
      <li class="dropdown"><?= $_SESSION['user'] ?>
          <ul class="dropdown-content">
            <form method="post">
              <li><input type="submit" name="logout" id="logout" value="Sign Out"></li>
            </form>
            <li><a href="~logout.php">Sign Out</a></li>
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
