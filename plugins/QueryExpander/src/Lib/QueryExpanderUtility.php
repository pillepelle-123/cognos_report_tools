<?php
namespace QueryExpander\Lib;

class QueryExpanderUtility
{
    public static function extractDataItems($xml)
    {
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

    public function downloadResults($response = null)  // Umbenannt von downloadModifiedXml()
    {
        // Ihre ursprüngliche Logik
        $response = $response->withType('xml')
            ->withDownload('modified_query.xml');
        
        return $response;
    }

}