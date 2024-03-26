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
    public function actionView($param1=null)
    {
        dd($param1);
        return $this->render('view');
    }

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
            $short_link_obj->generate_hash_link();
            $short_link_attr = $short_link_obj->get_short_link();

            /** Если нет ошибок из генератора ссылок, продолжает работу */
            if (!$short_link_attr['errors'])
            {
                /** Объект - добавление ссылок в бд */
                $add_link = new AddLinkDB($short_link_attr);

                /** Добавление хоста в БД */
                if ($add_link->add_host())
                {
                    return $this->redirect(['/', 'error' => 'Не удалось сохранить хост.']);
                }

                /** Добавление длинной ссылки в БД */
                if ($add_link->add_long_link($model_long_link))
                {
                    $this->redirect(['/', 'error' => 'Не удалось сохранить длинную ссылку.']);
                }

                /** Добавление короткой ссылки в БД */
                if ($add_link->add_short_link())
                {
                    $this->redirect(['/', 'error' => 'Не удалось сохранить короткую ссылку.']);
                }
            }
            else
            {
                return $this->render('create', [
                    'errors' => $short_link_attr['errors'],
                ]);
            }
        }

        //Yii::$app->runAction('LinkController/actionView', ['param1'=>'value1', 'param2'=>'value2']);

        return $this->render('view', [
            'model' => 'test',
        ]);
    }
}
