<?php
namespace App\Model\Behavior\App;

use Cake\ORM\Behavior;

class QueryExpanderBehavior extends Behavior
{
    public function parseQueriesFromXml($xmlContent)
    {
        // Implementierung wie in der Vorgänger-App
    }

    public function updateQueryInXml($xmlContent, $queryName, $newSql)
    {
        // Implementierung wie in der Vorgänger-App
    }
}