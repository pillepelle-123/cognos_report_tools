<?php
// templates/Crtapps/query_expander.php
?>
<div class="query-expander">
    <h2>Query Expander für: <?= h($report->report_name) ?></h2>
    
    <?= $this->Form->create(null, [
        'url' => ['controller' => 'Crtapps', 'action' => 'queryExpanderDataItems', $report->id],
        'type' => 'post'
    ]) ?>
    
    <table class="table">
        <thead>
            <tr>
                <th>Auswahl</th>
                <th>Query Name</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($queries as $name => $xml): ?>
            <tr>
                <td>
                    <?= $this->Form->radio('selected_query', [
                        $name => ''
                    ]) ?>
                </td>
                <td><?= h($name) ?>
                <?= $this->Form->hidden("queries[{$name}][xml]", [
                        'value' => $xml
                    ]); 
                    // $this->Form->hidden("report", [
                    //     $report->id => $report->report_name
                    // ]) 
                ?>

            
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <?= $this->Form->button('Weiter', ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>
</div>