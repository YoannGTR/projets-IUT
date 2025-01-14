<?php

use Classes\Toast;

$userData = $auth->getUserDataBackOffice();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
    $auth->logout(true);
    $userData = null;
    echo '<script>window.location.href = "/index.php";</script>';
    exit();
}

if($_SESSION['show_connected_toast'] ?? false) {
    Toast::trigger('Vous êtes maintenant connecté', 'success');
    $_SESSION['show_connected_toast'] = false;
}

if($_SESSION['show_registered_toast'] ?? false) {
    Toast::trigger('Vous êtes maintenant inscrit', 'success');
    $_SESSION['show_registered_toast'] = false;
}

?>

<header id="header-bo-desktop">
  <div class="area"></div>
  <nav class="main-menu">
    <ul>
      <li class="has-subnav">
        <a href="./consulter-reservations.php">
          <img class="resa image-header" alt="icon réservations" src="ressources/assets/calendar-icon.svg"/>
          <span class="nav-text">Réservations</span>
        </a>

      </li>
      <li class="has-subnav">
        <a href="./consulter-logements.php">
          <img class="home image-header" alt="icon réservations" src="ressources/assets/bed-icon.svg"/>
          <span class="nav-text">Logements</span>
        </a>

      </li>
    </ul>

    <ul class="logout">
      <li class="logout-bo">
        <form id="logout" method="POST">
          <button type="submit" name="logout" id="BO-logout">
            <img class="logout image-header" alt="icon réservations" src="ressources/assets/logout.svg"/>
            <span class="nav-text">Se déconnecter</span>
          </button>
        </form>
      </li>
      <li>
        <a href="./profile.php">
          <img class="user image-header" alt="icon réservations" src="ressources/assets/account_circle.svg"/>
          <span class="nav-text">Mon profil</span>
        </a>
      </li>
    </ul>
  </nav>
</header>
<div class="placeholder-hover"></div>
