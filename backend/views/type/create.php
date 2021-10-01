<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\FileInput;

$this->title = ($model->name)? 'Update type' :  'Create type';
$this->params['breadcrumbs'][] = ['label' => 'Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h4><?=$this->title;?></h4>
    </div>
    <?php $form = ActiveForm::begin(['id' => 'type-create']); ?>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <?=$form->field($model, 'name')->textInput();?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?=$form->field($model, 'description')->textInput();?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= Html::submitButton('Save',['class'=>'btn btn-success btn-block]']) ?>
            </div>
        </div>
    </div>
    <?php  ActiveForm::end(); ?>
</div>