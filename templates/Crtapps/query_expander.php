<?php
// templates/Crtapps/query_expander.php
?>
<div class="query-expander">
    <h2>Query Expander für: <?= h($report->report_name) ?></h2>
    
    <?= $this->Form->create(null, [
        'url' => ['controller' => 'Crtapps', 'action' => 'queryExpanderDataItems'],
        'type' => 'post'
    ]) ?>
    
    <fieldset>
    <legend>Query auswählen</legend>
    <?php foreach ($queries as $index => $query): ?>
        <div class="form-check">
            <?= $this->Form->radio('selected_query', [
                $index => $query['name'] // Nur der Name wird angezeigt
            ], [
                'label' => false,
                'hiddenField' => false,
                'required' => true
            ]) ?>
            <label class="form-check-label">
                <?= h($query['name']) ?>
            </label>
            <?= $this->Form->hidden("queries.$index.xml", ['value' => $query['xml']]) ?>
            <?= $this->Form->hidden("queries.$index.name", ['value' => $query['name']]) ?>
        </div>
    <?php endforeach; ?>
</fieldset>
    
    <?= $this->Form->button('Weiter', ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>

    <?= $this->Html->link('Zurück', [
        'controller' => 'Reports',
        'action' => 'apps']
    , ['class' => 'btn btn-secondary mt-3']) ?>
</div>