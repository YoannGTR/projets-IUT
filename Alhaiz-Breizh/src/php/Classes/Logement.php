<?php

namespace Classes;

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
    public function tostring()
    {
        return (string) $this->value;
    }
}

enum State: string
{
    case ONLINE = "EnLigne";
    case OFFLINE = "HorsLigne";
    case DELETED = "Supprimé";


    public static function fromCaseName(string $name): ?State
    {
        foreach (self::cases() as $case) {
            if ($case->name === $name) {
                return $case;
            }
        }
        return null; // Or throw an exception if you prefer
    }
    public function tostring()
    {
        return (string) $this->value;
    }
}

enum Size: string
{
    case STUDIO = "Studio";
    case T1 = "T1";
    case T2 = "T2";
    case T3 = "T3";
    case T4 = "T4";
    case T5 = "T5";
    case TPLUS = "T+";
    case F1 = "F1";
    case F2 = "F2";
    case F3 = "F3";
    case F4 = "F4";
    case F5 = "F5";
    case FPLUS = "F+";
    case AUTRE = "Autre";


    public static function fromCaseName(string $name): ?Size
    {
        foreach (self::cases() as $case) {
            if ($case->name === $name) {
                return $case;
            }
        }
        return null; // Or throw an exception if you prefer
    }
    public function tostring()
    {
        return (string) $this->value;
    }
}

enum Activities: string
{
    case BATHING = "Baignade";
    case SAIL = "Voile";
    case CANOE = "Canoë";
    case GOLF = "Golf";
    case HORSE_RIDING = "Équitation";
    case HIKING = "Randonnée";
    case TREE_CLIMBING = "Accrobranche";


    public static function fromCaseName(string $name): ?Activities
    {
        foreach (self::cases() as $case) {
            if ($case->name === $name) {
                return $case;
            }
        }
        return null; // Or throw an exception if you prefer
    }
    public function tostring()
    {
        return (string) $this->value;
    }
}
enum Perimeter: string
{
    case ON_THE_SPOT = "Sur place";
    case LESS_5_KM = "Moins de 5 km";
    case LESS_10_KM = "Moins de 10 km";
    case LESS_20_KM = "Moins de 20 km";
    case MORE_20_KM = "Plus de 20 km";


    public static function fromCaseName(string $name): ?Perimeter
    {
        foreach (self::cases() as $case) {
            if ($case->name === $name) {
                return $case;
            }
        }
        return null; // Or throw an exception if you prefer
    }
    public function tostring()
    {
        return (string) $this->value;
    }
}
enum Amneties: string
{
    case GARDEN = "Jardin";
    case BALCONY = "Balcon";
    case TERRACE = "Terrasse";
    case POOL = "Piscine";
    case JACUZZI = "Jacuzzi";


    public static function fromCaseName(string $name): ?Amneties
    {
        foreach (self::cases() as $case) {
            if ($case->name === $name) {
                return $case;
            }
        }
        return null; // Or throw an exception if you prefer
    }
    public function tostring()
    {
        return (string) $this->value;
    }
}

class Logement
{
    public $db;
    public $connection;
    public $antiXss;

    public function __construct()
    {
        // Import Database
        $this->db = Database::getInstance();
        $this->connection = $this->db->getConnection();
    }

    public function all_logements()
    {
        $query = "SELECT * FROM logement";

        return $this->db->executeQuery($query);
    }

    public function createMeilleursCard()
    {
        $query = "SELECT title, price_ttc, city, department, logement.uuid, state, url, capacity FROM logement JOIN photo_logement ON logement.uuid=photo_logement.logement_uuid WHERE state='ONLINE' order by city;";

        return $this->db->executeQuery($query);
    }

    public function createPriseCard()
    {
        $query = "SELECT logement.uuid, logement.street_number, logement.street_name, logement.city, photo_logement.url, logement.department, logement.title, logement.capacity, logement.state, logement.price_ttc, COUNT(reservation.logement_uuid) AS reservation_count FROM logement JOIN photo_logement ON logement.uuid=photo_logement.logement_uuid LEFT JOIN reservation ON logement.uuid = reservation.logement_uuid WHERE logement.state='ONLINE' GROUP BY logement.uuid, logement.street_number, logement.street_name, logement.city, logement.department, logement.title, logement.price_ttc, logement.capacity, photo_logement.url ORDER BY reservation_count DESC;";

        return $this->db->executeQuery($query);
    }
    public function getLogementById($uuid)
    {
        $query = "SELECT * FROM logement WHERE uuid = :uuid";
        $params = [
            ':uuid' => $uuid
        ];

        $logementRaw = $this->db->executeQuery($query, $params);

        if (!$logementRaw || count($logementRaw) == 0) {
            return false;
        }
        return $logementRaw[0];
    }

