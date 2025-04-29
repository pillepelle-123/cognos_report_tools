<?php
/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder; 
use Cake\Routing\Router; // NEU

Router::defaultRouteClass(DashedRoute::class);

/* NEU NEU NEU NEU NEU */

return function (RouteBuilder $routes): void {
    $routes->scope('/', function (RouteBuilder $builder): void {
        // Hauptroute für Reports
        $builder->connect('/', ['controller' => 'Reports', 'action' => 'index']);
        
        // Report-spezifische Routen
        $builder->connect('/upload', ['controller' => 'Reports', 'action' => 'upload']);
        $builder->connect('/edit/*', ['controller' => 'Reports', 'action' => 'edit']);
        $builder->connect('/view/*', ['controller' => 'Reports', 'action' => 'view']);
        $builder->connect('/delete/*', ['controller' => 'Reports', 'action' => 'delete']);
        $builder->connect('/crt-apps/*', ['controller' => 'Reports', 'action' => 'crtApps']);

        /*$builder->connect('/query-expander/:report_id', 
            ['controller' => 'Apps', 'action' => 'queryExpander']
        )->setPass(['report_id']);*/

        //App-spezifische Routen
        $builder->connect('/users/edit', ['controller' => 'Users', 'action' => 'edit']);


        $builder->connect('/test', array('controller' => 'Pages', 'action' => 'display', 'test'));

        /*$builder->connect('/query-expander/:report_id', 
        ['controller' => 'Apps', 'action' => 'queryExpander']
    )->setPass(['report_id']);*/


        $builder->fallbacks(DashedRoute::class);
    });



    // ##### ALTE QUERY EXPANDER ROUTEN #####
    //  $routes->scope('/crt', function (RouteBuilder $builder): void {
       
    //     $builder->connect('/query-expander', ['controller' => 'Crtapps', 'action' => 'queryExpander']);
    //     $builder->connect('/query-expander-data-items', ['controller' => 'Crtapps', 'action' => 'queryExpanderDataItems']);
    //     $builder->connect('/query-expander-result', ['controller' => 'Crtapps', 'action' => 'queryExpanderResult']);
    //     $builder->connect('/download-modified-xml', [
    //         'controller' => 'Crtapps',
    //         'action' => 'downloadModifiedXml'
    //     ]);


    //      $builder->fallbacks(DashedRoute::class);
    //  });
};
