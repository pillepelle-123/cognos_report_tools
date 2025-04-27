<?php
namespace App\Controller;

use App\Controller\AppController;

class ReportsController extends AppController
{   
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
        
    }

    /**
     * Summary of index
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $user = $this->user;
        $reports = $this->Reports->find('all')
            ->where(['username' => $user->username])

              // Auth->user('username')
            //Identity->get('username')
            ->order(['upload_timestamp' => 'DESC']);
        $this->set(compact('user', 'reports'));
    }

    /**
     * Summary of upload
     * @return \Cake\Http\Response|null
     */
    public function upload()
    {
        $user = $this->user;
        if ($this->request->is('post')) {
            $file = $this->request->getData('report_file');
            
            if ($file->getError() === UPLOAD_ERR_OK) {
                $filename = pathinfo($file->getClientFilename(), PATHINFO_FILENAME);

                $content = file_get_contents($file->getStream()->getMetadata('uri'));
                
                $report = $this->Reports->newEmptyEntity();
                $report = $this->Reports->patchEntity($report, [
                    'username' => $this->user->username,
                    'report_name' => $filename,
                    'report_xml' => $content
                ]);
                
                if ($this->Reports->save($report)) {
                    $this->Flash->success('Report erfolgreich hochgeladen und gespeichert.');
                    return $this->redirect(['action' => 'index']);
                }                
                $this->Flash->error('Fehler beim Speichern in der Datenbank.');
            }
        }
        $this->set(compact('user'));
    }

    /**
     * Summary of view
     * @param mixed $id
     * @return void
     */
    public function view($id = null) 
    {
        $user = $this->user;
        $report = $this->Reports->get(primaryKey: $id);
        /*$filepath = WWW_ROOT . 'reports' . DS . $filename;
        $content = file_get_contents($filepath);*/
        
        $this->set('report_name', $report->report_name);
        $this->set('content', $report->report_xml);

        $this->set(compact('user', 'report'));
    }

    /**
     * Summary of edit
     * @param mixed $id
     * @return \Cake\Http\Response|null
     */
    public function edit($id = null)
    {
        $user = $this->user;
        $report = $this->Reports->get($id);
        
        if ($this->request->is(['post', 'put'])) {
            $report = $this->Reports->patchEntity($report, $this->request->getData());
            
            if ($this->Reports->save($report)) {
                $this->Flash->success('Report erfolgreich aktualisiert.');
                return $this->redirect(['action' => 'index']);
            }
            
            $this->Flash->error('Fehler beim Aktualisieren des Reports.');
        }
        
        $this->set(compact('user', 'report'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        
        $report = $this->Reports->get($id);
        
        if ($this->Reports->delete($report)) {
            $this->Flash->success('Report wurde gelöscht.');
        } else {
            $this->Flash->error('Report konnte nicht gelöscht werden.');
        }
        
        return $this->redirect(['action' => 'index']);
    }

    public function crtApps($id = null)
    {
        $this->request->getSession()->read('QueryExpander.report');
        $user = $this->user;
        $report = $this->Reports->get($id);
        $this->request->getSession()->write('QueryExpander.report', $report);
        $this->set(compact('user', 'report'));

    }

// ############# Helferfunktionen #############

    public function isAuthorized($user)
    {
        // Nur der Besitzer darf Reports bearbeiten/löschen
        if (in_array($this->request->getParam('action'), ['edit', 'delete'])) {
            $reportId = (int)$this->request->getParam('pass.0');
            $report = $this->Reports->get($reportId);
            
            return $report->user === $user['username'];
        }
        
        return parent::isAuthorized($user);
    }
}