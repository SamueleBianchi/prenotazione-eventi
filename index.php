<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php 
$_SERVER['PHP_SELF'];
session_start(); 
if(!isset($_SESSION['email'])){
header('Location: index.php');
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
    <link rel="stylesheet" href="./stili/style_homepage.css">
    <script>
    $(document).ready(function(){   
    
		//When btn is clicked
		$(".btn-responsive-menu").click(function() {
			$("#mainmenu").toggleClass("show");
		
		});
    
    });
    </script>
        <title></title>
        
    </head>
    <body>
        <div id="wrapper">

    <header id="header">
    
        <h1 id="site-title"><a href="#">Events</a></h1>
        
        <div class="btn-responsive-menu">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </div>
        
    </header> <!-- #header -->
    
    <div id="mainmenu">
	 	<ul>
        	<li><a href=""><span class="glyphicon glyphicon-home"></span> Home</a></li>
            <li><a href=""><span class="glyphicon glyphicon-user"></span> Il mio profilo</a></li>
            <li><a href=""><span class="glyphicon glyphicon-list-alt"></span> I miei eventi</a></li>
            <li><a href=""><span class="glyphicon glyphicon-calendar"></span> Eventi disponibili</a></li>
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Esci</a></li>
        </ul> 
	</div> <!-- #mainmenu -->
    
	<div id="main">
    
        <!-- Prompt IE 6 and 7 users to install Chrome Frame:		chromium.org/developers/how-tos/chrome-frame-getting-started -->
        <!--[if lt IE 8]>
            <p class="chromeframe alert alert-warning">Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p>
        <![endif]--> 
    
        <h2>Questo è un esempio di menù Responsive. </h2>
        <p>Quando la larghezza dello schermo è sotto i 767px, il menu viene nascosto e ottimizzato per Smartphone e Tablet. Ridimensiona la finestra per vedere il menu in azione.</p>
        
	</div> <!-- #main -->

</div> <!-- #wrapper -->

    </body>
</html>
