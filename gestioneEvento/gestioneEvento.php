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
    echo '<form enctype="multipart/form-data" action="./modificaEvento/modificaEvento.php" method="POST">'
    .'<input type="text" id="id_evento" name="id_evento" style="display:none;" value='.$riga['IDEvento'].'></input>'
    .'<div class="container">'
    .'<div class="form-group">
                    <label for="denominazione2">Denominazione:</label>
                    <input style="width: 50%;" class="form-control" name="denominazione2" id="denominazione2" value="'.$riga['denominazione'].'"></input>
                </div>
         <div class="form-group">
                    <button name="modifica_bottone" id="modifica_bottone" type="submit" class="btn btn-warning"><i class="icon-hand-right"></i>Modifica</button> 
                    <button name="modifica_bottone" id="elimina_bottone" type="submit" class="btn btn-danger"><i class="icon-hand-right"></i>Elimina</button> 
                </div>
    </form>';
     
     }
}
    
