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
        <li><a href="manage_list.php">Things to Do Before I'm 40</a></li>
        <li><a href="manage_list.php">Our Sample List</a></li>
        <li><a href = "#opencreate" id = "create-btn">Add List</a></li>
      </ul>
    </li>
    <li>
      <div class="search-container">
        <form action="action_page.php">
          <input type="text" placeholder="Search.." name="search">
          <button type="submit"><i class="fa fa-search"></i></button>
        </form>
      </div>
    </li>
    <li><a href = "#openlogin" id = "login-btn">Login</a><!--<a href="register.php">Login</a>--></li>
  </ul>

  <div id="opencreate">
    <?php include "create_list.php" ?>
  </div>

  <div id="openlogin">
    <?php include "login.php" ?>
  </div>

</nav>
