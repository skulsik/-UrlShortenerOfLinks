<?php

namespace app\models;

use Yii;

class LongLinks extends \yii\db\ActiveRecord
{
    /** Валидация */
    public function rules()
    {
        return [
            ['link', 'required'],
            ['link', 'url'], // Валидация URL
        ];
    }

    /** Отношение: длинная ссылка - ко многим коротким ссылкам */
    public function getShortLink()
    {
        return $this->hasMany(ShortLinks::class, ['long_link_id' => 'id']);
    }
}