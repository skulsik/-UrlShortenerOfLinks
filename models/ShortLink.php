<?php

namespace app\models;

class ShortLink extends \yii\db\ActiveRecord
{
    public function getLongLink()
    {
        return $this->hasOne(LongLink::class, ['id' => 'long_link_id']);
    }
}