<?= $this->Form->create($report) ?>
<?= $this->Form->textarea('report_xml', [
    'value' => $report->report_xml,
    'rows' => 25
]) ?>
<?= $this->Form->button('Speichern') ?>
<?= $this->Form->end() ?>
<?= $this->Html->link('Zurück', ['action' => 'index']) ?>