<?php

namespace app\services;

use app\models\Hosts;
use app\models\LongLinks;
use yii\web\Controller;

class AddLinkDB
{
    public function __construct(array $attr)
    {
        /** Принимает атрибуты ссылки */
        $this->attr = $attr;
        $this->model_host = null;
        $this->model_long_link = null;
        $this->model_long_link_db = null;
    }

    protected function search_host()
    {
        /** Поиск хоста в БД */
        $this->model_host = Hosts::find()->where(['host' => $this->attr['host']])->one();
    }

    public function add_host()
    {
        /** Вызов метода поиска хоста */
        $this->search_host();
        /** Если в БД нет такого хоста, создает новую модель хоста */
        if(!$this->model_host)
        {
            $this->model_host = new Hosts();
            /** Запись хоста в модель */
            $this->model_host->host = $this->attr['host'];
            /** Сохранение модели хоста */
            if (!$this->model_host->save()) return true;
        }
    }

    protected function search_long_link($model)
    {
        /** Поиск длинной ссылки в БД */
        $this->model_long_link_db = LongLinks::find()->where(['link' => $model->link])->one();
    }

    public function add_long_link($model)
    {
        /** Вызов метода поиска длинной ссылки */
        $this->search_long_link($model);
        /** Если в БД нет такой длинной ссылки, создает новую модель длинной ссылки */
        if(!$this->model_long_link_db)
        {
            /** Присвоение родителя длинной ссылке */
            $this->model_long_link->host_id = $this->model_host->id;
            /** Сохранение модели длинной ссылки */
            if (!$this->model_long_link->save()) return true;
        }
        /** Если в бд существует длинная ссылка, присваивает новой модели - модель из бд */
        else $this->model_long_link = $this->model_long_link_db;
    }
}