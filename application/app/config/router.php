<?php

use Phalcon\Mvc\Router;

$router = new Router();

$router->add(
    "/time-your-life/:params",
    [
        'controller' => 'tyl',
        'action'     => 'index',
        'params' => 1
    ],
    ["GET", "POST"]
);

$router->add(
    "/time-your-life/users",
    [
        'controller' => 'tyl',
        'action'     => 'getUsers',
    ],
);

return $router;
