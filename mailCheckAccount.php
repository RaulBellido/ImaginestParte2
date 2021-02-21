<?php
session_start();

include 'includes/connect.php';
include 'includes/functions.php';

if(isset($_GET['mail']) && !empty($_GET['mail']) AND isset($_GET['activationcode']) && !empty($_GET['activationcode'])){
    // Rebem les dades
    $hash = filter_input(INPUT_GET, 'activationcode');
    $email = filter_input(INPUT_GET, 'mail');
    
    if(comprovaCodiActivacio($email, $hash) > 0){
        activarCompte($email, $hash);        
    }
                  
}

header('Location: index.php');
exit;