<?php
  /*-----------------------------------------------------------
  |
  |   PAGE:         terms.php
  |
  |   DESCRIPTION:  Terms and Conditions for the site
  |
  -----------------------------------------------------------*/
?>
<!DOCTYPE HTML>
<html lang="en">

<head>
  <?php
      $PAGE_TITLE = "Terms and Conditions";
      include "includes/meta.php"
    ?>

</head>

<body>

  <header>
    <?php include 'includes/nav.php' ?>
  </header>

  <main>
    <header>
      <h1>Terms And Conditions</h1>
    </header>

    <article id="tac">
      <h2 class="hidden">Terms and Conditions</h2>
        <!-- USE OF INFORMATION -->
        <section id="tacInfo">
            <h2>1. Use of Information</h2>
            <p>We will only use your information obtained in the registration process to best tailor the experience of our app to your liking.</p>
            <p>This includes:</p>
            <ul>
                <li>Providing search results best fitted to your age demographic</li>
                <li>Suggesting list items best fitted to your age demographic</li>
                <li>Displaying first name on publicly viewable lists</li>
            </ul>
        </section>

        <!-- SECURITY -->
        <section id="tacSec">
            <h2>2. Security</h2>
            <p>We take security very seriously and for that reason we will never ask for any personal information aside from the registration and login process. </p>
            <p>We will not email you asking to confirm personal information.</p>
            <p>We will not share any personal information besides your first name on publicly viewable lists.</p>
        </section>

        <!-- PRIVACY -->
        <section id="tacPriv">
            <h2>3. Privacy</h2>
            <p>We respect your privacy and your rights to remain a private user on this application. We provide the option to make all lists and list items be private and
                un-sharable with anyone other users on this page. </p>
        </section>
    </article>

  </main>

  <?php include 'includes/footer.php' ?>

</body>

</html>
