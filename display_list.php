<?php
// Check for a valid session (if not redirect back to login)
session_start();
 if(!isset($_SESSION['user'])){
   header("Location:login.php");
 }

?>
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

                  <div class="lists">  <ul>
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
                    <button onclick="document.getElementById('create-modal').style.display='block'">Add List</button>
            </div>
        </main>

        <!-- FOOTER -->
        <?php include 'includes/footer.php' ?>

    </body>
</html>
