<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            $PAGE_TITLE = "Public Lists";
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
                <h1>Publicly Viewable Lists</h1>
            </header>

            <ul>
              <!-- FIRST LIST -->
              <li><h2>Complete me by 50</h2>
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
              <li><h2>Complete me by 90</h2>
                <ul>
                  <li>
                    ->Don't die!
                  </li>
                  <li>
                    ->Go Skydiving.
                  </li>
                </ul>

            </ul>
        </main>

        <!-- FOOTER -->
        <?php include 'includes/footer.php' ?>
    </body>
</html>
