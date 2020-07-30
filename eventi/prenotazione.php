<?php
    include '../Classi/Utente.php';
//    require '../Database/connect.php';
//    require dirname(__FILE__).'/../Filtro/filtro.php';
    session_start();

    $IDEvento = $_GET['id'];
    $oggetto = unserialize($_SESSION['oggetto']);
    $oggetto->prenota($IDEvento);


