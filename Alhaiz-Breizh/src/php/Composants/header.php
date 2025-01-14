<?php

use Classes\Toast;

$userData = $auth->getUserData();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
    $auth->logout();
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

<header id="header-mobile">
    <?php if (isset($headerRedirectTo) && $headerRedirectTo) { ?>
        <div class="header-back redirect">
            <a href="<?php echo htmlspecialchars($headerRedirectTo, ENT_QUOTES, 'UTF-8') ?>"><img
                    src="/ressources/assets/back-arrow.svg" alt="back-arrow" /></a>
        </div>
    <?php } ?>
    <div class="header-title">
        <h1><?php if (isset($headerTitle))
            echo htmlspecialchars($headerTitle, ENT_QUOTES, 'UTF-8') ?>
            </h1>
        </div>
    </header>

<?php if (isset($currentPageHeader) && $currentPageHeader !== CurrentPage::REGISTER): ?>
<header id="header-desktop">
  <div id="header-container">
    <a id="header-logo" href="index.php">
      <img src="/ressources/assets/logoFull.svg" class="header-large-logo" alt="Logo BnByte">
      <img src="/ressources/assets/logo.svg" class="header-small-logo"  alt="icon">
    </a>
      <div id="header-content">
          <?php if (!isset($currentPageHeader) || (isset($currentPageHeader) && $currentPageHeader !== CurrentPage::HOME)): ?>
          <div class="header-barre-recherche-desktop">
            <a href="recherche.php" class="header-lien-boutons">
              <img src="./ressources/assets/bed-icon.svg" alt="Icone de lit"><span>Où allez-vous</span>
            </a>
            <a href="recherche.php" class="header-lien-boutons">
              <img src="./ressources/assets/calendar-icon.svg" alt="Icone de calendrier"><span>Arrivée - Départ</span>
            </a>
            <a href="recherche.php" class="header-lien-boutons">
              <img src="./ressources/assets/travellers-icon.svg" alt="Icone de voyageurs"><span>Voyageurs</span>
            </a>
            <a href="recherche.php" class="header-lien-boutons">
              Rechercher
            </a>
          </div>
        <?php endif; ?>
      </div>

    <div id="header-buttons">
      <?php if ($userData !== null): ?>
      <form id="logout" method="POST">
          <input type="submit" id="header-publish" name="logout" value="Se déconnecter">
      </form>
      <?php endif; ?>
        <div>
          <a href="/consulter-reservations.php" id="header-publish">
            <img src="/ressources/assets/plus.svg"  alt="icon">
            <span>Publier</span>
          </a>
        </div>
        <a href="<?php
          echo $userData !== null ? "/reservations.php" : $auth->redirectToLogin();
        ?>" id="header-login">
          <div id="header-login-text">
            <span class="header-welcome-text">Bonjour,</span>
            <span class="header-user">
                <?php
                echo $userData !== null ? htmlspecialchars($userData['firstname'], ENT_QUOTES, 'UTF-8') : 'Identifiez-vous';
                ?>
            </span>
          </div>
          <img alt="icon" class="header-icon" src="<?php
              echo $userData !== null && isset($userData['avatar']) ? htmlspecialchars($userData['avatar'], ENT_QUOTES, 'UTF-8') : "/ressources/assets/account.svg";
            ?>">
        </a>
       </div>
      <a href="" id="header-menu">
        <img src="/ressources/assets/burger-menu-svgrepo-com.svg" alt="icon" id="header-menu-icon">
      </a>
  </div>
</header>
<?php endif; ?>