<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m190321_121236_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'active' =>$this->tinyInteger(4)->defaultValue(1),
            'name' => $this->string(),
            'email' => $this->string()->defaultValue(null),
            'password' => $this->string(),
            'isAdmin' => $this->tinyInteger(4)->defaultValue(0),
            'image' => $this->string()->defaultValue(null),
			'role_id' => $this->integer()
			
        ]);
		$this->insert('user', [
            'active' => 1,
            'name' => 'admin',
			'email' => 'admin@admin.ru',
			'password' =>'admin',
			'role_id' =>1,
			
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
