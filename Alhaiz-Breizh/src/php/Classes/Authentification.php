<?php

namespace Classes;

use Classes\Database;
use DateTime;
use voku\helper\AntiXSS;

class Authentification
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

    private function registerUser($nom, $prenom, $title, $email, $password, $username, $birthdate, $tableName, $additionalParams = []) {
        // XSS clean all input variables
        list($nom, $prenom, $title, $email, $password, $username, $birthdate) = $this->antiXss->xss_clean([$nom, $prenom, $title, $email, $password, $username, $birthdate]);

        // Validate password complexity
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\s]).{8,}$/', $password)) {
            return false; // Password does not meet complexity requirements
        }

        // Generate UUID
        $uuid = uniqid();

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $date = DateTime::createFromFormat('d/m/Y', $birthdate);

        // Format DateTime object to SQL date format
        $sqlDate = $date->format('Y-m-d');

        // Prepare SQL query
        $query = "INSERT INTO $tableName (uuid, lastname, firstname, title, email, hashed_password, username, birthdate";
        $values = "VALUES (:uuid, :lastname, :firstname, :title, :email, :hashed_password, :username, :birthdate";
        $params = [
            ':uuid' => $uuid,
            ':firstname' => $prenom,
            ':lastname' => $nom,
            ':title' => $title,
            ':email' => $email,
            ':username' => $username,
            ':birthdate' => $sqlDate,
            ':hashed_password' => $hashedPassword
        ];

        // Add additional parameters if any
        foreach ($additionalParams as $key => $value) {
            $query .= ", $key";
            $values .= ", :$key";
            $params[":$key"] = $value;
        }

        $query .= ") $values)";

        // Execute the query
        $insertSuccess = $this->db->executeQuery($query, $params);

        if ($insertSuccess === false) {
            return false; // Failed to insert into database
        }

        // Attempt login
        return $this->login($email, $password, $tableName);
    }

    public function registerBO($nom, $prenom, $title, $email, $password, $username, $birthdate, $phone_number, $identity_verified = true) {
        $additionalParams = [
            'phone_number' => $phone_number,
            'identity_verified' => $identity_verified
        ];

        return $this->registerUser($nom, $prenom, $title, $email, $password, $username, $birthdate, 'proprietaire', $additionalParams);
    }

    public function register($nom, $prenom, $title, $email, $password, $username, $birthdate) {
        return $this->registerUser($nom, $prenom, $title, $email, $password, $username, $birthdate, 'client');
    }

    public function login($email, $password, $table)
    {
        // XSS clean email and password
        $email = $this->antiXss->xss_clean($email);
        $password = $this->antiXss->xss_clean($password);

        // Retrieve user based on the provided email
        $query = "SELECT uuid, hashed_password FROM $table WHERE email = :email";
        $params = [':email' => $email];
        $users = $this->db->executeQuery($query, $params);

        if (!empty($users)) {
            $user = $users[0]; // Get the first user

            // Verify the provided password against the hashed password in the database
            if (password_verify($password, $user['hashed_password'])) {
                // Start session if not already started
                if(session_status() == PHP_SESSION_NONE)
                    session_start();
                // Store user data in session using sessionID as key
                unset($user['hashed_password']); // Remove password from user data
                if($table == 'client') {
                    $_SESSION["sessionID"] = $user['uuid'];
                } else {
                    $_SESSION["sessionIDBO"] = $user['uuid'];
                }
                return $user;
            }
        }

        return false;
    }

    public function redirectToLoginOnLoad($continue = false, $isBackOffice = false)
    {
        $currentUrl = urlencode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
        $registerLink = 'connection.php?redirect=' . $currentUrl;
        if($continue)
            $registerLink .= "&continue=" . $continue;
        if($isBackOffice)
            $registerLink .= "&backoffice=" . $isBackOffice;
        header("Location: $registerLink");
    }

    public function redirectToRegister($overideUrl = null, $continue = false, $isBackOffice = false)
    {
        $currentUrl = $overideUrl ? urlencode($overideUrl) : urlencode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
        $string = 'inscription.php?redirect=' . $currentUrl;
        if($continue)
            $string = $string . "&continue=" . $continue;
        if($isBackOffice)
            return $string . "&backoffice=" . $isBackOffice;
        return $string;
    }

    public function redirectToLogin($overideUrl = null, $continue = false, $isBackOffice = false)
    {
        $currentUrl = $overideUrl ? urlencode($overideUrl) : urlencode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
        $string = 'connection.php?redirect=' . $currentUrl;
        if($continue)
            $string = $string . "&continue=" . $continue;
        if($isBackOffice)
            return $string . "&backoffice=" . $isBackOffice;
        return $string;
    }

    public function isEmailAvailable($email): bool
    {
        // Check if the email is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Invalid email format
            return false;
        }

        // Query to check if the email is already registered
        $query = "SELECT COUNT(*) as count FROM client WHERE email = :email";
        $params = [':email' => $email];

        // Execute the query
        $result = $this->db->executeQuery($query, $params);

        // If there's an error executing the query, return false
        if ($result === false) {
            return false;
        }

        // Extract the count from the result
        $count = $result[0]['count'];

        // Return true if count is 0 (email is available), false otherwise
        return ($count == 0);
    }

    public function isUsernameAvailable($username, $isBackOffice = false): bool
    {
        // Query to check if the email is already registered
        $table = $isBackOffice ? 'proprietaire' : 'client';
        $query = "SELECT COUNT(*) as count FROM $table WHERE username = :username";
        $params = [':username' => $username];

        // Execute the query
        $result = $this->db->executeQuery($query, $params);

        // If there's an error executing the query, return false
        if ($result === false) {
            return false;
        }

        // Extract the count from the result
        $count = $result[0]['count'];

        // Return true if count is 0 (username is available), false otherwise
        return ($count == 0);
    }

    public function getUserData() {
        // Check if sessionID is set
        if (!isset($_SESSION["sessionID"])) {
            // User is not logged in, return null
            return null;
        }

        // Return user data stored in session
        $query = "SELECT uuid, email, title, username, birthdate, firstname, lastname, avatar, billing_address1, billing_address2, created_at, updated_at FROM client WHERE uuid = :uuid";
        $params = [':uuid' => $_SESSION["sessionID"]];
        $users = $this->db->executeQuery($query, $params);

        // Return the first user if found, otherwise return null
        return !empty($users) ? $users[0] : null;
    }

    public function getUserDataBackOffice() {
        if (!isset($_SESSION["sessionIDBO"])) {
            // User is not logged in, return null
            return null;
        }

        // Return user data stored in session
        $query = "SELECT uuid, email, title, username, birthdate, firstname, lastname, avatar, address1, phone_number, address2, identity_card, identity_verified, iban, cancellation_deadline, bank_account_holder, created_at, updated_at FROM proprietaire WHERE uuid = :uuid";
        $params = [':uuid' => $_SESSION["sessionIDBO"]];
        $users = $this->db->executeQuery($query, $params);

        // Return the first user if found, otherwise return null
        return !empty($users) ? $users[0] : null;
    }

    public function logout($isBackOffice = false): void
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if($isBackOffice) {
            unset($_SESSION["sessionIDBO"]);
        } else {
            unset($_SESSION["sessionID"]);
        }
    }

    public function getRequestResultLogin($post, $isBackOffice = false): string
    {
        if (!isset($post['email'], $post['password'])) {
            return "Tous les champs sont requis.<br>";
        }

        if (!$this->connection) {
            return "Erreur interne du serveur<br>";
        }

        $table = $isBackOffice ? 'proprietaire' : 'client';

        $req = $this->login($post['email'], $post['password'], $table);
        if ($req === false) {
            return "Mot de passe ou email invalide.<br>";
        }

        return "";
    }

    public function getRequestResultSignUp($post, $isBackOffice): string
    {
        // Check if any required field is missing
        if (!isset($post['firstname'], $post['email'], $post['lastname'], $post['username'], $post['birthdate'], $post['password'], $post['title'])) {
            return "Tous les champs sont requis.<br>";
        }

        if ($isBackOffice) {
            if (!isset($post['phone_number'])) {
                return "Tous les champs sont requis.<br>";
            }
        }

        // Check if connection is established
        if (!$this->connection) {
            return "Erreur interne du serveur<br>";
        }

        // Check if email is available
        if (!$this->isEmailAvailable($post['email'])) {
            return "Email déjà utilisé.<br>";
        }

        if (!$this->isUsernameAvailable($post['username'])) {
            return "Pseudo déjà utilisé.<br>";
        }

        // Register the user
        if($isBackOffice) {
            $req = $this->registerBO($post['lastname'], $post['firstname'], $post['title'], $post['email'], $post['password'], $post['username'], $post['birthdate'], $post['phone_number']);
        } else {
            $req = $this->register($post['lastname'], $post['firstname'], $post['title'], $post['email'], $post['password'], $post['username'], $post['birthdate']);
        }

        if ($req === false) {
            return "Echec de l'inscription<br>";
        }

        return "";
    }
}