<div class="query-expander queries">
    <h2>Verfügbare Queries in <?= h($report->report_name) ?></h2>
    
    <table class="table">
        <thead>
            <tr>
                <th>Query Name</th>
                <th>Aktionen</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($queries as $query): ?>
            <tr>
                <td><?= h($query['name']) ?></td>
                <td>
                    <?= $this->Html->link('Bearbeiten', [
                        'action' => 'query',
                        $report->id,
                        urlencode($query['name'])
                    ], ['class' => 'btn btn-primary']) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>