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
        $this->insert('category', [
            'id'=>1,
            'id_section'=>0,
            'active'=>1,
            'lang'=>'ru',
            'title'=>'Новости',
            'description'=>'Новости со всего мира'            
        ]);
        $this->insert('category', [
            'id'=>2,
            'id_section'=>0,
            'active'=>1,
            'lang'=>'ru',
            'title'=>'Программирование',
            'description'=>'Статьи о программировании'            
        ]);
        $this->insert('category', [
            'id'=>3,
            'id_section'=>0,
            'active'=>1,
            'lang'=>'ru',
            'title'=>'Компьютер',
            'description'=>'Статьи о администрировании компьютера'            
        ]);
        $this->insert('category', [
            'id'=>4,
            'id_section'=>0,
            'active'=>1,
            'lang'=>'ru',
            'title'=>'Софт',
            'description'=>'Статьи о приложениях для компьютера'            
        ]);
        $this->insert('category', [
            'id'=>5,
            'id_section'=>0,
            'active'=>1,
            'lang'=>'ru',
            'title'=>'Мобильный',
            'description'=>'Статьи мобильных устройствах и приложениях для них'            
        ]);
        $this->insert('category', [
            'id'=>6,
            'id_section'=>0,
            'active'=>1,
            'lang'=>'ru',
            'title'=>'Дизайн',
            'description'=>'Статьи о дизайне'            
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
