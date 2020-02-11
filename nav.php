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
        <li><a href = "#create_modal" id="create-btn" class="modBtn">Add List</a></li>
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
    <li><a href = "#login-modal" id = "login-btn" class="modBtn">Login</a><!--<a href="register.php">Login</a>--></li>
  </ul>

  <?php include "login.php" ?>

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
          modal[1].style.display = "block";
      }

      // When the user clicks the button, open the modal
      btn[1].onclick = function() {
          modal[0].style.display = "block";
      }

      // When the user clicks on <span> (x), close the modal
      span[0].onclick = function() {
          modal[0].style.display = "none";
      }

      // When the user clicks on <span> (x), close the modal
      span[1].onclick = function() {
          modal[1].style.display = "none";
      }

      // When the user clicks anywhere outside of the modal, close it
      window.onclick = function(event) {
          if (event.target == modal[0]) {
              modal[0].style.display = "none";
          }
          if (event.target == modal[1]) {
              modal[1].style.display = "none";
          }
      }
  </script>

</nav>
