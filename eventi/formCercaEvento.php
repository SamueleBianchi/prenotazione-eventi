<div>
    <form name="cercaEvento" id="cercaEvento" enctype="multipart/form-data">
        <h1 style="font-size:20px; margin-bottom:10px;">Cerca un evento</h1>
        <div class="form-group">
            <label for="recapito">Scrivi l'evento che vuoi ricercare:</label>
            <input class="form-control" name="evento" id="evento" required="true">
        </div>
        <div class="form-group">
            <button id="cerca_evento" type="submit" name="cerca_evento" class="btn btn-info"><i class="icon-hand-right"></i>Cerca</button> 
        </div>
        <div style="text-align: center"id="risultato" name="risultato" style="display:none;"></div>  
    </form>
</div>
