<?php

namespace Classes;

use Exception;
use DateTime;
use DateInterval;



enum HousingType: string
{
    case CHATEAU = "Château";
    case APPARTEMENT = "Appartement";
    case MAISON = "Maison";
    case VILLA = "Villa";
    case FERME = "Ferme";
    case MANOIR = "Manoir";
    case CABANE = "Cabane";
    case AUTRE = "Autre";

    public static function fromCaseName(string $name): ?HousingType
    {
        foreach (self::cases() as $case) {
            if ($case->name === $name) {
                return $case;
            }
        }
        return null; // Or throw an exception if you prefer
    }
}

class Devis
{
    public $db;

    public function __construct()
    {
        // Import Database
        $this->db = Database::getInstance();
    }

    private function normalizeDate($date)
    {
        $dateParts = explode('-', $date);
        if (count($dateParts) === 3) {
            $year = $dateParts[0];
            $month = str_pad($dateParts[1], 2, '0', STR_PAD_LEFT);
            $day = str_pad($dateParts[2], 2, '0', STR_PAD_LEFT);
            return "$year-$month-$day";
        }
        return $date;
    }

    public function getLogementById($id)
    {
        try {
            $logementQuery = "SELECT * FROM logement WHERE uuid = :uuid";
            $logementParams = [':uuid' => $id];
            $logementRaw = $this->db->executeQuery($logementQuery, $logementParams);

            if (!$logementRaw || count($logementRaw) == 0) {
                return null;
            }
            return $logementRaw[0];
        } catch (Exception $e) {
            return null;
        }
    }

    public function getProprietaireById($id)
    {
        try {
            $proprietaireQuery = "SELECT * FROM proprietaire WHERE uuid = :uuid";
            $proprietaireParams = [':uuid' => $id];
            $proprietaireRaw = $this->db->executeQuery($proprietaireQuery, $proprietaireParams);

            if (!$proprietaireRaw || count($proprietaireRaw) == 0) {
                return null;
            }
            return $proprietaireRaw[0];
        } catch (Exception $e) {
            return null;
        }
    }

    public function createDevis($data)
    {
        try {
            $uuid = $this->db->generateUUID();
            $number_of_nights = $data['date_diff']->days;
            $tourist_tax = $number_of_nights * $data['nombre_voyageurs'] * 100; // 1 euro per night per person multiplied by 100
            $total_ttc = ($data['logement']['price_ttc'] * $number_of_nights) + $data['service_fees'] + $tourist_tax;

            $devisQuery = "INSERT INTO devis (uuid, client_uuid, logement_uuid, nb_people, daily_price_ttc, daily_price_ht, total_ttc, service_fees, tourist_tax, start_date, end_date, cancellation_deadline) VALUES (:uuid, :client_uuid, :logement_uuid, :nb_people, :daily_price_ttc, :daily_price_ht, :total_ttc, :service_fees, :tourist_tax, :start_date, :end_date, :cancellation_deadline)";
            $devisParams = [
                ':uuid' => $uuid,
                ':client_uuid' => $data['user'] ? $data['user']['uuid'] : null,
                ':logement_uuid' => $data['logement']['uuid'],
                ':nb_people' => $data['nombre_voyageurs'],
                ':daily_price_ttc' => $data['logement']['price_ttc'],
                ':daily_price_ht' => $data['logement']['price_ht'],
                ':service_fees' => $data['service_fees'],
                ':total_ttc' => $total_ttc,
                ':tourist_tax' => $tourist_tax,
                ':start_date' => $data['date_arrivee']->format('Y-m-d H:i:s'),
                ':end_date' => $data['date_depart']->format('Y-m-d H:i:s'),
                ':cancellation_deadline' => $data['proprietaire']['cancellation_deadline'],
            ];

            $res = $this->db->executeQuery($devisQuery, $devisParams);

            if (is_array($res) && count($res) == 0) {
                $this->insertUnavailabilityDates($data['logement']['uuid'], $data['date_arrivee'], $data['date_depart']);
                
                return $this->getDevis($uuid, $data['user']);
            }

            
            return null;
        } catch (Exception $e) {
            return null;
        }
    }

    public function insertUnavailabilityDates($logementUuid, $dateDebut, $dateFin)
    {
        try {
            $currentDate = clone $dateDebut;
            $dateBuffer = clone $dateFin;
            $dateBuffer->add(new DateInterval('P1D'));
            $interval = new DateInterval('P1D');
    
            while ($currentDate < $dateBuffer) {
                $planningQuery = "INSERT INTO planning (logement_uuid, unavailability_date) VALUES (:logement_uuid, :unavailability_date)";
                $planningParams = [
                    ':logement_uuid' => $logementUuid,
                    ':unavailability_date' => $currentDate->format('Y-m-d')
                ];
    
                $this->db->executeQuery($planningQuery, $planningParams);
                $currentDate->add($interval);
            }
    
            
        } catch (Exception $e) {
        }
    }
    


