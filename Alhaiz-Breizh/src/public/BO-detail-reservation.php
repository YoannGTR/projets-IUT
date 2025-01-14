<?php
require '../php/Tools/Bootstrap.php';

if(!$auth->getUserDataBackOffice()) {
    $auth->redirectToLoginOnLoad(true, true);
}

use Classes\DetailReservation;


$data = $auth-> getUserDataBackOffice();
$connectedUserUUID = $data['uuid'];

// If user need to be connected for this page



$Reservation = new DetailReservation();
$detail=$Reservation->getReservationFullInfoBO($_GET['id']);


if (!$detail) {
    echo ("HUH");
}

require('../php/Composants/headerBO.php');
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    require ('../php/Composants/head.php');
    ?>
  <title>ALHaIZ Breizh</title>
  <script src="./ressources/js/header.js"></script>
  <link rel="stylesheet" href="/ressources/css/Bo-detail-reservation.css" />
  <link rel="stylesheet" href="/ressources/css/styles.css" />
</head>

<body>
<?php
require ('../php/Composants/loader.php');
require ('../php/Composants/notch.php');
include('../php/Composants/toast.php');
?>
<main style="height: 100%;width: auto;margin-left:60px;">
  <section class="detailcomp">
    <div class="detail">
      <h2 class="laptop">Details de la reservation</h2>
      <table class="contenu">
          <tr class="laptop">
            <th>Titre de l'annonce :</th>
            <td><?php
            echo $detail["titre"];
            ?></td>
          </tr>
          <tr>
            <th>Adresse :</th>
            <td><?php echo $detail["adresse"] ?>
            </td>
          </tr>
          <tr class="ecart">
            <th>Date et heure d'arrivée :</th>
            <td><?php

            echo $detail["arrive"];
            ?></td>
          </tr>
          <tr>
            <th>Date et heure de départ :</th>
            <td><?php echo $detail["depart"]; ?></td>
          </tr>
          <tr>
            <th>Nombre de nuits :</th>
            <td class="numerique"><?php echo $detail["nb_jours"]; ?></td>
          </tr>
          <tr>
            <th>Nombre de personnes :</th>
            <td class="numerique"><?php echo $detail["personnalisation"]; ?></td>
          </tr>
          <tr>
          <th>Reservé par :</th>
          <td>
              <?php echo $detail["prenom_user"]; ?> <?php echo $detail["nom_user"]; ?>
          </td>

        </tr>

        </table>
    </div>

    <img class="image" src="<?php echo $detail["photo"] ?>" alt="Photo du logement">
    <button type="button" class="rose"
            onclick=window.location.href="./detail-mon-logement.php?id=<?php echo htmlentities($detail['logement_uuid']); ?>">Voir le logement</button>
  </section>
  <section class="paiement">
  <div class="detailpai">
    <h2>Détails du paiement :</h2>
    <div class="texte">
        <div class="ligne">
            <p class="description">Montant séjour (<?php echo $detail["nb_jours"]; ?> x <?php 
                    $montant_sejour_par_nuit = floatval(str_replace(',', '.', $detail["montant_sej"]));
                    echo number_format($detail["daily_price_ttc"] / 100, 2, ',', ' '); 
                ?>€) :</p>
            <p class="numerique">
                <?php echo number_format($montant_sejour_par_nuit, 2, ',', ' '); ?> €
            </p>
        </div>
        <div class="ligne">
            <p class="description">Frais de service :</p>
            <p class="numerique">
                <?php echo number_format(floatval(str_replace(',', '.', $detail["comission"])), 2, ',', ' '); ?> €
            </p>
        </div>
        <div class="ligne">
            <p class="description">Taxe de séjour :</p>
            <p class="numerique">
                <?php echo number_format(floatval(str_replace(',', '.', $detail["taxesej"])), 2, ',', ' '); ?> €
            </p>
        </div>
        
        <div class="ligne">
        </div>
        <div class="ligne">
            <p class="description">Total TTC :</p>
            <p class="numerique">
                <?php echo number_format(floatval(str_replace(',', '.', $detail["montant_ttc"])), 2, ',', ' '); ?> €
            </p>
        </div>
    </div>
    <div class="telecharger">
        <button type="button" class="gris">Télécharger Facture</button>
        <button type="button" class="gris">Télécharger Reçu</button>
    </div>
</div>

    <div class="methodepai">
      <h2>Méthode de paiement</h2>
      <div class="texte">
        <p>Moyen de paiement : Carte Bleue</p>
        <p class="gris">Numéro de carte : **** **** **** 4076</p>
        <p class="gris">Expire le : 11/26</p>
        <p class="gris">Numéro de transation : 1532874623664</p>
        <p class="gris">Email lié au paiement : donou.arthur@gmail.com</p>
        <p>Adresse de facturation : <?php echo $detail["billing_adress"] ?></p>
      </div>
    </div>
  </section>
</main>
<?php
$currentPageFooter = CurrentPage::BACKOFFICE;
require ('../php/Composants/footer.php');
?>
<script src="/ressources/js/main.js"></script>
</body>

</html>