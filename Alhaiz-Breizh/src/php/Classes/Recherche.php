<?php 
namespace Classes;
use Classes\Database;


class Recherche
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();

    }
    public function get_json(){
        $logementQuery = "SELECT * from logement Join photo_logement Where logement.uuid = photo_logement.logement_uuid";
        $logementRaw = $this->db->executeQuery($logementQuery);
        if(!$logementRaw || count($logementRaw)==0){
            return [];

        }
        else{
            return json_encode($logementRaw, JSON_UNESCAPED_UNICODE );
        }
    }
    public function get_date(){
        $logementQuery = "SELECT logement_uuid,devis.start_date,devis.end_date from logement Join devis where logement.uuid = devis.logement_uuid";
        $logementRaw = $this->db->executeQuery($logementQuery);
        if(!$logementRaw || count($logementRaw)==0){
            return [];

        }
        else{
            return json_encode($logementRaw, JSON_UNESCAPED_UNICODE );
        }
    }
}