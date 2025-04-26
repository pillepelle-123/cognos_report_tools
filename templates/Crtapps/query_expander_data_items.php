<?php
// templates/Crtapps/query_expander_data_items.php

$report = $this->request->getSession()->read('QueryExpander.report');
//$selectedQuery = $this->request->getSession()->read('QueryExpander.selectedQuery');
//$dataItems = $this->request->getSession()->read('QueryExpander.dataItems');


?>
<div class="query-expander data-items">
    <h2>Data Items für Query: <?= h($selectedQuery['name']) ?> in Report <?= h($report['name'])?></h2>
    
    <?= $this->Form->create(null, [
        'url' => ['action' => 'queryExpanderResult']
    ]) ?>
    
    <table class="table">
        <thead>
            <tr>
                <th>Auswahl</th>
                <th>Data Item Name</th>
                <th>Expression</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dataItems as $item => $value) : ?>
            <tr>
                <td>
                    <?= $this->Form->checkbox('selected_items[]', [
                        'value' => $item,
                        'hiddenField' => false
                    ]) ?>
                </td>
                <td><?= h($item) ?></td>
                <td><code><?= h($value['expression']) ?></code></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <div class="mt-4">
        <h4>Data Item Name anpassen:</h4>
        <?= $this->Form->control('name_search', ['label' => 'Text suchen']) ?>
        <?= $this->Form->control('name_replace', ['label' => 'Ersetzen mit']) ?>
    </div>
    
    <div class="mt-4">
        <h4>Expression anpassen:</h4>
        <?= $this->Form->control('expr_search', ['label' => 'Text suchen']) ?>
        <?= $this->Form->control('expr_replace', ['label' => 'Ersetzen mit']) ?>
    </div>
    
    <?= $this->Form->button('Weiter', ['class' => 'btn btn-primary mt-3']) ?>
    <?= $this->Form->end() ?>

    <?= $this->Html->link('Zurück', [
        'action' => 'queryExpander']
    , ['class' => 'btn btn-secondary mt-3']) ?>
</div>