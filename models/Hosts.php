<?php

namespace app\models;

class Hosts extends \yii\db\ActiveRecord
{
    public function getLongLink()
    {
        return $this->hasOne(LongLinks::class, ['id' => 'long_link_id']);
    }
}