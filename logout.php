<?php
session_start();
unset($_SESSION['email']);
if(!isset($_SESSION['id'])){
    unset($_SESSION['id']);
}
session_destroy();//distruggo la sessione
header('Location: accessPage.php');//ritorno alla pagina di accesso
exit();

