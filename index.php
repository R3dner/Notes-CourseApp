<?php

declare(strict_types=1);

spl_autoload_register(function(string $classNamespace){
    $path = str_replace(['\\', 'App'], ['/', ''], $classNamespace);
    $path = "src$path.php";
    require_once($path);
});

require_once("src/utils/debug.php");
$db_config = require_once("config/db_conf.php");

use App\Request;
use App\Controller\AbstractController;
use App\Controller\NoteController;
use App\Exception\AppException;
use App\Exception\ConfigurationException;

$request = new Request($_GET, $_POST, $_SERVER);

try{
    AbstractController::initConfiguration($db_config);

    $controller = new NoteController($request);
    $controller->run();
}catch(ConfigurationException $e){
    echo "<h1>Wystąpił błąd aplikacji</h1>";
    echo '<h3>Problem z konfiguracją.</h3>
            Proszę skontaktować się z administratorem';
}catch(AppException $e){
    echo "<h1>Wystąpił błąd aplikacji</h1>";
    echo '<h3>' . $e->getMessage() . '</h3>';
}catch(Throwable $e){
    echo "<h1>Wystąpił błąd aplikacji</h1>";
}
?>

