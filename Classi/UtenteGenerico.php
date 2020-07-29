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
}
