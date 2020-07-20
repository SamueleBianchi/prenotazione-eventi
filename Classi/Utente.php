<?php

class Utente{
//    public $IdUtente = "";
    public $nome = "";
    public $cognome = "";
    public $email = "";
    private $password = "";


    public function __construct($nome, $cognome, $email, $password) {
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->email = $email;
        $this->password = $password;
    }
    
    public function getNome() {
        return $this->nome;
    }
    
    public function getCognome() {
        return $this->cognome;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function getPassword() {
        return $this->password;
    }
    
    public function setNome($nome) {
        $this->nome = $nome;
    }
    
    public function setCognome($cognome) {
        $this->cognome = $cognome;
    }
    
    public function setEmail($email) {
        $this->email = $email;
    }
    
    public function setPassword($password) {
        $this->password = $password;
    }
    
    public function accedi($tipo_utente, $id_admin) {
        require '../Database/connect.php';
        if($tipo_utente == 0){
            $query = "SELECT * FROM utenti WHERE email = '$this->email' AND pwd = MD5('".$this->getPassword()."')";
            $risultato = $connessione->query($query);
            $numero_righe = $risultato->rowCount();
        }else{
            if($tipo_utente == 1){
                $query="SELECT * FROM Admins WHERE email = '$this->email' AND pwd = MD5('".$this->password."')";
                $risultato = $connessione->query($query);
                $numero_righe = $risultato->rowCount();
            }
        }
        
        if($numero_righe == 1){
            session_start();
            foreach ($connessione->query($query) as $row) {
                $this->nome = $row['nome'];
                $this->cognome = $row['cognome'];
                $this->password = $row['pwd'];
//                $this->IdUtente = $row['IDUtente'];
            }
            
            $_SESSION['email'] = $this->getEmail();
            $_SESSION['nome'] = $this->getNome();
            $_SESSION['cognome'] = $this->getCognome();
            
            if($tipo_utente == 1){
                $_SESSION['id'] = $id_admin;
            }
            
            $_SESSION['email'] = $this->getEmail();
            header("Location: ../index.php");   
        } else {
            $this->stampa_errore("Email o password errati");
        }
    }
    
    private function stampa_errore($messaggio){
        echo '<html>
    <head>
        <meta charset="UTF-8">
        <title>Accesso</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="stylesheet" href="../stili/style_access.css">
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
    </head>
    <body>
      <div class="login-page">
      <div class="form-subscribe" id="signupsuccess" style="margin-top:50px;font-family: "Poppins", sans-serif;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">            

                    <div style="padding-top:30px" class="panel-body">
                        <div class="alert alert-danger" role="alert">
                        '.$messaggio.'<br>
                        </div>
                        <a href="../accessPage.php">Ritorna alla pagina di login</a>
                        </div>  
                    </div>
    </body>
    </html>';
    }
    
}
