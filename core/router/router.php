<?php
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$routes = require 'routes.php';

function abort($code = 404){
    $errorPage = basePath("ui/error/{$code}.php");
    
    if (file_exists($errorPage)) {
      require $errorPage;
    } else {
      require basePath("ui/error/default_error_view.php"); // Fallback error page
    }
    
    http_response_code($code);
    exit();
  }

function routeToPages ($uri, $routes) {
    if(array_key_exists($uri, $routes)){
        require $routes[$uri];
    } else {
        abort();
    }
}

routeToPages($uri, $routes);