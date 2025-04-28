<div class="reports index">
    <h2><?= $this->get('title') ?></h2>
    
    <div class="actions">
        
		<?= $this->Html->image('icons/material_add.svg', array('title' => 'Report hochladen', 'height' => '40', 'width' => '40','url' => ['action' => 'upload'])) ?>
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
					 <td><?= h($report->report_name.'.xml') ?></td>
					 <td><?= h(date_format($report->upload_timestamp,"d.m.Y | H:i:s")) ?></td>
					 <td class="index_row_actions">
						<!-- Anzeigen -->
					 	<?= $this->Html->image('icons/material_view.svg', array('title' => 'Anzeigen', 'height' => '32', 'width' => '32','url' => ['action' => 'view', '?' => ['report_id' => $report->id]])) ?>
						<!-- Bearbeiten -->
						<?= $this->Html->image('icons/material_edit.svg', array('title' => 'Bearbeiten', 'height' => '32', 'width' => '32','url' => ['action' => 'edit', '?' => ['report_id' => $report->id]])) ?>			
						<!-- In App bearbeiten -->
						<?= $this->Html->image('icons/crt_logo_32_32.png', array('title' => 'In CRT App bearbeiten', 'height' => '32', 'width' => '32','url' => ['action' => 'crtApps', '?' => ['report_id' => $report->id]])) ?>
						
						<!-- Löschen -->
						<form style="display: inline;" id="deleteForm" method="post" action="<?= $this->Url->build(['action' => 'delete', '?' => ['report_id' => $report->id]]) ?>" onsubmit="return confirmDelete(<?= $report->id ?>);">
							<span id="delete-wrapper-<?= $report->id ?>">
								<img src="<?= $this->Url->build('img/icons/material_delete.svg') ?>" width="32" height="32" alt="Löschen" title="Löschen" onclick="initDelete(<?= $report->id ?>)" class="deleteLink"/>
							
			<!-- '/img/icons/material_design_delete.svg' ?d-->
								
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