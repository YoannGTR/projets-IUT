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
    SELECT logement.uuid,
       logement.street_number,
       logement.street_name, 
	   logement.city,
       logement.department,
       logement.title,
       logement.capacity,
       logement.state,
       photo_logement.url as photo_url
    FROM logement
    LEFT JOIN
        photo_logement ON logement.uuid = photo_logement.logement_uuid
	WHERE logement.proprietaire_uuid = :uuid
";
$reservationsParams = [
    ':uuid' => $connectedUserUUID
];

require('../php/Composants/headerBO.php');

$listeReservation = $db->executeQuery($reservationsQuery, $reservationsParams);

// Group reservations by reservation_uuid and include photos
$logement = [];
foreach ($listeReservation as $row) {
    $logement_uuid = $row['uuid'];
    if (!isset($logement[$logement_uuid])) {
        $logement[$logement_uuid] = $row;
        $logement[$logement_uuid]['photos'] = [];
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
    <link rel="stylesheet" href="/ressources/css/consulter-logements.css" />
</head>
<body style="display: flex; flex-direction: column; width: 100%; height: 100%">
<?php
require('../php/Composants/loader.php');
require('../php/Composants/notch.php');
include('../php/Composants/toast.php');
?>
<main class="main-page" style="height: 100%; width: auto; margin-left:60px">
    <div class="reservations-title">
        <h1>Mes Logements</h1>
        <button onclick="location.href='./create-logement.php'">Créer un logement</button>
    </div>
    <div class="tableau-reservations">
        <div class="contenu-tableau">
            <p class="tableau-vide-actuel">Vous n'avez aucun logement enregistré.</p>
            <?php
                    foreach ($logement as $logements): 
?>                  <a href="./detail-mon-logement.php?id=<?php echo htmlentities($logements['uuid']); ?>" id="rcard-lien">
                        <div class="rcard" data-start-date="<?php echo htmlentities($reservation['start_date']); ?>" data-end-date="<?php echo htmlentities($reservation['end_date']); ?>">
                            
                            <div class="rcard-image">
                                <?php 
                                if(empty($logements['photo_url'])){
                                    $url_image = "https://www.eclosio.ong/wp-content/uploads/2018/08/default.png";
                                }else{
                                    $url_image = $logements['photo_url'];
                                }
                                ?>
                                <img src="<?php echo htmlentities($url_image)?>" alt="image de la réservation">
                            </div>
                            <div class="rcard-corps">
                                <div class="rcard-text">
                                    <div class="rcard-titre">
                                        <h3><?php echo htmlspecialchars($logements['title']); ?></h3>
                                        <div class="rcard-adresse">
                                            <p><?php echo htmlspecialchars($logements['street_number']) ; ?></p>
                                            <p><?php echo htmlspecialchars($logements['street_name']) ; ?></p>
                                            <p><?php echo htmlspecialchars($logements['city']) ; ?>,</p>
                                            <p><?php echo htmlspecialchars($logements['department']) ; ?></p>
                                        </div>
                                    </div>
                                    <div class="rcard-state">    
                                            <p id="state"><?php echo htmlentities($logements['state']); ?></p>
                                        </div>
                                </div>
                                <div class="rcard-max">
                                    <div class="rcard-voyageurs">
                                        <p><?php echo htmlentities($logements['capacity']); ?></p>
                                        <img src="ressources/assets/travellers-icon-max.svg" alt="icone nombre de voyageurs">
                                    </div>
                                </div>
                            </div>
                        </div>
                        </a>
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
    let filteredCards = reservationCards.slice();
    let isDescending = false;
    let urlImageTri = true;
    const boutonPrecedant = document.querySelector('.bouton-precedant button');
    const boutonSuivant = document.querySelector('.bouton-suivant button');
    const nbPage = document.querySelector('.nb-page');
    const bouton_tri = document.getElementById('bouton-tri');
    const totalPages = Math.ceil(filteredCards.length / cardsPerPage);

    reservationCards.forEach((card) => {
        const stateElement = card.querySelector('#state');
        if (stateElement.textContent == "ONLINE") {
            stateElement.textContent = "En ligne";    
            stateElement.style.color = ""; // Réinitialiser la couleur
        } else {
            stateElement.textContent = "Hors ligne";
            stateElement.style.color = "red";
        }
    });

    function updatePagination() {
        nbPage.textContent = `Page ${currentPage}/${totalPages}`;
        boutonPrecedant.style.display = currentPage === 1 ? "none" : "block";
        boutonSuivant.style.display = (currentPage === totalPages || totalPages === 0) ? "none" : "block";
    }

    function updateEmptyTableMessage() {
        const tableau = document.querySelector('.tableau-vide-actuel');
        tableau.style.display = filteredCards.length === 0 ? 'block' : 'none';
        nbPage.style.display = filteredCards.length === 0 ? 'none' : 'flex';
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

    function sortReservations() {
        filteredCards.sort((a, b) => {
            const dateA = new Date(a.getAttribute('data-start-date')).getTime();
            const dateB = new Date(b.getAttribute('data-start-date')).getTime();
            if (isDescending) {
                return dateB - dateA; // Ordre décroissant
            } else {
                return dateA - dateB; // Ordre croissant
            }
        });

        // Mettre à jour le DOM avec les cartes triées
        const parentElement = document.querySelector('.contenu-tableau');
        filteredCards.forEach(card => parentElement.appendChild(card));
    }

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

    showPage(currentPage);
});



</script>



</body>
</html>
