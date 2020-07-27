<?php
require '../Database/connect.php';
require dirname(__FILE__).'/../Filtro/filtro.php';

$nome_evento = filtra($_POST['evento']);

$ricerca = "SELECT * FROM eventi WHERE denominazione = '".$nome_evento."'";
$risultato = $connessione->query($ricerca);
$num = $risultato->rowCount();
if($num == 0){
    echo '<div class="alert alert-danger" role="alert">Errore : non esiste alcun evento denominato '.$nome_evento.'.</div>';
}else{
    while($riga = $risultato->fetch(PDO::FETCH_ASSOC)){
        echo '<img src="http://chart.apis.google.com/chart?cht=qr&chs=150x150&chl=id='.$riga['IDEvento'].'">';
        echo '<p><h1 style="font-size:20px;">'.$riga['denominazione'].'</h1><br>';
        echo '<strong>Nome evento: </strong>'.$riga['denominazione'].'<br>';
        echo '<strong>Categoria: </strong>'.$riga['tipologia'].'<br>';
        echo '<strong>Data inizio: </strong>'.$riga['data_inizio'].'<br>';
        echo '<strong>Data fine: </strong>'.$riga['data_fine'].'<br>';
        echo '<strong>Via: </strong>'.$riga['via'].'<br>';
        echo '<strong>Provincia: </strong>'.$riga['provincia'].'<br>';
        echo '<strong>Iscritti: </strong>'.$riga['iscritti'].'<br>';
        echo '<strong>Numero massimo di iscritti: </strong>'.$riga['max_iscritti'].'<br>';
        echo '<strong>Prezzo: </strong>'.$riga['prezzo'].'<br>';
        echo '<strong>Descrizione: </strong>'.$riga['descrizione'].'<br>';
        echo '<strong>Sito di riferimento: </strong><a href="'.$riga['sito'].'">'.$riga['sito'].'</a><br>';
        echo '<strong>Recapito: </strong>'.$riga['recapito'].'<br><br>';
    }
}