<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
require_once('db.php');
require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");
    return $response;
});

$app->get('/classes', function(Request $request, Response $response, $args) {
    
    $query = "select * from classes";
    $result = $pdo->query($query);
    // var_dump($result);
    while ($row = $result->fetch(PDO::FETCH_ASSOC)){
        $data[] = $row;
    }
    //echo json_encode($data);
    //$response->withJson($data);
    $payload = json_encode($data);

    $response->getBody()->write($payload);
    return $response
          ->withHeader('Content-Type', 'application/json');
});

$app->get('/heroes', function(Request $request, Response $response, $args) {

    $query = "select * from heroes";
    $result = $pdo->query($query);
    // var_dump($result);
    while ($row = $result->fetch(PDO::FETCH_ASSOC)){
        $data[] = $row;
    }
    //echo json_encode($data);
    //$response->withJson($data);
    $payload = json_encode($data);

    $response->getBody()->write($payload);
    return $response
          ->withHeader('Content-Type', 'application/json');
});


$app->run();
?>