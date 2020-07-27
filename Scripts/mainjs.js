/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){   
    
		//When btn is clicked
		$(".btn-responsive-menu").click(function() {
			$("#mainmenu").toggleClass("show");
		
		});
                
                $('li').click(function(){   
                switch($(this).attr("id")){
                    case "profilo":
                        $('#main').empty();
                        if($(window).width() < 767){
                            $("#mainmenu").toggleClass("show");
                        }
                        $('#main').load("./modificaProfilo/formModificaProfilo.php");
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
                        $('#main').empty();
                        if($(window).width() < 767){
                            $("#mainmenu").toggleClass("show");
                        }
                        $('#main').load("./eventi/formCercaEvento.php");
                        break;
                }
                });
                
//                $("#aggiungi").click(function(){
//                        $("#testo").text("");
//                        $("#gestisciEvento").css("display", "none");
//                        $("#aggiornaProfilo").css("display","none");
//                        
//                       if($(window).width() < 767){
//                            $("#mainmenu").toggleClass("show");
//                        }
//                        $("#aggiungiEvento").css("display","block");
//                }); 
//                
//                $("#gestisci").click(function(){
//                        $("#testo").text("");
//                        $("#aggiornaProfilo").css("display","none");
//                        $("#aggiungiEvento").css("display","none");
//                       if($(window).width() < 767){
//                            $("#mainmenu").toggleClass("show");
//                        }
//                        $("#gestisciEvento").css("display","block");
//                }); 
                
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
    
     

