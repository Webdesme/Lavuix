<?php

namespace app\Controllers;

use yii\web\Response;
use yii\web\Controller;

class ResultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('form');
    }

    public function actionSubmit()
    {
        $model = $this->submit();

        $view = !$model->hasErrors() ? 'result' : 'error';
        return $this->render($view, [
            'model' => $model
        ]);
    }

    public function actionSubmitAjax()
    {
        $model = $this->submit();

        \Yii::$app->response->format = Response::FORMAT_JSON;
        $result = [
            'SUCCESS' => !$model->hasErrors(),
            'ERRORS' => $model->getErrors(),
            'DATA' => [
                'DRAW_ID' => $model->draw_id,
                'COUPLES' => $model->couples,
            ]
        ];
        return $result;
    }

    protected function submit()
    {
        $model = new \app\models\ResultForm();
        $request = \Yii::$app->request;

        if ($request->isPost) {
            $model->checkwords = $request->post('checkwords');
            $model->prepare();
            if ($model->validate()) {
                $model->make();
            }
        }

        return $model;
    }


}
