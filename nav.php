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
          <a href = "#create_modal" id="create-btn" class="modBtn">Add List</a>
        </li>
        <?php endif; ?>
      </ul>
    </li>
    <li>
      <div class="search-container">
        <form action="searchresults.php">
          <input type="text" placeholder="Search.." name="search">
          <button type="submit"><i class="fa fa-search"></i></button>
        </form>
      </div>
    </li>
    <li>
      <?php if(isset($_SESSION['user'])): ?>
        <a href="logout.php">Sign Out</a>
      <?php else: ?>
      <a href = "login.php">Login</a>
    <?php endif; ?>
    </li>
  </ul>

  <?php include "create_list.php" ?>

  <script>
      // Get the modal
      var modal = document.getElementsByClassName('modal');

      // Get the button that opens the modal
      var btn = document.getElementsByClassName("modBtn");

      // Get the <span> element that closes the modal
      var span = document.getElementsByClassName("close");

      // When the user clicks the button, open the modal
      btn[0].onclick = function() {
          modal[0].style.display = "block";
      }

      // When the user clicks on <span> (x), close the modal
      span[0].onclick = function() {
          modal[0].style.display = "none";
      }

      // When the user clicks anywhere outside of the modal, close it
      window.onclick = function(event) {
          if (event.target == modal[0]) {
              modal[0].style.display = "none";
          }
      }
  </script>

</nav>
