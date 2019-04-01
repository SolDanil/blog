<?php

use yii\db\Migration;

/**
 * Class m190401_023922_insert_article_tag_table
 */
class m190401_023922_insert_article_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
    	$this->insert('article_tag', [
            'article_id' => 1,
            'tag_id' => 4,						
        ]);
        $this->insert('article_tag', [
            'article_id' => 1,
            'tag_id' => 5,						
        ]);
        $this->insert('article_tag', [
            'article_id' => 1,
            'tag_id' => 6,						
        ]);
        $this->insert('article_tag', [
            'article_id' => 2,
            'tag_id' => 4,						
        ]);
        $this->insert('article_tag', [
            'article_id' => 2,
            'tag_id' => 5,						
        ]);
        $this->insert('article_tag', [
            'article_id' => 2,
            'tag_id' => 6,						
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190401_023922_insert_article_tag_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190401_023922_insert_article_tag_table cannot be reverted.\n";

        return false;
    }
    */
}
