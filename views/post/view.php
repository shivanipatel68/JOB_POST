<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Post $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="post-view">

    <h1>
       <?php   
       /** Html::encode($this->title) */ 
       ?>
    </h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            [
                'attribute' => 'Company',
                'value'     => $model-> company ->company_name,
            ],
            'job_title',
            [
                'attribute' => 'Job Category',
                'value'     => $model-> jobCategory ->category_name,
            ],
            [
                'attribute' => 'Industry Type',
                'value'     => $model-> jobType ->job_type_name,
            ],
            [
                'attribute' => 'Industry Type',
                'value'     => $model-> industryType ->industry_name,
            ],
            'short_desc',
            [
                'attribute' => 'job_desc',
                //'value'     => '/uploads/Captur.png',
                //http://localhost:8080/uploads/IMG-4265.jpg
                'value'     => 'http://localhost:8080/'.$model->job_desc,
                'format'    => ['image', ['width'=>'100']],
            ],
            'start_date',
            'pay_rate',
        ],
    ]) ?>

</div>
