<?php

namespace app\models;

use Yii;

class LongLink extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
            ['link', 'required'],
            ['link', 'url'], // Валидация URL
        ];
    }
}