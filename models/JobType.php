<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_job_type".
 *
 * @property int $id
 * @property string $job_type_name
 *
 * @property TblPost[] $tblPosts
 */
class JobType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_job_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['job_type_name'], 'required'],
            [['job_type_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'job_type_name' => 'Job Type Name',
        ];
    }

    /**
     * Gets query for [[TblPosts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTblPosts()
    {
        return $this->hasMany(TblPost::class, ['job_type_id' => 'id']);
    }
}
