<?php

namespace app\models;

use Yii;

class LongLinks extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
            ['link', 'required'],
            ['link', 'url'], // Валидация URL
        ];
    }
}