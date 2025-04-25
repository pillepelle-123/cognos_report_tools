<h1>Profil bearbeiten</h1>

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
        </fieldset>
    </fieldset>
    <?= $this->Form->button('Speichern') ?>
<?= $this->Form->end() ?>
<div><?= $this->Html->link('Zurück', ['controller' => 'Reports', 'action' => 'index']) ?></div>