<div class="query-expander">
    <h1><?= $this->get('title') ?></h1>   
    <?= $this->Form->create(null, [
        'url' => [/*'controller' => 'Crtapps',*/ 'action' => 'settings'],
        'type' => 'post'
    ]) ?>
    <fieldset>
    <p>Query auswählen</p>
    <table class="table">
        <thead>
            <tr>
                <th style="width:10%">Auswahl</th>
                <th style="width:90%">Query Name</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($queries as $index => $query): ?> 
            <tr>
                <td>
            <?= $this->Form->radio('selected_query', [
                $index => $query['name'] // Nur der Name wird angezeigt
            ], [
                'class' => 'form-check-input',
                'label' => false,
                'hiddenField' => false,
                'required' => true
            ]) ?>
            </td>
            <td>
            
                <?= h($query['name']) ?>
            
            </td>
            <?= $this->Form->hidden("queries.$index.xml", ['value' => $query['xml']]) ?>
            <?= $this->Form->hidden("queries.$index.name", ['value' => $query['name']]) ?>
            </tr>
    <?php endforeach; ?>
    </tbody>
    </table>
</fieldset>
    
    <?= $this->Form->button('Weiter', ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>

</div>