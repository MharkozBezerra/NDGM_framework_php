<?php
require __DIR__ . '/vendor/autoload.php';

use \App\Http\Router;
use \App\Http\Response;
use App\Controller\Pages\Home;

define('URL', 'https://www.mharkozbezerra.com/NDGM_framework_php');

$rota = new Router(URL);

//Home
$rota->get('/', [
    function () {
        return new Response(200, Home::getHome());
    }
]);

// Imprime a resposta da página
$rota->executar()->enviarResposta();

//echo Home::getHome();
