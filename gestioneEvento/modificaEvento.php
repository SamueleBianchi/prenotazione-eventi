<?php

require_once '../Database/connect.php';
require_once dirname(__FILE__).'/../Filtro/filtro.php';
include '../Classi/Admin.php';

$IdEvento = filtra($_POST['id_evento']);
session_start(); 
$oggetto = unserialize($_SESSION['oggetto']);
$oggetto->modificaEvento($IdEvento);