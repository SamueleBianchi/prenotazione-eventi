/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 5, mirror: false });

function prenotazione(content){
    if(content.startsWith("id=")){
        $.get("./eventi/prenotazione.php?"+content, function(data, status){
            $('#main2').css("display", "none"); // show response from the php script.
            scanner.stop();
            $("#main").html(data); // show response from the php script.
        });
    }else{
            $('#main2').css("display", "none"); // show response from the php script.
            scanner.stop();
            $("#main").html('<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove"></span> Errore : QR code non valido.</div>'); // show response from the php script.
    }
    }
    
$(document).ready(function(){   
                 
		//When btn is clicked
		$(".btn-responsive-menu").click(function() {
			$("#mainmenu").toggleClass("show");
		
		});
                
                $('li').click(function(){   
                switch($(this).attr("id")){
                    case "profilo":
                        scanner.stop();
                        $('#main').empty();
                        $('#main2').css("display", "none");
                        if($(window).width() < 767){
                            $("#mainmenu").toggleClass("show");
                        }
                        $('#main').load("./modificaProfilo/formModificaProfilo.php");
                        break;
                    case "profilo2":
                        scanner.stop();
                        $('#main').empty();
                        $('#main2').css("display", "none");
                        if($(window).width() < 767){
                            $("#mainmenu").toggleClass("show");
                        }
                        $('#main').load("./modificaProfilo/formModificaProfiloAdmin.php");
                        break;
                    case "aggiungi":
                        $('#main').empty();
                        if($(window).width() < 767){
                            $("#mainmenu").toggleClass("show");
                        }
                        $('#main').load("./eventi/formAggiungiEvento.php");
                        break;
                    case "gestisci":
                        $('#main').empty();
                        if($(window).width() < 767){
                            $("#mainmenu").toggleClass("show");
                        }
                        $('#main').load("./gestioneEvento/formGestioneEvento.php");
                        break;
                    case "ricerca":
                        if(scanner !== null){
                            scanner.stop();
                        }
                        $('#main').empty();
                        $('#main2').css("display", "none");
                        if($(window).width() < 767){
                            $("#mainmenu").toggleClass("show");
                        }
                        $('#main').load("./eventi/formCercaEvento.php");
                        break;
                    case "partecipanti":
                        if(scanner !== null){
                            scanner.stop();
                        }
                        $('#main').empty();
                        $('#main2').css("display", "none");
                        if($(window).width() < 767){
                            $("#mainmenu").toggleClass("show");
                        }
                        $('#main').load("./gestioneEvento/formVisualizzaPart.php");
                        break;
                    case "miei_eventi":
                        $('#main').empty();
                        $('#main2').css("display", "none");
                        if(scanner !== null){
                            scanner.stop();
                        }
                        $.ajax({
                        type: "POST",
                        url: "./gestioneEvento/eventiPrenotati.php",
                        data :{},
                        success: function(data)
                        {
                            $("#main").empty(); // show response from the php script.
                            $("#main").html(data); // show response from the php script.
                            $("#main").css("display", "block");
                        }
                        });
                        break;
                    case "scan":
                        $('#main').empty();
                        if($(window).width() < 767){
                            $("#mainmenu").toggleClass("show");
                        }
                        $('#main2').css("display", "block");
					scanner.addListener('scan',function(content){
                                                prenotazione(content);
					});
                                        $('li').click(function(){
                                            scanner.stop();
                                        });
					Instascan.Camera.getCameras().then(function (cameras){
						if(cameras.length>0){
							scanner.start(cameras[0]);
							$('[name="options"]').on('change',function(){
								if($(this).val()==1){
									if(cameras[1]!=""){
										scanner.start(cameras[0]);
									}else{
										alert('Nessuna fotocamera frontale trovata!');
									}
								}else if($(this).val()==2){
									if(cameras[0]!=""){
										scanner.start(cameras[1]);
									}else{
										alert('Nessuna fotocamera posteriore trovata!');
									}
								}
							});
						}else{
							console.error('Nessuna fotocamera trovata.');
							alert('Nessuna fotocamera trovata.');
						}
					}).catch(function(e){
						console.error(e);
						alert(e);
					});
                        break;
                }
                });                
    });
    
    
    
    $(document).on('submit', 'form#aggiornaProfilo', function(evt){
                    $.ajax({
                    type: "POST",
                    url: "./modificaProfilo/modificaProfiloUtente.php",
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
                 
     $(document).on('submit', 'form#evento_pren', function(evt){
                    $.ajax({
                    type: "POST",
                    url: "./gestioneEvento/annullaPrenotazione.php",
                    data :{denominazione: $("#denominazione").val(),IdEvento: $("#IdEvento").val()},
                    success: function(data)
                    {
                        $("#main").empty(); // show response from the php script.
                        $("#main").html(data); // show response from the php script.
                    }
                    });
                    evt.preventDefault(); 
                 });
                 
    $(document).on('submit', 'form#aggiornaProfiloAdmin', function(evt){
                    $.ajax({
                    type: "POST",
                    url: "./modificaProfilo/modificaProfiloAdmin.php",
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
                 
    $(document).on('submit', 'form#vis_partecipanti', function(evt){
                    $.ajax({
                    type: "POST",
                    url: "./gestioneEvento/visualizzaUtenti.php",
                    data :{evento: $("#evento").val()},
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
                 
      $(document).on('submit', 'form#gestisciEvento', function(evt){
                    $.ajax({
                    type: "POST",
                    url: "./gestioneEvento/gestioneEvento.php",
                    data :{evento: $("#evento").val()},
                    success: function(data)
                    {
                        $("#risultato").empty(); // show response from the php script.
                        $("#risultato").html(data); // show response from the php script.
                        $("#risultato").css("display", "block");
                    }
                    });
                    evt.preventDefault(); 
                 });
                 
       $(document).on('click', 'button#modifica_bottone', function(evt){
                    $.ajax({
                    type: "POST",
                    url: "./gestioneEvento/modificaEvento.php",
                    data :{id_evento: $("#id_evento").val(), denominazione2: $("#denominazione2").val(), 
                        città2: $("#città2").val(),tipologia2: $("#tipologia2").val(), provincia2: $("#provincia2").val(),
                        via2: $("#via2").val(), datainizio2: $("#datainizio2").val(), descrizione2: $("#descrizione2").val(),
                        datafine2: $("#datafine2").val(),recapito2: $("#recapito2").val(),
                        maxiscritti2: $("#maxiscritti2").val(), prezzo2: $("#prezzo2").val(),
                    sito2: $("#sito2").val()},
                    success: function(data)
                    {
                        $("#risultato").empty(); // show response from the php script.
                        $("#risultato").html(data); // show response from the php script.
                        $("#risultato").css("display", "block");
                    }
                    });
                    evt.preventDefault(); 
                 });
                 
        $(document).on('click', 'button#elimina_bottone', function(evt){
                    $.ajax({
                    type: "POST",
                    url: "./gestioneEvento/eliminaEvento.php",
                    data :{id_evento: $("#id_evento").val()},
                    success: function(data)
                    {
                        $("#risultato").empty(); // show response from the php script.
                        $("#risultato").html(data); // show response from the php script.
                        $("#risultato").css("display", "block");
                    }
                    });
                    evt.preventDefault(); 
                 });
                 
        $(document).on('click', 'button#cerca_evento', function(evt){
                    $.ajax({
                    type: "POST",
                    url: "./eventi/cercaEvento.php",
                    data :{evento: $("#evento").val()},
                    success: function(data)
                    {
                        $("#risultato").empty(); // show response from the php script.
                        $("#risultato").html(data); // show response from the php script.
                        $("#risultato").css("display", "block");
                    }
                    });
                    evt.preventDefault(); 
                 });
    
     

