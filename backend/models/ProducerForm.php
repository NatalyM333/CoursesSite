<?php

namespace backend\models;

use yii\base\Model;

class ProducerForm extends Model
{
    public $name;
    public $description;

    public function rules()
    {
        return[
            [['name','description',], 'string', 'message' => 'не вірний тип поля'],
            
            [['name'], 'required', 'message' => 'значення обов\'язкове'],
        ];     
    }
    public function attributeLabels()
    {
        return [
            'name' => 'Назва виробника',
            'description' => 'Опис',
        ];
    }
  

}
