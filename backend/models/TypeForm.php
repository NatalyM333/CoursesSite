<?php 
namespace backend\models;

use yii\base\Model;

class TypeForm extends Model
{
    public $name;
    public $description;
    
    public function rules()
    {
        return [
            [['name',], 'string', 'message' => 'Invalid field type'],
            [['name',], 'required', 'message' => 'The value is required']
        ];
        
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Назва виду',
            'description' => 'Опис'
        ];
    }
}