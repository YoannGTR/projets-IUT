<?php
require '../php/Tools/Bootstrap.php';

if(!$auth->getUserDataBackOffice()) {
    $auth->redirectToLoginOnLoad(true, true);
}

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    require('../php/Composants/head.php');
    ?>
  <title>ALHaIZ Breizh</title>
  <link rel="stylesheet" href="/ressources/css/styles.css" />
  <script src="./ressources/js/header.js"></script>
</head>

<body style="display: flex; flex-direction: column; width: 100%; height: 100%">
<?php
require('../php/Composants/loader.php');
require('../php/Composants/notch.php');
require('../php/Composants/headerBO.php');
include('../php/Composants/toast.php');
?>
<main style="height: 100%; width: auto; margin-left:60px">
  <h1>AAAAAAAA</h1>
</main>
<?php
$currentPageFooter = CurrentPage::BACKOFFICE;
require('../php/Composants/footer.php');
?>
<script src="/ressources/js/main.js"></script>
</body>

</html>