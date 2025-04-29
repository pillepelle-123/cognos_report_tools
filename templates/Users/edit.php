<h2><?= $this->get('title') ?></h2>

<?= $this->Form->create($user, ['action' => 'edit', 'type' => 'post']) ?>
    <fieldset>
        <legend>Account-Daten</legend>
        <?= $this->Form->control('firstname', [
            'label' => 'Vorname',
            'value' => $user->firstname,
            'required' => true
        ]) ?>
        <fieldset>
        <legend><?= __('Password') ?></legend>
        <?= $this->Form->control('old_password', [
            'type' => 'password',
            'label' => 'Altes Passwort',
            'required' => false
        ]) ?>
        <?= $this->Form->control('password', [
            'type' => 'password',
            'label' => 'Neues Passwort',
            'required' => false
        ]) ?>
        <?php 
        $avatarUrl = $user->avatar ? 
            '/img/users/' . $user->avatar : 
            '/img/users/default.png';
        ?>
         <div id="avatar-preview" 
             style="background-image: url('<?= $avatarUrl ?>')">
        </div>
        </fieldset>
    </fieldset>
    <?= $this->Form->button('Speichern') ?>
<?= $this->Form->end() ?>

<?= $this->Form->create($user, ['type' => 'file']) ?>
<!-- ... andere Felder ... -->

<div class="avatar-upload">
    <?php 
    $avatarUrl = $user->avatar ? 
        '/img/users/' . $user->avatar : 
        '/img/users/default.png';
    ?>
    
    <div id="avatar-preview" 
         style="background-image: url('<?= $avatarUrl ?>')"></div>
         
    <?= $this->Form->control('avatar', [
        'type' => 'file',
        'label' => 'Profilbild hochladen',
        'accept' => 'image/*'
    ]) ?>
    
    <!-- Cropping UI wird hier hinzugefügt -->
    <div id="crop-container" style="display:none;">
        <!-- Cropper.js wird hier initialisiert -->
    </div>
    
    <?= $this->Form->hidden('avatar-crop') ?>
</div>

<?= $this->Form->button(__('Profilfoto hochladen')) ?>
<?= $this->Form->end() ?>

<?php
$this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js', ['block' => true]);
    $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css', ['block' => true]);
    $this->Html->scriptStart(['block' => true]);
    ?>
<sctipt>

    // In Template einbinden

    // Eigenes Script

    document.addEventListener('DOMContentLoaded', function() {
        const avatarInput = document.querySelector('#avatar-file');
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
    </sctipt>
    <?php
$this->Html->scriptEnd();
