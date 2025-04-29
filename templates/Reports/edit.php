<div class="reports view">
    <h1><?= $this->get('title') ?>  </h1>
    <?= $this->Form->create($report) ?>
    <?= $this->Form->textarea('report_xml', [
        'value' => $report->report_xml,
        'rows' => 25,
        'class' => 'edit-textarea',
    ]) ?>
    <?= $this->Form->button('Abbrechen', array('type' => 'button', 'onclick' => 'location.href=\'/\'')); ?>
    <?= $this->Form->button('Speichern') ?>
    <?= $this->Form->end() ?>
</div>