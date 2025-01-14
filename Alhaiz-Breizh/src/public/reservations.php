<?php
require '../php/Tools/Bootstrap.php';

if (!$auth->getUserData()) {
    $auth->redirectToLoginOnLoad();
}

$data = $auth->getUserData();

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
        logement.capacity,
        logement.title,
        devis.start_date,
        devis.end_date,
        photo_logement.url AS photo_url,
        photo_logement.order AS photo_order
    FROM 
        reservation
    JOIN 
        logement ON reservation.logement_uuid = logement.uuid
    JOIN
        devis ON reservation.devis_uuid = devis.uuid
    LEFT JOIN
        photo_logement ON logement.uuid = photo_logement.logement_uuid
    WHERE 
        reservation.client_uuid = :uuid
    ORDER BY
    devis.start_date ASC, reservation.created_at DESC
";
$reservationsParams = [
    ':uuid' => $connectedUserUUID
];

$listeReservation = $db->executeQuery($reservationsQuery, $reservationsParams);




// Group reservations by reservation_uuid and include photos
$reservations = [];
foreach ($listeReservation as $row) {
    $reservation_uuid = $row['reservation_uuid'];
    if (!isset($reservations[$reservation_uuid])) {
        $reservations[$reservation_uuid] = $row;
        $reservations[$reservation_uuid]['photos'] = [];
    }
    if ($row['photo_url']) {
        $reservations[$reservation_uuid]['photos'][] = $row['photo_url'];
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
    <link rel="stylesheet" href="/ressources/css/reservation.css" />
    <link rel="stylesheet" href="/ressources/css/styles.css" />
    
</head>

<body>
    <?php
    require ('../php/Composants/loader.php');
    require ('../php/Composants/notch.php');
    include('../php/Composants/toast.php');
    $headerTitle = 'Mes réservations';
$currentPageHeader = CurrentPage::RESERVATIONS;
$headerTitle = 'Mes Réservations';
require('../php/Composants/header.php');
    ?>
    <main>
        <div class="content-container">
            <div class="filtre-liste">
                <p>Filtre 1</p>
                <p>Filtre 2</p>
                <p>Filtre 3</p>
                <p>Filtre 4</p>
            </div>

            <div class="reservation-container">
                <div class="filtre-tri">
                    <h1>Vos Réservations</h1>
                    <button class="filtre-tri-right">
                        <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M21 6H19M21 12H16M21 18H16M7 20V13.5612C7 13.3532 7 13.2492 6.97958 13.1497C6.96147 13.0615 6.93151 12.9761 6.89052 12.8958C6.84431 12.8054 6.77934 12.7242 6.64939 12.5617L3.35061 8.43826C3.22066 8.27583 3.15569 8.19461 3.10948 8.10417C3.06849 8.02393 3.03853 7.93852 3.02042 7.85026C3 7.75078 3 7.64677 3 7.43875V5.6C3 5.03995 3 4.75992 3.10899 4.54601C3.20487 4.35785 3.35785 4.20487 3.54601 4.10899C3.75992 4 4.03995 4 4.6 4H13.4C13.9601 4 14.2401 4 14.454 4.10899C14.6422 4.20487 14.7951 4.35785 14.891 4.54601C15 4.75992 15 5.03995 15 5.6V7.43875C15 7.64677 15 7.75078 14.9796 7.85026C14.9615 7.93852 14.9315 8.02393 14.8905 8.10417C14.8443 8.19461 14.7793 8.27583 14.6494 8.43826L11.3506 12.5617C11.2207 12.7242 11.1557 12.8054 11.1095 12.8958C11.0685 12.9761 11.0385 13.0615 11.0204 13.1497C11 13.2492 11 13.3532 11 13.5612V17L7 20Z"
                                stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>

                <div class="liste-reservation">
                    <?php if (empty($reservations)): ?>
                        <p>Vous n'avez aucune réservation en cours, vous pouvez trouver de très belles vacances en cliquant
                            <a href="index.php">ici</a>.</p>
                    <?php else: ?>
                        <?php foreach ($reservations as $reservation): ?>
                            <div class="card-reservation">
                                <div class="card-reservation-img">
                                    <?php if (!empty($reservation['photos'])): ?>
                                        <img src="<?php echo htmlspecialchars($reservation['photos'][0]); ?>" alt="Logement photo"
                                            onerror="this.onerror=null; this.src='https://www.eclosio.ong/wp-content/uploads/2018/08/default.png';">
                                    <?php else: ?>
                                        <img src="https://www.eclosio.ong/wp-content/uploads/2018/08/default.png"
                                            alt="Default photo">
                                    <?php endif; ?>
                                </div>
                                <div class="card-reservation-content">
                                    <h4><?php echo htmlspecialchars($reservation['title']); ?></h4>
                                    <p><svg width="25px" height="25px" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M3 9H21M17 13.0014L7 13M10.3333 17.0005L7 17M7 3V5M17 3V5M6.2 21H17.8C18.9201 21 19.4802 21 19.908 20.782C20.2843 20.5903 20.5903 20.2843 20.782 19.908C21 19.4802 21 18.9201 21 17.8V8.2C21 7.07989 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V17.8C3 18.9201 3 19.4802 3.21799 19.908C3.40973 20.2843 3.71569 20.5903 4.09202 20.782C4.51984 21 5.07989 21 6.2 21Z"
                                                stroke="#000000" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <b>Du</b> <i class="date"
                                            data-date="<?php echo htmlspecialchars($reservation['start_date']); ?>"></i>
                                        <b>au</b> <i class="date"
                                            data-date="<?php echo htmlspecialchars($reservation['end_date']); ?>"></i>
                                    </p>
                                    <p><svg fill="#000000" height="25px" width="25px" version="1.1" id="Layer_1"
                                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            viewBox="0 0 511.985 511.985" xml:space="preserve">
                                            <g>
                                                <g>
                                                    <g>
                                                        <path
                                                            d="M222,3.277C153.477,16.59,99.111,72.751,87.702,141.764c-6.79,41.231,1.13,81.857,21.702,116.271
                                                c2.35,3.928,4.199,7.011,8.39,14l0.967,1.613c41.753,69.614,59.977,101.895,79.073,142.806l38.825,83.218
                                                c7.659,16.416,31.001,16.419,38.664,0.004l34.965-74.901c19.287-41.357,37.562-74.11,79.19-144.553l1.062-1.797
                                                c6.181-10.459,9.139-15.472,12.673-21.482c15.271-25.943,23.445-55.54,23.445-86.29C426.659,63.541,329.368-17.545,222,3.277z
                                                M366.44,235.307c-3.518,5.984-6.466,10.977-12.631,21.41l-1.062,1.797c-42.326,71.624-61.063,105.204-81.123,148.219
                                                l-15.625,33.472l-19.5-41.795c-19.925-42.687-38.643-75.842-81.147-146.709l-0.967-1.613c-4.187-6.981-6.027-10.051-8.363-13.954
                                                c-15.428-25.808-21.358-56.232-16.222-87.425c8.504-51.443,49.357-93.645,100.331-103.549
                                                c80.922-15.693,153.862,45.096,153.862,125.49C383.993,193.74,377.88,215.872,366.44,235.307z" />
                                                        <path d="M255.993,106.652c-35.355,0-64,28.645-64,64s28.645,64,64,64s64-28.645,64-64S291.348,106.652,255.993,106.652z
                                                M255.993,191.985c-11.791,0-21.333-9.542-21.333-21.333s9.542-21.333,21.333-21.333c11.791,0,21.333,9.542,21.333,21.333
                                                S267.784,191.985,255.993,191.985z" />
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                        <?php echo htmlspecialchars($reservation['city'] . ', ' . $reservation['department']); ?>
                                    </p>
                                    <p><svg width="25px" height="25px" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M3 18C3 15.3945 4.66081 13.1768 6.98156 12.348C7.61232 12.1227 8.29183 12 9 12C9.70817 12 10.3877 12.1227 11.0184 12.348C11.3611 12.4703 11.6893 12.623 12 12.8027C12.3107 12.623 12.6389 12.4703 12.9816 12.348C13.6123 12.1227 14.2918 12 15 12C15.7082 12 16.3877 12.1227 17.0184 12.348C19.3392 13.1768 21 15.3945 21 18V21H15.75V19.5H19.5V18C19.5 15.5147 17.4853 13.5 15 13.5C14.4029 13.5 13.833 13.6163 13.3116 13.8275C14.3568 14.9073 15 16.3785 15 18V21H3V18ZM9 11.25C8.31104 11.25 7.66548 11.0642 7.11068 10.74C5.9977 10.0896 5.25 8.88211 5.25 7.5C5.25 5.42893 6.92893 3.75 9 3.75C10.2267 3.75 11.3158 4.33901 12 5.24963C12.6842 4.33901 13.7733 3.75 15 3.75C17.0711 3.75 18.75 5.42893 18.75 7.5C18.75 8.88211 18.0023 10.0896 16.8893 10.74C16.3345 11.0642 15.689 11.25 15 11.25C14.311 11.25 13.6655 11.0642 13.1107 10.74C12.6776 10.4869 12.2999 10.1495 12 9.75036C11.7001 10.1496 11.3224 10.4869 10.8893 10.74C10.3345 11.0642 9.68896 11.25 9 11.25ZM13.5 18V19.5H4.5V18C4.5 15.5147 6.51472 13.5 9 13.5C11.4853 13.5 13.5 15.5147 13.5 18ZM11.25 7.5C11.25 8.74264 10.2426 9.75 9 9.75C7.75736 9.75 6.75 8.74264 6.75 7.5C6.75 6.25736 7.75736 5.25 9 5.25C10.2426 5.25 11.25 6.25736 11.25 7.5ZM15 5.25C13.7574 5.25 12.75 6.25736 12.75 7.5C12.75 8.74264 13.7574 9.75 15 9.75C16.2426 9.75 17.25 8.74264 17.25 7.5C17.25 6.25736 16.2426 5.25 15 5.25Z"
                                                fill="#080341" />
                                        </svg> <?php echo htmlspecialchars($reservation['capacity']); ?> personnes</p>
                                    <button class="btn-principale"
                                        onclick="window.location.href='detail-reservation.php?id=<?php echo $reservation['reservation_uuid']; ?>'">
                                        <h5>Voir le détail</h5>
                                    </button>

                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
    <?php
    $currentPageFooter = CurrentPage::RESERVATIONS;
    require ('../php/Composants/footer.php');
    ?>
    <script src="/ressources/js/main.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const options = { month: 'long', day: 'numeric' };
            const dateElements = document.querySelectorAll('.date');
            dateElements.forEach(function (dateElement) {
                const date = new Date(dateElement.getAttribute('data-date'));
                dateElement.textContent = date.toLocaleDateString('fr-FR', options);
            });
        });
    </script>
</body>

</html>