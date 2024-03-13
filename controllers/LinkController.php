<?php

namespace app\controllers;

use app\models\Hosts;
use app\models\LongLinks;
use app\services\GeneratorShortLink;
use Yii;
use yii\web\Controller;
use app\models\ShortLinks;

class LinkController extends Controller
{
    public function actionGetShortLinks($longLink)
    {
        $shortLinks = ShortLinks::find()
            ->with('longLink')
            ->where(['long_link.link' => $longLink])
            ->all();

        // Вернуть короткие ссылки для заданной длинной ссылки
        return $this->asJson($shortLinks);
    }

    public function actionGetLongLink($shortLink)
    {
        $longLink = ShortLinks::findOne(['link' => $shortLink])->longLink;

        // Вернуть длинную ссылку для заданной короткой ссылки
        return $this->asJson($longLink);
    }

    /**  */
    public function actionCreate()
    {
        /** Создание моделей */
        $model_long_link = new LongLinks();
        $model_short_link = new ShortLinks();

        if ($model_long_link->load(Yii::$app->request->post()) && $model_long_link->validate())
        {
            /** Генерация короткой ссылки */
            $short_link_obj = new GeneratorShortLink($model_long_link);
            $short_link_atr = $short_link_obj->get_short_link();

            /** Если нет ошибок из генератора ссылок, продолжает работу */
            if(!$short_link_atr['errors'])
            {
                /** Поиск хоста в БД */
                $model_host = Hosts::find()->where(['host' => $short_link_atr['host']])->one();
                /** Если в БД нет такого хоста, создает новую модель хоста */
                if(!$model_host) $model_host = new Hosts();
                /** Запись хоста в модель */
                $model_host->host = $short_link_atr['host'];
                /** Сохранение модели хоста */
                if (!$model_host->save()) return $this->redirect(['create', 'error' => 'Не удалось сохранить хост.']);

                /** Поиск длинной ссылки в БД */
                $long_link_db = LongLinks::find()->where(['link' => $model_long_link->link])->one();
                dd($model_host);

            }
            else
            {
                return $this->render('create', [
                    'model' => $model_long_link,
                ]);
            }


            // сохранение данных
//            if ($model->save()) {
//                return $this->redirect(['view', 'id' => $model->id]);
//            }
        }

        return $this->render('create', [
            'model' => $model_long_link,
        ]);
    }
}
