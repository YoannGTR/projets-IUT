<?php
require '../php/Tools/Bootstrap.php';
if (!$auth->getUserDataBackOffice()) {
    $auth->redirectToLoginOnLoad(true, true);
}

use Classes\Size;
use Classes\Amneties;
use Classes\Perimeter;
use Classes\Activities;
use Classes\Logement;
use Classes\State;

$Logement = new Logement();
$userData = $auth->getUserDataBackOffice();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET["id"])) {

    $logementInfos = $Logement->getFullInfosDetailLogementBO($_GET["id"]);
}

$enums = $Logement->getCreateLogement();



require('../php/Composants/headerBO.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <script>
        var placeid = "<?= $logementInfos["place_id"] ?>";
    </script>
    <?php
    require('../php/Composants/head.php');
    ?>
    <title>ALHaIZ Breizh</title>
    <link rel="stylesheet" href="../ressources/css/create-logement.css">
    <link rel="stylesheet" href="../ressources/css/read-logement.css">
    <link rel="stylesheet" href="../ressources/css/styles.css">
    <!-- css commun a retirer -->
    <script src="./ressources/js/header.js"></script>
    <link rel="stylesheet" href="/ressources/css/styles.css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/smoothness/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
</head>

<body style="display: flex; flex-direction: column; width: 100%; height: 100%">
    <?php
    require('../php/Composants/loader.php');
    include('../php/Composants/toast.php');
    ?>
    <main style="height: 100%; width: auto; margin-left:60px">

        <div class="mainContainer">
            <h1>Détail du logement</h1>
            <form action="./create-logement.php" method="POST" enctype="multipart/form-data">
                <div class="part-form MainInfo">
                    <div class="div_titre_boutons">
                        <h2>Informations principales</h2>
                        <div>
                            <?php if (State::fromCaseName($logementInfos["etat"])->name === "ONLINE") {
                            ?>
                                <a class="bouton" id="<?= State::fromCaseName($logementInfos["etat"])->name ?>" onclick="changeState(event, '<?= $logementInfos['uuid'] ?>')">En ligne</a>
                            <?php } else {
                            ?>
                                <a class="bouton" id="<?= State::fromCaseName($logementInfos["etat"])->name ?>" onclick="changeState(event, '<?= $logementInfos['uuid'] ?>')">Hors ligne</a>

                            <?php
                            } ?>

                            <a class="bouton" id="btnPrevisualiser" href="/update-logement.php?id=<?= $infosLogement["uuid"] ?>">Modifier</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="titre">Titre de l'annonce</label>
                        <input type="text" class="form-control" id="titre" name="titre" placeholder="Ex : Petit chalêt à Brest" disabled value="<?= $logementInfos["title"] ?>">
                    </div>
                    <div class="form-group group-pading-pc">

                        <label for="accroche">Accroche de l'annonce</label>
                        <input type="text" class="form-control" id="accroche" name="accroche" placeholder="Accroche de l'annonce" disabled value="<?= $logementInfos["introduction"] ?>">
                    </div>
                    <div class="photo-description">
                        <div class="form-group">
                            <p id="photoP">Photo</p>
                            <div class="input-file-container">
                                <input class="input-file" id="my-file" type="file" accept=".png, .jpg">
                                <label tabindex="0" for="my-file" class="input-file-trigger" id="previewImageContainer" style="background-image: url(<?= $logementInfos["photo"] ?>);">

                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Décrire votre annonce</label>
                            <textarea class="form-control" id="description" name="description" placeholder="Description de l'annonce" disabled><?= $logementInfos["description"] ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="part-form">

                    <h2>Logement</h2>
                    <div class="adresseType">
                        <div class="form-group">
                            <label for="adresse">Adresse</label>

                            <div id="map" style="display:none;"></div>
                            <input type="text" class="form-control" id="adresse" name="adresse" placeholder="Ex : 8 rue de Bretagne, 22300 Lannion" disabled>

                            <input type="hidden" id="street_number" name="street_number">
                            <input type="hidden" id="department" name="department">
                            <input type="hidden" id="region" name="region">
                            <input type="hidden" id="zipcode" name="zipcode">
                            <input type="hidden" id="city" name="city">
                            <input type="hidden" id="street_name" name="street_name">
                            <input type="hidden" id="latitude" name="latitude">
                            <input type="hidden" id="longitude" name="longitude">
                            <input type="hidden" id="place_id" name="place_id">
                        </div>

                        <div class="type_price_capacity">
                            <div class="form-group">
                                <label for="type">Type de logement</label>
                                <select class="form-control" id="typeLogement" name="typeLogement" disabled>
                                    <option value=<?= $logementInfos["housing_type"]->name ?>>
                                        <?= $logementInfos["housing_type"]->value ?>
                                    </option>
                                </select>
                            </div>
                            <div class="form-group" id="pricediv">
                                <label for="price">Prix par nuit</label>
                                <div>
                                    <input type="text" class="form-control inputNumber" id="price" name="price" placeholder="Ex : 100" inputmode="numeric" step="1" disabled value="<?= $logementInfos["price"] ?>">
                                    <p>€</p>
                                </div>
                            </div>
                            <div class="form-group" id="capacity_div">
                                <label for="capacity">Capacité maximum</label>
                                <input type="text" class="form-control inputNumber" id="capacity" name="capacity" placeholder="Ex : 7" inputmode="numeric" step="1" disabled value="<?= $logementInfos["capacity"] ?>">
                            </div>
                        </div>
                    </div>
                    <div class="CBGS">

                        <div class="form-group checkboxGroup CBG">
                            <label for="amenagement">Aménagement</label>
                            <div>

                                <?php
                                foreach ($logementInfos["amenities"] as $amenities) {
                                ?>
                                    <div>
                                        <input class="CBAmenagement" type="checkbox" name="<?= Amneties::fromCaseName($amenities["amenities"])->name ?>" id=<?= Amneties::fromCaseName($amenities["amenities"])->name ?> value=<?= Amneties::fromCaseName($amenities["amenities"])->name ?>>
                                        <label for=<?= Amneties::fromCaseName($amenities["amenities"])->name ?>><?= Amneties::fromCaseName($amenities["amenities"])->value ?></label>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="hr_div">

                            <hr />
                        </div>
                        <div class="form-group checkboxGroup2 CBG">
                            <label for="activities">Activitées</label>
                            <div>
                                <?php
                                foreach ($logementInfos["activities"] as $activity) {

                                ?><div>
                                        <div>
                                            <input class="CBActivite" type="checkbox" name="<?= Activities::fromCaseName($activity["activity"])->name ?>" id=<?= Activities::fromCaseName($activity["activity"])->name ?> value=<?= Activities::fromCaseName($activity["activity"])->name ?>>
                                            <label for=<?= Activities::fromCaseName($activity["activity"])->name ?>><?= Activities::fromCaseName($activity["activity"])->value ?></label>
                                        </div>
                                        <select name="perimeter<?= Activities::fromCaseName($activity["activity"])->name ?>" class="perimeterActivite" id="perimeter<?= Activities::fromCaseName($activity["activity"])->name ?>" disabled>
                                            <option value=<?= Perimeter::fromCaseName($activity["perimeter"])->name ?> selected>
                                                <?= Perimeter::fromCaseName($activity["perimeter"])->value ?>
                                            </option>
                                        </select>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="part-form">

                    <h2>Composition</h2>
                    <div id="compositionElem">

                        <div id="nbpiece_surface">
                            <div class="form-group" id="nbpiece_div">
                                <label for="nbpiece">Nombre de pièce</label>
                                <select name="nbpiece" id="nbpiece" disabled>
                                    <option value=<?= Size::fromCaseName($logementInfos["housing_size"])->name ?>>
                                        <?= Size::fromCaseName($logementInfos["housing_size"])->value ?>
                                    </option>
                                </select>
                            </div>
                            <div class="form-group" id="surface_div">
                                <label for="surface">Surface du logement</label>
                                <div>
                                    <input type="text" class="form-control inputNumber" id="surface" name="surface" placeholder="Ex : 100" inputmode="numeric" step="1" disabled value="<?= $logementInfos["surface"] ?>">
                                    <p>m²</p>
                                </div>
                            </div>
                        </div>
                        <div id="nombres">
                            <div class="form-group" id="nbchambres_div">
                                <label for="nbchambres">Nombre de chambres</label>
                                <input type="text" class="form-control inputNumber" id="nbchambres" name="nbchambres" placeholder="Ex : 4" inputmode="numeric" step="1" disabled value="<?= $logementInfos["bedroom_number"] ?>">
                            </div>
                            <div class="form-group" id="surface_div">
                                <label for="nbLitsSimples">Nombre de lits simples</label>
                                <input type="text" class="form-control inputNumber" id="nbLitsSimples" name="nbLitsSimples" placeholder="Ex : 3" inputmode="numeric" step="1" disabled value="<?= $logementInfos["single_bed_number"] ?>">
                            </div>
                            <div class="form-group" id="surface_div">
                                <label for="nbLitsDoubles">Nombre de lits doubles</label>
                                <input type="text" class="form-control inputNumber" id="nbLitsDoubles" name="nbLitsDoubles" placeholder="Ex : 2" inputmode="numeric" step="1" disabled value="<?= $logementInfos["double_bed_number"] ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="part-form">

                    <h2>Organisation</h2>
                    <div id="delais">
                        <div class="form-group" id="nbJoursDelai_div">
                            <label for="nbJoursDelai">Délai minimum pour la prise de réservation</label>
                            <div>
                                <input type="text" class="form-control inputNumber" id="nbJoursDelai" name="nbJoursDelai" placeholder="Ex : 10" inputmode="numeric" step="1" disabled value="<?= $logementInfos["minimal_location_duration"] ?>">
                                <p>j</p>

                            </div>
                        </div>
                        <div class="form-group" id="nbNuitsMini_div">
                            <label for="nbNuitsMini">Nombre de nuitées minimales reservables</label>
                            <div>
                                <input type="number" class="form-control inputNumber" id="nbNuitsMini" name="nbNuitsMini" placeholder="Ex : 5" inputmode="numeric" step="1" disabled value="<?= $logementInfos["minimal_delay"] ?>">
                                <p>nuits</p>
                            </div>
                        </div>
                    </div>
                    <div id="heures">
                        <div class="form-group" id="heureArrivee_div">
                            <label for="heureArrivee">Heure d'arrivée minimale</label>
                            <input type="time" class="form-control" id="heureArrivee" name="heureArrivee" disabled value="<?= $logementInfos["heureArrivee"] ?>">
                        </div>
                        <div class="form-group" id="heureDepart_div">
                            <label for="heureDepart">Heure de départ maximale</label>
                            <input type="time" class="form-control" id="heureDepart" name="heureDepart" disabled value="<?= $logementInfos["heureDepart"] ?>">
                        </div>
                    </div>
                </div>



            </form>
        </div>
    </main>



    <?php
    $currentPageFooter = CurrentPage::BACKOFFICE;
    require('../php/Composants/footer.php');
    ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD07d-6xdhyP-kgE8hhTz4cYpzYIb4UNjg&libraries=places&callback=initMap" async defer></script>
    <script src="../ressources/js/detail-logement.js"></script>
</body>

</html>