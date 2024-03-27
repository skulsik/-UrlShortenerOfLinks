<?php

namespace app\controllers;

use app\models\Hosts;
use app\models\LongLinks;
use app\services\AddLinkDB;
use app\services\GeneratorShortLink;
use Yii;
use yii\web\Controller;

class LinkController extends Controller
{
    /** Вывод созданной ссылки */
    public function actionView()
    {
        return $this->render('view');
    }

    public function actionList()
    {
        $model_link = Hosts::find()->with('longLink')->all();
        dd($model_link);

        return $this->render('list');
    }

    /** Создание короткой ссылки
     * Запись хоста, длинной и короткой ссылки в бд
     */
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

        return $this->render('view', [
            'host' => $short_link_attr['host'],
            'short_link' => $short_link_attr['short_link'],
            'long_link' => $model_long_link->link
        ]);
    }
}
