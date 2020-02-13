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
        <li><a href="display_list.php">My Lists</a></li>
        <li><a href="public_list.php">Public Lists</a></li>
        <li><a href="sample_list.php">Our Sample List</a></li>
        <?php if(isset($_SESSION['user'])): ?>
        <li>
          <button onclick="document.getElementById('create-modal').style.display='block'">Add List</button>
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
      <li class="dropdown"><?php echo $_SESSION['user'] ?>
          <ul class="dropdown-content">
            <li><a href="logout.php">Sign Out</a></li>
            <li><a href="edit_account.php">Edit Account</a></li>
          </ul>
        </li>
    <?php else: ?>
      <li>
        <a href = "login.php">Login</a>
      </li>
    <?php endif; ?>
  
  </ul>

  <?php include "create_list.php" ?>

</nav>
