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
     
     <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">

        <script type="text/javascript" src="//code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
    <script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
    <link rel="stylesheet" href="./stili/style_homepage.css">
    <script>
    $(document).ready(function(){   
    
		//When btn is clicked
		$(".btn-responsive-menu").click(function() {
			$("#mainmenu").toggleClass("show");
		
		});
    
    
                $("#profilo").click(function(){
                        $("#testo").text("");
                        $("#aggiungiEvento").css("display","none");
                       if($(window).width() < 767){
                            $("#mainmenu").toggleClass("show");
                        }
                        $("#aggiornaProfilo").css("display","block");
                });
                
                $("#aggiungi").click(function(){
                        $("#testo").text("");
                        $("#aggiornaProfilo").css("display","none");
                       if($(window).width() < 767){
                            $("#mainmenu").toggleClass("show");
                        }
                        $("#aggiungiEvento").css("display","block");
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
                 
     $(document).on('submit', 'form#aggiungiEvento', function(evt){
                    $.ajax({
                    type: "POST",
                    url: "./eventi/aggiungiEvento.php",
                    data :{denominazione: $("#denominazione").val(),città: $("#città").val(),tipologia: $("#tipologia").val(),provincia: $("#provincia").val(),via: $("#via").val(), datainizio: $("#datainizio").val(), datafine: $("#datafine").val(),maxiscritti: $("#maxiscritti").val(),prezzo: $("#prezzo").val(), sito: $("#sito").val(),recapito: $("#recapito").val(),descrizione: $("#descrizione").val()},
                    success: function(data)
                    {
                        $("#successo").empty(); // show response from the php script.
                        $("#successo").html(data); // show response from the php script.
                        $("#successo").css("display", "block");
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
            <li><a id="profilo"><span class="glyphicon glyphicon-user"></span> Profilo</a></li>
            <li><a id="aggiungi"><span class="glyphicon glyphicon-plus"></span> Aggiungi evento</a></li>
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
                    <label for="nome">Nome:</label>
                    <input style="width: 50%;" class="form-control" name="nome" id="nome" value="<?php echo $_SESSION['nome'];?>" required="true">
                </div>
                <div class="form-group">
                    <label for="cognome">Cognome:</label>
                    <input style="width: 50%;" class="form-control" name="cognome" id="cognome" value="<?php echo $_SESSION['cognome'];?>" required="true">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input style="width: 50%;" type="email" class="form-control"  name="email" id="email" value="<?php echo $_SESSION['email'];?>" required="true">
               </div>
               <div class="form-group">
                    <label for="pwd">Vecchia password:</label>
                    <input style="width: 50%;" type="password" class="form-control" name="pwd" id="pwd" required="true">
               </div>
                
                <div class="form-group">
                    <label for="pwd2">Nuova password:</label>
                    <input style="width: 50%;" type="password" class="form-control" name="pwd2" id="pwd2" required="true">
               </div>
                    
                <div class="form-group">
                    <label for="pwd3">Conferma nuova password:</label>
                    <input style="width: 50%;" type="password" class="form-control" name="pwd3" id="pwd3" required="true">
               </div>                   
                <div class="form-group">
                    <button id="btn-modifica" type="submit" class="btn btn-info"><i class="icon-hand-right"></i>Modifica</button> 
                </div>
                </div>
    </form>
            </div>
            
            
            <div class="form-group" id ="divNuovoEvento">
                <form style="display:none;" name="aggiungiEvento" id="aggiungiEvento" enctype="multipart/form-data" action="./eventi/aggiungiEvento.php" method="POST">
                <div class="container">
                    <h1 style="font-size:20px; margin-bottom:10px;">Aggiungi un nuovo evento</h1>
                    <div id="success" class="alert alert-danger" style="display:none;"></div>
                    
                <div class="form-group">
                    <label for="nome">Denominazione:</label>
                    <input style="width: 50%;" class="form-control" name="denominazione" id="denominazione" required="true">
                </div>
                
                <?php 
                    require "./Database/connect.php";
                    $query = "SELECT nome FROM province";
                    $risultato = $connessione->query($query);
                    echo '<div class="form-group">
                    <label for="provincia">Provincia:</label>
                    <select class="form-control" id="provincia" name="provincia" style="width: 50%;">';
                    while($riga = $risultato->fetch(PDO::FETCH_ASSOC)){
                        echo '<option value="'.$riga['nome'].'">'.$riga['nome'].'</option>';
                    }
                    echo '</select></div>';
                ?>
                
                <div class="form-group">
                    <label for="città">Città:</label>
                    <input style="width: 50%;" class="form-control" name="città" id="città" required="true">
                </div>
                    
                 <div class="form-group">
                    <label for="tipologia">Tipologia:</label>
                    <select class="form-control" name="tipologia" id="tipologia" style="width: 50%;">
                      <option value="Manifestazione">Manifestazione</option>
                      <option value="Incontro">Incontro</option>
                      <option value="Concerto">Concerto</option>
                      <option value="Mostra">Mostra</option>
                      <option value="Sagra">Sagra</option>
                      <option value="Teatro">Teatro</option>
                      <option value="Fiera">Fiera</option>
                      <option value="Cibo e vino">Cibo e vino</option>
                      <option value="Disco e feste">Disco e feste</option>
                      <option value="Cinema">Cinema</option>
                      <option value="Sport">Sport</option>
                      <option value="Inaugurazione">Inaugurazione</option>
                      <option value="Mercatino">Mercatino</option>
                      <option value="Escursione">Escursione</option>
                      <option value="Promozione">Promozione</option>
                      <option value="Corso">Corso</option>
                      <option value="Hobby">Hobby</option>
                      <option value="Turismo">Turismo</option>
                    </select>
                  </div> 
                    
                <div class="form-group">
                    <label for="via">Via:</label>
                    <input style="width: 50%;" type="text" class="form-control"  name="via" id="via" required="true">
               </div>
                    
                <div class="container">
                <div class="row">

                        <div class="form-group">
                        <label for="dtpickerinizio">Data e ora inizio evento:</label>
                            <div class='col-sm-4 input-group date' id='dtpickerinizio'>
                                <input type='text' class="form-control" id="datainizio" name="datainizio" required="true"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    <script type="text/javascript">
                        $(function () {
                            $('#dtpickerinizio').datetimepicker({
                                locale: 'it'
                            });
                        });
                    </script>
                </div>
                </div> 
                    
                    <div class="container">
                <div class="row">

                        <div class="form-group">
                        <label for="dtpickerfine">Data e ora termine evento:</label>
                            <div class='col-sm-4 input-group date' id='dtpickerfine'>
                                <input type='text' class="form-control" id="datafine" name="datafine" required="true"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    <script type="text/javascript">
                        $(function () {
                            $('#dtpickerfine').datetimepicker({
                                locale: 'it'
                            });
                        });
                    </script>
                </div>
                </div>
                                    
                <div class="form-group">
                    <label for="maxiscritti">Numero massimo di iscritti:</label>
                    <input style="width: 50%;" type="number" class="form-control" name="maxiscritti" id="maxiscritti" required="true">
                </div>
                
                <div class="form-group">
                    <label for="prezzo">Prezzo:</label>
                    <input style="width: 50%;" class="form-control" name="prezzo" id="prezzo" required="true">
                </div>
                
                <div class="form-group">
                    <label for="sito">Sito:</label>
                    <input style="width: 50%;" class="form-control" name="sito" id="sito" required="true">
                </div>
                    
                <div class="form-group">
                    <label for="recapito">Recapito:</label>
                    <input style="width: 50%;" class="form-control" name="recapito" id="recapito" required="true">
                </div>
                
                <div class="form-group">
                    <label for="descrizione">Descrizione:</label>
                    <textarea class="form-control" rows="5" name="descrizione" id="descrizione"></textarea>
                </div>
                    
                <div class="form-group">
                    <button id="btn-modifica" type="submit" class="btn btn-info"><i class="icon-hand-right"></i>Aggiungi</button> 
                </div>
                    
                <div id="successo" name="successo" style="display:none;"></div>    
                
                </div>
    </form>
            </div>
	</div> <!-- #main -->

</div> <!-- #wrapper -->
    </body>
</html>
