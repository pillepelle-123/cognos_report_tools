<div class="reports upload">
    <h2>Report hochladen</h2>
    
    <?= $this->Form->create(null, ['type' => 'file']) ?>
    <?= $this->Form->file('report_file', ['required' => true]) ?>
    <?= $this->Form->button('Hochladen') ?>
    <?= $this->Form->end() ?>
    
    <?= $this->Html->link('Zurück', ['action' => 'index']) ?>
</div>