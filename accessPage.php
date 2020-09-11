<?php
session_start();
//se la sessione è già attiva vado direttamente alla homepage
if(isset($_SESSION['email'])){
     header('Location: index.php');
     exit();
}?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Accesso</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="stylesheet" href="./stili/style_access.css">
        <link rel="icon" type="image/x-icon" href="./stili/icon.png" />
    </head>
    <body>
       <div class="login-page">
            <div class="form">
                <form class="register-form" id="form_subscribe" role="form" method="POST" action="./iscrizione/iscrizione.php">
                    <h2> Registrati </h2>
                    <input type="text" name="nome" placeholder="Nome" required="true"/>
                    <input type="text" name="cognome"placeholder="Cognome" required="true"/>
                    <input type="text" name="codicefiscale" id="codicefiscale" placeholder="Codice fiscale" pattern="^[a-zA-Z]{6}[0-9]{2}[a-zA-Z][0-9]{2}[a-zA-Z][0-9]{3}[a-zA-Z]$" required="true" title="codice fiscale">
                    <input type="email" name="email" placeholder="Email" required="true"/>
                    <input type="password" name="password" placeholder="Password" required="true" pattern=".{8,}" title="almeno 8 caratteri"/>
                    <button type="submit" form="form_subscribe">Registrati</button>
                    <p class="message">Sei già registrato? <a href="#">Accedi</a></p>
                </form>
                <form class="login-form" id="form_access" role="form" method="POST" action="./accesso/accesso.php">
                    <h2> Accedi </h2>
                    <input name="id" type="text" placeholder="ID ( solo per utente admin )"/>
                    <input name="email" type="email" placeholder="Email" required="true"/>
                    <input name="password" type="password" placeholder="Password" required="true"/>
                    <button>Accedi</button>
                    <p class="message">Non hai un account? <a href="#">Registrati</a></p>
                </form>
            </div>
        </div>
        <script>$(".message a").click(function (){ 
            $("form").animate({ height: "toggle", opacity: "toggle" }, "slow");});
        </script>
    </body>
</html>
