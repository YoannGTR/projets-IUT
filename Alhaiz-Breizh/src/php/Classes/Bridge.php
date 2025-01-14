<?php

namespace Classes;

use DateTime;
use Enum\Scopes;
use Exception;
use Random\RandomException;
use voku\helper\AntiXSS;

class Bridge
{
    public $db;
    public $connection;
    public $antiXss;

    public function __construct()
    {
        // Import Database
        $this->db = Database::getInstance();
        $this->connection = $this->db->getConnection();
        $this->antiXss = new AntiXSS();
    }

    public function getSubscriber($uuid)
    {
        $query = "SELECT DISTINCT abonnement_id, api_key, start_date, end_date FROM abonnement_logement     
            JOIN 
        abonnement ON abonnement_logement.abonnement_id = abonnement.id 
            JOIN 
        logement ON abonnement_logement.logement_uuid = logement.uuid 
            WHERE proprietaire_uuid = :uuid";

        $params = [':uuid' => $uuid];
        $subs = $this->db->executeQuery($query, $params);

        if ($subs === false) {
            return false;
        }
        return $subs;
    }

    public function getSynkronizator($uuid)
    {
        $query = "SELECT * FROM synkronizator WHERE proprietaire_uuid = :uuid";
        $params = [':uuid' => $uuid];
        $subs = $this->db->executeQuery($query, $params);

        if ($subs === false) {
            return false;
        }

        return $subs;
    }

    public function getScopesForAPIKey($api): ?array
    {
        $query = "SELECT * FROM synkronizator WHERE api_key = :api";
        $params = [':api' => $api];
        $subs = $this->db->executeQuery($query, $params);

        if ($subs === false) {
            return null; // or handle error appropriately
        }

        $scopesCount = [];

        foreach ($subs as $record) {
            if (isset($record['scopes'])) {
                $scopes = explode(';', $record['scopes']);
                foreach ($scopes as $scope) {
                    $scope = trim($scope);
                    if (!isset($scopesCount[$scope])) {
                        $scopesCount[$scope] = 0;
                    }
                    $scopesCount[$scope]++;
                }
            }
        }

        // Translate scopes using the enum
        $translatedScopesCount = [];
        foreach ($scopesCount as $scope => $count) {
            $translatedScope = Scopes::translate($scope);
            $translatedScopesCount[$translatedScope] = $count;
        }

        // Prepare simplified output
        $data = array_keys($translatedScopesCount);
        $count = count($data);

        return [
            'data' => $data,
            'count' => $count
        ];
    }

    public function getLogementForAPIKey($api) {
        $query = "SELECT * FROM abonnement_logement     
            JOIN 
        logement ON abonnement_logement.logement_uuid = logement.uuid 
            JOIN 
        abonnement ON abonnement_logement.abonnement_id = abonnement.id 
            WHERE api_key = :api";

        $params = [':api' => $api];
        $subs = $this->db->executeQuery($query, $params);

        if ($subs === false) {
            return false;
        }

        return $subs;
    }

    public function addSynk($scopes, $proprietaire_uuid, $is_admin = 0): bool
    {
        $api = bin2hex(random_bytes(16));

        $query = "INSERT INTO synkronizator (api_key, is_admin, scopes, proprietaire_uuid) VALUES (:api_key, :is_admin, :scopes, :proprietaire_uuid)";

        $scopes = implode(';', $scopes);

        $params = [':api_key' => $api, ':is_admin' => $is_admin, ':scopes' => $scopes, ':proprietaire_uuid' => $proprietaire_uuid];

        $subs = $this->db->executeQuery($query, $params);

        if ($subs === false) {
            return false;
        }

        return true;
    }

    /**
     * @throws RandomException
     */
    public function addSubscriber($uuids, $deb, $fin): bool
    {
        $api = bin2hex(random_bytes(16));
        $debDate = DateTime::createFromFormat('d/m/Y', $deb);
        $finDate = DateTime::createFromFormat('d/m/Y', $fin);

        if (!$debDate || !$finDate) {
            return false;
        }

        $sqlDateDeb = $debDate->format('Y-m-d');
        $sqlDateFin = $finDate->format('Y-m-d');

        $query = "INSERT INTO abonnement (api_key, start_date, end_date) VALUES (:api_key, :start_date, :end_date)";
        $params = [':api_key' => $api, ':start_date' => $sqlDateDeb, ':end_date' => $sqlDateFin];

        try {
            $this->connection->beginTransaction();

            $subs = $this->db->executeQuery($query, $params);
            if ($subs === false) {
                throw new Exception('Failed to insert into abonnement table.');
            }

            $abonnementId = $this->connection->lastInsertId();
            if (!$abonnementId) {
                throw new Exception('Failed to retrieve last insert ID.');
            }

            foreach ($uuids as $uuid) {
                $query2 = "INSERT INTO abonnement_logement (abonnement_id, logement_uuid) VALUES (:abonnement_id, :logement_uuid)";
                $params2 = [':abonnement_id' => $abonnementId, ':logement_uuid' => $uuid];
                $subs2 = $this->db->executeQuery($query2, $params2);

                if ($subs2 === false) {
                    throw new Exception('Failed to insert into abonnement_logement table.');
                }
            }

            $this->connection->commit();
            return true;

        } catch (Exception $e) {
            $this->connection->rollBack();
            return false;
        }
    }

    public function deleteSynkronizator($api_key) {
        $query = "DELETE FROM synkronizator WHERE api_key = :api_key";
        $params = [':api_key' => $api_key];
        $subs = $this->db->executeQuery($query, $params);

        if ($subs === false) {
            return false;
        }

        return true;
    }

    public function deleteSubscriber($id) {
        $query = "DELETE FROM abonnement_logement WHERE abonnement_id = :id";
        $params = [':id' => $id];
        $subs = $this->db->executeQuery($query, $params);

        $query2 = "DELETE FROM abonnement WHERE id = :id";
        $params2 = [':id' => $id];
        $subs2 = $this->db->executeQuery($query2, $params2);

        if ($subs === false || $subs2 === false) {
            return false;
        }

        return true;
    }
}