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
        require_once '../Database/connect.php';
        require_once dirname(__FILE__).'/../Filtro/filtro.php';
        
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
}    