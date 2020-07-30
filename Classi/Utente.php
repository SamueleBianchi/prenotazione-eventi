<?php

require_once 'UtenteGenerico.php';

class Utente extends UtenteGenerico{
    
    private $IdUtente = "";

    public function __construct($nome, $cognome, $email, $password, $IdUtente) {
        parent::__construct($nome, $cognome, $email, $password);
        $this->IdUtente = $IdUtente;
    }
    
    public function getIdUtente() {
        return $this->IdUtente;
    }
    
    public function setIdUtente($IdUtente) {
        $this->IdUtente = $IdUtente;
    }
    
    public function accedi() {
        require '../Database/connect.php';
        $query = "SELECT * FROM utenti WHERE email = '".$this->getEmail()."' AND pwd = MD5('".$this->getPassword()."')";
        $risultato = $connessione->query($query);
        $numero_righe = $risultato->rowCount();
        
        if($numero_righe == 1){
            session_start();
            foreach ($connessione->query($query) as $row) {
                $this->setNome($row['nome']);
                $this->setCognome($row['cognome']);
                $this->setPassword($row['pwd']);
                $this->setIdUtente($row['IDUtente']);
            }
            
            $_SESSION['email'] = $this->getEmail();
            $_SESSION['nome'] = $this->getNome();
            $_SESSION['cognome'] = $this->getCognome();
            $_SESSION['IDUtente'] = $this->getIdUtente();
            $_SESSION['oggetto'] = serialize($this);
            header("Location: ../index.php");   
        } else {
            $this->stampa_errore("Email o password errati");
        }
    }
    
    public function modificaProfilo(){
        require '../Database/connect.php';
        require dirname(__FILE__).'/../Filtro/filtro.php';  

        $nuovoNome = filtra($_POST['nome']);
        $nuovoCognome = filtra($_POST['cognome']);
        $nuovaEmail = filtra($_POST['email']);
        $vecchiaPassword = filtra($_POST['pwd']);
        $nuovaPassword = filtra($_POST['pwd2']);
        $nuovaPassword2 = filtra($_POST['pwd3']);

        $message = "";
        $message2 = "";
        $session_id = $_SESSION['IDUtente'];

        $query="SELECT * FROM utenti WHERE IDUtente = $session_id AND pwd = MD5('".$vecchiaPassword."')";
        $risultato = $connessione->query($query);
        $num = $risultato->rowCount();
        if($num == 0){
            $message = $message."La password attuale inserita non è corretta.";
        }
        if(strcmp($nuovaPassword,$nuovaPassword2)){
            $message2 = $message2."Le due password non sono uguali.";
        }

        if(strcmp($message, "") || strcmp($message2, "")){
           echo '<div class="alert alert-danger" role="alert">';
           if(strcmp($message, "")){
                   echo '<span class="glyphicon glyphicon-remove"></span> '.$message.'<br>';       
           }
           if(strcmp($message2, "")){
                   echo '<span class="glyphicon glyphicon-remove"></span> '.$message2;       
           }
           echo '</div>';
        }else{
            $query2 = "UPDATE utenti SET nome = '".$nuovoNome."', cognome = '".$nuovoCognome."',email = '".$nuovaEmail."',pwd = MD5('".$nuovaPassword."') WHERE IDUtente = $session_id";
            $connessione->exec($query2);
            $_SESSION['nome']= $nuovoNome;
            $_SESSION['cognome']=$nuovoCognome;
            $_SESSION['email']=$nuovaEmail;
           echo '<div class="alert alert-success" role="alert">';
           echo '<span class="glyphicon glyphicon-ok"></span> Profilo aggiornato con successo';       
           echo '</div>';
        }
            }
            
       public function cercaEvento(){
            require_once '../Database/connect.php';
            require_once dirname(__FILE__).'/../Filtro/filtro.php';

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
       }
       
    private function update_iscritti($prossimo_iscritto, $IDEvento, $connessione){
        $update = "UPDATE eventi SET iscritti = ".$prossimo_iscritto.' WHERE IDEvento ='.$IDEvento;
        $connessione->exec($update);
    }

    private function ricerca_prenotazione($IDEvento, $connessione){
        $ricerca = "SELECT * FROM prenotazioni WHERE CodEvento = $IDEvento AND CodUtente = ".$_SESSION['IDUtente'];
        $out = $connessione->query($ricerca);
        $num = $out->rowCount();
        echo $num;
        if($num != 0){
            echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove"></span>Impossibile prenotare: prenotazione già effettuata per questo evento</div>';
            return 0; 
        }
            return 1;
    }

