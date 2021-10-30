<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Url;
use Phalcon\Db\Adapter\Pdo\Mysql;

// Define some absolute path constants to aid in locating resources
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

// Register an autoloader
$loader = new Loader();

$loader->registerFiles([BASE_PATH . '/vendor/autoload.php']);

$loader->registerDirs(
    [
        APP_PATH . '/controllers/',
        APP_PATH . '/models/',
        APP_PATH . '/services/',
//        APP_PATH . '/../vendor/',
    ]
);

$loader->register();

$container = new FactoryDefault();

$container->set(
    'db',
    function () {
        return new Mysql(
            [
                'host'     => 'db',
                'username' => 'root',
                'password' => 'root',
                'dbname'   => 'tg_tyl',
            ]
        );
    }
);

$container->set(
    'router',
    function () {
        require APP_PATH . '/config/router.php';

        return $router;
    }
);

$container->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);

$container->set(
    'url',
    function () {
        $url = new Url();
        $url->setBaseUri('/');
        return $url;
    }
);

$application = new Application($container);

try {
    // Handle the request
    $response = $application->handle(
        $_SERVER["REQUEST_URI"] ?? '/'
    );

    $response->send();
} catch (\Exception $e) {
//    $response = new \Phalcon\Http\Response();
//    $response->setStatusCode(404, "Page not Found");
//    $response->send();die;


    echo 'Exception: ', $e->getMessage();
    echo '<pre>';
    print_r($e->getTraceAsString());
}