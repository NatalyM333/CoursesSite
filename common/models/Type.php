<?php 
    namespace common\models;

    use Yii;
    use \yii\db\ActiveRecord;

    /**
     * 
     * @property int $id
     * @property string $title
     */
    class Type extends ActiveRecord
    {
        public static function tableName()
        {
            return 'types';
        }

        public function rules()
        {
            return [];
        }

        public function attributeLabel()
        {
            return [];
        }
    }