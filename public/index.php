<?php


require_once __DIR__ . '/../vendor/autoload.php';

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

$request->headers->set('Access-Control-Allow-Origin', '*');
$request->headers->set('Content-Type', 'application/json');

if ($request->getMethod() === 'OPTIONS') {
    $request->headers->set('HTTP/1.1 200', 'Created');
    $request->headers->set('Access-Control-Allow-Methods', 'POST');
    $request->headers->set('Access-Control-Allow-Credentials', 'true');
    $request->headers->set('Access-Control-Allow-Headers', 'X-Requested-With, X-HTTP-Method-Override, Content-Type, Accept');
    return;
}

set_exception_handler(function (\Exception $e) {
    http_response_code(200);
    print json_encode(['error' => $e->getMessage()]);
    return;
});



$handler = new \Refactor\Application\Handler($request);
$response = $handler->run(
    new \Refactor\Application\DataSource\Csv('../data/users.csv')
);
$response->send();