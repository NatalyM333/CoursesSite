<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
$js = <<<JS
$('.role').change(function(){
    var id =$(this).attr('name');
    var role = $(this).val();
    alert(id+ ' - ' + role);
    $.ajax({
        type:'post',
        url: 'change-role',
        data:{'id': id,
        'role':role
        },
        success: (function(){
            alert('Role is changed');
        }
        )
    })
})
JS;
$this->registerJs($js);

?>

<div class="panel panel-default ">
    <div class="panel-heading">
        <h4><?=$this->title;?>User</h4>
    </div>
    <?php
    $form=ActiveForm::begin(['id' => 'user-create']);
    ?>
     <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
            <p>Назва</p>
                <?=$model->username?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <p style="margin-top: 5px;">Email</p>
                <?=$model->email?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                
            <?= Select2::widget([
                'name' => $user_id,
                'id' => 'role',
                'data' => $role_array,
                'options' => [
                    'class'=> 'role',
                    'placeholder' => 'Select provinces ...',
                    'multiple' => false
                ],
            ]);?>
            </div>
        </div>
       
        </div>
        
      
    </div>
    <?php
        ActiveForm::end();
    ?>
</div>