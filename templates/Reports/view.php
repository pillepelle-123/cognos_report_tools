<div class="reports view">
    <h1><?= $this->get('title') ?></h1>
    
    <div class="actions">
        <?= $this->Html->link('Bearbeiten', ['action' => 'edit', '?' => ['report_id' => $report->id]], ['class' => 'button']) ?>
    </div>
    
    <pre><?= h($report->report_xml) ?></pre>
    <div style="text-align: right;"><a href="#">Nach oben ▲</a></div>
</div>

