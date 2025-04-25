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
    
    <style>
        #user_menu {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        #user_menu li {
            display: inline;
            margin-right: 4px;
        }
        .delete-container {
            display: inline-block;
        }
        .delete-btn {
            margin-left: 5px;
        }
        .delete-wrapper button {
            margin-right: 5px;
        }
        </style>

</head>
<body>
    <nav class="top-nav">
        <div class="top-nav-title">
            <a href="<?= $this->Url->build('/') ?>"><span>C</span>ongos <span>R</span>eport <span>T</span>ools  </a>
        </div>
        <div class="top-nav-links">
  

            <?php if ($this->Identity->isLoggedIn()): ?>
                <ul id="user_menu">
                <li><?php echo $this->Identity->get('username'); ?></li>
                <li><?php echo $this->Html->link('Profil editieren', url: ['controller' => 'Users', 'action' => 'edit']); ?></li>
                <li><?php echo $this->Html->link('Logout', url: ['controller' => 'Users', 'action' => 'logout']); ?></li>
                </ul>
                
            <?php endif; ?>    

        </div>
    </nav>
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
                
                wrapper.innerHTML = `
                    <span class="text-danger me-2">Sind Sie sicher?</span>
                    <button onclick="confirmDelete('${id}')" 
                            class="btn btn-danger btn-sm">
                        Löschen bestätigen
                    </button>
                    <button onclick="cancelDelete('${id}')" 
                            class="btn btn-secondary btn-sm">
                        Abbrechen
                    </button>
                `;
            }

            function confirmDelete(id) {
                document.getElementById('deleteId').value = id;
                document.getElementById('deleteForm').submit();
            }

            function cancelDelete(id) {
                const wrapper = document.getElementById(`delete-wrapper-${id}`);
                
                wrapper.innerHTML = `
                    <button onclick="initDelete('${id}')" 
                            class="btn btn-danger btn-sm">
                        Löschen
                    </button>
                `;
            }
        </script>
</body>
</html>
