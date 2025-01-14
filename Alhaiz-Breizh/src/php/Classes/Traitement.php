<?php

namespace Classes;

use Classes\Database;

class Traitement {
    private $connection;
    private $db;

    public function __construct() {
        // Import Database
        $this->db = Database::getInstance();
        $this->connection = $this->db->getConnection();
    }

    // Méthode pour récupérer les informations de devis
    public function storeData($client_uuid) {

        $devis_uuid = $_GET['id'];
        $logement_uuid = $this->getLogementUuid($_GET['id']);

        $query = "INSERT INTO reservation (logement_uuid, devis_uuid, client_uuid) 
                    VALUES
                    (:logement_uuid, :devis_uuid, :client_uuid)
                ";

        $params = [
            ':logement_uuid' => $logement_uuid,
            ':devis_uuid' => $devis_uuid,
            ':client_uuid' => $client_uuid
        ];
        return $this->db->executeQuery($query, $params);
    }

    public function setClientUuid($client_uuid) {
        //update value from null to client_uuid
        $devis_uuid = $_GET['id'];

        $query = "UPDATE devis SET client_uuid = :uuid WHERE client_uuid IS NULL AND uuid = :devis_uuid";
        $params = [
            ':uuid' => $client_uuid,
            ':devis_uuid' => $devis_uuid
        ];
    
        $result = $this->db->executeQuery($query, $params);
    
        if (!$result || count($result) == 0) {
            return null; // Retourner null si aucun résultat
        }
    
        return $result[0]['uuid']; // Retourner l'UUID
    }

    public function getDevisById($devis_uuid){

        $devisQuery = "SELECT * FROM devis WHERE uuid = :uuid";
        $devisParams = [
            ':uuid' => $devis_uuid
        ];
        $devisRaw = Database::getInstance()->executeQuery($devisQuery, $devisParams);

        if (!$devisRaw || count($devisRaw) == 0) {
            return [];
        }

        return $devisRaw[0];
    }

    public function getReservationUuid($devis_uuid) {
        $query = "SELECT uuid FROM reservation WHERE devis_uuid = :devis_uuid";
        $params = [
            ':devis_uuid' => $devis_uuid
        ];
    
        $result = $this->db->executeQuery($query, $params);
    
        if (!$result || count($result) == 0) {
            return null; // Retourner null si aucun résultat
        }
    
        return $result[0]['uuid']; // Retourner l'UUID
    }

    public function getLogementUuid($devis_uuid) {
        $query = "SELECT logement_uuid FROM devis WHERE uuid = :devis_uuid";
        $params = [
            ':devis_uuid' => $devis_uuid
        ];
    
        $result = $this->db->executeQuery($query, $params);
    
        if (!$result || count($result) == 0) {
            return null; // Retourner null si aucun résultat
        }
    
        return $result[0]['logement_uuid']; // Retourner l'UUID
    }  
}

?>
