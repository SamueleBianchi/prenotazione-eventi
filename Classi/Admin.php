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
        $query="SELECT * FROM Admins WHERE email = '".$this->getEmail()."' AND pwd = MD5('".$this->getPassword()."')";
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