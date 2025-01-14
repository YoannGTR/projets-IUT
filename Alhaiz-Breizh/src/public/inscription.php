<?php
require '../php/Tools/Bootstrap.php';

$errorMessages = "";

$continue = $_GET['continue'] ?? false;
$isBackOffice = $_GET['backoffice'] ?? false;
$defaultHomeFO = './index.php';
$defaultHomeBO = './consulter-reservations.php';
$defaultHome = $isBackOffice ? $defaultHomeBO : $defaultHomeFO;

$buttonTxt = $continue ? "S'inscrire et continuer" : "S'inscrire";

$redirect = $continue ? htmlspecialchars($_GET['redirect']) : $defaultHome;

$background = ($isBackOffice ? 'bo' : 'fo') . '-bc';
$primaryColor = $isBackOffice ? 'primaryBO' : 'primaryFO';
$secondaryColor = $isBackOffice ? 'secondaryBO' : 'secondaryFO';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $errorMessages = $auth->getRequestResultSignUp($_POST, $isBackOffice);
    if (empty($errorMessages)) {
        $redirectUrl = $_GET['redirect'] ?? './index.php';
        $_SESSION['show_registered_toast'] = true;
        header("Location: $redirectUrl");
        exit;
    }
}

// Check if user is already logged in, if yes then redirect to index page
if ($auth->getUserData()) {
    $redirectUrl = $_GET['redirect'] ?? $defaultHome;
    header("Location: $redirectUrl");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr" id="loginHtml">

<head>
    <?php
    require ('../php/Composants/head.php');
    ?>
    <title>ALHaIZ Breizh</title>
    <link rel="stylesheet" href="ressources/css/connexion.css" />
</head>

<body id="loginBody" class="<?php echo $background; ?>">
    <?php
    require('../php/Composants/loader.php');
    require('../php/Composants/notch.php');
    $headerTitle = 'Inscription';
    $currentPageHeader = CurrentPage::REGISTER;
    require('../php/Composants/header.php');
    include('../php/Composants/toast.php');
    ?>
    <main class="<?php echo $background; ?>">
        <div class="popup">
            <div class="popup-container">
                <div id="title">
                    <img src="./ressources/assets/logoFull.svg" alt="">
                </div>
              <form id="myForm" method="POST">
                <div class="page1">
                  <div id="input-container">
                    <label for="username-input">Pseudo</label>
                    <input aria-label="username" type="text"
                           value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                           id="username-input" name="username" placeholder="Pseudo" required>
                    <label for="email-input">Email</label>
                    <input aria-label="Email" type="text"
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                           id="email-input" name="email" placeholder="Email" required>
                    <p class="hidden" id="email-error">Votre email est incorrect.</p>
                    <label for="password-input">Mot de passe</label>
                    <div class="password-container">
                      <input aria-label="Mot de passe" type="password" id="password-input" name="password"
                             placeholder="Mot de passe" required>
                      <span class="toggle-password"></span>
                    </div>
                    <p class="hidden" id="password-error">Un mot de passe doit contenir au minimum 8 caractères, à
                      savoir : au moins une lettre minuscule et une lettre majuscule, un caractère spécial et un
                      chiffre.</p>
                    <label for="password-confirm-input">Confirmation de mot de passe</label>
                    <div class="password-container">
                      <input aria-label="Mot de passe" type="password" id="password-confirm-input" name="password-confirm"
                             placeholder="Confirmation de mot de passe" required>
                      <span class="toggle-password"></span>
                    </div>
                    <p class="hidden" id="password-confirm-error">Vos mots de passe ne correspondent pas.</p>
                  </div>

                  <div id='error-messages' class='error-messages'>
                      <?php if (!empty($errorMessages)): ?>
                        <div class='error-icon'></div>
                        <p><?php echo $errorMessages; ?></p>
                      <?php endif; ?>
                  </div>

                  <button type="button" class="button-container <?php echo $primaryColor?>" id="button-next" onclick="changePage(2)">Suivant</button>
                </div>
              <div class="page2 hidden">
                <div id="input-container">
                  <div onclick="changePage(1)" class="goBack">
                    <img src="ressources/assets/back-arrow.svg" alt="Icon retour">
                    <a>Retourner à la page précédente</a>
                  </div>
                  <label for="select">Civilité</label>
                  <select aria-label="Titre" class="select-field" id="select" name="title" required>
                    <option value="" disabled selected>Civilité</option>
                    <option value="Monsieur" <?php echo (isset($_POST['title']) && $_POST['title'] == 'Monsieur') ? 'selected' : ''; ?>>Monsieur</option>
                    <option value="Madame" <?php echo (isset($_POST['title']) && $_POST['title'] == 'Madame') ? 'selected' : ''; ?>>Madame</option>
                  </select>
                  <label for="nom-input">Nom</label>
                  <input aria-label="Nom" type="text" id="nom-input" name="lastname"
                         value="<?php echo isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : ''; ?>"
                         placeholder="Nom" required>
                  <label for="prenom-input">Prénom</label>
                  <input aria-label="Prénom" type="text" id="prenom-input" name="firstname"
                         value="<?php echo isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname']) : ''; ?>"
                         placeholder="Prénom" required>
                  <?php if ($isBackOffice): ?>
                    <label for="phone-input">Numéro de téléphone</label>
                    <input aria-label="Téléphone" type="tel"  id="phone-input" name="phone_number"
                           value="<?php echo isset($_POST['phone_number']) ? htmlspecialchars($_POST['phone_number']) : ''; ?>"
                           placeholder="01 23 45 67 89"
                           pattern="^(\+33\s?|0)[1-9](\s?\d{2}){4}$"
                           required>
                  <?php endif; ?>
                  <div class="date-container">
                    <label for="birthdate">Date de naissance</label>
                    <input type="text"
                           id="birthdate"
                           class="pf-c-form-control"
                           name="birthdate"
                           aria-invalid=""
                           placeholder="JJ/MM/AAAA"
                           required=""
                           value="<?php echo isset($_POST['birthdate']) ? htmlspecialchars($_POST['birthdate']) : ''; ?>"
                           inputmode="numeric"
                    >
                  </div>
                  <p class="hidden" id="date-error">Vous avez moins de 11 ans.</p>
                </div>

                <input type="submit" class="button-container <?php echo $primaryColor?>" name="register" id="button-container"
                       value="<?php echo $buttonTxt ?>">

                <div id='error-messages' class='error-messages'>
                    <?php if (!empty($errorMessages)): ?>
                      <div class='error-icon'></div>
                      <p><?php echo $errorMessages; ?></p>
                    <?php endif; ?>
                </div>
              </div>

              <div class="divider">Ou</div>

                <div class="switch">
                    <a>Vous avez un compte ? </a><a href=<?php echo $auth->redirectToLogin($redirect, $continue, $isBackOffice) ?>
                        class="switchButton <?php echo $secondaryColor?>">Se connecter</a>
                </div>
            </div>
        </div>
    </main>
    <script src="ressources/js/connexion.js"></script>
    <?php
    $currentPageFooter = CurrentPage::ACCOUNT;
    require('../php/Composants/footer.php');
    ?>
    <script src="/ressources/js/main.js"></script>
</body>

</html>