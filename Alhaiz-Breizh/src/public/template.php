<?php
// Required !
require '../php/Tools/Bootstrap.php';

use Classes\Database;

// If you need the DB here is how you can do a request
// We do the getInstance/getConnection only once
$db = Database::getInstance();
$connection = $db->getConnection();
// Example of a query
//$query = "INSERT INTO users (name, email) VALUES (:name, :email)";
// Example of parameters (:argName => value)
/*
$params = [
    ':name' => 'John Doe',
    ':email' => 'jhon.gmail.com'
];
*/

// For insert execute the query
//print_r($db->executeQuery($query, $params));
$userData = $auth->getUserData();

print_r($userData);
// If user need to be connected for this page
/*
if($userData === null){
    $auth->redirectToLoginOnLoad();
}
*/
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template</title>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="<?php echo $auth->redirectToLogin() ?>">Login</a></li>
            </ul>
        </nav>
    </header>
</body>

</html>