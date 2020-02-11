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
    <!-- LOGO -->
    <div class="logo">
      <figure>
        <img src="img/bucket.png" alt="Bucket List Logo" height=200 />
      </figure>
    </div>

    <?php include 'nav.php' ?>

  </header>
  <main>
    <article>
      <h1>Welcome to My Bucket List(s)</h1>
      <p>
        At this site you will be able to create your own bucket list, and keep track on the progress.
      </p>
      <section id="about">
        <h2>About</h2>
      </section>
      <section id="ideas">
        <h2>Sample Sites</h2>
      </section>
      <section id="top-ten">
        <h2>Top 10</h2>
      </section>
      <section id="register">
        <h2>Register</h2>
      </section>
    </article>
    <!-- OUR GENERIC LIST -->
    <!-- DEFAULT LIST -->
  </main>


  <?php include 'includes/footer.php' ?>

</body>

</html>
