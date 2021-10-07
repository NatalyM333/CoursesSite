<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\select2\Select2;
use kartik\widgets\FileInput;

use yii\widgets\ActiveForm;

$this->title = 'Створення';
$this->params['breadcrumbs'][] = ['label' => 'Технічна підтримка', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h4><?=$this->title;?></h4>
    </div>
    <?php
    $form=ActiveForm::begin(['id' => 'support-create']);
    ?>
     <div class="panel-body">
     <div class="row">
            <div class="col-md-12">
            <?=$form->field($model, 'name')->textInput();?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?=$form->field($model, 'description')->textarea(['row' => '3'])->label('Опис');?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <?= $form->field($model, 'supportFile')->widget(FileInput::classname(),[
            'name' => 'attachment_49[]',
            'attribute' => 'assets_file',
            'id' => 'assets_file',
            'options'=>[
                'multiple'=>true,
                'max' => 10,
            ],
            'pluginOptions' => [
                'initialPreview'=> $initialPreview,
                'initialPreviewConfig' => $initialConfig,
                'initialPreviewAsData'=>true,
                'hideThumbnailContent' => true,
                'initialPreviewFileType' => 'pdf',
                'showCaption' => false,
                'showUpload' => false,
                'removeClass' => 'btn btn-default pull-right',
                'browseClass' => 'btn btn-primary pull-right',
                'overwriteInitial'=>false,
                'maxFileSize'=>11000,
                'deleteUrl' => Url::to(['/support/' . $support_id . '/file-delete-support']),        
            ]
]); ?>

</div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?=Html::submitButton('Зберегти',['class'=>'btn btn-success btn-block]'])?>
            </div>
        </div>
    </div>
    <?php
        ActiveForm::end();
    ?>
</div>