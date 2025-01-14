<?php
require '../php/Tools/Bootstrap.php';

// Check if user is already logged in, If yes then redirect to index page
$errorMessages = "";

$continue = $_GET['continue'] ?? false;
$isBackOffice = $_GET['backoffice'] ?? false;
$defaultHomeFO = './index.php';
$defaultHomeBO = './consulter-reservations.php';
$defaultHome = $isBackOffice ? $defaultHomeBO : $defaultHomeFO;

$buttonTxt = $continue ? 'Se connecter et continuer' : 'Se connecter';

$redirect = $continue ? htmlspecialchars($_GET['redirect']) : $defaultHome;

$background = ($isBackOffice ? 'bo' : 'fo') . '-bc';
$primaryColor = $isBackOffice ? 'primaryBO' : 'primaryFO';
$secondaryColor = $isBackOffice ? 'secondaryBO' : 'secondaryFO';

if($isBackOffice) {
    if ($auth->getUserDataBackOffice()) {
        $redirectUrl = $_GET['redirect'] ?? $defaultHome;
        header("Location: $redirectUrl");
        exit;
    }
} else {
    if ($auth->getUserData()) {
        $redirectUrl = $_GET['redirect'] ?? $defaultHome;
        header("Location: $redirectUrl");
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $errorMessages = $auth->getRequestResultLogin($_POST, $isBackOffice);
    if (empty($errorMessages)) {
        // Redirect to original page or default to index
        $redirectUrl = $_GET['redirect'] ?? './index.php';
        $_SESSION['show_connected_toast'] = true;
        header("Location: $redirectUrl");
        exit;
    }
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
    $headerTitle = 'Connexion';
    $currentPageHeader = CurrentPage::REGISTER;
    require('../php/Composants/header.php');
    include('../php/Composants/toast.php');
    ?>
    <main class="<?php echo $background; ?>">
        <div class="popup">
            <div class="popup-container">
                <div id="title">
                    <img src="./ressources/assets/logoFull.svg">
                </div>

                <form id="myForm" method="POST">
                    <div id="input-container">
                      <label for="email-input">Email</label>
                        <input aria-label="Entrer votre email" type="text" id="email-input" name="email"
                            placeholder="Entrer votre email" value="" required>
                        <label for="password-input">Mot de passe</label>
                        <div class="password-container">
                            <input aria-label="Mot de passe" type="password" name="password" id="password-input"
                                placeholder="Mot de passe" required>
                            <span class="toggle-password"></span>
                        </div>
                    </div>
                    <input type="submit" class="button-container <?php echo $primaryColor?>" name="login" id="button-container"
                           value="<?php echo $buttonTxt; ?>">

                    <div id='error-messages' class='error-messages'>
                        <?php if (!empty($errorMessages)): ?>
                            <div class='error-icon'></div>
                            <p><?php echo $errorMessages; ?></p>
                        <?php endif; ?>
                    </div>
                </form>

                <div class="divider">Ou</div>

                <div class="switch">
                    <a>Pas encore de compte? </a><a href=<?php echo $auth->redirectToRegister($redirect, $continue, $isBackOffice) ?>
                        class="switchButton <?php echo $secondaryColor?>">S'inscrire</a>
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