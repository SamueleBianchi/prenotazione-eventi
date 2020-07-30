<?php

require_once 'Persona.php';

class UtenteGenerico extends Persona{
       
    private $password = "";
        
    public function __construct($nome, $cognome, $email, $password) {
        parent::__construct($nome, $cognome, $email, $password);
        $this->password = $password;
    }
    
    public function getPassword() {
        return $this->password;
    }
    
    public function setPassword($password) {
        $this->password = $password;
    }
    
    public function stampa_errore($messaggio){
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
