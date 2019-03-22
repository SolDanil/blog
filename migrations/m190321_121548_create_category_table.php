<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category}}`.
 */
class m190321_121548_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'id_section'=>$this->integer(),
            'active'=>$this->tinyInteger(4),
            'lang'=>$this->string(),
            'title'=>$this->string(),
            'description'=>$this->text(),
            'image'=>$this->string()

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%category}}');
    }
}
