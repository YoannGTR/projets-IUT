<?php

namespace Classes;

require __DIR__ . '/../../../vendor/autoload.php';

use Classes\ICal;
use Eluceo\iCal\Domain\ValueObject\TimeSpan;
use Eluceo\iCal\Domain\ValueObject\DateTime;
use Eluceo\iCal\Domain\Entity\Event;
use Eluceo\iCal\Domain\Entity\Calendar;
use Eluceo\iCal\Domain\ValueObject\Uri;
use Classes\Database;

class ICal {
    private $connection;
    private $db;

    public function __construct() {
        // Import Database
        $this->db = Database::getInstance();
        $this->connection = $this->db->getConnection();
    }

    public function getClientById($client_uuid) {
        $query = "SELECT * FROM client WHERE uuid = :client_uuid";
        $params = [
            ':client_uuid' => $client_uuid
        ];
        $result = $this->db->executeQuery($query, $params);


        if (!$result || count($result) == 0) {
            return null; // Retourner null si aucun résultat
        }

        return $result;
    }

    public function getApiByApiKey($api_key) {
        $query = "SELECT * FROM abonnement WHERE api_key = :api_key";
        $params = [
            ':api_key' => $api_key
        ];
        $result = $this->db->executeQuery($query, $params);

        if (!$result || count($result) == 0) {
            return null; // Retourner null si aucun résultat
        }

        return $result;
    }

    public function getLogementById($logement_uuid) {
        $query = "SELECT * FROM logement WHERE uuid = :logement_uuid";
        $params = [
            ':logement_uuid' => $logement_uuid
        ];
        $result = $this->db->executeQuery($query, $params);


        if (!$result || count($result) == 0) {
            return null; // Retourner null si aucun résultat
        }

        return $result;
    }

    public function getAllLogementByApiKey($api_key) {
        $query = "SELECT logement_uuid FROM abonnement_logement
                    INNER JOIN abonnement ON abonnement_logement.abonnement_id = abonnement.id
                    WHERE abonnement.api_key = :api_key";
        $params = [
            ':api_key' => $api_key
        ];
        $result = $this->db->executeQuery($query, $params);

        if (count($result) == 0) {
            return null;
        }

        return $result;
    }
    public function getAllLogementByProprioId($proprietaire_uuid) {
        $query = "SELECT logement.uuid AS logement_uuid FROM logement
                    INNER JOIN proprietaire ON logement.proprietaire_uuid = proprietaire.uuid
                    WHERE proprietaire.uuid = :proprietaire_uuid";
            $params = [
                ':proprietaire_uuid' => $proprietaire_uuid
            ];
            $result = $this->db->executeQuery($query, $params);

            if (!$result || count($result) == 0) {
                return null; // Retourner null si aucun résultat
            }
        return $result;
    }

    public function getAllDevisAndReservationById($logement_uuid, $api_start, $api_end){
        $query = "SELECT 
                        devis.*,
                        reservation.uuid AS reservation_uuid,
                        reservation.is_canceled,
                        reservation.client_uuid AS reservation_client_uuid,
                        reservation.created_at AS reservation_created_at,
                        reservation.updated_at AS reservation_updated_at
                    FROM 
                        devis
                    LEFT JOIN 
                        reservation ON devis.uuid = reservation.devis_uuid
                    WHERE 
                        devis.logement_uuid = :logement_uuid
                        AND (
                            (devis.start_date <= :api_start AND devis.end_date >= :api_start) OR
                            (devis.start_date <= :api_end AND devis.end_date >= :api_end) OR
                            (devis.start_date >= :api_start AND devis.end_date <= :api_end)
                        );";
        $params = [
            ':logement_uuid' => $logement_uuid,
            ':api_start' => $api_start,
            ':api_end' => $api_end
        ];
        $result = $this->db->executeQuery($query, $params);
        
        if (!$result || count($result) == 0) {
            return null; // Retourner null si aucun résultat
        }

        return $result;
    }

    public function generateICalResa($date_debut, $date_fin, $titre_logement, $nb_pers, $duree_nuit, $nom_client, $prenom_client, $uuid_reservation) {
        // Formatting using DateTimeImmutable objects
        $debut_string = $date_debut->format('d/m/Y') . "\n";
        $fin_string = $date_fin->format('d/m/Y') . "\n";

        $date_debut = new DateTime($date_debut, false);
        $date_fin = new DateTime($date_fin, false);
        
        $occurrence = new TimeSpan($date_debut, $date_fin);
        
        $event = new Event();

        $event->setSummary('[RESERVATION] ' . $titre_logement)
            ->setDescription($nb_pers . ' personnes ;' . $duree_nuit . ' nuit(s) ; Arrivée le ' .  $debut_string . '  ; Départ le ' . $fin_string . ' ; Réservation de ' . $nom_client . ' ' . $prenom_client . ' ; URL : https://bnbyte.ventsdouest.dev/detail-devis.php?uuid=' . $uuid_reservation)
            ->setOccurrence($occurrence);
        return $event;
    }
    public function generateICalDevis($date_debut, $date_fin, $titre_logement, $nb_pers, $duree_nuit) {
        // Formatting using DateTimeImmutable objects
        $debut_string = $date_debut->format('d/m/Y') . "\n";
        $fin_string = $date_fin->format('d/m/Y') . "\n";

        $date_debut = new DateTime($date_debut, false);
        $date_fin = new DateTime($date_fin, false);
        
        $occurrence = new TimeSpan($date_debut, $date_fin);
        
        $event = new Event();

        $event->setSummary('[DEVIS] ' . $titre_logement)
            ->setDescription($nb_pers . ' personnes ; ' . $duree_nuit . ' nuit(s) ; Arrivée le ' .  $debut_string . ' ; Départ le ' . $fin_string)
            ->setOccurrence($occurrence);
        return $event;
    }
}   
/*
BEGIN:VEVENT
UID:unique-identifier-for-reservation
DTSTAMP:20240619T120000Z
DTSTART:20240701T140000Z
DTEND:20240710T120000Z
SUMMARY:nb pers, durée nuit, debut fin, nom prenom pers, lien reservation
END:VEVENT

BEGIN:VCALENDAR
PRODID:-//eluceo/ical//2.0/EN
VERSION:2.0
CALSCALE:GREGORIAN

BEGIN:VEVENT
UID:c4ef0787b47c9a914d49863e726c7261
DTSTAMP:20240620T102357Z
SUMMARY:Christmas Eve
DESCRIPTION:Lorem Ipsum Dolor...
DTSTART;VALUE=DATE:20301224
END:VEVENT
END:VCALENDAR
*/
?>