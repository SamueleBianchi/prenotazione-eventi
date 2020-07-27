<!DOCTYPE html>
<?php 
$_SERVER['PHP_SELF'];
session_start(); 
if(!isset($_SESSION['email'])){
header('Location: accessPage.php');
}?>
<html>
<!--[if lt IE 7]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8" />
    <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Responsive Web Site</title>
    <!-- Mobile viewport optimized: j.mp/bplateviewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">

    <script type="text/javascript" src="//code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
    <script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
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
            <li><a><span class="glyphicon glyphicon-list-alt"></span> I miei eventi</a></li>
            <li><a><span class="glyphicon glyphicon-qrcode"></span> Scan</a></li>
            <li id="ricerca"><a id="ricerca"><span class="glyphicon glyphicon-search"></span> Ricerca Evento</a></li>
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Esci</a></li>
                <?php }else{?>
            <li id="profilo"><a id="profilo"><span class="glyphicon glyphicon-user"></span> Profilo</a></li>
            <li id="aggiungi"><a id="aggiungi"><span class="glyphicon glyphicon-plus"></span> Aggiungi evento</a></li>
            <li id="gestisci"><a id="gestisci"><span class="glyphicon glyphicon-list-alt"></span> Gestisci eventi</a></li>
            <li><a href=""><span class="glyphicon glyphicon-align-justify"></span> Visualizza utenti</a></li>
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Esci</a></li>
                <?php } ?>
        </ul> 
	</div> <!-- #mainmenu -->
    
	<div id="main"><div id="testo">
            <h2>Questo è un esempio di menù Responsive. </h2>
            <p>Quando la larghezza dello schermo è sotto i 767px, il menu viene nascosto e ottimizzato per Smartphone e Tablet. Ridimensiona la finestra per vedere il menu in azione.</p>
            </div>   
	</div> <!-- #main -->

</div> <!-- #wrapper -->
        <script src="./Scripts/mainjs.js" type="text/javascript"></script>
    </body>
</html>
