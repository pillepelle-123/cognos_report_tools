<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

use function PHPUnit\Framework\isEmpty;

class CrtappsController extends AppController
{
    protected $Reports;
    protected $report; // ausgewählte Report-Instanz

    public function initialize(): void
    {
        parent::initialize();
        // WICHTIG PSt: Hier wird die Reports-Tabelle geladen #########################
        $this->Reports = $this->fetchTable('Reports');
        

    }
    
    public function queryExpander($report_id = null)
    {
        $report = $this->Reports->get($report_id, [
            'contain' => []
        ]);
        $content = $report->report_xml;

        // Report Informationen in Session speichern, um sie in allen andern Funktionen hier zu benutzen
        $this->request->getSession()->write(['QueryExpander.report'=> $report]);

        try {
            // Entfernen von xmlns-Attributen, um Namespace-Probleme zu vermeiden
            $content = preg_replace('/xmlns[^=]*="[^"]*"/i', '', $content);

            // XML-Parsing
            $xml = simplexml_load_string($content);

            // Überprüfen auf Fehler beim Parsen
            if ($xml === false) {
                $errors = libxml_get_errors();
                $errorMsg = "XML-Fehler: ";
                foreach ($errors as $error) {
                    $errorMsg .= sprintf("Zeile %d: %s; ", $error->line, trim($error->message));
                }
                die($errorMsg);
            }

            //Namespace-unabhängige XPath-Abfrage nach "Query"-Elementen
            $queries = [];
            $found = $xml->xpath('//*[local-name()="queries"]/*[local-name()="query"]');
            
            if (empty($found)) {
                // Alternative Suche ohne Namespace
                $found = $xml->xpath('//queries/query');
            }
            
            $i = 0;
            foreach ($found as $query) {
                $queries[$i] = [
                    'name' => (string)$query['name'],
                    'xml' => $query->asXML()
                ];
                $i++;
            }


            
            if (empty($queries)) {
                die("Keine Queries in der XML-Datei gefunden. Ist dies eine gültige Cognos Report Definition?");
            }
            
            $this->set(compact('report', 'queries'));

        } catch (\Exception $e) {
            $this->Flash->error('Fehler beim Parsen und Auslesen der Queries: ' . $e->getMessage());
            return $this->redirect(['controller' => 'Reports', 'action' => 'index']);
        }    
    }

    public function queryExpanderDataItems()
    {
        $report = $this->request->getSession()->read('QueryExpander.report');

        //if ($this->request->is('post')) {

            if (!$this->request->is('post')) {
                $this->Flash->error('Ungültige Anfragemethode');
                return $this->redirect($this->referer());
            }

            $data = $this->request->getData();
            
            if (empty($data['selected_query']) || !isset($data['queries'][$data['selected_query']])) {
                $this->Flash->error('Bitte wählen Sie eine Query aus');
                return $this->redirect($this->referer());
            }

            // Ausgewählte Query ermitteln, Name und XML auslesen
            $selectedIndex = $data['selected_query'];
            $selectedQuery = $data['queries'][$selectedIndex];


            if (!isset($selectedQuery['name']) || !isEmpty($selectedQuery['name']) || !isset($selectedQuery['xml']) || !isEmpty($selectedQuery['xml'])) {
                $this->Flash->error('Ungültige Query-Daten');
                return $this->redirect($this->referer());
            }

            $selectedQueryName = $selectedQuery['name'];
            $selectedQueryXml = $selectedQuery['xml'];
            

            
            //$selectedQuery = array("name" => $selectedQueryName, "xml" => $selectedQueryXml);
            
            // XML verarbeiten
            $xml = simplexml_load_string($selectedQueryXml);
            if ($xml === false) {
                $this->Flash->error('Fehler beim Parsen der Query XML');
                return $this->redirect($this->referer());
            }
            
            $dataItems = $this->extractDataItems($xml);

            $this->set(compact('report', 'selectedQuery', 'dataItems'));

            return $this->render('query_expander_data_items' );
        //}
        
        //$this->Flash->error('Ungültiger Zugriff');
        //return $this->redirect(['action' => 'queryExpander']);
    }
    
    function extractDataItems($xml) {
        $dataItems = [];
        $i = 0;
        foreach ($xml->xpath('.//dataItem') as $dataItem) {
            $dataItems[(string)$dataItem['name']] = [
                'index'=> $i,
                'name'=> (string)$dataItem['name'],
                'xml' => $dataItem->asXML(),
                'expression' => (string)$dataItem->expression
            ];
            $i++;
        }
        
        return $dataItems;
    }

