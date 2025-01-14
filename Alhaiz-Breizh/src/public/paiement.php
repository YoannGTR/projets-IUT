<?php
require '../php/Tools/Bootstrap.php';

if (!isset($_GET['id'])) {
    header('Location: /');
    exit();
}

use Classes\Traitement;

$traitement = new Traitement();

$devis = $traitement->getDevisById($_GET['id']);

if (!$devis || $traitement->getReservationUuid($_GET['id'])) {
    header('Location: /');
    exit();
}

$userData = $auth->getUserData();

if ($userData === null) {
    $auth->redirectToLoginOnLoad(true);
    $userData = $auth->getUserData();
    $traitement->setClientUuid($userData['uuid']);
} else {
    $client_uuid = $userData['uuid'];
    if ($client_uuid != $devis['client_uuid'] && $devis['client_uuid'] != null) {
        header('Location: /');
        exit();
    }
}

// Verify if data is sent via post
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Validate"])) {
    $traitement->storeData($client_uuid);
    header('Location: /detail-reservation.php?id=' . $traitement->getReservationUuid($_GET['id']));
    exit();
}

// Calcul du nombre de nuits
$start_date = new DateTime($devis['start_date']);
$end_date = new DateTime($devis['end_date']);
$interval = $start_date->diff($end_date);
$duree_sejour = $interval->days;

// Ajouter une nuit si la différence en jours est zéro ou si les heures ne sont pas identiques
if ($duree_sejour == 0 || $start_date->format('H:i:s') != $end_date->format('H:i:s')) {
    $duree_sejour += 1;
}

// Conversion des prix de centimes en euros
$montant_journalier = $devis['daily_price_ttc'] / 100;
$montant_sejour = ($devis['daily_price_ttc'] * $duree_sejour) / 100;
$commission = $devis['service_fees'] / 100;
$taxe_sej = $devis['tourist_tax'] / 100;
$total_ttc = $devis['total_ttc'] / 100;

$headerRedirectTo = '/';
$headerTitle = 'Paiement';

$currentPageHeader = CurrentPage::RESERVATIONS;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    require ('../php/Composants/head.php');
    ?>
    <title>ALHaIZ Breizh</title>
    <link rel="stylesheet" href="ressources/css/paiement.css">
</head>

<body>
    <?php
    require ('../php/Composants/loader.php');
    require ('../php/Composants/notch.php');
    require ('../php/Composants/header.php');
    include ('../php/Composants/toast.php');
    ?>
    <main>
        <form method="post">
            <section class="order-summary">
                <h2>Récapitulatif de la commande</h2>
                <ul class="list-summary">
                    <li>
                        <p>Montant séjour <?php echo "({$duree_sejour} x {$montant_journalier}€) :" ?></p>
                        <em><?php echo number_format($montant_sejour, 2, ',', ' '); ?> €</em>
                    </li>
                    <li>
                        <p>Commission :</p>
                        <em><?php echo number_format($commission, 2, ',', ' '); ?> €</em>
                    </li>
                    <li>
                        <p>Taxe séjour :</p>
                        <em><?php echo number_format($taxe_sej, 2, ',', ' '); ?> €</em>
                    </li>
                    <li>
                        <strong>Total (TTC) :</strong>
                        <strong><em><?php echo number_format($total_ttc, 2, ',', ' '); ?> €</em></strong>
                    </li>
                </ul>
            </section>


            <section class="facturation">
                <h2>Informations de paiement</h2>
                <div class="payment-info">
                    <select type="text" name="Civilité" value="M.">
                        <option value="." disabled selected>Civilité</option>
                        <option value="M">M</option>
                        <option value="MME">MME</option>
                    </select>
                    <input type="text" placeholder="Nom" name="Nom">
                    <input type="text" placeholder="Prénom" name="Prenom">
                    <input type="text" placeholder="Adresse Complète" name="Adresse Complète">
                </div>
            </section>

            <section class="method-choice">
                <h2 class="payment-label">Choisir un moyen de paiement</h2>
                <div class="payment-option" id="credit-card-option">
                    <input type="radio" id="credit-card" name="payment-method" value="credit-card">
                    <div class="payment-details" id="credit-card-details">
                        <h3 for="credit-card">Carte de crédit</h3>
                        <input type="text" inputmode="numeric" maxLength="16" placeholder="Numéro de la carte"
                            name="Numéro de la carte">
                        <input type="text" placeholder="Titulaire de la carte">
                        <input type="text" inputmode="numeric" maxLength="2" id="expiration-month" placeholder="MM"
                            name="expiration-month">
                        <input type="text" inputmode="numeric" maxLength="2" id="expiration-year" placeholder="YY"
                            name="expiration-year">
                        <input type="text" inputmode="numeric" maxLength="3" placeholder="CVV" name="CVV">
                    </div>
                </div>
                <!-- <div class="payment-option" id="paypal-option">
                        <input type="radio" id="paypal" name="payment-method" value="paypal">
                        <div class="payment-details" id="paypal-details">
                            <h3 for="paypal">Paypal</h3>
                        </div>
                    </div>  -->
            </section>

            <section class="cgv">
                <div>
                    <input type="checkbox" id="cgv-checkbox" name="cgv">
                    <label for="cgv">J'accepte les <a target="_blank" href="/ressources/CGU.pdf">conditions générales de vente</a></label>
                </div>
                <button type="submit" class="validate-button" name="Validate">Valider</button>
            </section>
        </form>
    </main>

    <?php
    $currentPageFooter = CurrentPage::HOME;
    require ('../php/Composants/footer.php');
    ?>
    <script src="/ressources/js/main.js"></script>
    <script src="ressources/js/paiement.js"></script>
</body>

</html>