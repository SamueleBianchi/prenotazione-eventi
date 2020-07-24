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
    echo '<form enctype="multipart/form-data" action="./gestioneEvento/modificaEvento" method="POST">'
    .'<input type="text" id="id_evento" name="id_evento" style="display:none;" value='.$riga['IDEvento'].'></input>'
    .'<div class="container">'
        .'<div class="form-group">
                    <label for="denominazione2">Denominazione:</label>
                    <input style="width: 50%;" class="form-control" name="denominazione2" id="denominazione2" value="'.$riga['denominazione'].'">
          </div>
        
          <div class="form-group">
            <label for="città2">Città:</label>
            <input style="width: 50%;" class="form-control" name="provincia2" id="provincia2" value="'.$riga['provincia'].'" required="true">
          </div>
          <script> document.getElementById("tipologia2").value = "'.$riga['tipologia'].'"; </script>
            <div class="form-group">
                <label for="tipologia2">Tipologia:</label>
                <select class="form-control" value="'.$riga['tipologia'].'" name="tipologia2" id="tipologia2" style="width: 50%;">
                  <option value="Manifestazione">Manifestazione</option>
                  <option value="Incontro">Incontro</option>
                  <option value="Concerto">Concerto</option>
                  <option value="Mostra">Mostra</option>
                  <option value="Sagra">Sagra</option>
                  <option value="Teatro">Teatro</option>
                  <option value="Fiera">Fiera</option>
                  <option value="Cibo e vino">Cibo e vino</option>
                  <option value="Disco e feste">Disco e feste</option>
                  <option value="Cinema">Cinema</option>
                  <option value="Sport">Sport</option>
                  <option value="Inaugurazione">Inaugurazione</option>
                  <option value="Mercatino">Mercatino</option>
                  <option value="Escursione">Escursione</option>
                  <option value="Promozione">Promozione</option>
                  <option value="Corso">Corso</option>
                  <option value="Hobby">Hobby</option>
                  <option value="Turismo">Turismo</option>
                </select>
          </div> 

        <div class="form-group">
            <label for="via2">Via:</label>
            <input style="width: 50%;" type="text" class="form-control"  name="via2" id="via2" value="'.$riga['via'].'" required="true" >
        </div>

        <div class="container">
        <div class="row">

                <div class="form-group">
                <label for="dtpickerinizio">Data e ora inizio evento:</label>
                    <div class=\'col-sm-4 input-group date\' id=\'dtpickerinizio\'>
                        <input type=\'text\' class="form-control" id="datainizio2" name="datainizio2" required="true" value="'.$riga['data_inizio'].'"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            <script type="text/javascript">
                $(function () {
                    $(\'#dtpickerinizio\').datetimepicker({
                        locale: \'it\'
                    });
                });
            </script>
        </div>
        </div> 

        <div class="container">
        <div class="row">

                <div class="form-group">
                <label for="dtpickerfine">Data e ora termine evento:</label>
                    <div class=\'col-sm-4 input-group date\' id=\'dtpickerfine\'>
                        <input type=\'text\' class="form-control" id="datafine2" name="datafine2" value="'.$riga['data_fine'].'" required="true"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            <script type="text/javascript">
                $(function () {
                    $(\'#dtpickerfine\').datetimepicker({
                        locale: \'it\'
                    });
                });
            </script>
        </div>
        </div>

        <div class="form-group">
            <label for="maxiscritti2">Numero massimo di iscritti:</label>
            <input style="width: 50%;" type="number" class="form-control" name="maxiscritti2" id="maxiscritti2" value="'.$riga['max_iscritti'].'" required="true">
        </div>

        <div class="form-group">
            <label for="prezzo2">Prezzo:</label>
            <input style="width: 50%;" class="form-control" name="prezzo2" id="prezzo2" value="'.$riga['prezzo'].'" required="true">
        </div>

        <div class="form-group">
            <label for="sito2">Sito:</label>
            <input style="width: 50%;" class="form-control" name="sito2" id="sito2" value="'.$riga['sito'].'" required="true">
        </div>

        <div class="form-group">
            <label for="recapito2">Recapito:</label>
            <input style="width: 50%;" class="form-control" name="recapito2" id="recapito2" value="'.$riga['recapito'].'"required="true">
        </div>

        <div class="form-group">
            <label for="descrizione2">Descrizione:</label>
            <textarea class="form-control" rows="5" name="descrizione2" id="descrizione2">'.$riga['descrizione'].'</textarea>
        </div>
        
        <div class="form-group">
                    <button name="modifica_bottone" id="modifica_bottone" type="submit" class="btn btn-primary"><i class="icon-hand-right"></i>Modifica</button> 
                    <button name="modifica_bottone" id="elimina_bottone" type="submit" class="btn btn-danger"><i class="icon-hand-right"></i>Elimina</button> 
        </div>
    </div>
    </form>
   ';
     
     }
}
    
