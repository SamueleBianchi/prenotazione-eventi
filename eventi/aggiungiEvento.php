<?php

require '../Database/connect.php';
require dirname(__FILE__).'/../Filtro/filtro.php';

$nome = filtra($_POST['denominazione']);
$citta = filtra($_POST['città']);
$tipologia = filtra($_POST['tipologia']);
$via = filtra($_POST['via']);
$data_inizio = filtra($_POST['datainizio']);
$data_fine = filtra($_POST['datafine']);
$max_iscritti = filtra($_POST['maxiscritti']);
$prezzo = filtra($_POST['prezzo']);
$sito = filtra($_POST['sito']);
$recapito = filtra($_POST['recapito']);
$provincia = filtra($_POST['provincia']);
$descrizione = filtra($_POST['descrizione']);
$iscritti = 0;

$aggiungi_evento = $connessione->prepare("INSERT INTO eventi (denominazione, provincia, via, tipologia, descrizione, data_inizio, data_fine, iscritti, max_iscritti, prezzo, sito, recapito) VALUES (:denominazione, :provincia, :via, :tipologia, :descrizione, :data_inizio, :data_fine, :iscritti, :max_iscritti, :prezzo, :sito, :recapito)");
$aggiungi_evento->bindParam(':denominazione', $nome, PDO::PARAM_INT, 32);
$aggiungi_evento->bindParam(':provincia', $provincia, PDO::PARAM_STR, 32);
$aggiungi_evento->bindParam(':via', $via, PDO::PARAM_STR, 32);
$aggiungi_evento->bindParam(':tipologia', $tipologia, PDO::PARAM_STR, 32);
$aggiungi_evento->bindParam(':descrizione', $descrizione, PDO::PARAM_STR, 64);
$aggiungi_evento->bindParam(':data_inizio', $data_inizio, PDO::PARAM_STR, 6);
$aggiungi_evento->bindParam(':data_fine', $data_fine, PDO::PARAM_INT, 6);
$aggiungi_evento->bindParam(':iscritti', $iscritti, PDO::PARAM_INT, 10);
$aggiungi_evento->bindParam(':max_iscritti', $max_iscritti, PDO::PARAM_INT, 10);
$aggiungi_evento->bindParam(':prezzo', $prezzo, PDO::PARAM_STR, 32);
$aggiungi_evento->bindParam(':sito', $sito, PDO::PARAM_STR, 32);
$aggiungi_evento->bindParam(':recapito', $recapito, PDO::PARAM_STR, 16);
try{
$aggiungi_evento->execute();
   $html = '<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok"></span> Evento aggiunto al database</div>';
    echo($html);
            } catch (Exception $ex) {
                $html = '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove"></span> Errore duarente l\'inserimento dell\'evento</div>';
                echo($html);
                //echo $ex->getMessage();
            }

 
