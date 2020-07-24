<?php

require '../Database/connect.php';
require dirname(__FILE__).'/../Filtro/filtro.php';

$IdEvento = filtra($_POST['id_evento']);
$nome_evento = filtra($_POST['denominazione2']);
$tipologia = filtra($_POST['tipologia2']);
$via = filtra($_POST['via2']);
$data_inizio = filtra($_POST['datainizio2']);
$data_fine = filtra($_POST['datafine2']);
$max_iscritti = filtra($_POST['maxiscritti2']);
$prezzo = filtra($_POST['prezzo2']);
$sito = filtra($_POST['sito2']);
$recapito = filtra($_POST['recapito2']);
$provincia = filtra($_POST['provincia2']);
$descrizione = filtra($_POST['descrizione2']);
$modifica =  "UPDATE eventi SET denominazione = '".$nome_evento."', provincia = '".$provincia."', via = '".$via."', tipologia = '".$tipologia."', descrizione = '".$descrizione."', data_inizio = '".$data_inizio."', data_fine = '".$data_fine."', max_iscritti = '".$max_iscritti."', prezzo = '".$prezzo."', sito = '".$sito."', recapito = '".$recapito."' WHERE IDEvento = $IdEvento";
//echo $modifica;
$num = $connessione->exec($modifica);
//echo $num;

if($num == 1 && is_numeric($max_iscritti)){
    echo '<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok"></span> Evento modificato con successo</div>';
}else{
    echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove"></span> Errore durante la modifica dell\'evento : potrebbe essere stato eliminato o la modifica non ha apportato alcun effetto. Riprovare</div>';
}