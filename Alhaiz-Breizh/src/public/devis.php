<?php


require '../php/Tools/Bootstrap.php';

use Classes\Devis;

$Devis = new Devis();

$userData = $auth->getUserData();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['devis'])) {
    // Handle POST request
    $devis = $Devis->generateDevisFromPostData($_POST, $userData);



    if (!$devis) {
        header('Location: /');
        exit();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Handle GET request
    if (!isset($_GET['id'])) {
        header('Location: /');
        exit();
    }
    $devis = $Devis->getDevis($_GET['id'], $userData);
    if (!$devis) {
        header('Location: /');
        exit();
    }

}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    require ('../php/Composants/head.php');
    ?>
    <title>ALHaIZ Breizh</title>
    <link rel="stylesheet" href="/ressources/css/devis.css" />
</head>

<body>
    <?php
    $headerRedirectTo = '/';
    $headerTitle = 'Devis';
    $currentPageHeader = CurrentPage::RESERVATIONS;
    require ('../php/Composants/loader.php');
    require ('../php/Composants/notch.php');
    require ('../php/Composants/header.php');
    include ('../php/Composants/toast.php');
    ?>
    <main>
        <div id="infos_logement">
            <div id="firstBlocPc">
                <img src="<?php echo $devis["photo_logement"] ?>" alt="image logement" id="image_logement" class="bloc">
                <div class="sectionText bloc" id="title">
                    <div id="title_ville_note">
                        <div id="titreAuteur">
                            <h2><?= $devis["logement"]["title"]; ?></h2>
                            <div id="auteur_PC" class="auteur">
                                <p>
                                    Proposé par
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="#a09e9e">
                                        <path
                                            d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                                    </svg>
                                    <a><?= $devis["proprietaire"]["firstname"]; ?>
                                        <?= $devis["proprietaire"]["lastname"]; ?></a>
                                </p>
                            </div>
                        </div>
                        <div id="ville_et_note">
                            <p><?= $devis["logement"]["type"]; ?> &#xB7; <?= $devis["logement"]["city"]; ?>,
                                <?= $devis["logement"]["department"]; ?>
                            </p>
                            <div id="note">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" fill="#f57393">
                                    <path
                                        d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                                </svg>
                                <p><?= $devis["logement"]["note"]; ?></p>
                            </div>
                        </div>
                    </div>
                    <img src="<?php echo $devis["photo_logement"] ?>" alt="image logement" id="image_logementTablet"
                        class="bloc">
                </div>
                <div id="reservationMcontainer">
                    <div class="sectionText bloc" id="reservationM">
                        <h1 id="titreDevis">Devis</h1>
                        <table id="recapitulatif-table">
                <tr>
                    <td>Date et heure d'arrivée :</td>
                    <td style="text-align:right;"><?php echo $devis["devis"]["start_date"] ?> à
                        <?php echo $devis["devis"]["start_hours"] ?></td>
                </tr>
                <tr>
                    <td>Date et heure de départ :</td>
                    <td style="text-align:right;"><?php echo $devis["devis"]["end_date"] ?> à
                        <?php echo $devis["devis"]["end_hours"] ?></td>
                </tr>
                <tr class="tabBorderTop">
                    <td>Nombre de nuits :</td>
                    <td style="text-align:right;"><?php echo $devis["devis"]["nb_days"] ?></td>
                </tr>
                <tr class="tabBorderBottom">
                    <td>Nombre de personnes :</td>
                    <td style="text-align:right;"><?php echo $devis["devis"]["nb_people"] ?></td>
                </tr>
                <?php
                $prix_par_nuit = floatval($devis["devis"]["daily_price_ttc"]) / 100;
                $nombre_de_nuits = intval($devis["devis"]["nb_days"]);
                $prix_total_location = $prix_par_nuit * $nombre_de_nuits;
                $service_fees = floatval($devis["devis"]["service_fees"]) / 100;
                $tourist_tax = floatval($devis["devis"]["tourist_tax"]) / 100;
                $total_ttc = floatval(str_replace(',', '.', $devis["devis"]["total_ttc"]));
                ?>
                <tr>
                    <td>Montant séjour (<?php echo $nombre_de_nuits ?> x
                        <?php echo number_format($prix_par_nuit, 2, ',', ' ') ?> €):</td>
                    <td style="text-align:right;">
                        <?php echo number_format($prix_total_location, 2, ',', ' ') ?> €
                    </td>
                </tr>
                <tr>
                    <td>Frais de service :</td>
                    <td style="text-align:right;"><?php echo number_format($service_fees, 2, ',', ' ') ?> €</td>
                </tr>
                <tr class="tabBorderBottom">
                    <td>Taxe de séjour :</td>
                    <td style="text-align:right;"><?php echo number_format($tourist_tax, 2, ',', ' ') ?> €</td>
                </tr>
                <tr>
                    <td>Total TTC : </td>
                    <td style="text-align:right;"><?php echo number_format($total_ttc, 2, ',', ' ') ?> €</td>
                </tr>
            </table>
                        <div class="rangButton">
                            <button class="rose"
                                onclick="accepter('<?php echo $devis['devis']['uuid'] ?>');"><?php echo ($userData == null ? "S'identifier pour accepter" : "Accepter"); ?></button>
                            <button class="rose" onclick="refuser();">Refuser</button>
                        </div>
                    </div>
                </div>
                <div class="sectionText bloc" id="description">
                    <div id="auteur_mobile" class="auteur">
                        <p>
                            Proposé par
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="#a09e9e">
                                <path
                                    d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                            </svg>
                            <a><?= $devis["proprietaire"]["firstname"]; ?>
                                <?= $devis["proprietaire"]["lastname"]; ?></a>
                        </p>
                    </div>
                    <p class="longTexte" id="textDescription">
                        <?= $devis["logement"]["description"]; ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="sectionText bloc" id="reservation">
            <h1 id="titreDevis">Devis</h1>
            <table id="recapitulatif-table">
                <tr>
                    <td>Date et heure d'arrivée :</td>
                    <td style="text-align:right;"><?php echo $devis["devis"]["start_date"] ?> à
                        <?php echo $devis["devis"]["start_hours"] ?></td>
                </tr>
                <tr>
                    <td>Date et heure de départ :</td>
                    <td style="text-align:right;"><?php echo $devis["devis"]["end_date"] ?> à
                        <?php echo $devis["devis"]["end_hours"] ?></td>
                </tr>
                <tr class="tabBorderTop">
                    <td>Nombre de nuits :</td>
                    <td style="text-align:right;"><?php echo $devis["devis"]["nb_days"] ?></td>
                </tr>
                <tr class="tabBorderBottom">
                    <td>Nombre de personnes :</td>
                    <td style="text-align:right;"><?php echo $devis["devis"]["nb_people"] ?></td>
                </tr>
                <?php
                $prix_par_nuit = floatval($devis["devis"]["daily_price_ttc"]) / 100;
                $nombre_de_nuits = intval($devis["devis"]["nb_days"]);
                $prix_total_location = $prix_par_nuit * $nombre_de_nuits;
                $service_fees = floatval($devis["devis"]["service_fees"]) / 100;
                $tourist_tax = floatval($devis["devis"]["tourist_tax"]) / 100;
                $total_ttc = floatval(str_replace(',', '.', $devis["devis"]["total_ttc"]));
                ?>
                <tr>
                    <td>Montant séjour (<?php echo $nombre_de_nuits ?> x
                        <?php echo number_format($prix_par_nuit, 2, ',', ' ') ?> €):</td>
                    <td style="text-align:right;">
                        <?php echo number_format($prix_total_location, 2, ',', ' ') ?> €
                    </td>
                </tr>
                <tr>
                    <td>Frais de service :</td>
                    <td style="text-align:right;"><?php echo number_format($service_fees, 2, ',', ' ') ?> €</td>
                </tr>
                <tr class="tabBorderBottom">
                    <td>Taxe de séjour :</td>
                    <td style="text-align:right;"><?php echo number_format($tourist_tax, 2, ',', ' ') ?> €</td>
                </tr>
                <tr>
                    <td>Total TTC : </td>
                    <td style="text-align:right;"><?php echo number_format($total_ttc, 2, ',', ' ') ?> €</td>
                </tr>
            </table>

            <div class="rangButton">
                <button class="rose"
                    onclick="accepter('<?php echo $devis['devis']['uuid'] ?>');"><?php echo ($userData == null ? "S'identifier pour accepter" : "Accepter"); ?></button>
                <button class="rose" onclick="refuser();">Refuser</button>
            </div>
        </div>
    </main>
    <?php
    $currentPageFooter = CurrentPage::HOME;
    require ('../php/Composants/footer.php');
    ?>
    <script src="/ressources/js/main.js"></script>
    <script src="/ressources/js/devis.js"></script>
</body>

</html>