<?php

include '../Classi/Utente.php';
require_once dirname(__FILE__).'/../Filtro/filtro.php';

session_start(); 
$oggetto = unserialize($_SESSION['oggetto']);
$oggetto->annullaPrenotazione(filtra($_POST['IdEvento']), filtra($_POST['denominazione']));

