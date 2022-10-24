<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\JobCategory;
use app\models\JobType;
use app\models\IndustryType;
use app\models\Company;
use kartik\date\DatePicker;

/** @var yii\web\View $this */
/** @var app\models\Post $model */
/** @var yii\bootstrap4\ActiveForm $form */

/**<?= $form->field($model, 'company_id')->textInput() ?> */
?>


<div class="post-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= 
        $form->
        field($model, 'company_id')->
        dropDownlist(ArrayHelper :: map(company::find()->all(), 'id', 'company_name'),['form-control inline block'])->
        label('Company'); 
    ?>


    <?= 
        $form->
        field($model, 'job_title')->textInput(['maxlength' => true]) 
    ?>

    <?= 
        $form->
        field($model, 'job_category_id')->
        dropDownlist(ArrayHelper :: map(JobCategory::find()->all(), 'id', 'category_name'),['form-control inline block'])->
        label('Job Category'); 
    ?>

    <?= 
        $form->
        field($model, 'job_type_id')->
        dropDownlist(ArrayHelper :: map(JobType::find()->all(), 'id', 'job_type_name'),['form-control inline block'])->
        label('Job Type');  
    ?>

    <?= 
        $form->
        field($model, 'industry_type_id')->
        dropDownlist(ArrayHelper :: map(IndustryType::find()->all(), 'id', 'industry_name'),['form-control inline block'])->
        label('Industry Type');  
    ?>

    <?= 
        $form->field($model, 'short_desc')->textInput()->textarea(['rows' => 6])
    ?>

    <?= 
        $form->field($model, 'descFile')->fileInput() 
    ?>

    <?= '<label class="form-label">Start Date</label>'; ?>
    <?= 
        DatePicker::widget([
            'model' => $model, 
            'type' => DatePicker::TYPE_INPUT,
            'attribute' => 'start_date',
            'options' => ['placeholder' => 'Enter Start Date'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd',
            ]
        ]);
    ?>

    <?= 
        $form->field($model, 'pay_rate')->textInput()
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