    public function getProprietaireById($uuid)
    {
        $query = "SELECT * FROM proprietaire WHERE uuid = :uuid";
        $params = [
            ':uuid' => $uuid
        ];

        $proprietaireRaw = $this->db->executeQuery($query, $params);

        if (!$proprietaireRaw || count($proprietaireRaw) == 0) {
            return ["firstname" => "Deleted", "lastname" => "User"];
        }
        return $proprietaireRaw[0];
    }

    public function getPhotoByLogementId($uuid)
    {
        $query = "SELECT url FROM photo_logement WHERE logement_uuid = :uuid";
        $params = [
            ':uuid' => $uuid
        ];

        $photosRaw = $this->db->executeQuery($query, $params);

        if (!$photosRaw || count($photosRaw) == 0) {
            return false;
        }

        return $photosRaw[0];
    }

    public function getAmenetiesByLogementId($uuid)
    {
        $query = "SELECT amenities FROM amenagement WHERE logement_uuid = :uuid";
        $params = [
            ':uuid' => $uuid
        ];

        $amenitiesRaw = $this->db->executeQuery($query, $params);

        if (!$amenitiesRaw || count($amenitiesRaw) == 0) {
            return false;
        }

        return $amenitiesRaw;
    }

    public function getActivitiesByLogementId($uuid)
    {
        $query = "SELECT activity, perimeter FROM activite WHERE logement_uuid = :uuid";
        $params = [
            ':uuid' => $uuid
        ];

        $activitiesRaw = $this->db->executeQuery($query, $params);

        if (!$activitiesRaw || count($activitiesRaw) == 0) {
            return false;
        }

        return $activitiesRaw;
    }

    public function getAvisByLogementId($uuid)
    {
        $query = "SELECT ROUND(AVG(grade), 2) AS moyenne_grade FROM avis WHERE logement_uuid = :uuid";
        $params = [
            ':uuid' => $uuid
        ];

        $avisRaw = $this->db->executeQuery($query, $params);

        if ($avisRaw && (count($avisRaw) !== 0 && count($avisRaw[0]) !== 0 && !is_null($avisRaw[0]["moyenne_grade"]))) {
            return $avisRaw[0]["moyenne_grade"];
        }

        return "Pas d'avis pour le moment";
    }

    public function getFullInfosDetailLogement($uuid)
    {
        if (!isset($uuid)) {
            return false;
        }

        $logement = $this->getLogementById($uuid);
        if (!$logement) {
            return false;
        }
        $proprietaire = $this->getProprietaireById($logement["proprietaire_uuid"]);
        $moyenneLogement = $this->getAvisByLogementId($logement["uuid"]);
        $activites = $this->getActivitiesByLogementId($logement["uuid"]);
        $amenities = $this->getAmenetiesByLogementId($logement["uuid"]);
        $type = HousingType::fromCaseName($logement["housing_type"]);
        $infosLogement = array(
            "photo" => $this->getPhotoByLogementId($logement["uuid"])["url"],
            "capacity" => $logement["capacity"],
            "title" => $logement["title"],
            "housing_type" => $type->value,
            "city" => $logement["city"],
            "department" => $logement["department"],
            "price" => $logement["price_ttc"] / 100,
            "description" => $logement["description"],
            "amenities" => $amenities,
            "activities" => $activites,
            "uuid" => $logement["uuid"],
            "etat" => $logement["state"],
            "prenomProprietaire" => $proprietaire["firstname"],
            "nomProprietaire" => $proprietaire["lastname"],
            "proprietaire_uuid" => $logement["proprietaire_uuid"],
            "note" => $moyenneLogement,
            "single_bed" => $logement["single_bed_number"],
            "double_bed" => $logement["double_bed_number"],
            "bedroom" => $logement["bedroom_number"]

        );
        return $infosLogement;
    }

