<?php

use Slim\Http\Request;
use Slim\Http\Response;

require '../src/config/database.php';

// Routes

// $app->get('/[{name}]', function (Request $request, Response $response, array $args) {
//     // Sample log message
//     $this->logger->info("Slim-Skeleton '/' route");

//     // Render index view
//     return $this->renderer->render($response, 'index.phtml', $args);
// });

//Get All Customers
$app->get('/', function(Request $request, Response $response){
    
    $sql = "select * from customers";

    try {
        $database = new Database();

        $database->query("SELECT * FROM customers");

        $results = $database->results();

        foreach ($results as $result)
        {
            echo $result->first_name;
        }
        return $this->renderer->render($response, 'index.phtml', [$resultss => $results]);

    } catch (PDOException $th) {
        echo '{"error": {"text": '.$th->getMessage().'}';
    }
});

//Get Single customer
$app->get('/api/customers/{id}', function(Request $request, Response $response){
    
    $id = $request->getAttribute('id');

    try {
        $database = new Database();

        $database->query("SELECT * FROM customers WHERE id = :id");

        $database->bind(':id', $id);

        $results = $database->single();

        echo json_encode($results);

    } catch (PDOException $th) {
        echo '{"error": {"text": '.$th->getMessage().'}';
    }
});

//Add customer
$app->post('/api/customers/add', function(Request $request, Response $response){
    
    $first_name = $request->getParam('first_name');
    $last_name = $request->getParam('last_name');
    $phone = $request->getParam('phone');
    $email = $request->getParam('email');
    $address = $request->getParam('address');
    $city = $request->getParam('city');
    $state = $request->getParam('state');

    try {
        $database = new Database();

        $database->query("INSERT INTO customers(first_name, last_name, phone, email, `address`, city,`state`) values (:first_name, :last_name, :phone, :email, :address :city, :state)");

        $database->bind(':first_name', $first_name);
        $database->bind(':last_name', $last_name);
        $database->bind(':phone', $phone);
        $database->bind(':email', $email);
        $database->bind(':address', $address);
        $database->bind(':city', $city);
        $database->bind(':state', $state);

        $database->execute();

        echo '{"notice": {"text": "Customer added"}';

        echo json_encode($results);

    } catch (PDOException $th) {
        echo '{"error": {"text": '.$th->getMessage().'}';
    }
});

//Update customer
$app->put('/api/customers/update/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');

    $first_name = $request->getParam('first_name');
    $last_name = $request->getParam('last_name');
    $phone = $request->getParam('phone');
    $email = $request->getParam('email');
    $address = $request->getParam('address');
    $city = $request->getParam('city');
    $state = $request->getParam('state');

    try {
        $database = new Database();

        $database->query("UPDATE customers SET
                            first_name = :first_name,
                            last_name = :last_name,
                            phone = :phone,
                            email = :email,
                            `address` = :address,
                            city = :city,
                            `state` = :state,
                        WHERE id = :id");

        $database->bind(':first_name', $first_name);
        $database->bind(':last_name', $last_name);
        $database->bind(':phone', $phone);
        $database->bind(':email', $email);
        $database->bind(':address', $address);
        $database->bind(':city', $city);
        $database->bind(':state', $state);
        $database->bind(':id', $id);

        $database->execute();

        echo '{"notice": {"text": "Customer Updated"}';

        echo json_encode($results);

    } catch (PDOException $th) {
        echo '{"error": {"text": '.$th->getMessage().'}';
    }
});

//Delete customer
$app->delete('/api/customers/delete/{id}', function(Request $request, Response $response){
    
    $id = $request->getAttribute('id');

    try {
        $database = new Database();

        $database->query("DELETE FROM customers WHERE id = :id");

        $database->execute();

        echo '{"notice": {"text": "Customer Deleted"}';

    } catch (PDOException $th) {
        echo '{"error": {"text": '.$th->getMessage().'}';
    }
});