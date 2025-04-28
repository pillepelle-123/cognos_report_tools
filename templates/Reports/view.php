<div class="reports view">
    <h2><?= $this->get('title') ?></h2>
    
    <div class="actions">
        <?= $this->Html->link('Bearbeiten', ['action' => 'edit', '?' => ['report_id' => $report->id]], ['class' => 'button']) ?>
    </div>
    
    <pre><?= h($report->report_xml) ?></pre>
</div>

