<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_industry_type".
 *
 * @property int $id
 * @property string $industry_name
 *
 * @property TblPost[] $tblPosts
 */
class IndustryType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_industry_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['industry_name'], 'required'],
            [['industry_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'industry_name' => 'Industry Name',
        ];
    }

    /**
     * Gets query for [[TblPosts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTblPosts()
    {
        return $this->hasMany(TblPost::class, ['industry_type_id' => 'id']);
    }
}
