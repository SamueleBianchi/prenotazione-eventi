<?php

require '../Database/connect.php';
require dirname(__FILE__).'/../Filtro/filtro.php';

$IdEvento = filtra($_POST['id_evento']);
$nome_evento = filtra($_POST['denominazione2']);
$modifica =  "UPDATE eventi SET denominazione = '".$nome_evento."' WHERE IDEvento = $IdEvento";
//echo $modifica;
$num = $connessione->exec($modifica);
//echo $num;
if($num == 1){
    echo '<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok"></span> Evento modificato con successo</div>';
}else{
    echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove"></span> Errore durante la modifica dell\'evento : potrebbe essere stato eliminato o la modifica non ha apportato alcun effetto</div>';
}