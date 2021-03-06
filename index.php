<!DOCTYPE html>
<?php 
include './Classi/Utente.php';
include './Classi/Admin.php';

$_SERVER['PHP_SELF'];
session_start(); 
$oggetto = unserialize($_SESSION['oggetto']);
if(!isset($_SESSION['email'])){ //se la sessione non è attiva ritorno alla pagina di accesso
header('Location: accessPage.php');
}?>
<html>
<!--[if lt IE 7]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Events</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- JavaScript -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="./stili/icon.png" >
    <link rel="stylesheet" href="./stili/style_homepage.css">
    
    <title>Events</title>
        
    </head>
    <body style="background-color: white;">
    <div id="wrapper">
    <header id="header">
    
        <h1 id="site-title"><a href="#">Events</a></h1>
        
        <div class="btn-responsive-menu" id="miomenu">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </div>
        
    </header> <!-- #header -->
    
    <div id="mainmenu">
	 	<ul>
                <?php if(!isset($_SESSION['id'])){ ?>
        	<li><a href=""><span class="glyphicon glyphicon-home"></span> Home</a></li>
            <li id="profilo"><a id="profilo"><span class="glyphicon glyphicon-user"></span> Profilo</a></li>
            <li id="miei_eventi"><a><span class="glyphicon glyphicon-list-alt"></span> I miei eventi</a></li>
            <li id="scan"><a><span class="glyphicon glyphicon-qrcode"></span> Scan</a></li>
            <li id="ricerca"><a id="ricerca"><span class="glyphicon glyphicon-search"></span> Ricerca Evento</a></li>
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Esci</a></li>
                <?php }else{?>
            <li id="profilo2"><a id="profilo2"><span class="glyphicon glyphicon-user"></span> Profilo</a></li>
            <li id="aggiungi"><a id="aggiungi"><span class="glyphicon glyphicon-plus"></span> Aggiungi evento</a></li>
            <li id="gestisci"><a id="gestisci"><span class="glyphicon glyphicon-cog"></span> Gestisci eventi</a></li>
            <li id="partecipanti"><a id="partecipanti"><span class="glyphicon glyphicon-align-justify"></span> Visualizza prenotati</a></li>
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Esci</a></li>
                <?php } ?>
        </ul> 
	</div> <!-- #mainmenu -->
    
	<div id="main"><div id="testo">
            <h1>Bentornato <?php echo $oggetto->getNome(); ?> !</h1>
             <?php if(!isset($_SESSION['id'])){ ?>
            <br><p>Per scannerizzare il QR code di un evento premi l'apposito pulsante denominato "Scan", consenti l'uso della tua videocamera, e successivamente
                inquadra il QR code.<br>Per visualizzare gli eventi a cui sei prenotato clicca il pulsante "I miei eventi" : potrai annullare la prenotazione
                di un evento utilizzando l'apposito bottone. <br>Se invece vuoi cercare un determinato evento utilizza il pulsante "Ricerca Evento".<br>
                Puoi anche modificare le tue informazioni nell'interfaccia dedicata.<br>Ti ricordiamo che l'applicazione web è utilizzabile anche da smartphone.
            </p>
            <?php }else{?>
            <br><p> Per creare un nuovo evento clicca il pulsante "Aggiungi evento", compila il form e premi il bottone di conferma.
                <br>Se vuoi modificare o eliminare un evento invece, clicca "Gestisci eventi".
                <br>Se vuoi visualizzare gli utenti che si sono prenotati ad un determinato evento clicca il pulsante "Visualizza prenotati". 
                </p>
            <?php } ?>
            </div>   
	</div> <!-- #main -->
        
        <div id="main2" style="display: none">
            <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <div class="container-fluid">
		<div class="row">
			
			<div class="col" style="text-align: center;">
				<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
                                <h1 style="font-size: 20px;">Scannerizza</h1><br>
				<div class="col-sm-12" style="text-align: center;">
					<video id="preview" class="p-1 border" style="width:70%; text-align: center;"></video>
				</div>
                                <script type="text/javascript">
					
                                </script><br>
				<div class="btn-group btn-group-toggle mb-5" data-toggle="buttons">
				  <label class="btn btn-primary active">
					<input type="radio" name="options" value="1" autocomplete="off" checked> Front Camera
				  </label>
				  <label class="btn btn-secondary">
					<input type="radio" name="options" value="2" autocomplete="off"> Back Camera
				  </label>
				</div>
			</div>
			
			
			<div class="col-sm-3">
			</div>
		
		</div>
	</div>
        </div>
        
        <script src="Scripts/mainjs.js" type="text/javascript"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    
   
    
    <script type="text/javascript" src="//code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
    <script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
    </body>
</html>
