<?php
if (!isset($_GET['id'])) {
    header('Location: /');
    exit();
}

require '../php/Tools/Bootstrap.php';

$data = NULL;
$connectedUserUUID = NULL;

if ($auth->getUserData()) {
    $data = $auth->getUserData();
    $connectedUserUUID = $data['uuid'];
}

if($auth->getUserDataBackOffice()){
    $data = $auth->getUserDataBackOffice();
    $connectedUserUUID = $data['uuid'];
}

use Classes\Database;

$db = Database::getInstance();

// Validate and sanitize the 'id' parameter
$id = $_GET['id'];

$estProprio = false;
if ($connectedUserUUID && $id) {
    $requete = "
    SELECT 
        *
    FROM 
        bnbyte.logement
    WHERE 
        uuid = :logementUUID AND 
        proprietaire_uuid = :userUUID";

    $params = [
        ':logementUUID' => $id,
        ':userUUID' => $connectedUserUUID,
    ];

    $estProprio = $db->executeQuery($requete, $params);
}

// Retrieve planning data regardless of ownership status
$planningRequete = "
SELECT 
unavailability_date
FROM 
    bnbyte.planning
WHERE 
    logement_uuid = :logementUUID";

$planningParams = [
    ':logementUUID' => $id,
];

$planning = $db->executeQuery($planningRequete, $planningParams);
$planningJson = json_encode($planning);

use Classes\Logement;
use Enum\Amenities;
use Enum\Perimeter;
use Enum\Activity;

$logement = new Logement();
$infosLogement = $logement->getFullInfosDetailLogement($_GET['id']);

if (!$infosLogement) {
    header('Location: /');
    exit();
}

