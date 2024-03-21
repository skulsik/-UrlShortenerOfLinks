<?php

namespace app\controllers;

use app\models\LongLinks;
use app\services\AddLinkDB;
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
        /** Создание модели - длинной ссылки */
        $model_long_link = new LongLinks();

        if ($model_long_link->load(Yii::$app->request->post()) && $model_long_link->validate())
        {
            /** Генерация короткой ссылки */
            $short_link_obj = new GeneratorShortLink($model_long_link);
            $short_link_atr = $short_link_obj->get_short_link();

            /** Если нет ошибок из генератора ссылок, продолжает работу */
            if(!$short_link_atr['errors'])
            {
                /** Объект - добавление ссылок в бд */
                $add_link = new AddLinkDB($short_link_atr);

                /** Добавление хоста */
                if($add_link->add_host())
                {
                    dd('gfdgfd');
                    return $this->redirect(['create', 'error' => 'Не удалось сохранить хост.']);
                }

                /** Добавление длинной ссылки */
                if($add_link->add_long_link($model_long_link))
                {
                    $this->redirect(['create', 'error' => 'Не удалось сохранить длинную ссылку.']);
                }

                dd($add_link->model_long_link);



                /** Модель короткой ссылки */
                $model_short_link = new ShortLinks();



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
