<?php

require_once('../vendor/autoload.php');

use App\App;


try{
    $monApp = App::getInstance();
    $monApp -> demarrer();
}
catch(Throwable $error){
    echo "Revenez plus tard";
    error_log($error->getTraceAsString() . "\n", 3, "../ressources/error_log.txt");
}
