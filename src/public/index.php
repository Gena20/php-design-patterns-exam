<?php declare(strict_types=1);
/**
 * Entry script.​​
 */

/** @noinspection PhpIncludeInspection */
require sprintf('%s/vendor/autoload.php', dirname(__DIR__, 2));

use App\Controller\MainController;
use App\DataReader\CsvDataReader;
use App\DataReader\JsonDataReader;
use App\Http\Application;
use App\Routes\Config;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


$loader = new FilesystemLoader([dirname(__DIR__) . '/templates']);
$twig = new Environment($loader);
$csv = new CsvDataReader(dirname(__DIR__) . '/dataSource/data.csv');
$json = new JsonDataReader(dirname(__DIR__) . '/dataSource/data.json');

$controller = new MainController($twig, $csv, $json);

$routes = [
    '/cars' => static function () use ($controller): Response {
        return $controller->index();
    },
    '/car' => static function (Request $request) use ($controller): Response {
        return $controller->show($request);
    },
];
$routesConfig = Config::configure($routes);

$application = Application::getInstance($routesConfig);
$response = $application->handle(Request::createFromGlobals());
$response->send();
$application->dispose();