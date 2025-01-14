<?php 
require '../php/Tools/Bootstrap.php';

if(!$auth->getUserDataBackOffice()) {
    $auth->redirectToLoginOnLoad(true, true);
}

$data = $auth->getUserDataBackOffice();

$connectedUserUUID = $data['uuid'];

use Classes\Database;

$db = Database::getInstance();

$reservationsQuery = "
    SELECT 
        reservation.uuid AS reservation_uuid,
        reservation.created_at AS reservation_created_at,
        reservation.updated_at AS reservation_updated_at,
        logement.uuid AS logement_uuid,
        logement.street_number,
        logement.street_name,
        logement.city,
        logement.department,
        logement.title,
        logement.price_ttc,
        devis.start_date,
        devis.end_date,
        devis.nb_people,
        photo_logement.url AS photo_url
    FROM 
        reservation
    JOIN 
        logement ON reservation.logement_uuid = logement.uuid
    JOIN
        devis ON reservation.devis_uuid = devis.uuid
    LEFT JOIN
        photo_logement ON logement.uuid = photo_logement.logement_uuid
    WHERE 
        logement.proprietaire_uuid = :uuid
    ORDER BY
    devis.start_date ASC, reservation.created_at DESC
";
$reservationsParams = [
    ':uuid' => $connectedUserUUID
];

require('../php/Composants/headerBO.php');

$listeReservation = $db->executeQuery($reservationsQuery, $reservationsParams);

// Group reservations by reservation_uuid and include photos
$reservations = [];
foreach ($listeReservation as $row) {
    $reservation_uuid = $row['reservation_uuid'];
    if (!isset($reservations[$reservation_uuid])) {
        $reservations[$reservation_uuid] = $row;
        $reservations[$reservation_uuid]['photos'] = [];
    }
}