    private function info_pren($connessione,$IDEvento, $prossimo_iscritto, $data_prenotazione, $riga){
        require_once '../Database/connect.php';
        require_once dirname(__FILE__).'/../Filtro/filtro.php';
        echo '<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok"></span> Prenotazione effettuata con successo <br><br>'
             . '<strong>Numero prenotazione : </strong>'.$prossimo_iscritto.'/'.$riga['max_iscritti'].'<br>'
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
    
       
    public function prenota($IDEvento) {
        require '../Database/connect.php';

        $iscrizioni = "SELECT max_iscritti, iscritti FROM eventi WHERE IDEvento = $IDEvento";
        $risultato = $connessione->query($iscrizioni);
        $num = $risultato->rowCount();
        if($num != 1){
        echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove"></span> Errore : l\'evento potrebbe non essere più disponibile.</div>';
        }else{
            $riga = $risultato->fetch(PDO::FETCH_ASSOC);
            if($riga['iscritti'] == $riga['max_iscritti']){
                 echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove"></span> Siamo spiacenti: l\'evento non ha più posti disponibili!';
            }else{
                if($this->ricerca_prenotazione($IDEvento, $connessione) === 1){
                    $data_prenotazione = date("d/m/Y h:i:s");
                    $prossimo_iscritto = $riga['iscritti']+1;
                    $prenotazione = "INSERT INTO prenotazioni(CodEvento, CodUtente, numero_iscr, data_iscr) VALUES ($IDEvento, ".$_SESSION['IDUtente'].",".$prossimo_iscritto.",'".$data_prenotazione."')";        
                    $out = $connessione->exec($prenotazione);
                    
                    $this->update_iscritti($prossimo_iscritto, $IDEvento, $connessione);
                    $this->info_pren($connessione, $IDEvento, $prossimo_iscritto, $data_prenotazione, $riga);
                        
                    }
            }
        }
    }

    public function getEventiPrenotati(){
        require '../Database/connect.php';
        //$iscrizioni = "SELECT * FROM ((eventi, prenotazioni INNER JOIN Utenti ON utenti.IDUtente = prenotazioni.CodUtente) INNER JOIN eventi ON eventi.IDEvento = prenotazioni.CodPrenotazione ) WHERE utenti.IDUtente = ".$this->getIdUtente();;
        $query = "SELECT * FROM eventi, prenotazioni, utenti WHERE utenti.IDUtente = ".$this->getIdUtente()." AND utenti.IDUtente = prenotazioni.CodUtente AND eventi.IDEvento = prenotazioni.CodEvento";
        $risultato = $connessione->query($query);
        $num = $risultato->rowCount();
        if($num == 0){
            echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove"></span> Non hai eventi prenotati</div>';
        }else{
                echo '<h1 style="font-size: 20px;">I miei eventi</h1><br>';
            while($riga = $risultato->fetch(PDO::FETCH_ASSOC)){ 
                echo '<form id="evento_pren" name="evento_pren">';
                echo '<strong>Nome evento: </strong><input style="border: 0;" type="text" id="denominazione" name="denominazione" value="'.$riga['denominazione'].'" readonly="readonly" /><input style="display: none;" id="IdEvento" name="IdEvento" type="text" value="'.$riga['IDEvento'].'" /><br>';
                echo '<strong>Categoria: </strong>'.$riga['tipologia'].'<br>';
                echo '<strong>Data inizio: </strong>'.$riga['data_inizio'].'<br>';
                echo '<strong>Data fine: </strong>'.$riga['data_fine'].'<br>';
                echo '<strong>Via: </strong>'.$riga['via'].'<br>';
                echo '<strong>Provincia: </strong>'.$riga['provincia'].'<br>';
                echo '<strong>Prezzo: </strong>'.$riga['prezzo'].'<br>';
                echo '<strong>Descrizione: </strong>'.$riga['descrizione'].'<br>';
                echo '<strong>Numero iscrizione: </strong>'.$riga['numero_iscr'].'<br><br>'
                        . '<div class="form-group">
                            <button id="annulla_pren" type="submit" name="annulla_pren" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Annulla prenotazione</button> 
                            </form></div>';
            }
        }
    }
    
    public function annullaPrenotazione($IdEvento, $denominazione){
        require '../Database/connect.php';
        $numero_iscrizione = "SELECT numero_iscr FROM prenotazioni WHERE CodUtente = ".$this->getIdUtente()." AND CodEvento = $IdEvento";
        $risultato = $connessione->query($numero_iscrizione);
        $num = $risultato->rowCount();
        if($num != 0){
            while($riga = $risultato->fetch(PDO::FETCH_ASSOC)){ 
                $query = "DELETE FROM prenotazioni WHERE prenotazioni.CodUtente = ".$this->getIdUtente()." AND CodEvento = $IdEvento";
                $out = $connessione->query($query);
                $query2 = "UPDATE eventi SET iscritti = iscritti - 1 WHERE IDEvento = $IdEvento";
                $out1 = $connessione->query($query2);
                $query3 = "UPDATE prenotazioni SET numero_iscr = numero_iscr - 1 WHERE numero_iscr > ".$riga['numero_iscr']." AND CodEvento = $IdEvento";
                $out2 = $connessione->query($query3);
                echo 'fatto';
            }
        }   
        }
}
