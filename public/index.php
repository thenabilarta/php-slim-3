<?php

declare(strict_types=1);

use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;
use App\Application\Middleware\ExampleBeforeMiddleware;
use App\Application\Middleware\ExampleAfterMiddleware;
use Psr\Http\Message\ServerRequestInterface as RequestInterface;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->addErrorMiddleware(true, true, false);

$app->get('/hello/{name}', function (RequestInterface $request, ResponseInterface $response, $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
})->add(new ExampleAfterMiddleware())->add(new ExampleBeforeMiddleware());

$app->get('/user/{name}', function (RequestInterface $request, ResponseInterface $response, $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
});

$app->run();