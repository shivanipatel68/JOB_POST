<?php

use app\models\Company;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\CompanySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Companies';
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
                    url:"/company/deleteall",
                    data:data,
                    dataType:"json",
                    method:"post",
                    success:function(data){
                        if(data.success){
                            $.pjax({container:"#company-grid"});
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

<div class="company-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Company', ['create'], ['class' => 'btn btn-success']) ?>
        <?=Html::button('Delete All', ['class' => 'btn btn-danger', 'id' => 'delete'])?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php Pjax::begin(['id' => 'company-grid']);?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn', 'checkboxOptions' => function($model) {
                      return ['value' => $model->id];
                  },
            ],
            //'id',
            ['class' => 'yii\grid\SerialColumn'],
            'company_name',
            'company_address',
            'company_email:email',
            'company_phone',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Company $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

<?php Pjax::end();?>
</div>
