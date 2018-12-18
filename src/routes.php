<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes
/*
  $app->get('/[{name}]', function (Request $request, Response $response, array $args) {
  // Sample log message
  $this->logger->info("Slim-Skeleton '/' route");

  // Render index view
  return $this->renderer->render($response, 'index.phtml', $args);
  });
 */
$app->get('/listEmployees', function (Request $request, Response $response, array $args) {
    $db = getConnection();
    $sql_emp = "SELECT * FROM employees ORDER BY emp_id ASC";
    $stmt_emp = $db->query($sql_emp);
    $empList = $stmt_emp->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($empList);
});
$app->post('/addEmployee', function (Request $request, Response $response, array $args) {
    $db = getConnection();
    $parsedBody = $request->getParsedBody();
    $firstName = $parsedBody["firstName"];
    $lastName = $parsedBody["lastName"];
    $email = $parsedBody["email"];
    $mobile = $parsedBody["mobile"];

    $sqlInsert = "INSERT INTO employees SET first_name = '" . $firstName . "', last_name = '" . $lastName . "', email = '" . $email . "', mobile = '" . $mobile . "'";
    $stmtInsert = $db->prepare($sqlInsert);
    $stmtInsert->execute();
    
    echo "success";
});
$app->get('/deleteEmployee/[{emp_id}]', function (Request $request, Response $response, array $args) {
    $db = getConnection();
    $emp_id = $args['emp_id'];
    $sqlDelete = "DELETE FROM employees WHERE emp_id = '" . $emp_id . "'";
    $stmtDelete = $db->prepare($sqlDelete);
    $stmtDelete->execute();
    
    echo "success";
});
