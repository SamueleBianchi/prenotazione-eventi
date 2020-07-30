<?php

require_once "../Database/connect.php";
require dirname(__FILE__).'/../Filtro/filtro.php'; 
require_once '../Classi/Utente.php';
require_once '../Classi/Admin.php';

$is_admin = 0;
if(!isset($_POST["id"]) || trim($_POST["id"]) == ''){

}else{
    $is_admin = 1;
    $id_admin = $_POST["id"];
}

$email_form= filtra($_POST["email"]);
$password_form=filtra($_POST["password"]);
$utente = null;

if($is_admin == 0){
    session_start();
    $utente = new Utente("", "", $email_form, $password_form, "");
    //$_SESSION['oggetto'] = serialize($utente);
}else{
    session_start();
    $utente = new Admin("", "", $email_form, $password_form, $id_admin);
    //$_SESSION['oggetto'] = serialize($utente);
}
$utente->accedi();


