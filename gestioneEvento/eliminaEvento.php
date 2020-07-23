<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require '../Database/connect.php';
require dirname(__FILE__).'/../Filtro/filtro.php';

$IdEvento = filtra($_POST['id_evento']);
$elimina =  "DELETE FROM eventi WHERE IDEvento = '".$IdEvento."'";
$num = $connessione->exec($elimina);
if($num == 1){
    echo '<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok"></span> Evento eliminato con successo</div>';
}else{
    echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove"></span> Errore nell\'eliminazione dell\'evento</div>';
}