    public function getFullInfosDetailLogementBO($uuid)
    {
        if (!isset($uuid)) {
            return false;
        }

        $logement = $this->getLogementById($uuid);
        if (!$logement) {
            return false;
        }
        $proprietaire = $this->getProprietaireById($logement["proprietaire_uuid"]);
        $moyenneLogement = $this->getAvisByLogementId($logement["uuid"]);
        $activites = $this->getActivitiesByLogementId($logement["uuid"]);
        $amenities = $this->getAmenetiesByLogementId($logement["uuid"]);
        $type = HousingType::fromCaseName($logement["housing_type"]);
        $infosLogement = array(
            "photo" => $this->getPhotoByLogementId($logement["uuid"])["url"],
            "capacity" => $logement["capacity"],
            "title" => $logement["title"],
            "housing_type" => $type,
            "city" => $logement["city"],
            "department" => $logement["department"],
            "price" => $logement["price_ttc"] / 100,
            "description" => $logement["description"],
            "amenities" => $amenities,
            "activities" => $activites,
            "uuid" => $logement["uuid"],
            "etat" => $logement["state"],
            "prenomProprietaire" => $proprietaire["firstname"],
            "nomProprietaire" => $proprietaire["lastname"],
            "proprietaire_uuid" => $logement["proprietaire_uuid"],
            "note" => $moyenneLogement,
            "place_id" => $logement["place_id"],
            "introduction" => $logement["introduction"],
            "housing_size" => $logement["housing_size"],
            "surface" => $logement["surface"],
            "bedroom_number" => $logement["bedroom_number"],
            "single_bed_number" => $logement["single_bed_number"],
            "double_bed_number" => $logement["double_bed_number"],
            "minimal_location_duration" => $logement["minimal_location_duration"],
            "minimal_delay" => $logement["minimal_delay"],
            "heureArrivee" => substr($logement["arrival"], 0, 5),
            "heureDepart" => substr($logement["departure"], 0, 5),
            "price_ht" => $logement["price_ht"],





        );
        return $infosLogement;
    }
    public function getEtat($uuid)
    {
        $query = "SELECT state FROM logement WHERE uuid = :uuid";
        $params = [
            ':uuid' => $uuid
        ];

        $etatRaw = $this->db->executeQuery($query, $params);

        if (!$etatRaw || count($etatRaw) == 0) {
            return false;
        }

        return $etatRaw[0];
    }

    public function setHorsLigne($uuid)
    {
        $query = "UPDATE logement SET state = 'OFFLINE' WHERE uuid = :uuid";
        $params = [
            ':uuid' => $uuid
        ];

        return $this->db->executeQuery($query, $params);
    }
    public function setEnLigne($uuid)
    {
        $query = "UPDATE logement SET state = 'ONLINE' WHERE uuid = :uuid";
        $params = [
            ':uuid' => $uuid
        ];

        return $this->db->executeQuery($query, $params);
    }

    public function getCreateLogement()
    {
        $res = [];
        $res["types"] = HousingType::cases();
        $res["sizes"] = Size::cases();
        $res["states"] = State::cases();
        $res["activities"] = Activities::cases();
        $res["perimeters"] = Perimeter::cases();
        $res["amenities"] = Amneties::cases();
        return $res;
    }


