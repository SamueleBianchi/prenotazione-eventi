<?php 
$_SERVER['PHP_SELF'];
session_start(); 
if(!isset($_SESSION['email'])){
header('Location: accessPage.php');
}?> 
<div class="form-group" id ="contenuto">
    <form id="aggiornaProfiloAdmin" enctype="multipart/form-data" action="./modificaProfilo/modificaProfilo2.php" method="POST">
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