if ($infosLogement['etat'] == "OFFLINE" && $infosLogement['proprietaire_uuid'] != $connectedUserUUID) {
    header('Location: /');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require('../php/Composants/head.php'); ?>
    <title>ALHaIZ Breizh</title>
    <link rel="stylesheet" href="/ressources/css/logement.css">
</head>

<body>
    <script>
        var capacity = parseInt(<?= $infosLogement["capacity"]; ?>);
    </script>
    <?php
    require('../php/Composants/loader.php');
    require('../php/Composants/notch.php');
    include('../php/Composants/toast.php');
    $headerRedirectTo = '/';
    $headerTitle = 'Détail du logement';

    if ($infosLogement['proprietaire_uuid'] == $connectedUserUUID) {
        $headerTitle = 'Mon Logement';
        $currentPageHeader = CurrentPage::HOME;
        require('../php/Composants/headerBO.php');
    } else {
        $headerTitle = 'Logement';
        $currentPageHeader = CurrentPage::RESERVATIONS;
        require('../php/Composants/header.php');
    }
    ?>
    <main>
        <div id="infos_logement">
            <div id="firstBlocPc">
                <img src="<?php echo $infosLogement["photo"] ?>" alt="image logement" id="image_logement" class="bloc">
                <div class="sectionText bloc" id="title">
                    <div id="title_ville_note">
                        <div id="titreAuteur">
                            <h2><?= $infosLogement["title"]; ?></h2>
                            <div id="auteur_PC" class="auteur">
                                <p>
                                    Proposé par
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="#a09e9e">
                                        <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                                    </svg>
                                    <a><?= $infosLogement["prenomProprietaire"]; ?> <?= $infosLogement["nomProprietaire"]; ?></a>
                                </p>
                            </div>
                        </div>
                        <div id="ville_et_note">
                            <p><?= $infosLogement["housing_type"]; ?> &#xB7; <?= $infosLogement["city"]; ?>, <?= $infosLogement["department"]; ?></p>
                            <div id="note">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" fill="#f57393">
                                    <path d="M112 48a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm40 304V480c0 17.7-14.3 32-32 32s-32-14.3-32-32V256.9L59.4 304.5c-9.1 15.1-28.8 20-43.9 10.9s-20-28.8-10.9-43.9l58.3-97c17.4-28.9 48.6-46.6 82.3-46.6h29.7c33.7 0 64.9 17.7 82.3 46.6l58.3 97c9.1 15.1 4.2 34.8-10.9 43.9s-34.8 4.2-43.9-10.9L232 256.9V480c0 17.7-14.3 32-32 32s-32-14.3-32-32V352H152z" />
                                </svg>
                                <p><?= $infosLogement["capacity"]; ?> personnes max</p>
                            </div>
                        </div>
                    </div>
                    <div class="price">
                        <p class="numPrice"><?= $infosLogement["price"]; ?>€</p>
                        <p class="parNuit">/nuit</p>
                    </div>
                </div>
                <a class="bloc button lienReserver" href="#reservation" id="lienReserverM">
                    Aller à la réservation
                </a>
                <div class="sectionText bloc" id="description">
                    <div id="auteur_mobile" class="auteur">
                        <p>
                            Proposé par
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="#a09e9e">
                                <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                            </svg>
                            <a><?= $infosLogement["prenomProprietaire"]; ?> <?= $infosLogement["nomProprietaire"]; ?></a>
                        </p>
                    </div>
                    <p class="longTexte" id="textDescription">
                        <?= $infosLogement["description"]; ?>
                    </p>
                    <div id="firstPriceLaptop">
                        <div class="price">
                            <p class="numPrice"><?= $infosLogement["price"]; ?>€</p>
                            <p class="parNuit">/nuit</p>
                        </div>
                        <a class="bloc button lienReserver" href="#reservation" id="lienReserverLaptop">
                            Réserver
                        </a>
                    </div>
                </div>
            </div>
            <div class="sectionText bloc" id="elements">
                <div>
                    <h3>Aménagements</h3>
                    <?php if (!empty($infosLogement["amenities"])) {
                        foreach ($infosLogement["amenities"] as $amenity) : ?>
                            <div class="activities">
                                <ul>
                                <li class="longTexte">
                                    <?= Amenities::translate($amenity["amenities"]) ?>
                                </li>
                                </ul>
                            </div>
                        <?php endforeach;
                    } else { ?>
                        <div class="activities">
                            <p class="longTexte">
                                Aucun aménagement disponible.
                            </p>
                        </div>
                    <?php } ?>
                </div>
                <div class="act">
                    <h3>
                        Activitées
                    </h3>
                    <?php if (!empty($infosLogement["activities"])) {
                        foreach ($infosLogement["activities"] as $activities) : ?>
                            <div class="activities">
                            <ul>
                                <li class="longTexte">
                                    <?= Activity::translate($activities["activity"]) ?>
                                </li>
                            </ul>
                            
                            <p class="longTexte">
                                <?= Perimeter::translate($activities["perimeter"]) ?>
                            </p>
                            </div>
                        <?php endforeach;
                    } else { ?>
                        <div class="activities">
                            <p class="longTexte">
                                Aucune activité disponible.
                            </p>
                        </div>
                    <?php } ?>
                </div>
                <div>
                    <h3>Chambre(s) - <?php echo $infosLogement["bedroom"] ?></h3>
                    <div class="lits" style="padding-left: 2em;">
                        <ul>
                            <li>Lit double(s) : <?php echo $infosLogement["double_bed"] ?></li>
                            <li>Lit simple(s) : <?php echo $infosLogement["single_bed"] ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="sectionText bloc" id="reservation">
            <div class="price">
                <p class="numPrice"><?= $infosLogement["price"]; ?>€</p>
                <p class="parNuit">/nuit</p>
            </div>
            <div id="nbPers">
                <p>Nombre de personnes</p>
                <div class="number">
                    <div id="minus">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="#f57393" id="minusSvg">
                            <path d="M432 256c0 17.7-14.3 32-32 32L48 288c-17.7 0-32-14.3-32-32s14.3-32 32-32l352 0c17.7 0 32 14.3 32 32z" />
                        </svg>
                    </div>
                    <input type="text" value="1" id="quantity" inputmode="numeric" step="1" />
                    <div id="plus">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="#fff" id="plusSvg">
                            <path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="container-calendar">
                <h3 id="monthAndYear"></h3>
                <div class="button-container-calendar">
                    <button id="previous" onclick="previous()">
                        ‹
                    </button>
                    <button id="next" onclick="next()">
                        ›
                    </button>
                </div>
                <table class="table-calendar" id="calendar" data-lang="en">
                    <thead id="thead-month"></thead>
                    <tbody id="calendar-body">
                    </tbody>
                </table>
                <div class="footer-container-calendar">
                    <label for="month">Aller à : </label>
                    <select id="month" onchange="jump()">
                    </select>
                    <select id="year" onchange="jump()"></select>
                </div>
            </div>
            <p id="CalendarVide">
                Veuillez renseigner votre date d'arrivée et de départ
            </p>
            <form action="devis.php" method="POST" onsubmit="return verif()">
                <input type="hidden" id="formLogement" name="logement_uuid" class="formInput" value="<?= $infosLogement["uuid"]; ?>">
                <input type="hidden" id="formQuantity" name="nombre_voyageurs" class="formInput" value="">
                <input type="hidden" id="formDateDeb" name="date_arrivee" class="formInput" value="">
                <input type="hidden" id="formDateFin" name="date_depart" class="formInput" value="">
                <button class="button" name="devis" id="btnReserver" type="submit">
                    Réserver
                </button>
            </form>
        </div>
    </main>
    <?php
    $currentPageFooter = CurrentPage::HOME;
    require('../php/Composants/footer.php');
    ?>
    <script>
        let planningData = <?php echo $planningJson; ?>;
    </script>
    <script src="/ressources/js/main.js"></script>
    <script src="/ressources/js/logement.js"></script>
    <script src="./ressources/js/calendar.js"></script>
</body>

</html>
                        