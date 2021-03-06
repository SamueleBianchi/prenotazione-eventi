<?php

require_once 'UtenteGenerico.php';

class Admin extends UtenteGenerico{
    
    private $IdAdmin; //id univoco dell'admin
    
    //metodo costruttore
    public function __construct($nome, $cognome, $email, $password, $IdAdmin) {
        parent::__construct($nome, $cognome, $email, $password);
        $this->IdAdmin = $IdAdmin;
    }
    
    public function getIdAdmin() {
        return $this->IdAdmin;
    }
    
    public function setIdAdmin($IdAdmin) {
        $this->IdAdmin = $IdAdmin;
    }
    
    /* Tramite una query verifico la presenza dell'admin all'interno della tabella Admin
     * se la query non trova alcuna riga stampo l'errore tramite la funzione stampa_errore()
     * altrimenti creo la sessione e reindirizzo l'utente nella sua homepage tramite la funzione header()
     */
    public function accedi() {
        require '../Database/connect.php';
        $query="SELECT * FROM admins WHERE IDAdmin = ".$this->getIdAdmin()." AND email = '".$this->getEmail()."' AND pwd = MD5('".$this->getPassword()."')";
        $risultato = $connessione->query($query);
        $numero_righe = $risultato->rowCount();       
        if($numero_righe == 1){
            session_start();
            foreach ($connessione->query($query) as $row) {
                $this->setNome($row['nome']);
                $this->setCognome($row['cognome']);
                $this->setPassword($row['pwd']);
                $this->setCf($row['cf']);
                $this->setIdAdmin($row['IDAdmin']);
            }
            
            $_SESSION['email'] = $this->getEmail();
            $_SESSION['nome'] = $this->getNome();
            $_SESSION['cognome'] = $this->getCognome();
            $_SESSION['cf'] = $this->getCf();
            $_SESSION['id'] = $this->getIdAdmin();
            $_SESSION['oggetto'] = serialize($this);
            header("Location: ../index.php");   
        } else {
            $this->stampa_errore("Email o password errati");
        }
    }
    
