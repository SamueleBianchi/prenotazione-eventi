<?php

require_once 'Utente.php';

class Admin extends Utente{
    public $IdAdmin;
    
    public function __construct($nome, $cognome, $email, $password, $IdAdmin) {
        parent::__construct($nome, $cognome, $email, $password);
        $this->IdAdmin = $IdAdmin;
    }
}

