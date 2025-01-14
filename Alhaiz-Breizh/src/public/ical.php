<?php
require '../php/Tools/Bootstrap.php';

use Classes\ICal;
use Eluceo\iCal\Domain\ValueObject\TimeSpan;
use Eluceo\iCal\Domain\Entity\Event;
use  Eluceo\iCal\Domain\Entity\Calendar;

$ical = new ICal();
$calendar = new Calendar();

if (!isset($_GET['api_key'])) {
    echo 'Aucune clé API renseignée';
    exit();
}

// see the api key in URL to get the ical
$api_key = $ical->getApiByApiKey($_GET['api_key']);

//check api key valid?
//not valid => echo 'Error';
if (!$api_key) {
    echo 'Aucune clé API valide trouvée';
    exit;
}

//logement_liste = get abonnement_logement (récupérer la liste des logements liés)
//if vide => logement_liste = liste logement liés au proprio
$liste_logement_uuid = $ical->getAllLogementByApiKey($api_key[0]['api_key']);

if (!$liste_logement_uuid) {
    $liste_logement_uuid = $ical->getAllLogementByProprioId($api_key[0]['proprietaire_uuid']);
    if (!$liste_logement_uuid) {
        $componentFactory = new Eluceo\iCal\Presentation\Factory\CalendarFactory();
        $calendarComponent = $componentFactory->createCalendar($calendar);

        // 4. Set headers
        header('Content-Type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename="cal.ics"');

        // 5. Output
        echo $calendarComponent;
        exit;
    }    
}

//récupérer les devis / réservation => getAllDevisAndReservationById()
//générer ical
foreach ($liste_logement_uuid as $logement_uuid) {
    $all_data = $ical->getAllDevisAndReservationById($logement_uuid['logement_uuid'], $api_key[0]['start_date'], $api_key[0]['end_date']);

    if ($all_data) {
        foreach ($all_data as $devis_or_resa) {
            if ($devis_or_resa['uuid'] && !$devis_or_resa['reservation_uuid']) {
                $logement = $ical->getLogementById($devis_or_resa['logement_uuid']);
                $client = $ical->getClientById($devis_or_resa['client_uuid']);
                
                $startDateTime = \DateTime::createFromFormat('Y-m-d H:i:s', $devis_or_resa['start_date']);
                $endDateTime = \DateTime::createFromFormat('Y-m-d H:i:s', $devis_or_resa['end_date']);
        
                $duree_sejour = (new \DateTime($startDateTime->format('Y-m-d')))->diff(new \DateTime($endDateTime->format('Y-m-d')))->days;
        
                $calendar->addEvent($ical->generateICalDevis(
                    $startDateTime,
                    $endDateTime,
                    $logement[0]['title'],
                    $devis_or_resa['nb_people'],
                    $duree_sejour));

            } elseif ($devis_or_resa['reservation_uuid']) {
                $logement = $ical->getLogementById($devis_or_resa['logement_uuid']);
                $client = $ical->getClientById($devis_or_resa['reservation_client_uuid']);
                
                $startDateTime = \DateTime::createFromFormat('Y-m-d H:i:s', $devis_or_resa['start_date']);
                $endDateTime = \DateTime::createFromFormat('Y-m-d H:i:s', $devis_or_resa['end_date']);
        
                $duree_sejour = (new \DateTime($startDateTime->format('Y-m-d')))->diff(new \DateTime($endDateTime->format('Y-m-d')))->days;
        
                $calendar->addEvent($ical->generateICalResa(
                    $startDateTime,
                    $endDateTime,
                    $logement[0]['title'],
                    $devis_or_resa['nb_people'],
                    $duree_sejour,
                    $client[0]['lastname'],
                    $client[0]['firstname'],
                    $devis_or_resa['reservation_uuid']));
            }    
        }
    }    
}

//return ical

if (!$calendar) {
    echo 'Calendar null';
} else {
    $componentFactory = new Eluceo\iCal\Presentation\Factory\CalendarFactory();
    $calendarComponent = $componentFactory->createCalendar($calendar);

    // 4. Set headers
    header('Content-Type: text/calendar; charset=utf-8');
    header('Content-Disposition: attachment; filename="cal.ics"');

    // 5. Output
    echo $calendarComponent;
}
?>