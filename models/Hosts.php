<?php

namespace app\models;

class Hosts extends \yii\db\ActiveRecord
{
    /** Отношение: хост - ко многим длинным ссылкам */
    public function getLongLink()
    {
        return $this->hasMany(LongLinks::class, ['host_id' => 'id']);
    }
}