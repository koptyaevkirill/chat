<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use frontend\models\ProfileForm;

/**
 * Site controller
 */
class UserController extends Controller
{
    /**
     * Profile update.
     *
     * @return mixed
     */
    public function actionProfile()
    {
        if (Yii::$app->user->isGuest) {
            $this->goHome();
        }
        $model = new ProfileForm(Yii::$app->user->identity);

        if ($model->load(Yii::$app->request->post())) {
            $model->image = UploadedFile::getInstance($model, 'image');
            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Your account details have been updated.'));
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'An error occurred. Please try again later.'));
            }
        }
        return $this->render('profile', [
            'model' => $model,
        ]);
    }
    
}