<?php
namespace App\Controller;

use App\Controller\AppController;

class ReportsController extends AppController
{   
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
    $this->Authentication->allowUnauthenticated(['login' /*, 'add'*/ ]); 

    }

    /**
     * Summary of index
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $reports = $this->Reports->find('all')
            ->where(['username' => $this->user->username])
            ->order(['upload_timestamp' => 'DESC']);

        // Inhalte an Templates übergeben
        //$this->set(compact('user', 'reports')); /alte Variante, klappt aber nicht direkt mit $this->user
        $this->set(['user' => $this->user, 'reports' => $reports]);
        $this->set('title', 'Portal');
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
        $this->set(['user' => $this->user]);
        //$this->set(compact('user'));
        $this->set('title', 'Report hochladen');
    }

    /**
     * Summary of view
     * @param mixed $id
     * @return void
     */
    public function view() 
    {
        $user = $this->user;
        $reportId = $this->request->getQuery('report_id');
        $report = $this->Reports->get(primaryKey: $reportId);
        /*$filepath = WWW_ROOT . 'reports' . DS . $filename;
        $content = file_get_contents($filepath);*/
        
        $this->set('report_name', $report->report_name);
        $this->set('content', $report->report_xml);

        $this->set(compact('user', 'report'));
        $this->set('title', 'Bericht anzeigen');
    }

    /**
     * Summary of edit
     * @param mixed $id
     * @return \Cake\Http\Response|null
     */
    public function edit()
    {
        $user = $this->user;
        $reportId = $this->request->getQuery('report_id');
        $report = $this->Reports->get($reportId);
        
        if ($this->request->is(['post', 'put'])) {
            $report = $this->Reports->patchEntity($report, $this->request->getData());
            
            if ($this->Reports->save($report)) {
                $this->Flash->success('Report erfolgreich aktualisiert.');
                return $this->redirect(['action' => 'index']);
            }
            
            $this->Flash->error('Fehler beim Aktualisieren des Reports.');
        }
        
        $this->set(compact('user', 'report'));
        $this->set('title', 'Bericht bearbeiten');
    }

    public function delete()
    {
        $this->request->allowMethod(['post', 'delete']);
        $reportId = $this->request->getQuery('report_id');        
        $report = $this->Reports->get($reportId);

        if ($this->Reports->delete($report)) {
            $this->Flash->success('Report wurde gelöscht.');
        } else {
            $this->Flash->error('Report konnte nicht gelöscht werden.');
        }
        
        return $this->redirect(['action' => 'index']);
    }

    public function crtApps()
    {
        $user = $this->user;
        $reportId = $this->request->getQuery('report_id');
        $report = $this->Reports->get($reportId);
        $this->request->getSession()->write('QueryExpander.report', $report);
        $this->set(compact('user', 'report'));
        $this->set('title', 'App Hub');

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