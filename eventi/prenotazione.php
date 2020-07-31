<?php
    include '../Classi/Utente.php';
    session_start();

    $IDEvento = $_GET['id'];
    $oggetto = unserialize($_SESSION['oggetto']);
    $oggetto->prenota($IDEvento);


