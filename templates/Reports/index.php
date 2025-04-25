<div class="reports index">
    <h2>Cognos Reports</h2>
    
    <div class="actions">
        <?= $this->Html->link('Report hochladen', ['action' => 'upload'], ['class' => 'button'], ['type' => 'button']) ?>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Dateiname</th>
                <th>Upload</th>
                <th>Aktionen</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reports as $report): ?>
				<tr>
					 <td><?= h($report->report_name) ?></td>
					 <td><?= h($report->upload_timestamp) ?></td>
					 <td>
						<!-- Anzeigen -->
					 	<span title="Anzeigen"><?= $this->Html->image('icons/material_design_anzeigen.svg', array('height' => '100', 'width' => '100','url' => ['action' => 'view', $report->id])) ?>
						</span>
						<?= $this->Html->link('Anzeigen', 
							['action' => 'view', $report->id], 
							['class' => 'btn btn-primary btn-sm']) ?>
						<!-- Bearbeiten -->
						<?= $this->Html->link('Bearbeiten', 
							['action' => 'edit', $report->id], 
							['class' => 'btn btn-secondary btn-sm']) ?>
						<!-- In App bearbeiten -->
						<?= $this->Html->link('In App bearbeiten', 
							['action' => 'apps', $report->id],
							['class' => 'btn btn-info btn-sm']) ?>

						<!-- Löschen -->
						<form id="deleteForm" method="post" action="<?= $this->Url->build(['action' => 'delete', $report->id]) ?>" onsubmit="return confirmDelete(<?= $report->id ?>);">
							<span id="delete-wrapper-<?= $report->id ?>">
							<button onclick="initDelete(<?= $report->id ?>)" 
										class="btn btn-danger btn-sm">
								Löschen
							</button>
								
							</span>
						</form>




						</span>
						</form>
					 </td>
				</tr>
				<?php endforeach; ?>
        </tbody>
    </table>
</div>