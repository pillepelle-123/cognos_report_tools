<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

use Cake\Routing\Router;

use function PHPUnit\Framework\isEmpty;

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css(['normalize.min', 'milligram.min', 'fonts', 'cake']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    

</head>
<body>
    <div class="top-nav-container">
    <nav class="top-nav">
        <div class="top-nav-title">
            <?= $this->Html->image('crt_logo_50x60.png', array('title' => 'Congos Report Tools', 'url' => '/')) ?>
            <!-- <a href="<? /*= $this->Url->build('/') */?>"><span>C</span>ongos <span>R</span>eport <span>T</span>ools</a> -->
        </div>
        <div class="top-nav-links">
  

            <?php if ($this->Identity->isLoggedIn()): ?>
                <ul id="user_menu">
                    <li><?php echo $user->username; ?></li>
                    <li><?php echo $this->Html->link('Logout', url: ['controller' => 'Users', 'action' => 'logout']); ?></li>
                    <li><?= $this->Html->link(
                    $this->Avatar->display($user),
                    ['controller' => 'Users', 'action' => 'edit', $user->id],
                    ['escape' => false]) ?>
                    </li>
                </ul>
                
            <?php endif; ?>    

        </div>
        
    </nav>
    <div class="breadcrumb">
        <div class="breadcrumb-navigation">
            <?php
            
            
            // switch($this->getTemplate()):
            //     case 'upload':
            //     case 'view':
            //     case 'edit':
            //     case 'add':
            //     case 'crtApps':
            //         $backLink .= $this->Html->link('Portal', url: '/');
            //         break;
            //     case 'queries':
            //         $backLink .= $this->Html->link('▶ App Hub', ['plugin' => false, 'controller' => 'Reports', 'action' => 'crtApps', '?' => ['report_id' => $report->id]]);
            //         break;
            //     case 'settings':
            //         $backLink .= $this->Html->link('◀ Auswahl Query', ['action' => 'queries']);
            //         break;
            //     case 'result':
            //         $backLink .= $this->Html->link('◀ Einstellungen Data Items', ['action' => 'settings']);
            //         break;
            //     endswitch;

            if ($this->Identity->isLoggedIn()) {
                $template = $this->getTemplate();
                $plugin = $this->getPlugin();
                $backLink = '';
                if ($template !== 'index') {
                    $backLink .= $this->Html->link('Portal', url: '/');
                }

                if ($plugin === 'QueryExpander') {
                    $backLink .= '&nbsp;▶&nbsp;' . $this->Html->link('App Hub', ['plugin' => false, 'controller' => 'Reports', 'action' => 'crtApps', '?' => ['report_id' => $report->id]]);
                    if ($template === 'settings' || $template === 'result') {
                        $backLink .= '&nbsp;▶&nbsp;' . $this->Html->link('Auswahl Query', [
                            'action' => 'queries']);
                            if ($template === 'result') {
                                $backLink .= '&nbsp;▶&nbsp;' . $this->Html->link('Data Item Settings', [
                                    'action' => 'settings']);
                            }
                    } 
                } 

                // if ($template === 'queries') {
                //     $backLink .= '&nbsp;▶&nbsp;' . $this->Html->link('App Hub', ['plugin' => false, 'controller' => 'Reports', 'action' => 'crtApps', '?' => ['report_id' => $report->id]]);
                // } else if ($template === 'settings') {
                //     $backLink .= '&nbsp;▶&nbsp;' . $this->Html->link('Auswahl Query', [
                //         'action' => 'queries']);
                // } else if ($template === 'result') {
                //     $backLink .= '&nbsp;▶&nbsp;' . $this->Html->link('Data Item Settings', [
                //         'action' => 'settings']);
                // }
                if ($template !== 'index') {
                    $backLink .= '&nbsp;▶&nbsp;';
                }
                $backLink .= $this->get('title');

                echo $backLink; 
            }
            
            
            ?>
        </div>
        <div class="breadcrumb-report">
            <?php if (!empty($report)): ?>
                <?php echo h($report->report_name) . '&nbsp;';
                echo $this->Html->image('icons/material_view.svg', array('title' => 'Report', 'height' => '16', 'width' => '16'));
                 ?>
            <?php endif; ?>
        </div>
    </div>
    </div>
    <main class="main">
        <div class="container">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>
    <footer>
    </footer>
        <script>
            function initDelete(id) {
                const wrapper = document.getElementById(`delete-wrapper-${id}`);
                /* ##### Alter block
                 `<p>
                    <span class="text-danger me-2">Möchtest du wirklich löschen?</span><br>
                    <button onclick="confirmDelete('${id}')" 
                            class="btn btn-danger btn-sm">
                        Bestätigen
                    </button>
                    <button onclick="cancelDelete('${id}')" 
                            class="btn btn-secondary btn-sm">
                        Abbrechen
                    </button>
                    </p>
                ` */ 
                wrapper.innerHTML = `
                    <!--<div style="display: inline-block; border: 1px solid #292929; border-radius: 5px; padding: 2px;">-->
                    <div class="button-delete-cancel" onclick="cancelDelete('${id}')">
                    <img src="/img/icons/material_cancel_ffffff.svg" alt="Löschen abbrechen" title="Löschen abbrechen" onclick="cancelDelete('${id}')"> <br>
                    </div>
                    <div class="button-delete-confirm" onclick="confirmDelete('${id}')">
                    <img src="/img/icons/material_delete_ffffff.svg" alt="Löschen bestätigen" title="Löschen bestätigen" onclick="confirmDelete('${id}')"> <br>
                    </div>
                    <!--</div>-->

                    
                `;

            }

            function confirmDelete(id) { 
                document.getElementById('deleteId').value = id;
                document.getElementById('deleteForm').submit();
            }

            function cancelDelete(id) {
                const wrapper = document.getElementById(`delete-wrapper-${id}`);
                wrapper.innerHTML = `
                    <img src="<?= $this->Url->build('img/icons/material_delete_292929.svg') ?>" width="32" height="32" alt="Löschen" title="Löschen" onclick="initDelete('${id}')" class="deleteLink"/>
                `;
            }
            
            // Crop Images
            document.addEventListener('DOMContentLoaded', function() {
                const avatarInput = document.querySelector('#avatar');
                const preview = document.querySelector('#avatar-preview');
                const cropContainer = document.querySelector('#crop-container');
                const cropData = document.querySelector('#avatar-crop');
                
                avatarInput.addEventListener('change', function(e) {
                    if (e.target.files.length) {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            // Cropper initialisieren
                            const image = document.createElement('img');
                            image.id = 'image-to-crop';
                            image.src = event.target.result;
                            
                            cropContainer.innerHTML = '';
                            cropContainer.appendChild(image);
                            cropContainer.style.display = 'block';
                            
                            const cropper = new Cropper(image, {
                                aspectRatio: 1,
                                viewMode: 1,
                                autoCropArea: 1,
                                responsive: true,
                                crop(event) {
                                    cropData.value = JSON.stringify(event.detail);
                                }
                            });
                        }
                        reader.readAsDataURL(e.target.files[0]);
                    }
                });
            });
        </script>
        
</body>
</html>
