<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Menu".
 *
 * @property int $id
 * @property int $active
 * @property int $id_section
 * @property string $title
 * @property string $url
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Menu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['active', 'id_section'], 'integer'],
            [['title', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'active' => 'Active',
            'id_section' => 'Id Section',
            'title' => 'Title',
            'url' => 'Url',
        ];
    }
}
