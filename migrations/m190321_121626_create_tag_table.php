<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tag}}`.
 */
class m190321_121626_create_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tag}}', [
            'id' => $this->primaryKey(),
            'active'=>$this->tinyInteger(4),
            'lang'=>$this->string(),
            'title'=>$this->string()

        ]);
		$this->insert('tag', [
            'active' => 1,
			'title' => 'Новости',						
        ]);
		$this->insert('tag', [
            'active' => 1,
			'title' => 'Программирование',						
        ]);
		$this->insert('tag', [
            'active' => 1,
			'title' => 'Дизаин',						
        ]);
		$this->insert('tag', [
            'active' => 1,
			'title' => 'Компьютер',						
        ]);
		$this->insert('tag', [
            'active' => 1,
			'title' => 'Администрирование',						
        ]);
		$this->insert('tag', [
            'active' => 1,
			'title' => 'Полезно',						
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tag}}');
    }
}
