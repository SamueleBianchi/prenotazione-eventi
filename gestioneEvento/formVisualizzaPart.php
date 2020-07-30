<div>
    <form name="vis_partecipanti" id="vis_partecipanti" enctype="multipart/form-data">
        <h1 style="font-size:20px; margin-bottom:10px;">Cerca i partecipanti di un evento</h1>
        <div class="form-group">
            <label for="evento">Scrivi l'evento che vuoi ricercare:</label>
            <input class="form-control" name="evento" id="evento" required="true">
        </div>
        <div class="form-group">
            <button id="cerca_partecipanti" type="submit" name="cerca_partecipanti" class="btn btn-info"><i class="icon-hand-right"></i>Cerca</button> 
        </div>
        <div style="text-align: center"id="success" name="success" style="display:none;"></div>  
    </form>
</div>
