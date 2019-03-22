<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comment}}`.
 */
class m190321_121718_create_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comment}}', [
            'id' => $this->primaryKey(),
            'active' =>$this->tinyInteger(4)->defaultValue(1),
            'id_section'=>$this->integer(),
            'text'=>$this->string(),
            'user_id'=>$this->integer(),
            'date'=>$this->date(),
            'article_id'=>$this->integer()
        ]);

        //create index for column 'user_id'
        $this->createIndex(
            'idx-post-user_id',
            'comment',
            'user_id'
        );
        //add foreign key for table 'user'
        $this->addForeignKey(
            'fk-post-user_id',
            'comment',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        //create index for column 'article_id'
        $this->createIndex(
            'idx-post-article_id',
            'comment',
            'article_id'
        );
        //add foreign key for table 'article'
        $this->addForeignKey(
            'fk-post-article_id',
            'comment',
            'article_id',
            'article',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%comment}}');
    }
}
