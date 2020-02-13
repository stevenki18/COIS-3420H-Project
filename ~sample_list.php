<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            $PAGE_TITLE = "Sample List";
            include "includes/meta.php";
        ?>
    </head>

    <body>
        <!-- HEADER -->
        <header>
            <?php include 'includes/nav.php' ?>
        </header>

        <main>
            <!-- DISPLAY LIST -->
            <header>
                <!-- LIST NAME -->
                <h1>Sample List</h1>
                <!-- START DATE -->
                <div>
                    <h3>2/9/2017</h3>
                    <p>START DATE</p>
                </div>
                <!-- END DATE -->
                <div>
                    <h3>1/1/2025</h3>
                    <p>END DATE</p>
                </div>
            </header>

            <ul>
              <!-- FIRST ITEM -->
              <li>
                Go Skydiving!
                <figure>
                  <img src="img/skydiving.jpg" alt="simpleskydiver"/>
                </figure>
              </li>

              <!-- SECOND ITEM -->
              <li>
                List item 2
              </li>

              <!-- THIRD ITEM -->
              <li>
                List item 3
              </li>

            </ul>



        </main>

        <!-- FOOTER -->
        <?php include 'includes/footer.php' ?>

    </body>
</html>
