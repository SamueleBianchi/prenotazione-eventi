<?php

    require '../Database/connect.php';
    require dirname(__FILE__).'/../Filtro/filtro.php';
    session_start();

    $IDEvento = $_GET['id'];
    $iscrizioni = "SELECT max_iscritti, iscritti FROM Eventi WHERE IDEvento = $IDEvento";
    $risultato = $connessione->query($iscrizioni);
    $num = $risultato->rowCount();
    if($num != 1){
    echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove"></span> Errore : l\'evento potrebbe non essere più disponibile.</div>';
    }else{
    while($riga = $risultato->fetch(PDO::FETCH_ASSOC)){
        if($riga['iscritti'] == $riga['max_iscritti']){
             echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove"></span> Siamo spiacenti: l\'evento non ha più posti disponibili!';
        }else{
            if(ricerca_prenotazione($IDEvento, $connessione) == 1){
            $data_prenotazione = date("d/m/Y h:i:s");
            $prossimo_iscritto = $riga['iscritti']+1;
            $prenotazione = "INSERT INTO prenotazioni(CodEvento, CodUtente, numero_iscr, data_iscr) VALUES ($IDEvento, ".$_SESSION['IDUtente'].",".$prossimo_iscritto.",'".$data_prenotazione."')";        
            $out = $connessione->query($prenotazione);
            $num2 = $out->rowCount();
                if($num2 == 0){
                    echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove"></span> Errore durante la prenotazione: impossibile prenotare.</div>';
                }else{
                    update_iscritti($prossimo_iscritto, $IDEvento, $connessione);
                    info_pren($connessione, $IDEvento, $prossimo_iscritto, $data_prenotazione, $riga);
                }
            }
        }
    }
}


function update_iscritti($prossimo_iscritto, $IDEvento, $connessione){
    $update = "UPDATE Eventi SET iscritti = ".$prossimo_iscritto.' WHERE IDEvento ='.$IDEvento;
    $connessione->exec($update);
}

function ricerca_prenotazione($IDEvento, $connessione){
    $ricerca = "SELECT * FROM prenotazioni WHERE CodEvento = $IDEvento AND CodUtente = ".$_SESSION['IDUtente'];
    $out = $connessione->query($ricerca);
    $num = $out->rowCount();
    if($num != 0){
        echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove"></span> Impossibile prenotare: prenotazione già effettuata per questo evento</div>';
        return 0; 
    }
    return 1;
}

function info_pren($connessione, $IDEvento, $prossimo_iscritto, $data_prenotazione, $riga){
    echo '<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok"></span> Prenotazione effettuata con successo <br><br>'
         . '<strong>Numero prenotione : </strong>'.$prossimo_iscritto.'/'.$riga['max_iscritti'].'<br>'
         .'<strong>Data e ora di prenotazione : </strong>'.$data_prenotazione.'<br><br>';
    $evento = "SELECT * FROM eventi WHERE IDEvento = $IDEvento";
    $out = $connessione->query($evento);
    $num = $out->rowCount();
    if($num != 0){
        while($riga2 = $out->fetch(PDO::FETCH_ASSOC)){
        echo '<strong>Nome evento: </strong>'.$riga2['denominazione'].'<br>';
        echo '<strong>Categoria: </strong>'.$riga2['tipologia'].'<br>';
        echo '<strong>Data inizio: </strong>'.$riga2['data_inizio'].'<br>';
        echo '<strong>Data fine: </strong>'.$riga2['data_fine'].'<br>';
        echo '<strong>Via: </strong>'.$riga2['via'].'<br>';
        echo '<strong>Provincia: </strong>'.$riga2['provincia'].'<br>';
        echo '<strong>Prezzo: </strong>'.$riga2['prezzo'].'<br>';
        echo '<strong>Descrizione: </strong>'.$riga2['descrizione'].'<br>';
        }
    }
    echo '</div>'; 
}