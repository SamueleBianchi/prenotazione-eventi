<div class="form-group" id ="divNuovoEvento">
        <form name="aggiungiEvento" id="aggiungiEvento" enctype="multipart/form-data" action="./eventi/aggiungiEvento.php" method="POST">
        <div class="container">
            <h1 style="font-size:20px; margin-bottom:10px;">Aggiungi un nuovo evento</h1>
            <div id="success" class="alert alert-danger" style="display:none;"></div>

        <div class="form-group">
            <label for="nome">Denominazione:</label>
            <input style="width: 50%;" class="form-control" name="denominazione" id="denominazione" required="true">
        </div>

        <?php 
            require "../Database/connect.php";
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

