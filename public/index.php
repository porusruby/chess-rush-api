<!-- make sure the attribute enctype is set to multipart/form-data -->
<form action="add" method="post" enctype="multipart/form-data">
    <!-- upload of a single file -->
    <p>
        <label>Add file (single): </label><br/>
        <input type="text" name="name"/>
    </p>
</form>
<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");
    return $response;
});

$app->get('/classes', function(Request $request, Response $response, $args) {
    require_once('db.php');
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
    require_once('db.php');
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

$app->post('/add', function ($request, $response, $args) {
    //Create book
    require_once('db.php');
    $stmt = $pdo->prepare("INSERT INTO classes
											(name)
											VALUES(:name)" );


	$stmt->bindParam(":name", $_POST["name"], PDO::PARAM_STR);
    $count = $stmt->execute();
    $response->getBody()->write("Data has been added");
    return $response;
});

$app->delete('/delete/{id}', function ($request, $response, $args) {
    require_once('db.php');
    $id = $args['id'];
    $del = $pdo->query("DELETE FROM classes WHERE id='$id'");
    $del->execute();
    $response->getBody()->write("Data has been deleted");
    return $response;
});




$app->run();
?>