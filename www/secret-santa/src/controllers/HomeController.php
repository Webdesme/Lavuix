<?php

namespace app\Controllers;

use yii\web\Response;
use yii\web\Controller;

class HomeController extends Controller
{
    public function actionIndex()
    {
        return $this->render('form');
    }


    public function actionInfo()
    {
        return $this->render('info');
    }


    public function actionSubmit()
    {
        $session = \Yii::$app->session;
        if (
            isset($session['form_token']) &&
            isset($_POST['form_token']) &&
            ($_POST['form_token'] == $session['form_token'])
        ) {
            $model = $this->submit();
        }
        else {
            $model = new \app\models\CreateForm();
            $model->addError('token_error', 'Некорректный токен');
        }

        $view = !$model->hasErrors() ? 'success' : 'error';
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
            'ERRORS' => $model->getErrors()
        ];
        return $result;
    }

    protected function submit()
    {
        $model = new \app\models\CreateForm();
        $request = \Yii::$app->request;

        if ($request->isPost) {
            $model->emails = $request->post('emails');
            $model->message = $request->post('message');
            //if ($model->load(\Yii::$app->request->post())) {
            $model->prepare();
            if ($model->validate()) {
                $model->make();
            }
        }

        return $model;
    }


}
