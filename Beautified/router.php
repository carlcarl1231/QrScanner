<?php

define('BASE_PATH', __DIR__);

define('BASE_URL', '/scanner/Beautified/index.php');


$fullUri = $_SERVER['REQUEST_URI'];

$baseDir = '/scanner/Beautified/index.php';
$uri = str_replace($baseDir, '', parse_url($fullUri, PHP_URL_PATH));

$routes = [
    '/' => 'controllers/index.php',
    '/about' => 'controllers/about.php',
    '/contact' => 'controllers/contact.php',
    '/scanner' => 'controllers/scanner/index.php',
    '/note' => 'controllers/note.php',
    '/notes' => 'controllers/notes.php',
];

function routeToController($uri, $routes)
{
    if (array_key_exists($uri, $routes)) {
        $path = BASE_PATH . '/' . $routes[$uri];
        if (!file_exists($path)) {
            http_response_code(500); 
            echo "Error: Controller not found at $path";
            die();
        }
        require $path;
    } else {
        http_response_code(404);
        echo "404: Page not found!";
        die();
    }
}

routeToController($uri, $routes);
