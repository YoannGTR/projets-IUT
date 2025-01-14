<?php

require '../php/Tools/Bootstrap.php';

use Classes\Logement;
use Classes\Recherche;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require ('../php/Composants/head.php');
    ?>
    <title>ALHaIZ Breizh</title>
    <link rel="stylesheet" href="/ressources/css/recherche.css">
</head>

<body>
    <?php
    $recherche = new Recherche();
    $logement = new Logement();
    $headerRedirectTo = '/';
    $headerTitle = 'Filtre';
    $currentPageHeader = CurrentPage::RESERVATIONS;
    require ('../php/Composants/header.php');
    require ('../php/Composants/loader.php');
    require ('../php/Composants/notch.php');
    include ('../php/Composants/toast.php');
    ?>
    <main>
        <div class="container">
            <div class="container-filtre" id="container-filtre">
                <div class="first-ligne">
                    <h2 class="filtre">Filtres</h2>
                    <img class="down-mobile" src="ressources/assets/down-arrow-svgrepo-com.svg">
                </div>
                <div class="container-prix">
                    <div class="ligne">
                        <h5>Prix par nuit</h5><img class="down-desktop"
                            src="ressources/assets/down-arrow-svgrepo-com.svg">
                    </div>
                    <div class="input-prix">
                        <div class="colonne">
                            <label for="min-price">Prix minimum :</label><input type="number" id="min-price"
                                oninput=updateInput(this) class="price" name="min-price" step="1" placeholder="0"
                                min="0">
                        </div>
                        <div class="colonne">
                            <label for="max-price">Prix maximum :</label><input type="number" id="max-price"
                                oninput=updateInput(this) class="price" name="max-price" step="1" placeholder="100"
                                min="0">
                        </div>
                    </div>
                </div>
                <div class="container-dates">
                    <div class="ligne">
                        <h5>Dates</h5><img class="down-desktop" src="ressources/assets/down-arrow-svgrepo-com.svg">
                    </div>
                    <div class="container-underfiltre">
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
                                <!-- Table body for displaying the calendar -->
                                <tbody id="calendar-body">

                                </tbody>
                            </table>
                            <div class="footer-container-calendar">
                                <label for="month">Aller à : </label>
                                <!-- Dropdowns to select a specific month and year -->
                                <select id="month" onchange="jump()">
                                </select>
                                <!-- Dropdown to select a specific year -->
                                <select id="year" onchange="jump()"></select>
                            </div>
                        </div>
                    </div>
                    <p id="CalendarVide">
                    </p>

                    <form action="" method="POST" onsubmit="return verif()">
                        <input type="hidden" id="formLogement" name="logement_uuid" class="formInput" value="">
                        <input type="hidden" id="formQuantity" name="nombre_voyageurs" class="formInput" value="">
                        <input type="hidden" id="formDateDeb" name="date_arrivee" class="formInput" value="">
                        <input type="hidden" id="formDateFin" name="date_depart" class="formInput" value="">
                    </form>
                </div>
                <div class="container-voyageurs">
                    <div class="ligne">
                        <h5>Voyageurs</h5><img class="down-desktop" src="ressources/assets/down-arrow-svgrepo-com.svg">
                    </div>
                    <div class="container-underfiltre">
                        <div id="minus">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="#f57393" id="minusSvg">
                                <path
                                    d="M432 256c0 17.7-14.3 32-32 32L48 288c-17.7 0-32-14.3-32-32s14.3-32 32-32l352 0c17.7 0 32 14.3 32 32z" />
                            </svg>
                        </div>
                        <input type="text" id="quantity" inputmode="numeric" step="1" value="0" />
                        <div id="plus">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="#fff" id="plusSvg">
                                <path
                                    d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="container-commune">
                    <div class="ligne">
                        <h5>Commune</h5><img class="down-desktop" src="ressources/assets/down-arrow-svgrepo-com.svg">
                    </div>
                    <div class="container-underfiltre">
                        <input id="city-select" type="text" placeholder="Saisir une ville">
                    </div>
                </div>
                <div class="container-departement">
                    <div class="ligne">
                        <h5>Département</h5><img class="down-desktop"
                            src="ressources/assets/down-arrow-svgrepo-com.svg">
                    </div>
                    <div class="container-underfiltre">
                        <select name="select-departement" class="select-departement">
                            <option value="">Choisissez un département</option>
                            <option value="Finistère">Finistère</option>
                            <option value="Côtes-d'Armor">Côtes-d'Armor</option>
                            <option value="Ille-et-Vilaine">Ille-et-Vilaine</option>
                            <option value="Morbihan">Morbihan</option>
                        </select>
                    </div>

                </div>
                <button class="close-filter" id="close-filter">Fermer les filtres</button>
            </div>
            <div class="container-card">
                <div class="ligne" id="space">
                    <h2>Résultats</h2>
                    <select class="select-filtre" id="filtre">
                        <option value="">Aucun filtre</option>
                        <option value="prix-asc">Prix ASC <img src='ressources/assets/sort-up-solid.svg' class="filtre">
                        </option>
                        <option value="prix-desc">Prix DESC <img src='ressources/assets/sort-down-solid.svg'
                                class="filtre"></option>
                        <option value="nom-asc">Nom ASC <img src='ressources/assets/sort-up-solid.svg' class="filtre">
                        </option>
                        <option value="nom-desc">Nom DESC <img src='ressources/assets/sort-down-solid.svg'
                                class="filtre"></option>
                        <option value="voy-asc">Voyageurs ASC <img src='ressources/assets/sort-up-solid.svg'
                                class="filtre"></option>
                        <option value="voy-desc">Voyageurs DESC <img src='ressources/assets/sort-down-so    lid.svg'
                                class="filtre"></option>

                    </select>
                </div>
                <div class="all-card" id="all-card">

                </div>
            </div>
    </main>
    <script> const logement = <?php echo $recherche->get_json(); ?> </script>
    <script> const date = <?php echo $recherche->get_date(); ?></script>
    <script src="/ressources/js/main.js"></script>
    <script src="./ressources/js/calendar.js"></script>
    <script src="./ressources/js/recherche.js"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD07d-6xdhyP-kgE8hhTz4cYpzYIb4UNjg&libraries=places&callback=initAutocomplete"
        async defer></script>

</body>

</html>