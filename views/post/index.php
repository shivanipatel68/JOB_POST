<?php

use app\models\Post;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\JobType;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\PostSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php 
    $this->registerJs('
    $(document).on("click","#delete",function(e){
        let selected=$(".grid-view>table>tbody :input");
        let data=selected.serialize();
        
        if(data.length){
            let confirmDelete  =   confirm("Are you sure you want to delete???");
            if(confirmDelete){
                $.ajax({
                    url:"/post/eleteall",
                    data:data,
                    dataType:"json",
                    method:"post",
                    success:function(data){
                        if(data.success){
                            $.pjax({container:"#post-grid"});
                        }else{
                            alert(data.msg);
                        }
                    },
                    error:function(erorr,responseText,code){}
                });
            }
        }else{
            alert("select someitems to delete");
        }
    });
    ', \yii\web\view::POS_READY);
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
        <?=Html::button('Delete All', ['class' => 'btn btn-danger', 'id' => 'delete'])?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php Pjax::begin(['id' => 'post-grid']);?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn', 'checkboxOptions' => function($model) {
                      return ['value' => $model->id];
                  },
            ],

            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            [
                'label' => 'Company',
                'value' => function ($data) {
                    return $data->company->company_name; 
                },
            ],


            [ 
                'label' =>'Job Title',
                //'attribute' => 'job_title'
                'value' => function ($data) {
                    return $data->job_title; 
                },
            ],

            [
                'label' => 'Job Category',
                'value' => function ($data) {
                    return $data->jobCategory->category_name; 
                },
            ],

            [
                'label' => 'Job Type',
                'value' => function ($data) {
                    return $data->jobType->job_type_name; 
                },
                //'attribute' => 'jobTypeName',
            ],
            
            //($model, 'job_type_id')->dropDownlist(ArrayHelper :: map(JobType::find()->all(), 'id', 'job_type_name'));
            //'industry_type_id',
            //'short_desc',
            //'job_desc',
            //'start_date',
            //'pay_rate',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Post $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

<?php Pjax::end();?>
</div>
