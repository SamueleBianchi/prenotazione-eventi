<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require dirname(__FILE__).'/../Filtro/filtro.php';  
require "../Database/connect.php";

//sanifico i vari dati immessi dall'utente
$nome= filtra($_POST['nome']);
$cognome=filtra($_POST['cognome']);
$pwd=filtra($_POST['password']);
$email=filtra($_POST['email']);
$IDUtente="";
$query_email = "SELECT email FROM Utenti WHERE email ='".$email."'";
$risultato = $connessione->query($query_email);
$count = $risultato->rowCount();

$html='<html>
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

                                    <div style="padding-top:30px" class="panel-body">';
if($count == 0){
    $pwdCript= md5($pwd);

    $query=$connessione->prepare("INSERT INTO utenti (IDUtente, nome, cognome, email, pwd) VALUES (:IDUtente, :nome, :cognome, :email, :pwd)");
    $query->bindParam(':IDUtente', $IDUtente, PDO::PARAM_INT, 10);
    $query->bindParam(':nome', $nome, PDO::PARAM_STR, 30);
    $query->bindParam(':cognome', $cognome, PDO::PARAM_STR, 40);
    $query->bindParam(':email', $email, PDO::PARAM_STR, 64);
    $query->bindParam(':pwd', $pwdCript, PDO::PARAM_STR, 30);
    try{
        $query->execute();
                                    
                                        $html = $html.'<div class="alert alert-success" role="alert">
                                                            Iscrizione avvenuta con successo<br>
                                                        </div>
                                                        <a href="../accessPage.php">Ritorna alla pagina di login</a>
                                                        </div>  
                                                        </div>
                                                        </body>
                                            </html>';

                } catch (Exception $ex) {
                    echo $ex->getMessage();
                }
}else{
    $html = $html.'<div class="alert alert-danger" role="alert">
                                                            Email non disponibile, utilizzare un altra email<br>
                                                        </div>
                                                        <a href="../accessPage.php">Ritorna alla pagina di login</a>
                                                        </div>  
                                                        </div>
                                                        </body>
                                            </html>';
}
echo $html;