<div>
    <form name="gestisciEvento" id="gestisciEvento" enctype="multipart/form-data" action="./gestioneEvento/gestioneEvento.php" method="POST">
        <h1 style="font-size:20px; margin-bottom:10px;">Cerca un evento</h1>
        <div class="form-group">
            <label for="recapito">Scrivi l'evento che vuoi ricercare:</label>
            <input style="width: 50%;" class="form-control" name="evento" id="evento" required="true">
        </div>
        <div class="form-group">
            <button id="btn-modifica" type="submit" class="btn btn-info"><i class="icon-hand-right"></i>Cerca</button> 
        </div>
        <div id="risultato" name="risultato" style="display:none;"></div>  
    </form>
</div>
