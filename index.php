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
    <link rel="stylesheet" href="./stili/style_homepage.css">
    <script>
    $(document).ready(function(){   
    
		//When btn is clicked
		$(".btn-responsive-menu").click(function() {
			$("#mainmenu").toggleClass("show");
		
		});
    
    
                $("#profilo").click(function(){
                        $("#testo").text("");
                       if($(window).width() < 767){
                            $("#mainmenu").toggleClass("show");
                        }
                        $("#aggiornaProfilo").css("display","block");
                });
                
    });
    
    $(document).on('submit', 'form#aggiornaProfilo', function(evt){
                    $.ajax({
                    type: "POST",
                    url: "./modificaProfilo/modificaProfilo.php",
                    data :{nome: $("#nome").val(),cognome: $("#cognome").val(),email: $("#email").val(),pwd: $("#pwd").val(), pwd2: $("#pwd2").val(), pwd3: $("#pwd3").val()},
                    success: function(data)
                    {
                        $("#success").empty(); // show response from the php script.
                        $("#success").html(data); // show response from the php script.
                        $("#success").css("display", "block");
                    }
                    });
                    evt.preventDefault(); 
                 });
    
     
    </script>
        <title></title>
        
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
            <li><a><span class="glyphicon glyphicon-qrcode"></span> Scan</a></li>
            <li><a><span class="glyphicon glyphicon-list-alt"></span> I miei eventi</a></li>
            <li><a><span class="glyphicon glyphicon-calendar"></span> Eventi disponibili</a></li>
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Esci</a></li>
                <?php }else{?>
            <li><a href=""><span class="glyphicon glyphicon-user"></span> Il mio profilo</a></li>
            <li><a href=""><span class="glyphicon glyphicon-list-alt"></span> Gestisci eventi</a></li>
            <li><a href=""><span class="glyphicon glyphicon-align-justify"></span> Visualizza utenti</a></li>
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Esci</a></li>
                <?php } ?>
        </ul> 
	</div> <!-- #mainmenu -->
    
	<div id="main">
            <div id="testo">
            <h2>Questo è un esempio di menù Responsive. </h2>
            <p>Quando la larghezza dello schermo è sotto i 767px, il menu viene nascosto e ottimizzato per Smartphone e Tablet. Ridimensiona la finestra per vedere il menu in azione.</p>
            </div>   
            <div class="form-group" id ="contenuto">
            <form style="display:none;" id="aggiornaProfilo" enctype="multipart/form-data" action="./modificaProfilo/modificaProfilo.php" method="POST">
                <div id="success" name="success" style="display:none;"></div>
                <div class="container">
                    <h1 style="font-size:20px; margin-bottom:10px;">Modifica il tuo profilo</h1>
                    <div id="success" class="alert alert-danger" style="display:none;"></div>
                <div class="form-group">
                    <label for="usr">Nome:</label>
                    <input style="width: 50%;" class="form-control" name="nome" id="nome" value="<?php echo $_SESSION['nome'];?>" required="true">
                </div>
                <div class="form-group">
                    <label for="usr">Cognome:</label>
                    <input style="width: 50%;" class="form-control" name="cognome" id="cognome" value="<?php echo $_SESSION['cognome'];?>" required="true">
                </div>
                <div class="form-group">
                    <label for="pwd">Email:</label>
                    <input style="width: 50%;" type="email" class="form-control"  name="email" id="email" value="<?php echo $_SESSION['email'];?>" required="true">
               </div>
               <div class="form-group">
                    <label for="pwd">Vecchia password:</label>
                    <input style="width: 50%;" type="password" class="form-control" name="pwd" id="pwd" required="true">
               </div>
                
                <div class="form-group">
                    <label for="pwd">Nuova password:</label>
                    <input style="width: 50%;" type="password" class="form-control" name="pwd2" id="pwd2" required="true">
               </div>
                    
                <div class="form-group">
                    <label for="pwd">Conferma nuova password:</label>
                    <input style="width: 50%;" type="password" class="form-control" name="pwd3" id="pwd3" required="true">
               </div>                   
                <div class="form-group">
                    <button id="btn-modifica" type="submit" class="btn btn-info"><i class="icon-hand-right"></i>Modifica</button> 
                </div>
                </div>
    </form>
            </div>
	</div> <!-- #main -->

</div> <!-- #wrapper -->
    </body>
</html>
