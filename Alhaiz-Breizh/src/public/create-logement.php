<?php
require '../php/Tools/Bootstrap.php';
if (!$auth->getUserDataBackOffice()) {
    $auth->redirectToLoginOnLoad(true, true);
}

use Classes\Logement;
use Classes\State;

$Logement = new Logement();
$userData = $auth->getUserDataBackOffice();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["titre"])) {
    
    if($_POST["publication"] == "previsualiser"){
        $_POST["pubHorsLigne"] = State::OFFLINE->name;
        $uuid = $Logement->createLogement($_POST, $userData);
        if ($uuid) {
            header('Location: /logement.php?id='.$uuid);
            exit();
        }
    }
    else if($_POST["publication"] == "publier"){
        $_POST["pubHorsLigne"] = null;
        $uuid = $Logement->createLogement($_POST, $userData);
        if ($uuid) {
            header('Location: /consulter-logements.php');
            exit();
        }
    }
}

$enums = $Logement->getCreateLogement();

require('../php/Composants/headerBO.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    require('../php/Composants/head.php');
    ?>
    <title>ALHaIZ Breizh</title>
    <link rel="stylesheet" href="../ressources/css/create-logement.css">
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
            <h1>Créer un logement</h1>
            <form action="./create-logement.php" method="POST" enctype="multipart/form-data">
                <div class="part-form MainInfo">

                    <h2>Informations principales</h2>
                    <div class="form-group">
                        <label for="titre">Titre de l'annonce</label>
                        <input type="text" class="form-control" id="titre" name="titre" placeholder="Ex : Petit chalêt à Brest" required>
                    </div>
                    <div class="form-group group-pading-pc">

                        <label for="accroche">Accroche de l'annonce</label>
                        <input type="text" class="form-control" id="accroche" name="accroche" placeholder="Accroche de l'annonce" required>
                    </div>
                    <div class="photo-description">
                        <div class="form-group">
                            <p id="photoP">Photo</p>
                            <div class="input-file-container">
                                <input class="input-file" id="my-file" type="file" accept=".png, .jpg">
                                <label tabindex="0" for="my-file" class="input-file-trigger" id="previewImageContainer">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" id="addPhoto">
                                        <path d="M144 480C64.5 480 0 415.5 0 336c0-62.8 40.2-116.2 96.2-135.9c-.1-2.7-.2-5.4-.2-8.1c0-88.4 71.6-160 160-160c59.3 0 111 32.2 138.7 80.2C409.9 102 428.3 96 448 96c53 0 96 43 96 96c0 12.2-2.3 23.8-6.4 34.6C596 238.4 640 290.1 640 352c0 70.7-57.3 128-128 128H144zm79-217c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l39-39V392c0 13.3 10.7 24 24 24s24-10.7 24-24V257.9l39 39c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-80-80c-9.4-9.4-24.6-9.4-33.9 0l-80 80z" />
                                    </svg>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Décrire votre annonce</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Description de l'annonce" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="part-form">

                    <h2>Logement</h2>
                    <div class="adresseType">
                        <div class="form-group">
                            <label for="adresse">Adresse</label>
                            <input type="text" class="form-control" id="adresse" name="adresse" placeholder="Ex : 8 rue de Bretagne, 22300 Lannion" required>

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
                                <select class="form-control" id="typeLogement" name="typeLogement" required>
                                    <option value="Default" selected disabled>Choisissez un type</option>
                                    <?php
                                    foreach ($enums["types"] as $type) {
                                    ?><option value=<?= $type->name ?>>
                                            <?= $type->toString() ?>
                                        </option><?php
                                                }
                                                    ?>
                                </select>
                            </div>
                            <div class="form-group" id="pricediv">
                                <label for="price">Prix par nuit</label>
                                <div>
                                    <input type="text" class="form-control inputNumber" id="price" name="price" placeholder="Ex : 100" inputmode="numeric" step="1" required>
                                    <p>€</p>
                                </div>
                            </div>
                            <div class="form-group" id="capacity_div">
                                <label for="capacity">Capacité maximum</label>
                                <input type="text" class="form-control inputNumber" id="capacity" name="capacity" placeholder="Ex : 7" inputmode="numeric" step="1" required>
                            </div>
                        </div>
                    </div>
                    <div class="CBGS">

                        <div class="form-group checkboxGroup CBG">
                            <label for="amenagement">Aménagement</label>
                            <div>
                                <?php
                                foreach ($enums["amenities"] as $amenities) {
                                ?>
                                    <div>
                                        <input class="CBAmenagement" type="checkbox" name="<?=$amenities->name?>" id=<?= $amenities->name ?> value=<?= $amenities->name ?>>
                                        <label for=<?= $amenities->name ?>><?= $amenities->toString() ?></label>
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
                                foreach ($enums["activities"] as $activity) {
                                ?><div>
                                        <div>
                                            <input class="CBActivite" type="checkbox" name="<?=$activity->name?>" id=<?= $activity->name ?> value=<?= $activity->name ?>>
                                            <label for=<?= $activity->name ?>><?= $activity->toString() ?></label>
                                        </div>
                                        <select name="perimeter<?=$activity->name?>" class="perimeterActivite" id="perimeter<?=$activity->name?>">
                                            <option value="Default" selected disabled>Choisissez un périmètre</option>
                                            <?php
                                            foreach ($enums["perimeters"] as $perimeter) {
                                            ?><option value=<?= $perimeter->name ?>>
                                                    <?= $perimeter->toString() ?>
                                                </option><?php
                                                        }
                                                            ?>
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
                                <select name="nbpiece" id="nbpiece" required>
                                    <option value="Default" selected disabled >Choisissez un type de logement</option>
                                    <?php
                                    foreach ($enums["sizes"] as $size) {
                                    ?><option value=<?= $size->name ?>>
                                            <?= $size->toString() ?>
                                        </option><?php
                                                }
                                                    ?>
                                </select>
                            </div>
                            <div class="form-group" id="surface_div">
                                <label for="surface">Surface du logement</label>
                                <div>
                                    <input type="text" class="form-control inputNumber" id="surface" name="surface" placeholder="Ex : 100" inputmode="numeric" step="1" required>
                                    <p>m²</p>
                                </div>
                            </div>
                        </div>
                        <div id="nombres">
                            <div class="form-group" id="nbchambres_div">
                                <label for="nbchambres">Nombre de chambres</label>
                                <input type="text" class="form-control inputNumber" id="nbchambres" name="nbchambres" placeholder="Ex : 4" inputmode="numeric" step="1" required>
                            </div>
                            <div class="form-group" id="surface_div">
                                <label for="nbLitsSimples">Nombre de lits simples</label>
                                <input type="text" class="form-control inputNumber" id="nbLitsSimples" name="nbLitsSimples" placeholder="Ex : 3" inputmode="numeric" step="1" required>
                            </div>
                            <div class="form-group" id="surface_div">
                                <label for="nbLitsDoubles">Nombre de lits doubles</label>
                                <input type="text" class="form-control inputNumber" id="nbLitsDoubles" name="nbLitsDoubles" placeholder="Ex : 2" inputmode="numeric" step="1" required>
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
                                <input type="text" class="form-control inputNumber" id="nbJoursDelai" name="nbJoursDelai" placeholder="Ex : 10" inputmode="numeric" step="1" required>
                                <p>j</p>

                            </div>
                        </div>
                        <div class="form-group" id="nbNuitsMini_div">
                            <label for="nbNuitsMini">Nombre de nuitées minimales reservables</label>
                            <div>
                                <input type="number" class="form-control inputNumber" id="nbNuitsMini" name="nbNuitsMini" placeholder="Ex : 5" inputmode="numeric" step="1" required>
                                <p>nuits</p>
                            </div>
                        </div>
                    </div>
                    <div id="heures">
                        <div class="form-group" id="heureArrivee_div">
                            <label for="heureArrivee">Heure d'arrivée minimale</label>
                            <input type="time" class="form-control" id="heureArrivee" name="heureArrivee" required>
                        </div>
                        <div class="form-group" id="heureDepart_div">
                            <label for="heureDepart">Heure de départ maximale</label>
                            <input type="time" class="form-control" id="heureDepart" name="heureDepart" required>
                        </div>
                    </div>
                </div>
                <div class="hors-ligne">
                    <label for="pubHorsLigne">Publier Hors Ligne : </label>
                    <input type="checkbox" class="form-control CBHL" id="pubHorsLigne" name="pubHorsLigne" value="<?= State::OFFLINE->name ?>">
                </div>
                <div class="boutons">
                    <input type="hidden" name="publication" id="publication">
                    <a class="bouton" id="btnAnnuler" href="/consulter-reservations.php">Annuler</a>
                    <button type="submit" class="bouton" id="btnPrevisualiser" onclick="submitForm(event)">Prévisualiser</button>
                    <button type="submit" class="bouton" id="btnPublier" onclick="submitForm(event)">Publier</button>
                </div>


            </form>
        </div>
    </main>

    <?php
    $currentPageFooter = CurrentPage::BACKOFFICE;
    require('../php/Composants/footer.php');
    ?>
    <script>
        function submitForm(event) {
            var button = event.target;
            var publicationInput = document.getElementById('publication');
            var pubHorsLigneInput = document.getElementById('pubHorsLigne');

            if (button.id === 'btnPrevisualiser') {
                publicationInput.value = 'previsualiser';
                pubHorsLigneInput.checked = true;
            } else if (button.id === 'btnPublier') {
                publicationInput.value = 'publier';
                pubHorsLigneInput.checked = false;
            }
        }
    </script>
    <script src="../ressources/js/create-logement.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD07d-6xdhyP-kgE8hhTz4cYpzYIb4UNjg&libraries=places&callback=initAutocomplete" async defer></script>
</body>

</html>
