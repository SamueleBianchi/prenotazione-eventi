<?php
include '../Classi/Utente.php';
session_start(); 
$oggetto = unserialize($_SESSION['oggetto']);
$oggetto->modificaProfilo();
