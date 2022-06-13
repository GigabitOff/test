<?php

namespace app\controllers;


use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Users;


class MyroomController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionJornal()

    {
        $id= Yii::$app->user->id;
        $model = Yii::$app->db->createCommand("SELECT * FROM {{users}} WHERE [[id]] = '$id'")
            ->queryOne();
        $date_urok = date( "Y-m-d" );
        $schoolid = $model["school"];
        $classnumber = $model["classnumber"];
        $classlater = $model["classlater"];
        if($model["tipe"] == 3) {
            $uroki = Yii::$app->db->createCommand("SELECT * FROM {{raspisanie}} WHERE [[date]] = '$date_urok' AND [[school_id]] = '$schoolid' AND [[classnumber_id]] = '$classnumber' AND [[status_uroka]] = '0' OR  [[status_uroka]] = '1' AND [[classlater_id]] = '$classlater' ORDER BY time ASC ")
                ->queryAll();
        }
        if($model["tipe"] == 2 OR $model["tipe"] == 4) {
            $uroki = Yii::$app->db->createCommand("SELECT * FROM {{raspisanie}} WHERE [[date]] = '$date_urok' AND [[ticher_id]] = '$id' AND [[active]] = '1' ")
                ->queryAll();
        }
        $transaction_code_security = rand(1000, 999999999);

        return $this->render('jornal', [
            'model' => $model,
            'uroki' => $uroki,
            'tranzaction_code_security' => $transaction_code_security,
        ]);
    }

    public function actionIndex()
    {
        $id = Yii::$app->user->id;
        $model = Yii::$app->db->createCommand("SELECT * FROM {{users}} WHERE [[id]] = '$id'")
            ->queryOne();



        if($model["status_user"] == 0 and $model["tipe"] == 3){
            return $this->redirect('../site/registration_user?step=2&tipe=3');
        }
        if($model["status_user"] == 0 and $model["tipe"] == 4){
            return $this->redirect('../site/registration_user?step=2&tipe=4');
        }
        $date_urok = date("Y-m-d");
        $schoolid = $model["school"];
        $classnumber = $model["classnumber"];
        $classlater = $model["classlater"];
        if ($model["tipe"] == 3) {
            $uroki = Yii::$app->db->createCommand("SELECT * FROM {{raspisanie}} WHERE [[date]] = '$date_urok' AND [[school_id]] = '$schoolid' AND [[classnumber_id]] = '$classnumber' AND [[status_uroka]] = '0' OR  [[status_uroka]] = '1' AND [[classlater_id]] = '$classlater' ORDER BY time ASC ")
                ->queryAll();
        }
        if ($model["tipe"] == 2 or $model["tipe"] == 4) {
            $uroki = Yii::$app->db->createCommand("SELECT * FROM {{raspisanie}} WHERE [[date]] = '$date_urok' AND [[ticher_id]] = '$id' AND [[active]] = '1' ")
                ->queryAll();
        }
        $transaction_code_security = rand(1000, 999999999);
        
        if (!Yii::$app->user->isGuest) {
            return $this->render('start', [
                'model' => $model,
                'uroki' => $uroki,
                'tranzaction_code_security' => $transaction_code_security,
            ]);
        }
        if (Yii::$app->user->isGuest) {
            return $this->redirect('../site/login');
        }
    } //Метод экранирован

    public function actionOnline($ids,$cod)
    {
        $user_id = Yii::$app->user->id;

        $urok = Yii::$app->db->createCommand("SELECT * FROM {{raspisanie}} WHERE [[code_uroka]] = '$cod'")
            ->queryOne();

        $data = Yii::$app->db->createCommand('SELECT [[id]] FROM {{urok_online}} ORDER BY [[id]] DESC LIMIT 1')
            ->queryOne();
        $cod_uroka_data = Yii::$app->db->createCommand('SELECT * FROM {{urok_online}} WHERE [[code_uroka]] = '.$cod.'  ORDER BY [[id]] DESC ')
            ->queryOne();
        $id_table_end = $data["id"] + 1;
        if($cod_uroka_data["code_uroka"] != $cod) {
            $model = Yii::$app->db->createCommand("SELECT * FROM {{users}} WHERE [[id]] = '$user_id'")
                ->queryOne();
            if($model["tipe"] == 2) {
                Yii::$app->db
                    ->createCommand()
                    ->insert('urok_online', ['id' => $id_table_end, 'school_id' => $urok["school_id"], 'user_id' => $ids, 'ticher_id' => $urok["ticher_id"], 'time' => $urok["time"], 'date' => $urok["date"], 'classnumber_id' => $urok["classnumber_id"], 'classlater_id' => $urok["classlater_id"], 'timeendurok' => $urok["timeendurok"], 'status_uroka' => 1, 'active' => $urok["active"], 'code_uroka' => $cod])
                    ->execute();

                Yii::$app->db->createCommand("UPDATE {{raspisanie}} SET [[status_uroka]] = 1   WHERE [[code_uroka]] = '$cod'")->execute();
                Yii::$app->db->createCommand("UPDATE {{raspisanie}} SET [[active]] = 2   WHERE [[code_uroka]] = '$cod'")->execute();
            }
        }
        return $this->render('online');
    }//Метод экранирован

    public function actionOnlinestart($ids,$cod)
    {
        $user_id = Yii::$app->user->id;

        $urok = Yii::$app->db->createCommand("SELECT * FROM {{raspisanie}} WHERE [[code_uroka]] = '$cod'")
            ->queryOne();

        $data = Yii::$app->db->createCommand('SELECT [[id]] FROM {{urok_online}} ORDER BY [[id]] DESC LIMIT 1')
            ->queryOne();
        $cod_uroka_data = Yii::$app->db->createCommand('SELECT * FROM {{urok_online}} WHERE [[code_uroka]] = '.$cod.'  ORDER BY [[id]] DESC ')
            ->queryOne();
        $data_zoom = Yii::$app->db->createCommand("SELECT * FROM {{data_zoom}} WHERE  [[urok_id]] = " . $urok['id'] . "  ")->queryOne();
        $id_table_end = $data["id"] + 1;
        if($cod_uroka_data["code_uroka"] != $cod) {
            $model = Yii::$app->db->createCommand("SELECT * FROM {{users}} WHERE [[id]] = '$user_id'")
                ->queryOne();
            if($model["tipe"] == 2) {
                Yii::$app->db
                    ->createCommand()
                    ->insert('urok_online', ['id' => $id_table_end, 'school_id' => $urok["school_id"], 'user_id' => $ids, 'ticher_id' => $urok["ticher_id"], 'time' => $urok["time"], 'date' => $urok["date"], 'classnumber_id' => $urok["classnumber_id"], 'classlater_id' => $urok["classlater_id"], 'timeendurok' => $urok["timeendurok"], 'status_uroka' => 1, 'active' => $urok["active"], 'code_uroka' => $cod])
                    ->execute();

                Yii::$app->db->createCommand("UPDATE {{raspisanie}} SET [[status_uroka]] = 1   WHERE [[code_uroka]] = '$cod'")->execute();
                Yii::$app->db->createCommand("UPDATE {{raspisanie}} SET [[active]] = 2   WHERE [[code_uroka]] = '$cod'")->execute();
            }
        }
        return $this->render('onlinestart', [
            'urok' => $urok,
        ]);

    }//Метод экранирован
}
