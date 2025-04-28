<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Auth\DefaultPasswordHasher;
// use Cake\Filesystem\File;
// use LasseRafn\InitialAvatarGenerator\InitialAvatar;
use Intervention\Image\ImageManager;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    /**
     * Initialize controller
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        // füge add hinzu, wenn ein allererster User angelegt werden muss
        $this->Authentication->allowUnauthenticated(['login' /*, 'add'*/ ]); 
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Users->find();
        $users = $this->paginate($query);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, contain: []);
        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                //return $this->redirect(['controller' => 'Report', 'action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
        $this->set('title', 'User anlegen');
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit()
    {   $user = $this->Users->get($this->Authentication->getIdentity()->get('id'));
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'edit']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
        $this->set('title', 'Profil bearbeiten');
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    // /**
    //  * Login method
    //  *
    //  * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
    //  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    //  */
    // public function login()
    // {
    //     $this->request->allowMethod(['get', 'post']);
    //     $result = $this->Authentication->getResult();
    //     if ($result->isValid()) {
    //         $this->Flash->success(__('Login successful'));
    //         $redirect = $this->Authentication->getLoginRedirect();
    //         if ($redirect) {
    //             return $this->redirect($redirect);
    //         }
    //     }

    //     // Display error if user submitted and authentication failed
    //     if ($this->request->is('post')) {
    //         $this->Flash->error(__('Invalid username or password'));
    //     }
    // }

    public function login()
    {
        $result = $this->Authentication->getResult();
        // If the user is logged in send them away.
        if ($result && $result->isValid()) {
            $target = $this->Authentication->getLoginRedirect() ?? '/';
            return $this->redirect($target);
        }
        if ($this->request->is('post')) {
            $this->Flash->error('Invalid username or password');
        }
    }

    public function logout()
    {
        $this->Authentication->logout();
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

    //     public function beforeFilter(\Cake\Event\EventInterface $event)
    // {
    //     parent::beforeFilter($event);

    //     $this->Authentication->allowUnauthenticated(['login']);
    // }

    // public function editProfile()
    // {

        
    //     $user = $this->Users->get($this->Authentication->getIdentity()->get('id'));

    //     if ($this->request->is(['post', 'put'])) {
    //         $data = $this->request->getData();

    //         // Passwort validieren
    //         if (!empty($data['old_password']) && !empty($data['password'])) {
    //             $hasher = new DefaultPasswordHasher();
    //             if (!$hasher->check($data['old_password'], $user->password)) {
    //                 $this->Flash->error('Das alte Passwort ist falsch.');
    //                 return;
    //             }
    //             $user->password = $data['password'];
    //         }

    //         // Vorname ändern
    //         if (!empty($data['firstname']) && !empty($data['firstname'])) {
   
    //             //$user->firstname = $data['firstname'];
    //             $user->set('firstname', $data['firstname']);
    //         }
    //         // Profilfoto hochladen
    //         // if (!empty($data['profile_photo']) && $data['profile_photo']->getError() === UPLOAD_ERR_OK) {
    //         //     $file = $data['profile_photo'];
    //         //     $targetPath = WWW_ROOT . 'img' . DS . 'profile_photos' . DS . $user->id . '.jpg';
    
    //         //     // Bild verarbeiten (300x300px, quadratisch zuschneiden)
    //         //     $imageManager = new ImageManager(); // Erstelle eine Instanz von ImageManager
    //         //     $image = $imageManager->make($file->getStream()->getMetadata('uri'))
    //         //         ->fit(300, 300)
    //         //         ->save($targetPath);
    
    //         //     $user->profile_photo = 'profile_photos/' . $user->id . '.jpg';
    //         // }
    //         // elseif (empty($user->profile_photo)) {
    //         //     // Standard-Profilfoto generieren
    //         //     $avatar = new InitialAvatar();
    //         //     $avatarPath = WWW_ROOT . 'img' . DS . 'profile_photos' . DS . $user->id . '.jpg';
    //         //     $avatar->name($data['firstname'] ?? 'User')
    //         //         ->size(300)
    //         //         ->save($avatarPath);

    //         //     $user->profile_photo = 'profile_photos/' . $user->id . '.jpg';
    //         // }

    //         $user = $this->Users->patchEntity($user, $data);
    //         if ($this->Users->save($user)) {
    //             $this->Flash->success('Profil wurde erfolgreich aktualisiert.');
    //             return $this->redirect(['action' => 'editProfile']);
    //         }
    //         $this->Flash->error('Profil konnte nicht aktualisiert werden. Bitte versuche es erneut.');
    //     }

    //     $this->set(compact('user'));
    // }

}
