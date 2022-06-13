<?php
///Я остановился на том чтобі в тестах біла сделана функция которая правильно формирует варианті ответов.
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\HtmlPurifier;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Users;


class ApijornalController extends \yii\web\Controller
{


    public static function actionIndex()
    {
        return htmlspecialchars(1);
    }


}
