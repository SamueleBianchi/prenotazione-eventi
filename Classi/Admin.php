<?php

require_once 'UtenteGenerico.php';

class Admin extends UtenteGenerico{
    
    private $IdAdmin;
    
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
    
    public function accedi() {
        require '../Database/connect.php';
        
        $query="SELECT * FROM Admins WHERE IDAdmin = ".$this->getIdAdmin()." AND email = '".$this->getEmail()."' AND pwd = MD5('".$this->getPassword()."')";
        $risultato = $connessione->query($query);
        $numero_righe = $risultato->rowCount();       
        if($numero_righe == 1){
            session_start();
            foreach ($connessione->query($query) as $row) {
                $this->setNome($row['nome']);
                $this->setCognome($row['cognome']);
                $this->setPassword($row['pwd']);
                $this->setIdAdmin($row['IDAdmin']);
            }
            
            $_SESSION['email'] = $this->getEmail();
            $_SESSION['nome'] = $this->getNome();
            $_SESSION['cognome'] = $this->getCognome();
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
        $vecchiaPassword = filtra($_POST['pwd']);
        $nuovaPassword = filtra($_POST['pwd2']);
        $nuovaPassword2 = filtra($_POST['pwd3']);

        $message = "";
        $message2 = "";
        $session_id = $_SESSION['id'];
        
        $query="SELECT * FROM admins WHERE IDAdmin = $session_id AND pwd = MD5('".$vecchiaPassword."')";
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
            $query2 = "UPDATE admins SET nome = '".$nuovoNome."', cognome = '".$nuovoCognome."',email = '".$nuovaEmail."',pwd = MD5('".$nuovaPassword."') WHERE IDAdmin = $session_id";
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
        $iscritti = 0;

        $aggiungi_evento = $connessione->prepare("INSERT INTO eventi (denominazione, provincia, via, tipologia, descrizione, data_inizio, data_fine, iscritti, max_iscritti, prezzo, sito, recapito) VALUES (:denominazione, :provincia, :via, :tipologia, :descrizione, :data_inizio, :data_fine, :iscritti, :max_iscritti, :prezzo, :sito, :recapito)");
        $aggiungi_evento->bindParam(':denominazione', $nome, PDO::PARAM_INT, 32);
        $aggiungi_evento->bindParam(':provincia', $provincia, PDO::PARAM_STR, 32);
        $aggiungi_evento->bindParam(':via', $via, PDO::PARAM_STR, 32);
        $aggiungi_evento->bindParam(':tipologia', $tipologia, PDO::PARAM_STR, 32);
        $aggiungi_evento->bindParam(':descrizione', $descrizione, PDO::PARAM_STR, 64);
        $aggiungi_evento->bindParam(':data_inizio', $data_inizio, PDO::PARAM_STR, 6);
        $aggiungi_evento->bindParam(':data_fine', $data_fine, PDO::PARAM_INT, 6);
        $aggiungi_evento->bindParam(':iscritti', $iscritti, PDO::PARAM_INT, 10);
        $aggiungi_evento->bindParam(':max_iscritti', $max_iscritti, PDO::PARAM_INT, 10);
        $aggiungi_evento->bindParam(':prezzo', $prezzo, PDO::PARAM_STR, 32);
        $aggiungi_evento->bindParam(':sito', $sito, PDO::PARAM_STR, 32);
        $aggiungi_evento->bindParam(':recapito', $recapito, PDO::PARAM_STR, 16);
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
            $num = $connessione->exec($elimina);
            if($num == 1){
                echo '<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok"></span> Evento eliminato con successo</div>';
            }else{
                echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove"></span> Errore nell\'eliminazione dell\'evento</div>';
            }
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
            $modifica =  "UPDATE eventi SET denominazione = '".$nome_evento."', provincia = '".$provincia."', via = '".$via."', tipologia = '".$tipologia."', descrizione = '".$descrizione."', data_inizio = '".$data_inizio."', data_fine = '".$data_fine."', max_iscritti = '".$max_iscritti."', prezzo = '".$prezzo."', sito = '".$sito."', recapito = '".$recapito."' WHERE IDEvento = $IdEvento";
            $num = $connessione->exec($modifica);

            if($num == 1 && is_numeric($max_iscritti)){
                echo '<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok"></span> Evento modificato con successo</div>';
            }else{
                echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove"></span> Errore durante la modifica dell\'evento : potrebbe essere stato eliminato o la modifica non ha apportato alcun effetto. Riprovare</div>';
            }
                    }
            }    