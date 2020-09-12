<?php

require_once 'UtenteGenerico.php';

class Utente extends UtenteGenerico{
    
    private $IdUtente = ""; // id univoco dell'utente (non viene utilizzato dall'utente ma solo lato server)

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
                $this->setEmail($row['email']);
                $this->setCognome($row['cognome']);
                $this->setCf($row['cf']);
                $this->setPassword($row['pwd']);
                $this->setIdUtente($row['IDUtente']);
            }
            
            $_SESSION['email'] = $this->getEmail();
            $_SESSION['nome'] = $this->getNome();
            $_SESSION['cognome'] = $this->getCognome();
            $_SESSION['cf'] = $this->getCf();
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
        $nuovoCf = filtra($_POST['codicefiscale']);
        $vecchiaPassword = filtra($_POST['pwd']);
        $nuovaPassword = filtra($_POST['pwd2']);
        $nuovaPassword2 = filtra($_POST['pwd3']);

        $message_email = "";
        $message = "";
        $message2 = "";
        $session_id = $_SESSION['IDUtente'];
        $query_email = "SELECT email FROM utenti WHERE email ='".$nuovaEmail."' AND IDUtente != $session_id ";
        $risultato1 = $connessione->query($query_email);
        $count = $risultato1->rowCount();
        if($count == 1){
            $message_email = $message_email."L'email inserità è già utilizzata da un altro utente.";
        }
        $query="SELECT * FROM utenti WHERE IDUtente = $session_id AND pwd = MD5('".$vecchiaPassword."')";
        $risultato = $connessione->query($query);
        $num = $risultato->rowCount();
        if($num == 0){
            $message = $message."La password attuale inserita non è corretta.";
        }
        if(strcmp($nuovaPassword,$nuovaPassword2)){
            $message2 = $message2."Le due password non sono uguali.";
        }
        if(strlen($nuovaPassword) < 8 || strlen($nuovaPassword2) < 8){
            $message2 = $message2."La nuova password deve contenere almeno 8 caratteri";
        }

        if(strcmp($message, "") || strcmp($message2, "") || strcmp($message_email, "")){
           echo '<div class="alert alert-danger" role="alert">';
           if(strcmp($message_email, "")){
                   echo '<span class="glyphicon glyphicon-remove"></span> '.$message_email.'<br>';       
           }
           if(strcmp($message, "")){
                   echo '<span class="glyphicon glyphicon-remove"></span> '.$message.'<br>';       
           }
           if(strcmp($message2, "")){
                   echo '<span class="glyphicon glyphicon-remove"></span> '.$message2;       
           }
           echo '</div>';
        }else{
            $query2 = "UPDATE utenti SET nome = '".$nuovoNome."', cognome = '".$nuovoCognome."',cf = '".$nuovoCf."', email = '".$nuovaEmail."',pwd = MD5('".$nuovaPassword."') WHERE IDUtente = $session_id";
            $connessione->exec($query2);
            $_SESSION['nome']= $nuovoNome;
            $_SESSION['cognome']=$nuovoCognome;
            $_SESSION['email']=$nuovaEmail;
            $_SESSION['cf']=$nuovoCf;
            $this->setNome($nuovoNome);
            $this->setCognome($nuovoCognome);
            $this->setEmail($nuovaEmail);
            $this->setPassword($nuovaPassword);
           echo '<div class="alert alert-success" role="alert">';
           echo '<span class="glyphicon glyphicon-ok"></span> Profilo aggiornato con successo';       
           echo '</div>';
        }
            }
            
       public function cercaEvento(){
            require_once '../Database/connect.php';
            require_once dirname(__FILE__).'/../Filtro/filtro.php';

            $nome_evento = filtra($_POST['evento']);
            $data = date("d/m/Y h:i:s");
            
            $ricerca = "SELECT * FROM eventi, luoghi WHERE denominazione = '".$nome_evento."' AND eventi.CodLuogo = luoghi.IDLuogo AND STR_TO_DATE(eventi.data_fine, '%d/%m/%Y %H:%i:%s') > STR_TO_DATE('$data', '%d/%m/%Y %H:%i:%s')";
            $risultato = $connessione->query($ricerca);
            $num = $risultato->rowCount();
            
            if($num == 0){
                echo '<div class="alert alert-danger" role="alert">Errore : non esiste alcun evento denominato '.$nome_evento.'. o l\'evento non è più prenotabile.</div>';
            }else{
                while($riga = $risultato->fetch(PDO::FETCH_ASSOC)){
                    echo '<img src="http://chart.apis.google.com/chart?cht=qr&chs=150x150&chl=id='.$riga['IDEvento'].'">';
                    echo '<p><h1 style="font-size:20px;">'.$riga['denominazione'].'</h1><br>';
                    echo '<strong>Nome evento: </strong>'.$riga['denominazione'].'<br>';
                    echo '<strong>Categoria: </strong>'.$riga['tipologia'].'<br>';
                    echo '<strong>Data inizio: </strong>'.$riga['data_inizio'].'<br>';
                    echo '<strong>Data fine: </strong>'.$riga['data_fine'].'<br>';
                    echo '<strong>Via: </strong>'.$riga['via'].'<br>';
                    echo '<strong>Città: </strong>'.$riga['citta'].'<br>';
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
        $ricerca = "SELECT * FROM prenotazioni WHERE prenotazioni.CodEvento = $IDEvento AND prenotazioni.CodUtente = ".$_SESSION['IDUtente'];
        $out = $connessione->query($ricerca);
        $num = $out->rowCount();
        if($num == 1){
            echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove"></span>Impossibile prenotare: prenotazione già effettuata per questo evento</div>';
            return 0; 
        }
            return 1;
    }
    
    // la funzione stampa le informazioni utili nella fase di prenotazione
    private function info_pren($connessione,$IDEvento, $prossimo_iscritto, $data_prenotazione, $riga){
        require_once '../Database/connect.php';
        require_once dirname(__FILE__).'/../Filtro/filtro.php';
        echo '<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok"></span> Prenotazione effettuata con successo <br><br>'
             . '<strong>Numero prenotazione : </strong>'.$prossimo_iscritto.'/'.$riga['max_iscritti'].'<br>'
             .'<strong>Data e ora di prenotazione : </strong>'.$data_prenotazione.'<br><br>';
        $evento = "SELECT * FROM eventi, luoghi WHERE IDEvento = $IDEvento AND eventi.CodLuogo = luoghi.IDLuogo";
        $out = $connessione->query($evento);
        $num = $out->rowCount();
        if($num != 0){
            while($riga2 = $out->fetch(PDO::FETCH_ASSOC)){
                echo '<strong>Nome evento: </strong>'.$riga2['denominazione'].'<br>';
                echo '<strong>Categoria: </strong>'.$riga2['tipologia'].'<br>';
                echo '<strong>Data inizio: </strong>'.$riga2['data_inizio'].'<br>';
                echo '<strong>Data fine: </strong>'.$riga2['data_fine'].'<br>';
                echo '<strong>Via: </strong>'.$riga2['via'].'<br>';
                echo '<strong>Città: </strong>'.$riga2['citta'].'<br>';
                echo '<strong>Provincia: </strong>'.$riga2['provincia'].'<br>';
                echo '<strong>Prezzo: </strong>'.$riga2['prezzo'].'<br>';
                echo '<strong>Descrizione: </strong>'.$riga2['descrizione'].'<br>';
            }
        }
        echo '</div>'; 
    }
    
       
    public function prenota($IDEvento) {
        require '../Database/connect.php';
        // memorizzo le info utili
        $iscrizioni = "SELECT max_iscritti, iscritti, data_fine FROM eventi WHERE IDEvento = $IDEvento";
        $risultato = $connessione->query($iscrizioni);
        $num1 = $risultato->rowCount();
        if($num1 != 1){
            echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove"></span> Errore : l\'evento potrebbe non essere più disponibile.</div>';
        }else{
            // se l'evento non può avere altri partecipanti perche pieno viene mostrato un messaggio esplicativo
            $riga = $risultato->fetch(PDO::FETCH_ASSOC);
            if($riga['iscritti'] == $riga['max_iscritti']){
                 echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove"></span> Siamo spiacenti: l\'evento non ha più posti disponibili!';
            }else{
                // se il momento della scannerizzazione viene nel momento successivo al termine delle'evento
                // (ora > tempo_fine evento) si avvaisa che il qrcode è "scaduto" 
                // (utile ad esempio se l'utente si salva il QR code e pensa di effettuare lo scan in un secondo momento,
                // senza questo controllo l'utente avrebbe modo di prenotarsi anche dopo l'effettivo termine dell'evento cosa che 
                // non è ammessa)
                $date = DateTime::createFromFormat('d/m/Y H:i', $riga['data_fine']);
                $date = $date->format('d/m/Y H:i');
                if($date < date("d/m/Y H:i")){
                    echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove"></span> Siamo spiacenti: il QRCode non è piu valido!';
                }else{
                //se non è già stata fatta una prenotazione dall'utente effettuo la prenotazione
                if($this->ricerca_prenotazione($IDEvento, $connessione) == 1){
                    $data_prenotazione = date("d/m/Y h:i:s");
                    $prossimo_iscritto = $riga['iscritti']+1;
                    $prenotazione = "INSERT INTO prenotazioni(CodEvento, CodUtente, numero_iscr, data_iscr) VALUES ($IDEvento, ".$_SESSION['IDUtente'].",".$prossimo_iscritto.",'".$data_prenotazione."')";        
                    $stmt = $connessione->query($prenotazione);
                    
                    $this->update_iscritti($prossimo_iscritto, $IDEvento, $connessione);
                    $this->info_pren($connessione, $IDEvento, $prossimo_iscritto, $data_prenotazione, $riga);
                    
                }
            }
        }
    }}

    public function getEventiPrenotati(){
        require '../Database/connect.php';
        $query = "SELECT * FROM eventi, prenotazioni, utenti, luoghi WHERE utenti.IDUtente = ".$this->getIdUtente()." AND utenti.IDUtente = prenotazioni.CodUtente AND eventi.IDEvento = prenotazioni.CodEvento AND eventi.CodLuogo = luoghi.IDLuogo";
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
                echo '<strong>Descrizione: </strong>'.$riga['descrizione'].'<br><br>';
                echo '<strong>Data e ora di iscrizione: </strong>'.$riga['data_iscr'].'<br>';
                echo '<strong>Numero iscrizione: </strong>'.$riga['numero_iscr'].'<br><br>'
                        . '<div class="form-group" style="text-align: center;">
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
                $num1 = $out->rowCount();
                if($num1 == 1){
                    $query2 = "UPDATE eventi SET iscritti = iscritti - 1 WHERE IDEvento = $IdEvento";
                    $out1 = $connessione->query($query2);
                    $num2 = $out1->rowCount();
                    if($num1 == 1){
                        $query3 = "UPDATE prenotazioni SET numero_iscr = numero_iscr - 1 WHERE numero_iscr > ".$riga['numero_iscr']." AND CodEvento = $IdEvento";
                        $out2 = $connessione->query($query3);  
                        echo '<div class="alert alert-success" role="alert">';
                        echo '<span class="glyphicon glyphicon-ok"></span> Prenotazione annullata con successo';       
                        echo '</div>';
                    }else{
                        echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove"></span> Errore durante l\'annullamento dell\'evento.</div>';
                    }
                }else{
                    echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove"></span> Errore durante l\'annullamento dell\'evento.</div>';
                }
            }
        }   
        }
}
