<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%menu}}`.
 */
class m190322_153013_create_menu_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%menu}}', [
            'id' => $this->primaryKey(),
            'active' =>$this->tinyInteger(4)->defaultValue(1),
            'id_section'=>$this->integer(),
            'title'=>$this->string(),
            'url'=>$this->string(),
            'menu_from'=>$this->string()

        ]);
		$this->insert('menu', [
            'active' => 1,
            'id_section' => 0,
			'title' => 'Главная',
			'url' =>'/',			
        ]);
		$this->insert('menu', [
            'active' => 1,
            'id_section' => 0,
			'title' => 'Категории',
			'url' =>'/site/category/',
			'menu_from' => "category|'id_section'=0",
        ]);
		$this->insert('menu', [
            'active' => 1,
            'id_section' => 0,
			'title' => 'О блоге',
			'url' =>'/site/about',			
        ]);
		$this->insert('menu', [
            'active' => 1,
            'id_section' => 0,
			'title' => 'Контакты',
			'url' =>'/site/contact',			
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%menu}}');
    }
}