    public function generateDevisFromPostData($postData, $user = null)
    {
        try {// Afficher les données POST pour le débogage

            if (!isset($postData['logement_uuid']) || !isset($postData['date_arrivee']) || !isset($postData['date_depart']) || !isset($postData['nombre_voyageurs'])) {
                
                return null;
            }

            $logement = $this->getLogementById($postData['logement_uuid']);

            if (!$logement) {
                return null;
            }

            // Normaliser les dates
            $postData['date_arrivee'] = $this->normalizeDate($postData['date_arrivee']);
            $postData['date_depart'] = $this->normalizeDate($postData['date_depart']);

            // Vérifiez le format des dates avant de créer les objets DateTime
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $postData['date_arrivee']) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $postData['date_depart'])) {
                
                return null;
            }

            $dateArrivee = DateTime::createFromFormat('Y-m-d', $postData['date_arrivee']);
            $dateDepart = DateTime::createFromFormat('Y-m-d', $postData['date_depart']);

            // Check for valid date formats
            if (!$dateArrivee || !$dateDepart || $dateArrivee->format('Y-m-d') !== $postData['date_arrivee'] || $dateDepart->format('Y-m-d') !== $postData['date_depart']) {
                
                return null;
            }

            $dateDiff = $dateArrivee->diff($dateDepart);

            // Check if date difference is negative or equals to 0
            if ($dateDiff->invert == 1 || $dateDiff->days == 0) {
                
                return null;
            }

            $nombreVoyageurs = intval($postData['nombre_voyageurs']);

            if ($nombreVoyageurs < 1) {
                
                return null;
            }

            $number_of_nights = $dateDiff->days; // Correctly calculate the number of nights
            $prixHT = $logement['price_ttc'] * $number_of_nights;
            $comAmount = $prixHT * 0.01;
            $taxeSejourAmount = $number_of_nights * $nombreVoyageurs * 100; // 1 euro per night per person multiplied by 100

            $arrivalTime = DateTime::createFromFormat('H:i:s', $logement['arrival']);
            $departureTime = DateTime::createFromFormat('H:i:s', $logement['departure']);
            $dateArrivee->setTime($arrivalTime->format('H'), $arrivalTime->format('i'), $arrivalTime->format('s'));
            $dateDepart->setTime($departureTime->format('H'), $departureTime->format('i'), $departureTime->format('s'));

            $proprietaire = $this->getProprietaireById($logement['proprietaire_uuid']);

            $data = [
                'logement' => $logement,
                'proprietaire' => $proprietaire,
                'user' => $user,
                'date_arrivee' => $dateArrivee,
                'date_depart' => $dateDepart,
                'date_diff' => $dateDiff,
                'nombre_voyageurs' => $nombreVoyageurs,
                'service_fees' => $comAmount,
                'tourist_tax' => $taxeSejourAmount,
            ];

            return $this->createDevis($data);
        } catch (Exception $e) {
            
            return null;
        }
    }

    public function getPhotoLogementById($id)
    {
        try {
            $photoLogementQuery = "SELECT * FROM photo_logement WHERE logement_uuid = :uuid";
            $photoLogementParams = [':uuid' => $id];
            $photoLogementRaw = $this->db->executeQuery($photoLogementQuery, $photoLogementParams);

            if (!$photoLogementRaw || count($photoLogementRaw) == 0) {
                
                return [];
            }

            return $photoLogementRaw[0];
        } catch (Exception $e) {
        
            return [];
        }
    }

    public function getAvisByLogementId($uuid)
    {
        try {
            $query = "SELECT ROUND(AVG(grade), 2) AS moyenne_grade FROM avis WHERE logement_uuid = :uuid";
            $params = [':uuid' => $uuid];

            $avisRaw = $this->db->executeQuery($query, $params);

            if ($avisRaw && (count($avisRaw) !== 0 && count($avisRaw[0]) !== 0 && !is_null($avisRaw[0]["moyenne_grade"]))) {
                return $avisRaw[0]["moyenne_grade"];
            }

            return "Pas d'avis pour le moment";
        } catch (Exception $e) {
            
            return "Pas d'avis pour le moment";
        }
    }

    public function getDevis($uuid, $userData)
    {
        try {
            $devisQuery = "SELECT * FROM devis WHERE uuid = :uuid";
            $devisParams = [':uuid' => $uuid];
            $devisRaw = $this->db->executeQuery($devisQuery, $devisParams);

            if (!$devisRaw || count($devisRaw) == 0) {
                
                return null;
            }

            $devis = $devisRaw[0];

            if ($userData && $devis['client_uuid'] ? $userData['uuid'] !== $devis['client_uuid'] : false) {
                
                return null;
            }

            $logement = $this->getLogementById($devis['logement_uuid']);
            $proprietaire = $this->getProprietaireById($logement['proprietaire_uuid']);
            $photoLogement = $this->getPhotoLogementById($logement['uuid']);

            $moyenneLogement = $this->getAvisByLogementId($logement["uuid"]);
            $logement["type"] = HousingType::fromCaseName($logement["housing_type"])->value;

            $dateArrivee = DateTime::createFromFormat('Y-m-d H:i:s', $devis['start_date']);
            $dateDepart = DateTime::createFromFormat('Y-m-d H:i:s', $devis['end_date']);

            $devis['start_date'] = $dateArrivee->format('d/m/Y');
            $devis['end_date'] = $dateDepart->format('d/m/Y');
            $devis['start_hours'] = $dateArrivee->format('H:i');
            $devis['end_hours'] = $dateDepart->format('H:i');

            $dateArrivee->setTime(0, 0, 0);
            $dateDepart->setTime(0, 0, 0);

            $nbDays = $dateArrivee->diff($dateDepart)->days;

            $devis['nb_days'] = $nbDays;
            $devis['price_ht'] = number_format($devis["daily_price_ttc"] * $nbDays / 100, 2, ',', ' ');
            $devis['total_ttc'] = number_format($devis["total_ttc"] / 100, 2, ',', ' ');
            $data = [
                'devis' => $devis,
                'logement' => $logement,
                'proprietaire' => $proprietaire,
                'user' => $userData,
                'photo_logement' => $photoLogement["url"],
                "note" => $moyenneLogement
            ];

            return $data;
        } catch (Exception $e) {
            
            return null;
        }
    }
}
