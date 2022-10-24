<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "tbl_post".
 *
 * @property int $id
 * @property int $company_id
 * @property string $job_title
 * @property int $job_category_id
 * @property int $job_type_id
 * @property int $industry_type_id
 * @property string $short_desc
 * @property string $job_desc
 * @property string $start_date
 * @property string $pay_rate
 *
 * @property TblCompany $company
 * @property TblIndustryType $industryType
 * @property TblJobCategory $jobCategory
 * @property TblJobType $jobType
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $descFile;
    
    public static function tableName()
    {
        return 'tbl_post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'job_title', 'job_category_id', 'job_type_id', 'industry_type_id', 'short_desc', 'job_desc', 'start_date', 'pay_rate'], 'required'],
            [['company_id', 'job_category_id', 'job_type_id', 'industry_type_id'], 'integer'],

            [['job_title', 'job_desc', 'start_date','pay_rate'], 'string', 'max' => 255],
            [['short_desc'], 'string', 'max' => 1024],//1024

            ['pay_rate', 'match', 'pattern' => '/^[+]?[0-9]{1,2}(\,[0-9]{1,3})?$/'],

            [['descFile'], 'file', 'skipOnEmpty' => true,], //'extensions' => 'png, jpg'

            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => company::class, 'targetAttribute' => ['company_id' => 'id']],
            [['industry_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => IndustryType::class, 'targetAttribute' => ['industry_type_id' => 'id']],
            [['job_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => JobCategory::class, 'targetAttribute' => ['job_category_id' => 'id']],
            [['job_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => JobType::class, 'targetAttribute' => ['job_type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
            'job_title' => 'Job Title',
            'job_category_id' => 'Job Category ID',
            'job_type_id' => 'Job Type ID',
            'industry_type_id' => 'Industry Type ID',
            'short_desc' => 'Short Desc',
            'job_desc' => 'Job Description',
            'start_date' => 'Start Date',
            'pay_rate' => 'Pay Rate $(Yearly)',
        ];
    }

    /**
     * Gets query for [[Company]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::class, ['id' => 'company_id']);
    }

    /**
     * Gets query for [[IndustryType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIndustryType()
    {
        return $this->hasOne(IndustryType::class, ['id' => 'industry_type_id']);
    }

    /**
     * Gets query for [[JobCategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJobCategory()
    {
        return $this->hasOne(JobCategory::class, ['id' => 'job_category_id']);
    }

    /**
     * Gets query for [[JobType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJobType()
    {
        return $this->hasOne(JobType::class, ['id' => 'job_type_id']);
    }

    public function getJobTypeName() {

        return $this->jobType->job_type_name;
    }

    public function upload() {
        if (true) {
            $path = $this->descFile->baseName . '.' . $this->descFile->extension;
            $this->descFile->saveAs('uploads/' . $path);
            $this->job_desc = 'uploads/' . $path;
            $this->save();
            return true;
        } else {
            return false;
        }
    }
}