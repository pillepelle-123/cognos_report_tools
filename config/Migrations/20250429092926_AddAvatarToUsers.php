<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class AddAvatarToUsers extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('users');
        $table->addColumn('avatar', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('avatar_crop', 'text', [
            'default' => null,
            'null' => true
        ]);
        $table->update();
    }
}
