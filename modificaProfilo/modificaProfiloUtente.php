<?php
include '../classi/Utente.php';
session_start(); 
$oggetto = unserialize($_SESSION['oggetto']);
$oggetto->modificaProfilo();
