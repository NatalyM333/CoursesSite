<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = 'Producer';
$this->params['breadcrumbs'][] = $this->title;



?>
<div class="row">
    
    <div class="col-md-12">
        <?= Html::a(
            'Додати виробника',
            Url::toRoute('producer/create'),
            [
                'class' => 'btn btn-success pull-right',
                'id' => 'producer-create'
            ]
        );?>
    </div>
    <div class="col-md-12">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                'name',
                [
                    'class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}',
                    'contentOptions' => ['style' => 'width: 30%'],
                    'buttons' => [
                        
                        
                        'update' => function ($url, $model, $key){
                            return Html::a('Update', ['update','id' => $model->id], ['class' => 'btn btn-success']);
                        },
                        'delete' => function ($url, $model, $key){
                            return Html::a('Delete', ['delete','id' => $model->id], ['class' => 'btn btn-danger']);
                        }
                    ]
                ]
            ]
        ]);
        ?>
    </div>
   
</div>