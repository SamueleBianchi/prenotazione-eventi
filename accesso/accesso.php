<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require "../Database/connect.php";
require dirname(__FILE__).'/../Filtro/filtro.php';  

$admin = 0;
if(!isset($_POST["id"]) || trim($_POST["id"]) == ''){

}else{
    echo $admin = 1;
    $idadmin = $_POST["id"];
}

$email= filtra($_POST["email"]);
$password=filtra($_POST["password"]);

if($admin == 0){
    $query="SELECT * FROM utenti WHERE email = '$email' AND pwd = MD5('".$password."')";
    $risultato = $connessione->query($query);
    $num = $risultato->rowCount();
}else{
    if($admin == 1){
        $query="SELECT * FROM Admins WHERE IDAdmin = '$idadmin' AND email = '$email' AND pwd = MD5('".$password."')";
        $risultato = $connessione->query($query);
        $num = $risultato->rowCount();
    }
}
foreach ($connessione->query($query) as $row) {
        $nome = $row['nome'];
        $id = $row['IDUtente'];
        $cognome = $row['cognome'];
        $pwd = $row['pwd'];
    }
if($num=='1'){
    session_start();
    if($admin == 1){
        $_SESSION['id'] = $idadmin;
    }
    $_SESSION['email'] = $email;
    $_SESSION['IDUtente'] = $id;
    $_SESSION['nome'] = $nome;
    $_SESSION['cognome'] = $cognome;
//    if(!empty($_POST["remember"])) {
//				setcookie ("email",$_POST["email"],time()+ (10 * 365 * 24 * 60 * 60), "/");
//				setcookie ("password",$_POST["password"],time()+ (10 * 365 * 24 * 60 * 60), "/");
//			} else {
//				if(isset($_COOKIE["email"])) {
//					setcookie ("email","");
//				}
//				if(isset($_COOKIE["password"])) {
//					setcookie ("password","");
//				}
//			}
    header("Location: ../index.php");   
} else {
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
                        Email o password errati<br>
                        </div>
                        <a href="../accessPage.php">Ritorna alla pagina di login</a>
                        </div>  
            </div>
    </body>
</html>';
}