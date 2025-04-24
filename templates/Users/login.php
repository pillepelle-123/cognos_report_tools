<h1>Bitte einloggen</h1>
<div class="users form content">
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Please enter your email and password') ?></legend>
        <p>Username (E-Mail Adresse):<br />
        <?=     $this->Form->input("username", [
                    'required' => true,
                    'label'    => false,
                    'id'       => "email",
                    'type'     => "email"
                    ]); 
            ?>
        </p>Passwort:<br />
        <?= $this->Form->input('password', ['type' => 'password'])  ?>
        </p>

    </fieldset>
    <?= $this->Form->button(__('Login')); ?>
    <?= $this->Form->end() ?>
</div>