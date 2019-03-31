<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%role}}`.
 */
class m190321_121448_create_role_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%role}}', [
            'id' => $this->primaryKey(),
            'active'=>$this->tinyInteger(4)->defaultValue(1),
            'name'=>$this->string()
        ]);
		
		$this->insert('role', [
            'active' => '1',
            'name' => 'admin',
        ]);
		$this->insert('role', [
            'active' => '1',
            'name' => 'author',
        ]);
		$this->insert('role', [
            'active' => '1',
            'name' => 'user',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%role}}');
    }
}
