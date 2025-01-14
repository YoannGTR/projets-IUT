<?php
require '../php/Tools/Bootstrap.php';
use Classes\Logement;
use Classes\State;

$logement = new Logement();
$etat = $logement->getEtat($_POST['id']);
if(isset($_POST["state"])){
    if($_POST["state"]===State::ONLINE->name){
        $logement->setHorsLigne($_POST['id']);
        echo "ID: ".$_POST['id']." est hors ligne";
    }else if($_POST["state"]===State::OFFLINE->name){
        $logement->setEnLigne($_POST['id']);
        echo "ID: ".$_POST['id']." est en ligne";
    }
}
        
