<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "company".
 *
 * @property int $id
 * @property string $company_name
 * @property string $company_address
 * @property string $company_email
 * @property string $company_phone
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_company';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_name', 'company_address', 'company_phone'], 'required'],
            [['company_email'], 'email'],
            [['company_address'], 'string'],
            [['company_name', 'company_email'], 'string', 'max' => 255],
            [['company_phone'], 'string', 'max' => 12],
            ['company_phone', 'match', 'pattern' => '/^(\(\d{3}\)[.-]?|\d{3}[.-]?)?\d{3}[.-]?\d{4}$/'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_name' => 'Company Name',
            'company_address' => 'Company Address',
            'company_email' => 'Company Email',
            'company_phone' => 'Company Phone',
        ];
    }
}
