<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use frontend\models\SignupForm;

/**
 * Site controller
 */
class UserController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionProfile()
    {
        if (Yii::$app->user->isGuest) {
            $this->goHome();
        }
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('profile', [
                'model' => $model,
            ]);
        }
    }
    
}