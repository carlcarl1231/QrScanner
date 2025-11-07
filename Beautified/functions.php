<?php


function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";

    die();
}

function abort($code = 404)
{
    http_response_code($code);
    
}

function urlIs($url) {
    $currentUrl = $_SERVER['REQUEST_URI'];
    $projectFolder =  dirname($_SERVER['SCRIPT_NAME']);
    return $currentUrl === $projectFolder . $url || $currentUrl === $url;
}

function authorize($condition, $status = Response::FORBIDDEN) {
    if (!$condition) {
        abort($status);
    }
}


