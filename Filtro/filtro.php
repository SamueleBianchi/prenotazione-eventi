<?php
/**
 * 
 * @param type $str stringa da sanificare
 * @return type ritorna la stringa sanificata
 */
function filtra($str){
    $corretta = trim($str);//elimino gli spazi all'inizio e alla fine della riga
    $corretta = stripslashes($corretta);//rimuovo il carattere di backslash
    $corretta = htmlspecialchars($corretta);
    return $corretta;
}
