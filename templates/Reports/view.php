<div class="reports view">
    <h2>Report anzeigen: <?= h($report->report_name) ?></h2>
    
    <div class="actions">
        <?= $this->Html->link('Bearbeiten', ['action' => 'edit', $report->id], ['class' => 'button']) ?>
        <?= $this->Html->link('Zurück', ['action' => 'index']) ?>
    </div>
    
    <pre><?= h($report->report_xml) ?></pre>
</div>

