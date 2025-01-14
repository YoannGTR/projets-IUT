<?php
namespace Classes;

use Classes\Database;
use \DateTime;

class DetailReservation
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getReservationById($id)
    {
        $reservationQuery = "SELECT * FROM reservation where uuid = :uuid";
        $reservationParams = [
            ':uuid' => $id
        ];
        $reservationRaw = $this->db->executeQuery($reservationQuery, $reservationParams);

        if (!$reservationRaw || count($reservationRaw) == 0) {
            return [];
        }

        return $reservationRaw[0];
    }

    public function getDevisById($id)
    {
        $devisQuery = "SELECT * from devis where uuid = :uuid";
        $devisParams = [
            ':uuid' => $id
        ];
        $devisRaw = $this->db->executeQuery($devisQuery, $devisParams);

        if (!$devisRaw || count($devisRaw) == 0) {
            return [];
        }

        return $devisRaw[0];
    }

    public function getLogementById($id)
    {
        $logementQuery = "SELECT * from logement where uuid = :uuid";
        $logementParams = [
            ':uuid' => $id
        ];
        $logementRaw = $this->db->executeQuery($logementQuery, $logementParams);

        if (!$logementRaw || count($logementRaw) == 0) {
            return [];
        }

        return $logementRaw[0];
    }

    public function getPhotoLogementById($id)
    {
        $photoLogementQuery = "SELECT * from photo_logement where logement_uuid = :uuid";
        $photoLogementParams = [
            ':uuid' => $id
        ];
        $photoLogementRaw = $this->db->executeQuery($photoLogementQuery, $photoLogementParams);

        if (!$photoLogementRaw || count($photoLogementRaw) == 0) {
            return [];
        }

        return $photoLogementRaw[0];
    }

    public function getUserById($uuid)
    {
        $userQuery = "SELECT * from client where uuid = :uuid";
        $userParams = [
            ':uuid' => $uuid
        ];
        $userRaw = $this->db->executeQuery($userQuery, $userParams);

        if (!$userRaw || count($userRaw) == 0) {
            return [];
        }

        return $userRaw[0];
    }

    public function statut(DateTime $debut, DateTime $fin)
    {
        $mtn = new DateTime();
        if ($mtn >= $debut && $mtn <= $fin) {
            return "En cours";
        } elseif ($mtn < $debut) {
            return "À venir";
        } else {
            return "Passée";
        }
    }

    public function checkcmbtemps(DateTime $debut, DateTime $fin)
    {
        $mtn = new DateTime();
        $JourRestant = $mtn->diff($debut)->days;
        if ($mtn >= $debut && $mtn <= $fin) {
            return "en cours";
        } elseif ($mtn < $debut) {
            if($JourRestant==0){
                return "aujourd'hui.";
            }else{
                return "dans $JourRestant jours.";
            }
            
        }else {
            $JourPasse = $mtn->diff($fin)->days;
            return "passé il y a $JourPasse jours.";
        }
    }

    public function formatDateTimeFrench(DateTime $dateTime): string
    {
        return $dateTime->format('d/m/Y \à H:i');
    }

    public function calculateNightsBetween(DateTime $startDateTime, DateTime $endDateTime): int
    {
        $interval = $startDateTime->diff($endDateTime);
        return $interval->days;
    }
    public function getProprioById($uuid){
        $userQuery = "SELECT * from proprietaire where uuid = :uuid";
        $userParams = [
            ':uuid' => $uuid
        ];
        $userRaw = $this->db->executeQuery($userQuery, $userParams);

        if (!$userRaw || count($userRaw) == 0) {
            return [];
        }

        return $userRaw[0];

    }

    public function getReservationFullInfo($uuid, $client_uuid)
    {
        $reservation = $this->getReservationById($uuid);
        if (!$reservation) {
            return false;
        }
        if ($reservation["client_uuid"] != $client_uuid) {
            return false;
        }
        $devis = $this->getDevisById($reservation['devis_uuid']);
        $logement = $this->getLogementById($reservation['logement_uuid']);
        $photo = $this->getPhotoLogementById($logement["uuid"]);
        $user = $this->getUserById($reservation['client_uuid']);
        $proprio = $this->getProprioById($logement["proprietaire_uuid"]);

        $dateArrivee = DateTime::createFromFormat('Y-m-d H:i:s', $devis['start_date'])->setTime(0, 0, 0);
        $dateDepart = DateTime::createFromFormat('Y-m-d H:i:s', $devis['end_date'])->setTime(0, 0, 0);

        $nbDays = $dateArrivee->diff($dateDepart)->days;

        $total_ttc = $devis['total_ttc'] / 100;
        $tva_amount = $total_ttc - ($total_ttc / 1.1);

        $detail = array(
            "statut" => $this->statut(new DateTime($devis["start_date"]), new DateTime($devis["end_date"])),
            "titre" => $logement["title"],
            "arrive" => $this->formatDateTimeFrench(new DateTime($devis["start_date"])),
            "depart" => $this->formatDateTimeFrench(new DateTime($devis["end_date"])),
            "adresse" => $logement["street_number"] . " " . $logement["street_name"] . " " . $logement["city"] . " " . $logement["department"],
            "personnalisation" => $devis["nb_people"],
            "logement" => $logement['uuid'],
            "daily_price_ttc" => $devis["daily_price_ttc"],
            "nb_jours" => $nbDays,
            "montant_sej" => number_format(($devis["daily_price_ttc"] * $nbDays) / 100, 2, ',', ' '),
            "taxesej" => number_format($devis["tourist_tax"] / 100, 2, ',', ' '),
            "TVA" => number_format($tva_amount/100, 2, ',', ' '),
            "montant_ttc" => number_format($total_ttc, 2, ',', ' '),
            "comission" => number_format($devis["service_fees"] / 100, 2, ',', ' '),
            "billing_adress" => $user["billing_address1"] . " " . $user["billing_address2"],
            "photo" => $photo["url"],
            "nom_proprio" => $proprio["title"]." ".$proprio["firstname"]." ".$proprio["lastname"],
            "numero_proprio" => $proprio["phone_number"],
            "avatar" => $proprio["avatar"]
        );

        if ($reservation["is_canceled"] == 1) {
            $detail["cmbtemps"] = " annulée.";
        } else {
            $detail["cmbtemps"] = $this->checkcmbtemps(new DateTime($devis["start_date"]), new DateTime($devis["end_date"]));
        }
        return $detail;
    }

    public function getReservationFullInfoBO($uuid)
    {
        $reservation = $this->getReservationById($uuid);
        if (!$reservation) {
            return false;
        }
        $devis = $this->getDevisById($reservation['devis_uuid']);
        $logement = $this->getLogementById($reservation['logement_uuid']);
        $photo = $this->getPhotoLogementById($logement["uuid"]);
        $user = $this->getUserById($reservation['client_uuid']);

        $dateArrivee = DateTime::createFromFormat('Y-m-d H:i:s', $devis['start_date'])->setTime(0, 0, 0);
        $dateDepart = DateTime::createFromFormat('Y-m-d H:i:s', $devis['end_date'])->setTime(0, 0, 0);

        $nbDays = $dateArrivee->diff($dateDepart)->days;

        $total_ttc = $devis['total_ttc'] / 100;
        $tva_amount = $total_ttc - ($total_ttc / 1.1);

        $detail = array(
            "statut" => $this->statut(new DateTime($devis["start_date"]), new DateTime($devis["end_date"])),
            "titre" => $logement["title"],
            "arrive" => $this->formatDateTimeFrench(new DateTime($devis["start_date"])),
            "depart" => $this->formatDateTimeFrench(new DateTime($devis["end_date"])),
            "adresse" => $logement["street_number"] . " " . $logement["street_name"] . " " . $logement["city"] . " " . $logement["department"],
            "personnalisation" => $devis["nb_people"],
            "logement" => $logement['uuid'],
            "daily_price_ttc" => $devis["daily_price_ttc"],
            "nb_jours" => $nbDays,
            "montant_sej" => number_format(($devis["daily_price_ttc"] * $nbDays) / 100, 2, ',', ' '),
            "taxesej" => number_format($devis["tourist_tax"] / 100, 2, ',', ' '),
            "TVA" => number_format($tva_amount, 2, ',', ' '),
            "montant_ttc" => number_format($total_ttc, 2, ',', ' '),
            "comission" => number_format($devis["service_fees"] / 100, 2, ',', ' '),
            "billing_adress" => $user["billing_address1"] . " " . $user["billing_address2"],
            "photo" => $photo["url"],
            "nom_user" => $user["lastname"],
            "prenom_user" => $user["firstname"],
            "logement_uuid" => $logement["uuid"]
        );

        if ($reservation["is_canceled"] == 1) {
            $detail["cmbtemps"] = " annulée.";
        } else {
            $detail["cmbtemps"] = $this->checkcmbtemps(new DateTime($devis["start_date"]), new DateTime($devis["end_date"]));
        }
        return $detail;
    }
}
