<?php
// templates/Crtapps/query_expander_data_items.php

//$modifiedXmlContent = $this->request->getSession()->read('QueryExpander.modifiedXmlContent');
$report = $this->request->getSession()->read('QueryExpander.report');

?>



<div class="query-expander result">
    <h2>Ergebnis</h2>
    
    <div class="card mb-4">
        <div class="card-header">Modifizierte XML</div>
        <div class="card-body">
            <pre><?= h($modifiedXmlContent) ?></pre>
        </div>
    </div>
    
    <?= $this->Form->create(null, [
        'url' => ['controller' => 'Crtapps', 'action' => 'downloadModifiedXml']
    ]) ?>
    <?= $this->Form->button('XML herunterladen', [
        'class' => 'btn btn-success'
    ]) ?>
    <?= $this->Form->end() ?>
    
    <?= $this->Html->link('Zurück', [
        'action' => 'queryExpander', $report['id']]
    , ['class' => 'btn btn-secondary mt-3']) ?>
</div>