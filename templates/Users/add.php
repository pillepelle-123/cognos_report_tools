<div class="users form">
<?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Add User') ?></legend>
        <p>Username (E-Mail Adresse):<br />
        <?=     $this->Form->input("username", [
                    'required' => true,
                    'label'    => false,
                    'id'       => "email",
                    'type'     => "email"
                    ]);
            ?>
        </p>Passwort:<br />
        <?= $this->Form->input('password') ?>
        </p>
   </fieldset>
<?= $this->Form->button(__('Submit')); ?>
<?= $this->Form->end() ?>
</div>
<div><?= $this->Html->link('Zurück', ['controller' => 'Reports', 'action' => 'index']) ?></div>