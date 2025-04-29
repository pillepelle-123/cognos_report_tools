<?php
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder; 
use Cake\Routing\Router; // NEU

Router::defaultRouteClass(DashedRoute::class);

return function (RouteBuilder $routes): void {
    $routes->scope('/', function (RouteBuilder $builder): void {
        $builder->connect('/queries', ['controller' => 'QueryExpander', 'action' => 'queries']);  
        $builder->connect('/settings', ['controller' => 'QueryExpander', 'action' => 'settings']);
        $builder->connect('/result', ['controller' => 'QueryExpander', 'action' => 'result']);
        $builder->connect('/download', ['controller' => 'QueryExpander', 'action' => 'resultDownload']);
        $builder->fallbacks('DashedRoute');
    });
}

// Router::plugin('QueryExpander', ['path' => '/query-expander'], function (RouteBuilder $routes) {
//     $routes->connect('/', ['controller' => 'QueryExpander', 'action' => 'queries']);  // action umbenannt
//     $routes->connect('/settings', ['controller' => 'QueryExpander', 'action' => 'settings']);  // action umbenannt
//     $routes->connect('/result', ['controller' => 'QueryExpander', 'action' => 'result']);  // action umbenannt
//     $routes->connect('/download', ['controller' => 'QueryExpander', 'action' => 'resultDownload']);  // action umbenannt
//     $routes->fallbacks('DashedRoute');
// });
?>