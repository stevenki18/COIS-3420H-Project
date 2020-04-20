<?php session_start(); 
  require_once 'includes/library.php';

  if($_SESSION['user'])
    $pdo = connectDB();
?>
<!DOCTYPE HTML>
<!-- ******************************** Filename: index.html, uses default.css
 *
 * Usage: Bucket List Splash PAGE
 *        This is the first page when coming to the website to create or modify
 *        a bucket list. Work in progress
 *
 *
 * Note: reset.css is also being used by the q3.html files in order to wipe settings
 *
 * Created by: Group 10 for COIS-3420H Project
 ******************************************************************************
 -->
<html lang="en">
  <head>
    <?php
      $PAGE_TITLE = "Welcome!";
      include "includes/meta.php"
    ?>
  </head>

  <body>
    <!-- SPLASH PAGE -->
    <header>
      <?php include 'includes/nav.php' ?>
    </header>

    <main>
      <article>
        <header>
          <!-- LOGO -->
          <div class="logo">
            <figure>
              <img src="img/bucket.png" alt="Bucket List Logo" height=200 />
            </figure>
          </div>

          <h1>Welcome to My Bucket List(s)</h1>
        </header>

        <section id="about">
          <h2>About</h2>
          <p>
            At this site you will be able to create your own bucket list, and keep track on the progress.
          </p>
        </section>

        <section id="ideas">
          <h2>Sample Lists</h2>
          <ul>
            <li>
              Things to do before 50
            </li>
            <li>
              Do before I get married!
            </li>
          </ul>
        </section>

        <section id="top-ten">
          <h2>Top 5</h2>
          <ol>
            <li>
              Go Skydiving
            </li>
            <li>
              Don't Die
            </li>
            <li>
              List item 3
            </li>
            <li>
              List item 4
            </li>
            <li>
              List item 5
            </li>
          </ol>
        </section>

      </article>

    </main>


    <?php include 'includes/footer.php' ?>

  </body>

</html>
