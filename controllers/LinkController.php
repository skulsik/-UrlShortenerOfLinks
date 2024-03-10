<?php

namespace app\controllers;

use app\models\LongLink;
use app\services\GeneratorToken;
use Yii;
use yii\web\Controller;
use app\models\ShortLink;

class LinkController extends Controller
{
    public function actionGetShortLinks($longLink)
    {
        $shortLinks = ShortLink::find()
            ->with('longLink')
            ->where(['long_link.link' => $longLink])
            ->all();

        // Вернуть короткие ссылки для заданной длинной ссылки
        return $this->asJson($shortLinks);
    }

    public function actionGetLongLink($shortLink)
    {
        $longLink = ShortLink::findOne(['link' => $shortLink])->longLink;

        // Вернуть длинную ссылку для заданной короткой ссылки
        return $this->asJson($longLink);
    }

    public function actionCreate()
    {
        $model = new LongLink();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $token = new GeneratorToken();
            dd($token->getToken());
            // сохранение данных
//            if ($model->save()) {
//                return $this->redirect(['view', 'id' => $model->id]);
//            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
}
