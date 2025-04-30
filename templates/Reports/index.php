<div class="reports index">
    <h1><?= $this->get('title') ?></h1>
    
    <div class="actions">   
		<?= $this->Html->image('icons/material_add_292929.svg', array('title' => 'Report hochladen', 'height' => '40', 'width' => '40', 'class' => 'action-button-img', 'url' => ['action' => 'upload'])) ?>
    </div>
    <table>
        <thead>
            <tr>
                <th>Dateiname</th>
                <th>Upload</th>
                <th class="index-column-actions">Aktionen</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reports as $report): ?>
				<tr>
					 <td><?= h($report->report_name.'.xml') ?></td>
					 <td><?= h(date_format($report->upload_timestamp,"d.m.Y | H:i:s")) ?></td>
					 <td class="index-column-actions">
						<!-- Anzeigen -->
					 	<?= $this->Html->image('icons/material_view_292929.svg', array('title' => 'Anzeigen', 'height' => '32', 'width' => '32', 'class' => 'action-button-img', 'url' => ['action' => 'view', '?' => ['report_id' => $report->id]])) ?>
						<!-- Bearbeiten -->
						<?= $this->Html->image('icons/material_edit_292929.svg', array('title' => 'Bearbeiten', 'height' => '32', 'width' => '32', 'class' => 'action-button-img', 'url' => ['action' => 'edit', '?' => ['report_id' => $report->id]])) ?>			
						<!-- In App bearbeiten -->
						<?= $this->Html->image('icons/crt_icon.svg', array('title' => 'In CRT App bearbeiten', 'height' => '32', 'width' => '32', 'class' => 'action-button-img', 'url' => ['action' => 'crtApps', '?' => ['report_id' => $report->id]])) ?>
						
						<!-- Löschen -->
						<form style="display: inline;" id="deleteForm" method="post" action="<?= $this->Url->build(['action' => 'delete', '?' => ['report_id' => $report->id]]) ?>" onsubmit="return confirmDelete(<?= $report->id ?>);">
							<span id="delete-wrapper-<?= $report->id ?>">
								<img src="<?= $this->Url->build('img/icons/material_delete_292929.svg') ?>" width="32" height="32" class="action-button-img" alt="Löschen" title="Löschen" onclick="initDelete(<?= $report->id ?>)" class="deleteLink"/>
								
							</span>
						</form>
<!-- Verstecktes Löschformular -->
<div style="display:none;">
    <?= $this->Form->create(null, ['id' => 'deleteForm', 'url' => ['action' => 'delete']]) ?>
    <?= $this->Form->hidden('report_id', ['id' => 'deleteId']) ?>
    <?= $this->Form->end() ?>
</div>
					 </td>
				</tr>
				<?php endforeach; ?>
        </tbody>
    </table>
</div>