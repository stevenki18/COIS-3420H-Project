<?php session_start(); ?>
<!DOCTYPE HTML>
<html lang="en">

<head>
  <?php
      $PAGE_TITLE = "Results";
      include "includes/meta.php"
    ?>

  <link type="text/css" rel="stylesheet" href="css/terms.css" />
</head>

<body>

  <header>
    <?php include 'nav.php' ?>
  </header>

  <main>
    <header>
      <h1>Search Results</h1>
    </header>

    <span>Results for: <?= $_GET["search"] ?></span>

    <?php if(isset($_SESSION['user'])): ?>
    <h2>My List(s)</h2>
    <ul>
      <!-- FIRST LIST -->
      <li>Complete me by 50
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
      <li>Complete me by 90
        <ul>
          <li>
            ->Don't die!
          </li>
          <li>
            ->Go Skydiving.
          </li>
        </ul>

    </ul>
  <?php endif; ?>
  <h2>Public List(s)</h2>
    <ul>
      <!-- FIRST LIST -->
      <li>
        ->Don't die!
      </li>
      <li>
        ->Ride a Camel.
      </li>

      <li>
        ->Don't die!
      </li>
      <li>
        ->Go Skydiving.

    </ul>

  </main>

  <?php include 'includes/footer.php' ?>

</body>

</html>