function calculateNights($date_debut, $date_fin) {
                                            
    // S'assurer que les heures sont minuit pour ne compter que les jours complets
    $date_debut->setTime(0, 0, 0);
    $date_fin->setTime(0, 0, 0);

    // Calculer la différence entre les dates
    $interval = $date_debut->diff($date_fin);

    // Retourner le nombre de jours de l'intervalle
    return $interval->days;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        require('../php/Composants/head.php');
    ?>
    <title>ALHaIZ Breizh</title>
    <script src="./ressources/js/header.js"></script>
    <link rel="stylesheet" href="/ressources/css/styles.css" />
    <link rel="stylesheet" href="/ressources/css/consulter-reservations.css" />
</head>
<body style="display: flex; flex-direction: column; width: 100%; height: 100%">
<?php
require('../php/Composants/loader.php');
require('../php/Composants/notch.php');
include('../php/Composants/toast.php');
?>
<main class="main-page" style="height: 100%; width: auto; margin-left:60px">
    <div class="reservations-title">
        <h1>Mes réservations</h1>
    </div>
    <div class="onglets">
        <button id="cours">En cours</button>
        <button id="venir">À venir</button>
        <button id="termine">Terminée</button>
    </div>
    <div class="tableau-reservations">
        <div class="entete-tableau">
            <button class="tri">
                <span id="tri">Tri par date DESC</span>
                <img src="/ressources/assets/sort-up-solid.svg" alt="Boutton icon tri" id="bouton-tri">
            </button>
        </div>
        <div class="contenu-tableau">
            <p class="tableau-vide-terminée">Vous n'avez aucune réservation terminée.</p>
            <p class="tableau-vide-en-cours">Vous n'avez aucune réservation en cours.</p>
            <p class="tableau-vide-à-venir">Vous n'avez aucune réservation à venir.</p>
            <?php
                    foreach ($reservations as $reservation): 
?> 
                        <div class="rcard" data-start-date="<?php echo htmlentities($reservation['start_date']); ?>" data-end-date="<?php echo htmlentities($reservation['end_date']); ?>">
                        <a href="./BO-detail-reservation.php?id=<?php echo htmlentities($reservation['reservation_uuid']); ?>"class="rcard-lien">
                            <div class="rcard-image">
                                <?php 
                                if(empty($reservation['photo_url'])){
                                    $url_image = "https://www.eclosio.ong/wp-content/uploads/2018/08/default.png";
                                }else{
                                    $url_image = $reservation['photo_url'];
                                }
                                ?>
                                <img src="<?php echo htmlentities($url_image)?>" alt="image de la réservation">
                            </div>
                            <div class="rcard-corps">
                                <div class="rcard-text">
                                    <div class="rcard-titre">
                                        <h3><?php echo htmlspecialchars($reservation['title']); ?></h3>
                                        <p><?php echo htmlspecialchars($reservation['city']); ?></p>
                                    </div>
                                    <div class="rcard-bas">
                                        <div class="rcard-descr">
                                            <?php 
                                            // Créer un objet DateTime à partir de la chaîne de date
                                            $date_debut = new DateTime($reservation['start_date']);
                                            $date_fin = new DateTime($reservation['end_date']);
                                            // Formater la date selon le format souhaité
                                            $formattedDate = $date_debut->format('j F Y H\hi');
                                            $formattedDate2 = $date_fin->format('j F Y H\hi');
                                            // Remplacer le nom du mois en anglais par le nom en français
                                            $formattedDate = str_replace(
                                                ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                                                ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'],
                                                $formattedDate
                                            );
                                            $formattedDate2 = str_replace(
                                                ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                                                ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'],
                                                $formattedDate2
                                            );
                                            $difference_en_jours = calculateNights($date_debut,$date_fin)?>
                                            <p><?php echo htmlentities($formattedDate); ?></p>
                                            <p>-</p>
                                            <p><?php echo htmlentities($formattedDate2); ?></p>
                                        </div>
                                        <div class="rcard-prix">
                                            <p><?php echo htmlentities($difference_en_jours); ?> nuit<?php if($difference_en_jours!=1){?>s<?php }    ?> ·
                                            <span><?php echo htmlentities($reservation['price_ttc']/100); ?></span>€</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="rcard-max">
                                    <div class="rcard-voyageurs">
                                        <p><?php echo htmlentities($reservation['nb_people']); ?></p>
                                        <img src="ressources/assets/travellers-icon-max.svg" alt="icone nombre de voyageurs">
                                    </div>
                                </div>
                            </div>
                        </a>
                        </div>
                    <?php endforeach; ?>
        </div>
    </div>
    <div class="bas-tableau">
        <div class="bouton-precedant">
            <button>Précédent</button>
        </div>
        <div class="nb-page">
            <p>Page 1/7</p>
        </div>
        <div class="bouton-suivant">
            <button>Suivant</button>
        </div>
    </div>
</main>
<?php
$currentPageFooter = CurrentPage::BACKOFFICE;
require('../php/Composants/footer.php');
?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const reservationCards = Array.from(document.querySelectorAll('.rcard'));
    const cardsPerPage = 5;
    let currentPage = 1;
    let filteredCards = [];
    let isDescending = false;
    let urlImageTri = true;
    const terminée = document.getElementById('termine');
    const encours = document.getElementById('cours');
    const àvenir = document.getElementById('venir');
    const boutonPrecedant = document.querySelector('.bouton-precedant button');
    const boutonSuivant = document.querySelector('.bouton-suivant button');
    const nbPage = document.querySelector('.nb-page');
    const triButton = document.querySelector('.tri');
    const today = new Date();
    const tableau_vide = document.getElementsByClassName('tableau-vide');
    const bouton_tri = document.getElementById('bouton-tri');
    const texte_tri = document.getElementById('tri');

    function updatePagination() {
        const totalPages = Math.ceil(filteredCards.length / cardsPerPage);
        nbPage.textContent = `Page ${currentPage}/${totalPages}`;
        boutonPrecedant.style.display = currentPage === 1 ? "none" : "block";
        boutonSuivant.style.display = (currentPage === totalPages || totalPages === 0) ? "none" : "block";
    }
    
    function updateEmptyTableMessage() {
        const tableauEnCours = document.querySelector('.tableau-vide-en-cours');
        const tableauTerminée = document.querySelector('.tableau-vide-terminée');
        const tableauAVenir = document.querySelector('.tableau-vide-à-venir');
        const nbPage = document.querySelector('.nb-page');

        // Récupérer l'onglet actif en fonction de sa classe active
        let ongletActif = '';
        if (terminée.classList.contains('active')) {
            ongletActif = 'terminée';
        } else if (encours.classList.contains('active')) {
            ongletActif = 'en cours';
        } else if (àvenir.classList.contains('active')) {
            ongletActif = 'à venir';
        }

        // Afficher ou masquer les messages en fonction de l'onglet actif
        switch (ongletActif) {
            case 'terminée':
                tableauTerminée.style.display = filteredCards.length === 0 ? 'block' : 'none';
                tableauEnCours.style.display = 'none';
                tableauAVenir.style.display = 'none';
                nbPage.style.display = filteredCards.length === 0 ? 'none' : 'flex';
                break;
            case 'en cours':
                tableauEnCours.style.display = filteredCards.length === 0 ? 'block' : 'none';
                tableauTerminée.style.display = 'none';
                tableauAVenir.style.display = 'none';
                nbPage.style.display = filteredCards.length === 0 ? 'none' : 'flex';
                break;
            case 'à venir':
                tableauAVenir.style.display = filteredCards.length === 0 ? 'block' : 'none';
                tableauEnCours.style.display = 'none';
                tableauTerminée.style.display = 'none';
                nbPage.style.display = filteredCards.length === 0 ? 'none' : 'flex';
                break;
            default:
                tableauEnCours.style.display = 'none';
                tableauTerminée.style.display = 'none';
                tableauAVenir.style.display = 'none';
                nbPage.style.display = 'none';
                break;
        }
    }

    function showPage(page) {
        reservationCards.forEach((card) => {
            card.style.display = "none";
        });
        filteredCards.slice((page - 1) * cardsPerPage, page * cardsPerPage).forEach((card) => {
            card.style.display = "flex";
        });
        updatePagination();
        updateEmptyTableMessage();
    }

    function filterEncours() {
        filteredCards = reservationCards.filter((card) => {
            const startDate = new Date(card.getAttribute('data-start-date'));
            const endDate = new Date(card.getAttribute('data-end-date'));
            return startDate <= today && endDate >= today;
        });
        showPage(1);
    }

    function filterTerminée() {
        filteredCards = reservationCards.filter((card) => {
            const endDate = new Date(card.getAttribute('data-end-date'));
            return endDate < today;
        });
        showPage(1);
    }

    function filterAvenir() {
        filteredCards = reservationCards.filter((card) => {
            const startDate = new Date(card.getAttribute('data-start-date'));
            return startDate > today;
        });
        showPage(1);
    }

    function clearActive() {
        terminée.classList.remove('active');
        encours.classList.remove('active');
        àvenir.classList.remove('active');
    }

    function updateFilteredCards() {
    if (terminée.classList.contains('active')) {
        filterTerminée();
    } else if (encours.classList.contains('active')) {
        filterEncours();
    } else if (àvenir.classList.contains('active')) {
        filterAvenir();
    }
    
}

function sortReservations() {
    reservationCards.sort((a, b) => {
        const dateA = new Date(a.getAttribute('data-start-date')).getTime();
        const dateB = new Date(b.getAttribute('data-start-date')).getTime();
        if (isDescending) {
            return dateB - dateA; // Ordre décroissant
        } else {
            return dateA - dateB; // Ordre croissant
        }
        showPage(currentPage);
    });

    // Mettre à jour le DOM avec les cartes triées
    const parentElement = document.querySelector('.contenu-tableau'); // Sélectionnez l'élément parent
    reservationCards.forEach(card => parentElement.appendChild(card)); // Ré-attacher les cartes triées

    updateFilteredCards(); // Mettre à jour les cartes filtrées après le tri
}



    terminée.addEventListener('click', function() {
        clearActive();
        terminée.classList.add('active');
        filterTerminée();
    });

    encours.addEventListener('click', function() {
        clearActive();
        encours.classList.add('active');
        filterEncours();
    });

    àvenir.addEventListener('click', function() {
        clearActive();
        àvenir.classList.add('active');
        filterAvenir();
    });

    boutonSuivant.addEventListener('click', function() {
        const totalPages = Math.ceil(filteredCards.length / cardsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            showPage(currentPage);
        }
    });

    boutonPrecedant.addEventListener('click', function() {
        if (currentPage > 1) {
            currentPage--;
            showPage(currentPage);
        }
    });

    triButton.addEventListener('click', function() {
        isDescending = !isDescending; // Inverser l'état du tri
        sortReservations();
        showPage(currentPage); // Afficher la première page après le tri
        urlImageTri = !urlImageTri;
        if (urlImageTri){
            bouton_tri.src="/ressources/assets/sort-down-solid.svg"
            texte_tri.textContent = "Tri par date DESC"
        }else{
            bouton_tri.src="/ressources/assets/sort-up-solid.svg"
            texte_tri.textContent = "Tri par date ASC"
        }
    });


    // Initialize default filter and pagination display
    clearActive();
    encours.classList.add('active');
    filterEncours();
});

</script>



</body>
</html>
