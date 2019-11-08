<?php

require_once('../vendor/autoload.php');

use App\App;


//try{
    $monApp = App::getInstance();
    $monApp -> demarrer();
//}
//catch(Throwable $error){
//    echo "Revenez plus tard";
//    error_log($error->getTraceAsString() . "\n", 1, "../ressources/error_log.txt");
//}
