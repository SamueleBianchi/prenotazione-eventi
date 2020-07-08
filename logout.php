<?php
session_start();
unset($_SESSION['email']);
session_destroy();
header('Location: accessPage.php');
exit();

