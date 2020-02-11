<?php require "checklogin.php" ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            $PAGE_TITLE = "My Lists";
            include "includes/meta.php";
        ?>
    </head>

    <body>
        <!-- HEADER -->
        <header>
            <?php include 'nav.php' ?>
        </header>

        <main>
            <!-- DISPLAY LIST -->
            <header>
                <!-- LIST NAME -->
                <h1>My Lists</h1>
            </header>

                  <form>
                    <ul>
                    <!-- FIRST LIST -->
                    <li>
                      <h2>Complete me by 50 <a href="manage_list.php"><i class="fa fa-edit"></i></a></h2>
                      <ul>
                        <li>
                          ->Don't die!
                        </li>
                        <li>
                          ->Ride a Camel.
                        </li>
                      </ul>
                    </li>

                    <!-- SECOND LIST -->
                    <li><h2>Complete me by 90 <a href="manage_list.php"><i class="fa fa-edit"></i></a></h2>
                      <ul>
                        <li>
                          ->Don't die!
                        </li>
                        <li>
                          ->Go Skydiving.
                        </li>
                      </ul>

                  </ul>
                    <!-- Add item Button -->
                    <button type="button" class="modBtn">ADD NEW LIST</button>
                  </form>
        </main>

        <!-- FOOTER -->
        <?php include 'includes/footer.php' ?>

        <script>
          // When the user clicks the button, open the modal
          btn[1].onclick = function() {
              modal[0].style.display = "block";
          }

          // When the user clicks on <span> (x), close the modal
          span[1].onclick = function() {
              modal[0].style.display = "none";
          }

          // When the user clicks anywhere outside of the modal, close it
          window.onclick = function(event) {
              if (event.target == modal[1]) {
                  modal[0].style.display = "none";
              }
          }
        </script>

    </body>
</html>
