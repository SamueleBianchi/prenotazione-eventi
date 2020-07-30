<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../Database/connect.php';
require_once dirname(__FILE__).'/../Filtro/filtro.php';
include '../Classi/Admin.php';

$IdEvento = filtra($_POST['id_evento']);
session_start(); 
$oggetto = unserialize($_SESSION['oggetto']);
$oggetto->eliminaEvento($IdEvento);