    public function modificaProfilo(){
        require_once '../Database/connect.php';
        require_once dirname(__FILE__).'/../Filtro/filtro.php';
        
        $nuovoNome = filtra($_POST['nome']);
        $nuovoCognome = filtra($_POST['cognome']);
        $nuovaEmail = filtra($_POST['email']);
        $nuovoCf = filtra($_POST['codicefiscale']);
        $vecchiaPassword = filtra($_POST['pwd']);
        $nuovaPassword = filtra($_POST['pwd2']);
        $nuovaPassword2 = filtra($_POST['pwd3']);

        $message = "";
        $message2 = "";
        $session_id = $_SESSION['id'];
        //verifico che l'admin abbia inserito la sua password attuale in maniera corretta PRIMA di effettuare la modifica del profilo
        //se l'attuale password non è corretta viene concatenato un apposito messaggio ad una stringa $message 
        $query="SELECT * FROM admins WHERE IDAdmin = $session_id AND pwd = MD5('".$vecchiaPassword."')";
        $risultato = $connessione->query($query);
        $num = $risultato->rowCount();
        if($num == 0){
            $message = $message."La password attuale inserita non è corretta.";
        }
        //se i due campi corrispondenti alla nuova password non sono uguali viene concatenato il messaggio di errore nell'apposita variabile
        if(strcmp($nuovaPassword,$nuovaPassword2)){
            $message2 = $message2."Le due password non sono uguali.";
        }
        //stampa errori
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
            // effetuo la modifica del profilo tramie UPDATE e informo l'utente dell'avvenuta modifica.
            $query2 = "UPDATE admins SET nome = '".$nuovoNome."', cognome = '".$nuovoCognome."', cf = '".$nuovoCf."', email = '".$nuovaEmail."',pwd = MD5('".$nuovaPassword."') WHERE IDAdmin = $session_id";
            $connessione->exec($query2);
            $_SESSION['nome']= $nuovoNome;
            $_SESSION['cognome']=$nuovoCognome;
            $_SESSION['email']=$nuovaEmail;
           echo '<div class="alert alert-success" role="alert">';
           echo '<span class="glyphicon glyphicon-ok"></span> Profilo aggiornato con successo';       
           echo '</div>';
        }
            }
            
    public function aggiungiEvento(){
        require '../Database/connect.php';
        require dirname(__FILE__).'/../Filtro/filtro.php';

        $nome = filtra($_POST['denominazione']);
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
        $città = filtra($_POST['città']);
        $iscritti = 0;
        
        $IdLuogo = "";
        $query_luogo = "SELECT IDLuogo FROM luoghi WHERE citta = '".$città."' AND via = '".$via."' AND provincia = '".$provincia."'";
        $risultato = $connessione->query($query_luogo);
        $num = $risultato->rowCount();
        // Se il luogo inserito non è gia presente nel db viene inserito tramite INSERT, altrimenti no
        if($num == 1){
            $riga = $risultato->fetch(PDO::FETCH_ASSOC);
            $IdLuogo = $riga['IDLuogo'];
        }else{
            $aggiungi_luogo = $connessione->prepare("INSERT INTO luoghi (citta, provincia, via) VALUES (:citta, :provincia, :via)");
            $aggiungi_luogo->bindParam(':citta', $città, PDO::PARAM_INT, 32);
            $aggiungi_luogo->bindParam(':provincia', $provincia, PDO::PARAM_STR, 32);
            $aggiungi_luogo->bindParam(':via', $via, PDO::PARAM_STR, 32);
            $aggiungi_luogo->execute();
            $risultato = $connessione->query($query_luogo);
            $riga = $risultato->fetch(PDO::FETCH_ASSOC);
            $IdLuogo = $riga['IDLuogo'];
        }
        
        //Effettuo la prenotazione specificando la chiave esterna come variabile di sessione dell'utente
        $aggiungi_evento = $connessione->prepare("INSERT INTO eventi (denominazione, tipologia, descrizione, data_inizio, data_fine, iscritti, max_iscritti, prezzo, sito, recapito, CodLuogo) VALUES (:denominazione, :tipologia, :descrizione, :data_inizio, :data_fine, :iscritti, :max_iscritti, :prezzo, :sito, :recapito, :CodLuogo)");
        $aggiungi_evento->bindParam(':denominazione', $nome, PDO::PARAM_INT, 32);
        $aggiungi_evento->bindParam(':tipologia', $tipologia, PDO::PARAM_STR, 32);
        $aggiungi_evento->bindParam(':descrizione', $descrizione, PDO::PARAM_STR, 255);
        $aggiungi_evento->bindParam(':data_inizio', $data_inizio, PDO::PARAM_STR, 6);
        $aggiungi_evento->bindParam(':data_fine', $data_fine, PDO::PARAM_INT, 6);
        $aggiungi_evento->bindParam(':iscritti', $iscritti, PDO::PARAM_INT, 10);
        $aggiungi_evento->bindParam(':max_iscritti', $max_iscritti, PDO::PARAM_INT, 10);
        $aggiungi_evento->bindParam(':prezzo', $prezzo, PDO::PARAM_STR, 32);
        $aggiungi_evento->bindParam(':sito', $sito, PDO::PARAM_STR, 32);
        $aggiungi_evento->bindParam(':recapito', $recapito, PDO::PARAM_STR, 16);
        $aggiungi_evento->bindParam(':CodLuogo', $IdLuogo, PDO::PARAM_INT, 10);
        try{
        $aggiungi_evento->execute();
           $html = '<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok"></span> Evento aggiunto al database</div>';
            echo($html);
                    } catch (Exception $ex) {
                        $html = '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove"></span> Errore durante l\'inserimento dell\'evento</div>';
                        echo($html);
                        //echo $ex->getMessage();
                    }

            }
            
        public function eliminaEvento($IdEvento){
            require '../Database/connect.php';
            $elimina =  "DELETE FROM eventi WHERE IDEvento = '".$IdEvento."'";
            $elimina_prenotazioni =  "DELETE FROM prenotazioni WHERE CodEvento = '".$IdEvento."'";
            $num = $connessione->exec($elimina);
            if($num == 1){
                echo '<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok"></span> Evento eliminato con successo</div>';
            }else{
                echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove"></span> Errore nell\'eliminazione dell\'evento</div>';
            }
            $out = $connessione->exec($elimina_prenotazioni);
        }
        
        public function modificaEvento($IdEvento){
            require '../Database/connect.php';
            require_once dirname(__FILE__).'/../Filtro/filtro.php';

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
            $città = filtra($_POST['città2']);
            $IdLuogo = "";
            $query_luogo = "SELECT IDLuogo FROM luoghi WHERE citta = '".$città."' AND via = '".$via."' AND provincia = '".$provincia."'";
            $risultato = $connessione->query($query_luogo);
            $num = $risultato->rowCount();
            // Se il luogo inserito non è gia presente nel db viene inserito tramite INSERT, altrimenti no
            if($num == 1){
                $riga = $risultato->fetch(PDO::FETCH_ASSOC);
                $IdLuogo = $riga['IDLuogo'];
            }else{
                $aggiungi_luogo = $connessione->prepare("INSERT INTO luoghi (citta, provincia, via) VALUES (:citta, :provincia, :via)");
                $aggiungi_luogo->bindParam(':citta', $città, PDO::PARAM_INT, 32);
                $aggiungi_luogo->bindParam(':provincia', $provincia, PDO::PARAM_STR, 32);
                $aggiungi_luogo->bindParam(':via', $via, PDO::PARAM_STR, 32);
                $aggiungi_luogo->execute();
                $risultato = $connessione->query($query_luogo);
                $riga = $risultato->fetch(PDO::FETCH_ASSOC);
                $IdLuogo = $riga['IDLuogo'];
            }
            //modifico l'evento
            $modifica =  "UPDATE eventi SET denominazione = '".$nome_evento."', tipologia = '".$tipologia."', descrizione = '".$descrizione."', data_inizio = '".$data_inizio."', data_fine = '".$data_fine."', max_iscritti = '".$max_iscritti."', prezzo = '".$prezzo."', sito = '".$sito."', recapito = '".$recapito."', CodLuogo = '".$IdLuogo."' WHERE IDEvento = $IdEvento";
            $num = $connessione->exec($modifica);

            if($num == 1 && is_numeric($max_iscritti)){
                echo '<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok"></span> Evento modificato con successo</div>';
            }else{
                echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove"></span> Errore durante la modifica dell\'evento : potrebbe essere stato eliminato o la modifica non ha apportato alcun effetto. Riprovare</div>';
            }
                    }
            /* Dato un evento estrapolo tutte le prenotazioni per quell'evento e le ordino per numero di iscrizioni
             * successivamente stampo ogni record come riga di una tabella in html
             */       
            public function visualizzaUtenti($evento){
                require '../Database/connect.php';
                $ricerca = "SELECT * FROM eventi WHERE denominazione = '".$evento."'";
                $risultato = $connessione->query($ricerca);
                $num = $risultato->rowCount();
                if($num == 0){
                    echo '<div class="alert alert-danger" role="alert">Errore : non esiste alcun evento denominato '.$evento.'.</div>';
                }else{
                    while($riga = $risultato->fetch(PDO::FETCH_ASSOC)){
                        $query = "SELECT * FROM prenotazioni WHERE CodEvento = '".$riga['IDEvento']."' ORDER BY numero_iscr";
                        $risultato2 = $connessione->query($query);
                        $num2 = $risultato2->rowCount();
                        if($num2 == 0){
                            echo '<div class="alert alert-danger" role="alert">L\'evento denominato '.$evento.' non ha nessun partecipante.</div>';
                        }else{
                             echo '<div class="table-responsive"><table class="table">
                                    <thead class="table table-bordered table-striped">
                                      <tr>
                                        <th>Numero iscrizione</th>
                                        <th>Nome</th>
                                        <th>Cognome</th>
                                        <th>Email</th>
                                      </tr>
                                    </thead>
                                    <tbody>';
                             while($riga2 = $risultato2->fetch(PDO::FETCH_ASSOC)){
                                 $query3 = "SELECT * FROM utenti WHERE IdUtente = ".$riga2['CodUtente'];
                                 $risultato3 = $connessione->query($query3);
                                 $num3 = $risultato3->rowCount();  
                                 if($num3 == 0){
                                        echo '<div class="alert alert-danger" role="alert">Errore : non esiste alcun evento denominato '.$evento.'.</div>';
                                 }else{
                                     while($riga3 = $risultato3->fetch(PDO::FETCH_ASSOC)){
                                         echo '<tr><td>'.$riga2['numero_iscr'].'</td>';
                                         echo '<td>'.$riga3['nome'].'</td>';
                                         echo '<td>'.$riga3['cognome'].'</td>';
                                         echo '<td>'.$riga3['email'].'</td></tr>';
                                     }
                                 }
                             }
                             echo '</tbody></table></div>';
                        }
                    }
                }
                
                
            
            }
}    