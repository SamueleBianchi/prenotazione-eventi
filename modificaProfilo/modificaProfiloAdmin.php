<?php

include '../Classi/Admin.php';
session_start(); 
$oggetto = unserialize($_SESSION['oggetto']);
$oggetto->modificaProfilo();

