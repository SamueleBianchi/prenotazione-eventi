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
    $utente = new Utente("", "", $email_form, $password_form);
}else{
    $utente = new Admin("", "", $email_form, $password_form, $id_admin);
}
$numero_righe = $utente->accedi($is_admin, $id_admin);