    public function createLogement(array $logement, array $userData)
    {
        $uuid = $this->db->generateUUID();
        $logementQuery = "INSERT INTO logement (uuid, street_number, street_name, city, department, region, latitude, longitude, place_id, housing_type, title, description, price_ht, capacity, state, arrival, departure, proprietaire_uuid, created_at, updated_at, introduction, housing_size, surface, bedroom_number, single_bed_number, double_bed_number, price_ttc, minimal_location_duration, minimal_delay, zipcode) 
        VALUES (:uuid, :street_number, :street_name, :city, :department, :region, :latitude, :longitude, :place_id, :housing_type, :title, :description, :price_ht, :capacity, :state, :arrival, :departure, :proprietaire_uuid, :created_at, :updated_at, :introduction, :housing_size, :surface, :bedroom_number, :single_bed_number, :double_bed_number, :price_ttc, :minimal_location_duration, :minimal_delay, :zipcode)";



        $logementParams = [
            ':uuid' => $uuid,
            ':street_number' => $logement['street_number'],
            ':street_name' => $logement['street_name'],
            ':city' => $logement['city'],
            ':department' => $logement['department'],
            ':region' => $logement['region'],
            ':latitude' => $logement['latitude'],
            ':longitude' => $logement['longitude'],
            ':place_id' => $logement['place_id'],
            ':housing_type' => isset($logement["typeLogement"]) ? $logement["typeLogement"] : "AUTRE",
            ':title' => $logement['titre'],
            ':description' => $logement['description'],
            ':price_ht' => round(((int)$logement['price'] / 1.1) * 100),
            ':capacity' => (int)$logement['capacity'],
            ':state' => isset($logement["pubHorsLigne"]) ? $logement["pubHorsLigne"] : "ONLINE",
            ':arrival' => $logement['heureArrivee'],
            ':departure' => $logement['heureDepart'],
            ':proprietaire_uuid' => $userData['uuid'],
            ':created_at' => date('Y-m-d H:i:s'),
            ':updated_at' => date('Y-m-d H:i:s'),
            ':introduction' => $logement['accroche'],
            ':housing_size' => isset($logement["nbpiece"]) ? $logement["nbpiece"] : "AUTRE",
            ':surface' => (int)$logement['surface'],
            ':bedroom_number' => (int)$logement['nbchambres'],
            ':single_bed_number' => (int)$logement['nbLitsSimples'],
            ':double_bed_number' => (int)$logement['nbLitsDoubles'],
            ':price_ttc' => (int)$logement['price'] * 100,
            ':minimal_location_duration' => (int)$logement['nbNuitsMini'],
            ':minimal_delay' => (int)$logement['nbJoursDelai'],
            ':zipcode' => $logement['zipcode']
        ];
        // echo "<pre style='margin-left:5rem;'>";
        // print_r($logementParams);
        // echo "</pre>";

        $res = $this->db->executeQuery($logementQuery, $logementParams);
        foreach (Amneties::cases() as $value) {
            if (isset($logement[$value->name])) {
                $amenitiesQuery = "INSERT INTO amenagement (logement_uuid, amenities) VALUES (:logement_uuid, :amenities)";
                $amenitiesParams = [
                    ':logement_uuid' => $uuid,
                    ':amenities' => $logement[$value->name]
                ];
                // echo "<pre style='margin-left:5rem;'>";
                // print_r($amenitiesParams);
                // echo "</pre>";
                $res2 = $this->db->executeQuery($amenitiesQuery, $amenitiesParams);
            }
        }
        foreach (Activities::cases() as $value) {
            if (isset($logement[$value->name]) && isset($logement["perimeter" . $value->name])) {
                $activitiesQuery = "INSERT INTO activite (logement_uuid, activity, perimeter) VALUES (:logement_uuid, :activity, :perimeter)";
                $activitiesParams = [
                    ':logement_uuid' => $uuid,
                    ':activity' => $logement[$value->name],
                    ':perimeter' => $logement["perimeter" . $value->name],
                ];
                // echo "<pre style='margin-left:5rem;'>";
                // print_r($activitiesParams);
                // echo "</pre>";
                $res3 = $this->db->executeQuery($activitiesQuery, $activitiesParams);
            }
        }
        $photo_uuid = $this->db->generateUUID();
        $url = "https://www.eclosio.ong/wp-content/uploads/2018/08/default.png";//TODO: a changer par le vraie photo uploadée
        $photoQuery = "INSERT INTO photo_logement (uuid, url, `order`, logement_uuid) VALUES (:uuid, :url, :order, :logement_uuid)";
        $photoParams = [
            ':uuid' => $photo_uuid,
            ':url' => $url,
            ':order' => 0,
            ':logement_uuid' => $uuid
        ];
        // echo "<pre style='margin-left:5rem;'>";
        // print_r($photoParams);
        // echo "</pre>";
        $res4 = $this->db->executeQuery($photoQuery, $photoParams);
        

        $ress = [];

        if (isset($res)) {
            return $uuid;
        }


        return null;
    }

//     public function addPhotoInRepo(array $file)
//     {
//         // Configuration
//         $token = $_ENV["TOKEN_SECRET_GITHUB"]; // Remplacez par votre token personnel
//         $owner = 'votre_nom_utilisateur'; // Remplacez par le nom du propriétaire du repo
//         $repo = 'nom_du_repo'; // Remplacez par le nom du repo
//         $path = 'chemin/du/fichier.txt'; // Chemin où le fichier sera ajouté
//         $message = 'Ajouter un fichier via API PHP'; // Message de commit
//         $content = base64_encode('Contenu du fichier'); // Contenu du fichier encodé en base64

//         // URL de l'API GitHub pour créer ou mettre à jour un fichier
//         $url = "https://api.github.com/repos/$owner/$repo/contents/$path";

//         // Configuration cURL
//         $ch = curl_init($url);
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//         curl_setopt($ch, CURLOPT_HTTPHEADER, [
//             'Authorization: token ' . $token,
//             'User-Agent: PHP Script', // GitHub nécessite un User-Agent
//             'Content-Type: application/json'
//         ]);

//         // Données à envoyer en JSON
//         $data = json_encode([
//             'message' => $message,
//             'content' => $content
//         ]);

//         curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

//         // Exécution de la requête
//         $response = curl_exec($ch);

//         // Vérification des erreurs
//         if (curl_errno($ch)) {
//             echo 'Erreur cURL : ' . curl_error($ch);
//         } else {
//             $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//             if ($http_code == 201) {
//                 echo "Fichier ajouté avec succès !";
//             } else {
//                 echo "Erreur lors de l'ajout du fichier : " . $response;
//             }
//         }

//         // Fermeture de la session cURL
//         curl_close($ch);


//         return $url;
//     }
}
