<?php
/*
  parametri di connessione
*/
// nome di host
$host = "localhost";
// nome del database
$db = "Eventi";
// username dell'utente in connessione
$user = "root";
// password dell'utente
$password = "";

/*
  blocco try/catch di gestione delle eccezioni
*/
try {
  // stringa di connessione al DBMS
  global $connessione;
  $connessione= new PDO("mysql:host=$host;dbname=$db", $user, $password);
  // impostazione dell'attributo per il report degli errori
  $connessione->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
  // notifica in caso di errore nel tentativo di connessione
  echo $e->getMessage();
}

