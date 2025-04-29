<div class="reports upload">
    <h1><?= $this->get('title') ?></h1>
    
    <?= $this->Form->create(null, ['type' => 'file']) ?>
    <?= $this->Form->file('report_file', ['required' => true], array('id' => 'chose_file')) ?>
    <?= $this->Form->button('Hochladen') ?>
    <?= $this->Form->end() ?>
    
</div>