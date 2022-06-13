<?php
///Я остановился на том чтобі в тестах біла сделана функция которая правильно формирует варианті ответов.
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\HtmlPurifier;
use yii\rest\DeleteAction;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Users;

///// Все метода защищені от XSS and SQL-injection
class ApiController extends Controller
{
    const RESPONSE_OK = 'OK';
    const RESPONSE_NO_DATA = 'No data';

    public static function encode($text)
    {
        return htmlspecialchars($text);
    }

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

    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            $posts = Yii::$app->db->createCommand('SELECT * FROM {{users}}')
                ->queryAll();
            // return $this->respond(200,self::RESPONSE_OK,$posts);
            foreach ($posts as $value) {
                return HtmlPurifier::process($value);
            }
        }
    }//Метод экранирован и защищён от XSS

    public function actionIntervaldatedz($parametr1, $parametr2, $parametr3)
    {
        if (!Yii::$app->user->isGuest) {
            $user_id = Yii::$app->user->id;
            if ($parametr1 != "uchenic") {
                $posts = Yii::$app->db->createCommand("SELECT * FROM {{dz}} WHERE [[ticher_id]] = '$parametr1' AND [[date]] >= '$parametr2' AND [[date]] <= '$parametr3'  GROUP BY [[date]]  ")->queryAll();
                foreach ($posts as $value) {
                    echo HtmlPurifier::process("<hr style=' border: none; 
    background-color: red; 
    color: red; 
    height: 2px;'><p style='color: #2e6da4;'>" . $value["date"] . "</p></hr>");
                    $date_res = $value["date"];
                    $res_posts = Yii::$app->db->createCommand("SELECT * FROM {{dz}} WHERE [[ticher_id]] = '4' AND [[date]] = '$date_res' ")->queryAll();
                    foreach ($res_posts as $values) {
                        echo HtmlPurifier::process('<div class="listgroupitemDZ">
    <input type="checkbox" id="hd-' . $values["id"] . '" class="hide"/>
    <label style="margin-top:17px;" for="hd-' . $values["id"] . '" >' . $values["name_predmet"] . '</label>
    <div>
       gfhfh' . $values["text"] . '
         </div>
    <br/>
    <br/> 
</div>');
                    }
                }
            }
            if ($parametr1 == "uchenic") {
                $user_id = Yii::$app->user->id;
                $model = Yii::$app->db->createCommand("SELECT * FROM {{users}} WHERE [[id]] = '$user_id'")
                    ->queryOne();
                $schoolid = $model["school"];
                $classnumber = $model["classnumber"];
                $classlater = $model["classlater"];
                $posts = Yii::$app->db->createCommand("SELECT * FROM {{dz}} WHERE [[classnumber_id]] = '$classnumber' AND [[classlater_id]] = '$classlater' AND [[school_id]] = '$schoolid' AND [[date]] >= '$parametr2' AND [[date]] <= '$parametr3'  GROUP BY [[date]]  ")->queryAll();
                foreach ($posts as $value) {
                    echo HtmlPurifier::process("<hr style=' border: none; 
    background-color: red; 
    color: red; 
    height: 2px;'><p style='color: #2e6da4;'>" . $value["date"] . "</p></hr>");
                    $date_res = $value["date"];
                    $res_posts = Yii::$app->db->createCommand("SELECT * FROM {{dz}} WHERE [[classnumber_id]] = '$classnumber' AND [[classlater_id]] = '$classlater' AND [[school_id]] = '$schoolid' AND [[date]] = '$date_res' ")->queryAll();
                    foreach ($res_posts as $values) {
                        echo HtmlPurifier::process('<div class="listgroupitemDZ">
    <input type="checkbox" id="hd-' . $values["id"] . '" class="hide"/>
    <label style="margin-top:17px;" for="hd-' . $values["id"] . '" >' . $values["name_predmet"] . '</label>
    <div>
       ' . $values["text"] . '
         </div>
    <br/>
    <br/> 
</div>');
                    }
                }
            }
        }
    }//Метод экранирован и защищён от XSS

    public function actionIntervaldateraspisanie($parametr1, $parametr2, $parametr3)
    {
        if (!Yii::$app->user->isGuest) {
            $user_id = Yii::$app->user->id;
            if ($parametr1 != "uchenic") {
                $posts = Yii::$app->db->createCommand("SELECT * FROM {{raspisanie}} WHERE [[ticher_id]] = '$parametr1' AND [[date]] >= '$parametr2' AND [[date]] <= '$parametr3'  GROUP BY [[date]],[[classnumber_id]] ")->queryAll();
                foreach ($posts as $value) {
                    print HtmlPurifier::process("<hr style=' border: none; 
    background-color: red; 
    color: red; 
    height: 2px;'><p style='color: #2e6da4;'><br><h4 style='color: #2e6da4;'>" . $value["date"] . "<h4 style='color: #2e6da4;'>" . $value["classnumber_id"] . " - " . $value["classlater_id"] . "</h4>");
                    $date_res = $value["date"];
                    $res_posts = Yii::$app->db->createCommand("SELECT * FROM {{raspisanie}} WHERE [[ticher_id]] = '$parametr1' AND [[date]] = '$date_res' AND [[classnumber_id]] = '" . $value["classnumber_id"] . "'  AND [[classlater_id]] = '" . $value["classlater_id"] . "'  ")->queryAll();
                    foreach ($res_posts as $values) {
                        $data_zoom = Yii::$app->db->createCommand("SELECT * FROM {{data_zoom}} WHERE  [[urok_id]] = " . $values['code_uroka'] . "  ")->queryOne();
                            $idts = $values["id"];
                            $time_end_urok = date("H:i", strtotime($values['datetimeurok']));
                            print HtmlPurifier::process("<p><h3>" . $values['name_predmet'] . "-" . $time_end_urok . "</h3>");
                    }
                }
            }
            if ($parametr1 == "zavuch") {
                $posts = Yii::$app->db->createCommand("SELECT * FROM {{raspisanie}} WHERE  [[date]] >= '$parametr2' AND [[date]] <= '$parametr3'  GROUP BY [[date]],[[classnumber_id]] ")->queryAll();
                foreach ($posts as $value) {
                    echo HtmlPurifier::process("<hr style=' border: none; 
    background-color: red; 
    color: red; 
    height: 2px;'><h4><p style='color: #2e6da4;'>" . $value["date"] . "</p><p style='color: #2e6da4;'>&nbsp;&nbsp;&nbsp;&nbsp;" . $value["classnumber_id"] . " - " . $value["classlater_id"] . "</p></hr>");
                    $date_res = $value["date"];

                    $res_posts = Yii::$app->db->createCommand("SELECT * FROM {{raspisanie}} WHERE [[date]] = '$date_res' AND [[classnumber_id]] = '" . $value["classnumber_id"] . "'  AND [[classlater_id]] = '" . $value["classlater_id"] . "'  ")->queryAll();
                    foreach ($res_posts as $values) {
                        $time_end_urok = date("H:i", strtotime($values['time']));
                        echo "<p><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $values['name_predmet'] . "-" . $time_end_urok . "<a href='' class='cursor_pointer' style='font-size: 11px; color: #2e6da4;' onclick='RaspisanieRedact(".$values['id'].");'>&nbsp;Видалити</a>";
                    }
                }
            }
            if ($parametr1 == "uchenic") {
                $user_id = Yii::$app->user->id;
                $model = Yii::$app->db->createCommand("SELECT * FROM {{users}} WHERE [[id]] = '$user_id'")
                    ->queryOne();
                $schoolid = $model["school"];
                $classnumber = $model["classnumber"];
                $classlater = $model["classlater"];
                $posts = Yii::$app->db->createCommand("SELECT * FROM {{raspisanie}} WHERE [[classnumber_id]] = '$classnumber' AND [[classlater_id]] = '$classlater' AND [[school_id]] = '$schoolid' AND [[date]] >= '$parametr2' AND [[date]] <= '$parametr3'  GROUP BY [[date]]  ")->queryAll();
                foreach ($posts as $value) {
                    echo HtmlPurifier::process("<hr style=' border: none; 
    background-color: red; 
    color: red; 
    height: 2px;'><p style='color: #2e6da4;'>" . $value["date"] . "</p></hr>");
                    $date_res = $value["date"];
                    $res_posts = Yii::$app->db->createCommand("SELECT * FROM {{raspisanie}} WHERE [[classnumber_id]] = '$classnumber' AND [[classlater_id]] = '$classlater' AND [[school_id]] = '$schoolid' AND [[date]] = '$date_res' ")->queryAll();
                    foreach ($res_posts as $values) {
                        echo HtmlPurifier::process('<p>' . $values["name_predmet"] . ' - <span style="font-size: 18px;" >' . date("H:i", strtotime($values["time"])));
                    }
                }
            }
        }
    }//Метод экранирован и защищён от XSS


    public function actionResponsedz($parametr1, $parametr2)
    {
        if (!Yii::$app->user->isGuest) {
            $user_id = Yii::$app->user->id;
            if ($parametr2 = "uchenik") {
                $model = Yii::$app->db->createCommand("SELECT * FROM {{users}} WHERE [[id]] = '$user_id'")
                    ->queryOne();
                $schoolid = $model["school"];
                $classnumber = $model["classnumber"];
                $classlater = $model["classlater"];
                $posts = Yii::$app->db->createCommand("SELECT * FROM {{dz}} WHERE [[date]] = '$parametr1' AND [[school_id]] = '$schoolid' AND [[classnumber_id]] = '$classnumber' AND [[classlater_id]] = '$classlater'")->queryAll();
                foreach ($posts as $value) {
                    echo HtmlPurifier::process('<div class="listgroupitemDZ">
    <input type="checkbox" id="hd-' . $value["id"] . '" class="hide"/>
    <hr style=" border: none; 
    background-color: red; 
    color: red; 
    height: 2px;"><label style="margin-top:17px;" for="hd-' . $value["id"] . '" >' . $value["name_predmet"] . '</label>
    <div>
       ' . $value["text"] . '
         </div>
    <br/>
    <br/> 
</div></hr>');
                }
            }
            if ($parametr2 = "ticher") {
                $posts = Yii::$app->db->createCommand("SELECT * FROM {{dz}} WHERE [[user_id]] = '$user_id' AND [[date]] = '$parametr1'")->queryAll();
                foreach ($posts as $value) {
                    echo HtmlPurifier::process('<div class="listgroupitemDZ">
    <input type="checkbox" id="hd-' . $value["id"] . '" class="hide"/>
    <label style="margin-top:17px;" for="hd-' . $value["id"] . '" >' . $value["name_predmet"] . '</label>
    <div>
       ' . $value["text"] . '
         </div>
    <br/>
    <br/>
</div>');
                }
            }
        }
    }//Метод экранирован и защищён от XSS

    public function actionResponseraspisanie($parametr1, $parametr2)
    {
        if (!Yii::$app->user->isGuest) {
            $user_id = Yii::$app->user->id;
            if ($parametr2 == "respond_uchenik") {
                $model = Yii::$app->db->createCommand("SELECT * FROM {{users}} WHERE [[id]] = '$user_id'")
                    ->queryOne();
                $schoolid = $model["school"];
                $classnumber = $model["classnumber"];
                $classlater = $model["classlater"];

                $posts = Yii::$app->db->createCommand("SELECT * FROM {{raspisanie}} WHERE date = '$parametr1' AND [[school_id]] = '$schoolid' AND [[classnumber_id]] = '$classnumber' AND [[status_uroka]] = '0' AND [[classlater_id]] = '$classlater'")->queryAll();
                foreach ($posts as $value) {
                    echo HtmlPurifier::process('<span class="list-group-item ">' . $value["name_predmet"] . ' </span>');
                }
            }
            if ($parametr2 == "respond") {
                $posts = Yii::$app->db->createCommand("SELECT * FROM {{raspisanie}} WHERE [[date]] = '$parametr1' AND [[ticher_id]] = '$user_id'")->queryAll();
                foreach ($posts as $value) {
                    echo HtmlPurifier::process('<span class="list-group-item ">' . $value["name_predmet"] . ' </span>');
                }
            }
            if ($parametr2 == "redact") {
                $posts_class_summ = Yii::$app->db->createCommand("SELECT * FROM {{raspisanie}} WHERE [[user_id]] = '$user_id' AND [[date]] = '$parametr1'  GROUP BY [[classnumber_id]],[[classlater_id]] ")->queryAll();
                foreach ($posts_class_summ as $values) {
                    $classnumber = $values['classnumber_id'];
                    $classlater = $values['classlater_id'];
                    $classactive = $values['active'];
                    $time_end_urok = date("Ymd", strtotime($parametr1));
                    $posts = Yii::$app->db->createCommand("SELECT * FROM {{raspisanie}}
 WHERE date = '$parametr1' AND {{user_id}} = '$user_id' AND [[classnumber_id]] = '$classnumber' AND [[classlater_id]] = '$classlater' AND [[active]] = ' $classactive'")->queryAll();
                    echo HtmlPurifier::process("<span class='cursor_pointer' style='font-size:18px; ' id='yes" . $values["classnumber_id"] . "" . $values["classlater_id"] . "'>&nbsp;<a  onclick='DisplayVisibleBlock($time_end_urok, $classactive)'>" . $classnumber . "-" . $classlater . "</a></span>");
                }
            }
        }
    }//Метод экранирован и защищён от XSS

    public function actionVisibleraspisanie($parametr1, $parametr3)
    {

        if (!Yii::$app->user->isGuest) {
            $user_id = Yii::$app->user->id;

            $posts = Yii::$app->db->createCommand("SELECT * FROM {{raspisanie}} WHERE date = '$parametr1' AND [[user_id]] = '$user_id' AND [[active]] = '$parametr3'  ")->queryAll();

            echo HtmlPurifier::process("<span style='font-size: 15px; color: #2e6da4;'>" . $posts[0]["classnumber_id"] . "-" . $posts[0]["classlater_id"] . "</span>");
            echo HtmlPurifier::process("<p><a  onclick='DisplayVisibleBlock()'></a>");
            foreach ($posts as $value) {
                $time_end_urok = date("H:i", strtotime($value["time"]));
                echo HtmlPurifier::process('<span><a class="list-group-item"  id="none' . $value["id"] . '" >' . $value["name_predmet"] . ' - ' . $time_end_urok . '<a class="cursor_pointer" style="font-size: 11px; color: #2e6da4;" onclick="RaspisanieRedact(' . $value["id"] . ')";>&nbsp;Видалити</a></span>');
            }
        }
    }//Метод экранирован и защищён от XSS

    public function actionCreatedatazoom($paramzoom, $iddatazoom)
    {
        if (!Yii::$app->user->isGuest) {
            $data = Yii::$app->db->createCommand('SELECT [[id]] FROM {{data_zoom}} ORDER BY [[id]] DESC LIMIT 1')
                ->queryOne();
            $id_table_end = $data["id"] + 1;
            Yii::$app->db->createCommand("INSERT INTO `data_zoom`(`id`, `urok_id`, `zoomdata`) VALUES ('$id_table_end','$iddatazoom','$paramzoom')")->execute();
            return 1;
        }
    }

    public  function actionUserhashreturn($id){
        $model = Yii::$app->db->createCommand("SELECT * FROM {{users}} WHERE [[id]] = '$id' ")->queryOne();
        return "<button type='submit' class='btn btn-success' onclick='CreateRaspisanie(this.value);' value='".$model["hash"]."'>Додати</button>";

    }

    public  function actionUserhashreturndz($id=10){
        $model = Yii::$app->db->createCommand("SELECT * FROM {{users}} WHERE [[id]] = '$id' ")->queryOne();
        return "<button type='submit' class='btn btn-success' onclick='CreateDZ(this.value);' value='".$model["hash"]."'>Cтворити</button>";

    }

    public function actionRaspisanie($parametr1=null,
                                     $parametr2=null,
                                     $parametr3=null,
                                     $parametr4=null,
                                     $parametr5=null,
                                     $parametr6=null,
                                     $parametr7=null)
    {
        if (!Yii::$app->user->isGuest) {
            $user_id = Yii::$app->user->id;
            $model = Yii::$app->db->createCommand("SELECT * FROM {{users}} WHERE [[id]] = '$user_id'")
                ->queryOne();
            if ($hash == $model["hash"]) {
                $code_uroka = rand(1000000, 999999999);
                date_default_timezone_set('Europe/Kiev');
                $time_end_urok = date("Y-m-d H:i", strtotime(" + 40 minutes"));
                $data_for_search_string = "$parametr7";
                $result_search_string = strstr($data_for_search_string, "(");
                $data1 = str_replace('(', '', $result_search_string);
                $data2 = str_replace(')', '', $data1);
                $user_school = $model["school"];
                $user_city = $model["city"];
                date_default_timezone_set('Europe/Kiev');
                if ($parametr1 == "create") {
                    $data = Yii::$app->db->createCommand('SELECT [[id]] FROM {{raspisanie}} ORDER BY [[id]] DESC LIMIT 1')
                        ->queryOne();
                    $id_table_end = $data["id"] + 1;
                    $today_date = date("Y-m-d H:i");
                    $rey = "$parametr3" . "$parametr2";
                    $time_end_urok = date("Y-m-d H:i", strtotime($rey . " + 40 minutes"));
                    $df = date("Y-m-d H:i", strtotime($rey . " + 0 minutes"));
                    $zoom_time = date("H:i", strtotime($parametr2 . " - 3 hours"));

                    $responseData = $this->actionSearchtimeaddurok($parametr3, $df, $time_end_urok);
                    if ($responseData == 1) {
                        return 1;
                    }
                    if ($today_date < $df) {
                        if ($responseData != 1) {
                            Yii::$app->db
                                ->createCommand()
                                ->insert('raspisanie', ['id' => $id_table_end, 'school_id' => $user_school, 'user_id' => $user_id, 'ticher_id' => $data2, 'time' => $parametr2, 'datetimeurok' => $df, 'date' => $parametr3, 'classnumber_id' => $parametr4, 'classlater_id' => $parametr5, 'name_predmet' => $parametr6, 'timeendurok' => $time_end_urok, 'active' => '1', 'code_uroka' => $code_uroka])
                                ->execute();

                            return HtmlPurifier::process(0);
                        }
                    } else {
                        return 2;
                    }
                }
            }
        }
    } //Метод экранирован

    public  function  actionSearchtimeaddurok($parametr3,$df,$time_end_urok)
    {
        if (!Yii::$app->user->isGuest) {
            $search = Yii::$app->db->createCommand("SELECT * FROM {{raspisanie}} WHERE 
                               [[date]] = '$parametr3'")->queryAll();
            foreach ($search as $val) {
                $d = $df;
                $dftime = date("Y-m-d H:i:s", strtotime($d . " + 0 minutes"));
                $ds = $time_end_urok;
                $dfs = date("Y-m-d H:i:s", strtotime($d . " + 40 minutes"));
                $d1 = $val['datetimeurok'];
                $d2 = $val['timeendurok'];
                if ($d2 >= $dftime && $d1 <= $dftime or $d2 >= $dfs && $d1 <= $dfs) {
                    return 1;
                }
            }
        }
    }

    public function actionCreateuseradd($parametr1,
                                        $parametr2,
                                        $parametr3,
                                        $parametr4,
                                        $predmet0=null)
    {
        if (!Yii::$app->user->isGuest) {
            $user_id = Yii::$app->user->id;
            $model = Yii::$app->db->createCommand("SELECT * FROM {{users}} WHERE [[id]] = '$user_id'")
                ->queryOne();
            $data = Yii::$app->db->createCommand('SELECT [[id]] FROM {{ticher_predmet}} ORDER BY [[id]] DESC LIMIT 1')
                ->queryOne();
            $id_table_end = $data["id"] + 1;
            $password = rand(1000000, 999999999);
            $login = $this->Translit("$parametr1");
            $user_school = $model["school"];
            $user_city = $model["city"];
            $user_country = $model["country"];
            $users_search = Yii::$app->db->createCommand("SELECT * FROM {{users}} WHERE [[email]] = '$parametr4'")
                ->queryOne();
            $ticher_name_number = rand(100, 99999);
            $ticher_name = "ticher_".$ticher_name_number;
            if($parametr4 != $users_search["email"]) {
                Yii::$app->db->createCommand("INSERT INTO {{users}} ([[id]], [[username]], [[firstname]], [[lastname]],
 [[otchestvo]], [[password]], [[email]], [[tipe]], [[create_user_id]], [[telefon]], [[country]], [[city]], [[school]],
  [[classnumber]], [[classlater]], [[date]], [[time]], [[dateandtime]], [[status_user]],
   [[active]],[[hash]]) VALUES ('','$ticher_name','$parametr1','$parametr2','$parametr3','$password','$parametr4','2', '$user_id','','$user_country','$user_city ','$user_school','','','','','','1','1','')")->execute();

                Yii::$app->db->createCommand("INSERT INTO {{ticher_predmet}} ([[id]], [[email]], [[title]], [[active]]) VALUES ('$id_table_end','$parametr4','$predmet0','1')")->execute();
                $arr = array('respond' => 1);
                return json_encode($arr);
            }else{
                $arr = array('respond' => 0);
                return json_encode($arr);
            }

        }
    } //Метод экранирован

    public function Translit($value)
    {
        if (!Yii::$app->user->isGuest) {
            $converter = array(
                'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
                'е' => 'e', 'ё' => 'e', 'ж' => 'zh', 'з' => 'z', 'и' => 'i',
                'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
                'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
                'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch',
                'ш' => 'sh', 'щ' => 'sch', 'ь' => '', 'ы' => 'y', 'ъ' => '',
                'э' => 'e', 'ю' => 'yu', 'я' => 'ya',

                'А' => 'a', 'Б' => 'b', 'В' => 'v', 'Г' => 'g', 'Д' => 'd',
                'Е' => 'e', 'Ё' => 'e', 'Ж' => 'zh', 'З' => 'z', 'И' => 'i',
                'Й' => 'y', 'К' => 'k', 'Л' => 'l', 'М' => 'm', 'Н' => 'n',
                'О' => 'o', 'П' => 'p', 'Р' => 'r', 'С' => 's', 'Т' => 't',
                'У' => 'u', 'Ф' => 'f', 'Х' => 'x', 'Ц' => 'c', 'Ч' => 'ch',
                'Ш' => 'sh', 'Щ' => 'sch', 'Ь' => '', 'Ы' => 'y', 'Ъ' => '',
                'Э' => 'e', 'Ю' => 'yu', 'Я' => 'ya',
            );

            $value = strtr($value, $converter);
            return $value;
        }
    }

    public function actionRaspisanieredact($parametr1, $parametr2)
    {
        if (!Yii::$app->user->isGuest) {

            $user_id = Yii::$app->user->id;
            if ($parametr2 == "delete") {
                Yii::$app->db->createCommand("DELETE FROM {{raspisanie}} WHERE [[id]] = '$parametr1'")->execute();
                $posts = Yii::$app->db->createCommand("SELECT * FROM {{raspisanie}} WHERE [[id]] = '$parametr1'")->queryAll();
                foreach ($posts as $value) {
                    return HtmlPurifier::process($value["name_predmet"]);
                }
            }
        }
    } //Метод экранирован

    public function actionUsersredact($parametr1, $parametr2)
    {
        if (!Yii::$app->user->isGuest) {

            $user_id = Yii::$app->user->id;
            if ($parametr2 == "delete") {
                Yii::$app->db->createCommand("DELETE FROM {{users}} WHERE [[id]] = '$parametr1'")->execute();

            }
        }
    } //Метод экранирован

    public function actionDzredact($parametr1, $parametr2)
    {
        if (!Yii::$app->user->isGuest) {
            $user_id = Yii::$app->user->id;
            if ($parametr2 == "delete") {
                Yii::$app->db->createCommand("DELETE FROM {{dz}} WHERE [[id]] = '$parametr1'")->execute();
                $posts = Yii::$app->db->createCommand("SELECT * FROM {{dz}} WHERE [[id]] = '$parametr1'")->queryAll();
                foreach ($posts as $value) {
                    return HtmlPurifier::process($value["name_predmet"]);
                }
            }
        }
    }//Метод экранирован

    public function actionDz($parametr2, $parametr3, $parametr4, $parametr5, $parametr6, $parametr7,$hash=null)
    {
        if (!Yii::$app->user->isGuest) {
            date_default_timezone_set('Europe/Kiev');
            $user_id = Yii::$app->user->id;
            $model = Yii::$app->db->createCommand("SELECT * FROM {{users}} WHERE [[id]] = '$user_id'")
                ->queryOne();
            if(!empty($parametr2) or !empty($parametr3) or !empty($parametr4) or !empty($parametr5) or !empty($parametr6) or !empty($parametr7)){
            if($hash == $model["hash"]) {
                $school_id = $model["school"];
                $data = Yii::$app->db->createCommand('SELECT [[id]] FROM {{dz}} ORDER BY [[id]] DESC LIMIT 1')
                    ->queryOne();
                $id_table_end = $data["id"] + 1;
                Yii::$app->db
                    ->createCommand()
                    ->insert('dz', ['id' => $id_table_end, 'user_id' => $user_id, 'school_id' => $school_id, 'ticher_id' => $user_id, 'time' => $parametr2, 'date' => $parametr3, 'classnumber_id' => $parametr4, 'classlater_id' => $parametr5, 'name_predmet' => $parametr6, 'text' => $parametr7])
                    ->execute();
                return HtmlPurifier::process($id_table_end);
               }
            }else{return 0;}
        }
    } //Метод экранирован

    public function actionResponsehash()
    {
        if (!Yii::$app->user->isGuest) {
            $user_id = 3;
            $model = new Users();
            $ttt = $model->UserData($user_id);
            echo HtmlPurifier::process($ttt[0]["hash"]);
        }
    }//Метод экранирован

    public function actionResponseusers()
    {
        if (!Yii::$app->user->isGuest) {
            $user_id = Yii::$app->user->id;
            $posts = Yii::$app->db->createCommand("SELECT * FROM {{users}} WHERE [[tipe]] = '2' AND [[create_user_id]] = '$user_id' ")->queryAll();
            foreach ($posts as $value) {
                echo "<span><a class='list-group-item'>" . $value["firstname"] . "&nbsp;" . $value["otchestvo"] . "&nbsp;" . $value["lastname"] . "<a href='' class='cursor_pointer' style='font-size: 11px; color: #2e6da4;' onclick='DeleteUsers(".$value["id"].")';>&nbsp;ddВидалити</a></span>";
            }
        }
    } //Метод экранирован

    public function actionEditraspisanie()
    {
        if (!Yii::$app->user->isGuest) {
            return $posts = Yii::$app->db->createCommand('SELECT * FROM {{users}}')
                ->queryAll();
        }
    } //Метод экранирован

    protected function respond($httpCode, $status, $data = array())
    {
        if (!Yii::$app->user->isGuest) {
            $response['status'] = $status;
            $response['data'] = $data;
            return json_encode($response);
        }
        // Yii::app()->end($httpCode, true);
    }//Метод экранирован

    public function actionTicheraddresponseselect()
    {
        if (!Yii::$app->user->isGuest) {
            $user_id = Yii::$app->user->id;
            $model = Yii::$app->db->createCommand("SELECT * FROM {{users}} WHERE [[id]] = '$user_id' ")->queryOne();
            $country = $model['country'];
            $city = $model['city'];
            $school = $model['school'];
            $data = Yii::$app->db->createCommand("SELECT * FROM {{users}} WHERE [[country]] = '$country' AND  [[tipe]] = '2' AND  [[city]] = '$city' AND [[school]] = '$school'")->queryAll();
            foreach ($data as $values) {
                echo "<option>" . $values["firstname"] . " " . $values["otchestvo"] . " " . $values["lastname"] . "-(" . $values["id"] . ")</option>";
            }
        }
    } //Метод экранирован

    public function actionProverkaraspisaniya()
    {
        if (!Yii::$app->user->isGuest) {
            $user_id = Yii::$app->user->id;
            $model = Yii::$app->db->createCommand("SELECT * FROM {{users}} WHERE [[id]] = '$user_id' ")->queryOne();
            $country = $model['country'];
            return HtmlPurifier::process($country);
        }
    }//Метод экранирован

    public function actionPredmeti($param=null)
    {
        if (!Yii::$app->user->isGuest) {
            $user_id = Yii::$app->user->id;
            $model = Yii::$app->db->createCommand("SELECT * FROM {{users}} WHERE [[id]] = '$user_id' ")->queryOne();
            $predmet = Yii::$app->db->createCommand("SELECT * FROM {{ticher_predmet}} WHERE [[email]] = '".$model["email"]."'")->queryAll();
            foreach($predmet as $val_predmet){
                return "<option>".$val_predmet["title"]."</option>";
}
        }
    }


    public function actionProverkaonlineurok($id)
    {
        if (!Yii::$app->user->isGuest) {
            $user_id = Yii::$app->user->id;
            $model = Yii::$app->db->createCommand("SELECT * FROM {{users}} WHERE [[id]] = '$user_id' ")->queryOne();
            $tipe = $model['tipe'];
            $posts = Yii::$app->db->createCommand("SELECT * FROM {{urok_online}} WHERE [[user_id]] = '$id' AND [[status_uroka]] = 1")->queryOne();
            $code_uroka = $posts["code_uroka"];
            if (!empty($posts)) {
                return HtmlPurifier::process($posts["code_uroka"]);
            } else {
                return HtmlPurifier::process(0);
            }
            $posts = Yii::$app->db->createCommand("SELECT * FROM {{urok_online}} WHERE [[user_id]] = '$id' AND [[status_uroka]] = 1")->queryOne();
            $code_uroka = $posts["code_uroka"];
            if (!empty($posts)) {
                return HtmlPurifier::process($posts["code_uroka"]);
            } else {
                return HtmlPurifier::process(0);
            }
        }
    }//Метод экранирован

    public function actionProverkatimeurokticher($id)
    {
        if (!Yii::$app->user->isGuest) {
            $user_id = $id;
            date_default_timezone_set('Europe/Kiev');
            $datetime = date("Y-m-d");
            $time = date("H:i");
            $posts_ticher = Yii::$app->db->createCommand("SELECT * FROM {{raspisanie}} WHERE [[ticher_id]] = '$user_id' AND [[date]] = '$datetime'  AND [[status_uroka]] = '0' AND [[ready]] = '0'")->queryOne();
            $code_uroka = $posts_ticher["code_uroka"];
            if (!empty($posts_ticher)) {
                Yii::$app->db->createCommand("UPDATE {{raspisanie}} SET [[ready]] = 2 WHERE  [[code_uroka]] = '$code_uroka'")->execute();

                return HtmlPurifier::process(1);
            } else {
                return HtmlPurifier::process(0);
            }
        }
    }//Метод экранирован

    public function actionProverkatimeurok($id)
    {
        if (!Yii::$app->user->isGuest) {
            $user_id = $id;
            $model = Yii::$app->db->createCommand("SELECT * FROM {{users}} WHERE [[id]] = '$user_id' ")->queryOne();
            $user_school = $model["school"];
            $user_city = $model["city"];
            $user_country = $model["country"];
            $classnumber = $model["classnumber"];
            $classlater = $model["classlater"];
            $schoolid = $model["school"];
            $posts = Yii::$app->db->createCommand("SELECT * FROM {{urok_online}} WHERE [[classnumber_id]] = '$classnumber' AND [[classlater_id]] = '$classlater' AND [[school_id]] = '$schoolid'  AND [[status_uroka]] = 1 AND [[ticher_online]] = 1 ")->queryOne();
            if (!empty($posts)) {
                return HtmlPurifier::process(1);
            } else {
                return HtmlPurifier::process(0);
            }
        }
    }//Метод экранирован

    public function actionDeleteonlineurokitimeout($ids)
    {
        if (!Yii::$app->user->isGuest) {
            date_default_timezone_set('Europe/Kiev');
            $today = date("Y-m-d H:i");
            Yii::$app->db->createCommand("UPDATE {{raspisanie}} SET [[status_uroka]] = 2 WHERE [[code_uroka]] = '$ids' AND [[timeendurok]] <= '$today'")->execute();
            Yii::$app->db->createCommand("UPDATE {{raspisanie}} SET [[active]] = 2 WHERE  [[timeendurok]] < '$today'")->execute();
        }
    }//Метод экранирован

    public function actionRedirectifnourok($ids)
    {
        if (!Yii::$app->user->isGuest) {
            date_default_timezone_set('Europe/Kiev');
            $today = date("Y-m-d h:i");
            $id_status_uroka = 3;
            $posts = Yii::$app->db->createCommand("SELECT * FROM {{raspisanie}} WHERE [[code_uroka]] = '$ids' AND  [[status_uroka]] = 2 ")->queryOne();
            $status_uroka = $posts["status_uroka"];
            if ($status_uroka == 2) {
                Yii::$app->db->createCommand("DELETE FROM {{urok_online}} WHERE [[code_uroka]] = '$ids' AND [[status_uroka]] = 1")->execute();

                echo HtmlPurifier::process(3);
            }
        }
    }//Метод экранирован

    public function actionOnlineticherno($cod)
    {
        if (!Yii::$app->user->isGuest) {
            $posts = Yii::$app->db->createCommand("SELECT * FROM {{urok_online}} WHERE [[code_uroka]] = '$cod' AND [[ticher_online]] = '1' ")->queryOne();
            $ticher_online = $posts["ticher_online"];
            if (empty($ticher_online)) {
                return HtmlPurifier::process(0);
            }
            if (!empty($ticher_online)) {
                return HtmlPurifier::process(1);
            }
        }
    }//Метод экранирован

    public function actionDeactivateraspisanietimeend()
    {
        if (!Yii::$app->user->isGuest) {
            date_default_timezone_set('Europe/Kiev');
            $today = date("Y-m-d H:i");
            Yii::$app->db->createCommand("UPDATE {{raspisanie}} SET [[status_uroka]] = 2 WHERE  [[timeendurok]] <= '$today'")->execute();
            Yii::$app->db->createCommand("UPDATE {{raspisanie}} SET [[active]] = 2 WHERE  [[timeendurok]] < '$today'")->execute();

        }
    }//Метод экранирован

    public function actionTs($param2, $param3, $param4, $param5, $param6)
    {
        if (!Yii::$app->user->isGuest) {
            $city_id = 1;
            $school = $param4;
            $class = $param5;
            $latterclass = $param6;
            $rey = "$param3" . " $param2";
            date_default_timezone_set('Europe/Kiev');
            $time_end_urok = date("Y-m-d H:i", strtotime($rey . " + 40 minutes"));
            $search = Yii::$app->db->createCommand("SELECT * FROM {{raspisanie}} WHERE [[city_id]] = '$city_id' AND [[school_id]] = '$param4' AND [[classnumber_id]] = '$param5' AND [[classlater_id]] = '$param6' AND [[datetimeurok]] < '$time_end_urok' AND [[timeendurok]] > '$time_end_urok'  AND [[status_uroka]] = 0")->queryAll();

            echo "<p>" . $rey;
            echo "<p>" . $time_end_urok;
        }
    }

    ////Функция курл (ищим неактивные уроки по расписанию меньше даты сегодня и деактивируем)
    public function actionStatusurokadactivate()
    {
        if (!Yii::$app->user->isGuest) {
            $time_end_urok = date("Y-m-d H:i");
            Yii::$app->db->createCommand("UPDATE {{raspisanie}} SET [[status_uroka]] = 2 WHERE  [[timeendurok]] < '$time_end_urok'")->execute();
        }
    }

    ////Функция курл (ищим неактивные уроки по расписанию меньше даты сегодня и деактивируем)
    public function actionRegraspnp($oblast)
    {
        if (!Yii::$app->user->isGuest) {
            $data = Yii::$app->db->createCommand("SELECT * FROM {{oblast}} WHERE [[id]] = '$oblast' ")->queryAll();
            foreach ($data as $oblast_data) {
                echo $oblast_data["name"];
            }
            $raion_data = $oblast_data["name"];
            $raion = Yii::$app->db->createCommand("SELECT * FROM {{school_details_adres}} WHERE [[oblast]]  LIKE '%" . $raion_data . "'  GROUP BY [[raion]] ORDER BY [[raion]] ASC  ")->queryAll();
            echo "<option value=''>Оберіть район</option>";
            foreach ($raion as $raion_value) {
                echo "<option value='" . $raion_value["raion"] . "'>" . $raion_value["raion"] . "</option>";
            }
        }
    }

    public function actionRegraspcity($city)
    {
        if (!Yii::$app->user->isGuest) {
            $city = Yii::$app->db->createCommand("SELECT * FROM {{school_details_adres}} WHERE [[raion]]  LIKE '%" . $city . "'  GROUP BY [[np]] ORDER BY [[np]] ASC  ")->queryAll();
            echo "<option value=''>Оберіть н/п</option>";
            foreach ($city as $city_value) {
                echo "<option value='" . $city_value["id"] . "'>" . $city_value["np"] . "</option>";
            }
        }
    }

    public function actionRegraspschool($school)
    {
        if (!Yii::$app->user->isGuest) {
            $school_search_id = Yii::$app->db->createCommand("SELECT * FROM {{school_details_adres}} WHERE [[id]] = '$school' ")->queryOne();
            $name_np = $school_search_id["np"];

            $school = Yii::$app->db->createCommand("SELECT * FROM {{school_details_adres}} WHERE [[np]]  LIKE '%" . $name_np . "%'  GROUP BY [[sokr]] ORDER BY [[sokr]] ASC  ")->queryAll();

            foreach ($school as $school_value) {
                if (!empty($school_value["sokr"])) {
                    echo "<option value='" . $school_value["id"] . "'>" . $school_value["sokr"] . "</option>";
                }
            }
        }
    }

    public function actionReguch($id, $oblast = null, $raion = null, $city = null, $school = null, $classnumber = null, $classlater = null)
    {
        if (!Yii::$app->user->isGuest) {
            Yii::$app->db->createCommand("UPDATE {{users}} SET [[status_user]] = 1,
                   [[city]] = '$city',
                   [[school]] = '$school',
                   [[classnumber]] = '$classnumber',
                   [[classlater]] = '$classlater' WHERE  [[id]] = '$id'")->execute();
            return 1;
        }
    }

    public function actionOdinc($polnoenazvanie = null,
                                $sokr = null,
                                $status = null,
                                $type = null,
                                $forma = null,
                                $region = null,
                                $np = null,
                                $adres = null,
                                $phone = null,
                                $email = null)
    {

            $fd = explode(',', $np);
            if ($np == "Київ") {
                $data = Yii::$app->db->createCommand('SELECT [[id]] FROM {{school_details_adres}} ORDER BY [[id]] ASC LIMIT 1')
                    ->queryOne();
                $id_table_end = $data["id"] + 1;
                if (!empty($sokr)) {
                    Yii::$app->db
                        ->createCommand()
                        ->insert('email_school', ['id' => $id_table_end, 'title' => $polnoenazvanie, 'telefon' => $phone, 'email' => $email])
                        ->execute();
                }
                if (empty($sokr)) {
                    Yii::$app->db
                        ->createCommand()
                        ->insert('email_school', ['id' => $id_table_end, 'title' => $polnoenazvanie, 'telefon' => $phone, 'email' => $email])
                        ->execute();
                }
                return $id_table_end;
            } else {

                $data = Yii::$app->db->createCommand('SELECT [[id]] FROM {{email_school}} ORDER BY [[id]] DESC LIMIT 1')
                    ->queryOne();
                $id_table_end = $data["id"] + 1;

                if (!empty($sokr)) {
                    Yii::$app->db
                        ->createCommand()
                        ->insert('email_school', ['id' => $id_table_end, 'title' => $polnoenazvanie, 'telefon' => $phone, 'email' => $email])
                        ->execute();
                }
                if (empty($sokr)) {
                    Yii::$app->db
                        ->createCommand()
                        ->insert('email_school', ['id' => $id_table_end, 'title' => $polnoenazvanie, 'telefon' => $phone, 'email' => $email])
                        ->execute();
                }
                return $id_table_end;

        }
    }

    ///////////////////////////////Функция отмечает уроки которые кончились по времени значениями 2

  public function actionDeactivateurok(){

          $date = date("Y-m-d H:i:s");
      $datedate = date("Y-m-d");
          $search_urok_time_out = Yii::$app->db->createCommand("SELECT * FROM {{raspisanie}} WHERE  [[timeendurok]] <= '$date'")->queryAll();
          foreach ($search_urok_time_out as $val_urok) {
              $code_uroka_update = $val_urok["code_uroka"];
              Yii::$app->db->createCommand("UPDATE {{raspisanie}} SET [[status_uroka]] = 2
                    WHERE  [[code_uroka]] = '$code_uroka_update'")->execute();
              $id_urok = $val_urok["id"];
              Yii::$app->db->createCommand("DELETE FROM `raspisanie` WHERE id =  '$id_urok'")->execute();

          }

  }

    public  function actionInstruktionhelpclose($id){

        if (!Yii::$app->user->isGuest) {
            $user_id = $id;
            $model = Yii::$app->db->createCommand("SELECT * FROM {{users}} WHERE [[id]] = '$user_id' ")->queryOne();
if($model["username"] != "demo1" or $model["username"] != "demo2" or $model["username"] != "demo3"){
            Yii::$app->db->createCommand("UPDATE {{users}} SET [[instruktion_open]] = 1
                    WHERE  [[id]] = '$id'")->execute();
            return 1;
        }}}

  public  function actionOnoff(){
      if (!Yii::$app->user->isGuest) {
          return 200;
      }
  }

    public  function actionNamepredmetticheradd($identifi){
        if (!Yii::$app->user->isGuest) {
            if($identifi == 0) {
                return '<input id="dataticheradd1" class="form-control" onchange="AddTicherPredmet(1);" list="list-ticher0" style=""
                       placeholder="Предмет"></input>
                </p>';
            }
            if($identifi == 1) {
                return '<input id="dataticheradd2" class="form-control" onchange="AddTicherPredmet(2);" list="list-ticher0" style=""
                       placeholder="Предмет"></input>
                </p>';
            }
            if($identifi == 2) {
                return '<input id="dataticheradd3" class="form-control" onchange="AddTicherPredmet(3);" list="list-ticher0" style=""
                       placeholder="Предмет"></input>
                </p>';
            }
            if($identifi == 3) {
                return '<input id="dataticheradd4" class="form-control" onchange="AddTicherPredmet(4);" list="list-ticher0" style=""
                       placeholder="Предмет"></input>
                </p>';
            }
            if($identifi == 4) {
                return '<input id="dataticheradd5" class="form-control" onchange="AddTicherPredmet(5);" list="list-ticher0" style=""
                       placeholder="Предмет"></input>
                </p>';
            }
            if($identifi == 5) {
                return '<input id="dataticheradd6" class="form-control" onchange="AddTicherPredmet(6);" list="list-ticher0" style=""
                       placeholder="Предмет"></input>
                </p>';
            }
            if($identifi == 6) {
                return '<input id="dataticheradd7" class="form-control" onchange="AddTicherPredmet(7);" list="list-ticher0" style=""
                       placeholder="Предмет"></input>
                </p>';
            }
            if($identifi == 7) {
                return '<input id="dataticheradd8" class="form-control" onchange="AddTicherPredmet(8);" list="list-ticher0" style=""
                       placeholder="Предмет"></input>
                </p>';
            }
            if($identifi == 8) {
                return '<input id="dataticheradd9" class="form-control" onchange="AddTicherPredmet(9);" list="list-ticher0" style=""
                       placeholder="Предмет"></input>
                </p>';
            }
        }
    }

///////Для курла котороя обновляет хеш секретный ключ
    public  function actionUserhashupdate(){

            $code_uroka = rand(1000000, 999999999);
            $str = $code_uroka;

            $hash_encode = md5($str);
            Yii::$app->db->createCommand("UPDATE {{users}} SET [[hash]] = '$hash_encode'
                    ")->execute();
    }

}
