<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;

use function PHPUnit\Framework\isNull;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/5/en/controllers.html#the-app-controller
 */
class AppController extends Controller

{
    protected $user;
    protected $Users;
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Flash');
        $this->loadComponent('Authentication.Authentication');
        $this->viewBuilder()->setHelpers(['Authentication.Identity']); // wichtig für Views!

        //$acb = $this->Users->find(  'all');
        $identity = $this->request->getAttribute('identity');
        if(isset($identity)) {
            $this->Users = $this->fetchTable('Users');
            $this->user = $this->Users->get($identity->getIdentifier());
        }



        // $query = $this->Users->find();
        
        // $user2 = $this->Authentication->getIdentity();



        // $identity = $this->request->getAttribute('identity');
        // $this->username = $identity ? $identity->get('username') : null; //$this->request->getSession()->read

        // Vermutlich veraltet
        // $this->loadComponent('Auth', [
        //     'authenticate' => [
        //         'Form' => [
        //             'fields' => ['username' => 'username', 'password' => 'password']
        //         ]
        //     ],
        //     'loginAction' => ['controller' => 'Users', 'action' => 'login'],
        //     'unauthorizedRedirect' => $this->referer()
        // ]);

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/5/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
    }

    public function isAuthorized($user)
    {
        // Standardmäßig: Nur eingeloggte Benutzer haben Zugriff
        // Admin bekommt vollen Zugriff
        return isset($user['role']) && $user['role'] === 'admin';
    }

    // public function beforeFilter(EventInterface $event)
    // {
    //     parent::beforeFilter($event);

    //     $this->Authentication->addUnauthenticatedActions(['login']);
    // }
}
