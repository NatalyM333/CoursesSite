<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\select2\Select2;
use kartik\widgets\FileInput;

use yii\widgets\ActiveForm;

$this->title = 'Технічна підтримка';
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
            <p>Назва</p>
                <?=$model->name?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <p>Опис</p>
                <?=$model->description?>
            </div>
        </div>
        
       
        <div class="row">
                    <div class="col-md-12">
                    <?php
                        foreach ($initialPreview as $key ) {  
                            
                    ?>
                    <div>
                    <a href ='<?=Url::to(["file", 'filename' => $key])?>')>view</div>
                    <a href ="../../files/support/dae66e01b9680b5b16118ce73a6988f3.pdf">kkkk</a>
                    <object data="../../files/support/dae66e01b9680b5b16118ce73a6988f3.pdf" type="application/x-pdf" title="SamplePdf" width="500" height="720">
    <a href="../../files/support/dae66e01b9680b5b16118ce73a6988f3.pdf">shree</a> 
</object>
                    </div>
                     <?php
                        }
                    ?>
                  

                    </div>
        </div>
      
    </div>
    <?php
        ActiveForm::end();
    ?>
</div>