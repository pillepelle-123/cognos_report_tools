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

    public function index()
    {
        $reports = $this->Reports->find('all');
        $this->set(compact('reports'));
    }

    public function upload()
    {
        if ($this->request->is('post')) {
            $file = $this->request->getData('report_file');
            
            if ($file->getError() === UPLOAD_ERR_OK) {
                $filename = pathinfo($file->getClientFilename(), PATHINFO_FILENAME);

                $content = file_get_contents($file->getStream()->getMetadata('uri'));
                
                $report = $this->Reports->newEmptyEntity();
                $report = $this->Reports->patchEntity($report, [
                    'user' => 'dummy',
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
    }

    public function view($id = null) 
    {
        $report = $this->Reports->get(primaryKey: $id);
        /*$filepath = WWW_ROOT . 'reports' . DS . $filename;
        $content = file_get_contents($filepath);*/
        
        $this->set('report_name', $report->report_name);
        $this->set('content', $report->report_xml);

        $this->set(compact('report'));
    }

    public function edit($id = null)
    {
        $report = $this->Reports->get($id);
        
        if ($this->request->is(['post', 'put'])) {
            $report = $this->Reports->patchEntity($report, $this->request->getData());
            
            if ($this->Reports->save($report)) {
                $this->Flash->success('Report erfolgreich aktualisiert.');
                return $this->redirect(['action' => 'index']);
            }
            
            $this->Flash->error('Fehler beim Aktualisieren des Reports.');
        }
        
        $this->set(compact('report'));
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

    public function apps($id = null)
    {
        $report = $this->Reports->get($id);
        $this->set(compact('report'));
        $this->request->getSession()->write('QueryExpander.report', $report);
    }
}