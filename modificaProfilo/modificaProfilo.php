<?php
require '../Database/connect.php';
require dirname(__FILE__).'/../Filtro/filtro.php';

session_start();

$nuovoNome = filtra($_POST['nome']);
$nuovoCognome = filtra($_POST['cognome']);
$nuovaEmail = filtra($_POST['email']);
$vecchiaPassword = filtra($_POST['pwd']);
$nuovaPassword = filtra($_POST['pwd2']);
$nuovaPassword2 = filtra($_POST['pwd3']);

$message = "";
$message2 = "";

$table = "utenti";
$id_table = "IDUtente";
if(isset($_SESSION['id'])){
    $table = "admins";
    $id_table = "IDAdmin";
    $session_id = $_SESSION['id'];
}else{
    $session_id = $_SESSION['IDUtente'];
}

$query="SELECT * FROM $table WHERE $id_table = $session_id AND pwd = MD5('".$vecchiaPassword."')";
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
    $query2 = "UPDATE $table SET nome = '".$nuovoNome."', cognome = '".$nuovoCognome."',email = '".$nuovaEmail."',pwd = MD5('".$nuovaPassword."') WHERE $id_table = $session_id";
    $connessione->exec($query2);
    $num2 = $risultato->rowCount();
    
   echo '<div class="alert alert-success" role="alert">';
   echo '<span class="glyphicon glyphicon-ok"></span> Profilo aggiornato con successo';       
   echo '</div>';
}