    public function queryExpanderResult() {
        
        //$session = $this->request->getSession();
        //$dataItems = $session->read('QueryExpander.dataItems');
        $report = $this->request->getSession()->read('QueryExpander.report');
        $xml = $report->report_xml;
        // Daten aus dem Formular
        $data = $this->request->getData();
        $query = $this->request->getQuery();

 
        if ($this->request->is('post') && $this->request->getQuery('form') === 'form_data_items') {
        
            // Original XML laden
            $xmlContent = $report->report_xml;
            preg_match('/<report[^>]+xmlns="([^"]+)"/', $xmlContent, $matches);
            $namespace = $matches[1] ?? 'http://developer.cognos.com/schemas/report/17.2/';
            
            // Temporären Namespace entfernen
            $tempXmlContent = preg_replace('/xmlns="[^"]+"/', '', $xmlContent);
            $xml = simplexml_load_string($tempXmlContent);
            
            if ($xml === false) {
                die("Fehler beim Parsen der XML-Datei: " . implode("\n", libxml_get_errors()));
            }
        
            $selectedItems = $data['selected_items'];
            $nameSearch = $data['name_search'];
            $exprSearch = $data['expr_search'];
            
            // Replace-Pairs sammeln
            $replacePairs = [];
            if (isset($data['expr_replace'])) {
                $replacePairs[] = [
                    'name' => $data['name_replace'],
                    'expr' => $data['expr_replace']
                ];
            }
        
            // Prüfen ob Index-Operation gewünscht ist
            $nameIndexOp = preg_match('/^\[index\((\d+)\)\]$/', $nameSearch, $nameIndexMatches);
            $exprIndexOp = preg_match('/^\[index\((\d+)\)\]$/', $exprSearch, $exprIndexMatches);
        
            foreach ($selectedItems as $itemName) {
                $dataItems = $xml->xpath("//*[local-name()='dataItem'][@name='$itemName']");
                        
                foreach ($dataItems as $originalItem) {
                    $originalDom = dom_import_simplexml($originalItem);
                    
                    foreach ($replacePairs as $pair) {
                        $newItem = clone $originalItem;
                        
                        // Name bearbeiten
                        if ($nameIndexOp) {
                            $index = (int)$nameIndexMatches[1];
                            $originalName = (string)$newItem['name'];
                            $newName = substr_replace($originalName, $pair['name'], $index, 0);
                            $newItem['name'] = $newName;
                        } else {
                            $newName = str_replace($nameSearch, $pair['name'], (string)$newItem['name']);
                            $newItem['name'] = $newName;
                        }
                        
                        // Expression bearbeiten
                        if (isset($newItem->expression)) {
                            $expression = (string)$newItem->expression;
                            
                            if ($exprIndexOp) {
                                $index = (int)$exprIndexMatches[1];
                                $newExpression = substr_replace($expression, $pair['expr'], $index, 0);
                            } else {
                                $newExpression = str_replace($exprSearch, $pair['expr'], $expression);
                            }
                            
                            $newItem->expression = $newExpression;
                        }
                        
                        // Neues Element einfügen
                        $newDom = dom_import_simplexml($newItem);
                        $originalDom->parentNode->insertBefore($newDom, $originalDom->nextSibling);
                    }
                }
            }
        
            // XML mit Namespace zurück konvertieren
            $modifiedXmlContent = $xml->asXML();
            $modifiedXmlContent = preg_replace(
                '/<report ([^>]*)>/',
                "<report $1 xmlns=\"$namespace\">", 
                $modifiedXmlContent
            );
        
            $this->set(name: compact('modifiedXmlContent'));
            $this->request->getSession()->write(['QueryExpander.modifiedXmlContent'=> $modifiedXmlContent]);
        } else if ($this->request->getQuery()['form'] = 'form_download') {
            $this->downloadModifiedXml();
        }
    }
    public function downloadModifiedXml()
    {
        // 1. Nur POST erlauben
        $this->request->allowMethod(['post']);

        // 2. Session-Daten lesen
        $session = $this->request->getSession();
        $xmlContent = $session->read('QueryExpander.modifiedXmlContent');
        $report = $this->request->getSession()->read('QueryExpander.report');

        // 3. Validierung
        if (empty($xmlContent)) {
            throw new \RuntimeException('Keine XML-Daten zum Download verfügbar');
        }

        // 4. Response vorbereiten
        $response = $this->response
            ->withType('application/xml')
            //->withHeader('Content-Disposition', 'attachment; filename="'.$report->report_name.'modified_report.xml"')
            ->withDownload($report->report_name.'_modified.xml')
            ->withStringBody($xmlContent);

        //

        return $response;
    }

}