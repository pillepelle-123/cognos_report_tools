<?php
$report = $this->request->getSession()->read('QueryExpander.report');

?>
<div class="query-expander data-items">
    <h1><?= $this->get('title') ?></h1>
    <p>für Query: <code><?= h($selectedQuery['name']) ?></code></p>
    
    <?= $this->Form->create(null, [
        'url' => ['action' => 'result', '?' => ['form' => 'form_data_items']],
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
                    <div class="form-check">
                    <?= $this->Form->checkbox('selected_items[]', [
                        'value' => $item,
                        'class' => 'form-check-input',
                        'type' => 'checkbox',
                        'hiddenField' => false
                    ]) ?>
                    </div>  
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

</div>