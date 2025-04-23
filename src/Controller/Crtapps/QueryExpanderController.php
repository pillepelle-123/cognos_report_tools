<?php
namespace App\Controller\Apps;

use App\Controller\AppController;

class QueryExpanderController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
        //$this->loadComponent('RequestHandler');
    }

    public function index($id = null)
    {
        $report = $this->Reports->get($id);
        $this->set(compact('report'));
        
        // XML-Verarbeitung wie in der Vorgänger-App
       //$xml = simplexml_load_string($report->report_xml);
        //$queries = [];
        
        // foreach ($xml->Query as $query) {
        //     $queries[] = [
        //         'name' => (string)$query['name'],
        //         'sql' => (string)$query->SQL
        //     ];
        // }
        
        $this->set(compact('queries'));


        
    }

    public function apps($id = null)
    {
        $report = $this->Reports->get($id);
        $this->set(compact('report'));
    }
}

/*namespace App\Controller\App;
 <?php 

use App\Controller\AppController;
use Cake\Core\Configure;

class QueryExpanderController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    public function index($reportId)
    {
        $report = $this->fetchTable('Reports')->get($reportId);
        $this->set(compact('report'));
        
        // XML Parsing wie in der Vorgänger-App
        $xml = simplexml_load_string($report->report_xml);
        $queries = [];
        
        foreach ($xml->Query as $query) {
            $queries[] = [
                'name' => (string)$query['name'],
                'sql' => (string)$query->SQL
            ];
        }
        
        $this->set(compact('queries'));
    }

    public function query($reportId, $queryName)
    {
        // Implementierung wie in der Vorgänger-App
    }

    public function result($reportId, $queryName)
    {
        // Implementierung wie in der Vorgänger-App
    }
}
    */