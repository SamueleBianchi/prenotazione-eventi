<?php
session_start();
unset($_SESSION['email']);
if(!isset($_SESSION['id'])){
    unset($_SESSION['id']);
}
session_destroy();
header('Location: accessPage.php');
exit();

