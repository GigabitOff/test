<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<style>
    /*_Calendar*/
    #Calendar {
        position: absolute;
        border-collapse: collapse;
        background: #FFFFFF;
        border: 1px solid #303030;
        display: none;
        -moz-user-select: none;
        -khtml-user-select: none;
        user-select: none;
        z-index: 9999999;
        box-shadow: 0 0 15px rgba(98, 98, 206, 1);
    }

    #Calendar_mns {
        text-align: center;
        margin: 0;
        padding: 0;
    }

    #Calendar select, #Calendar option {
        font-size: 11px;
        padding: 0 2px
    }
</style>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="./online.js"></script>

    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php if (Yii::$app->user->isGuest) { ?>
        <style>body {
                background-image: url(../../images/fon.jpg);
                background-position: center center;
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: cover;
                background-color: #464646;
            }</style>
    <?php } ?>
    <style>
        @-webkit-keyframes blinker {
            from {
                opacity: 1.0;
            }
            to {
                opacity: 0.0;
            }
        }

        .blink {
            text-decoration: blink;
            -webkit-animation-name: blinker;
            -webkit-animation-duration: 0.6s;
            -webkit-animation-iteration-count: infinite;
            -webkit-animation-timing-function: ease-in-out;
            -webkit-animation-direction: alternate;
        }

        body {
            margin: 0;
        }

        <?php   if (Yii::$app->user->isGuest) {  ?>
        .active {
            background-color: #;
            border-color: #;
        }

        .navbar-inverse {

            background-color: #;
            border-color: #;
            opacity: 50.5%;
        }

        <?php } ?>
        .navbar-inverse {

            height: 10px;
        }

        .preloader {
            position: fixed;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            background: #e0e0e0;
            z-index: 1001;
        }

        .preloader__row {
            position: relative;
            top: 50%;
            left: 50%;
            width: 70px;
            height: 70px;
            margin-top: -35px;
            margin-left: -35px;
            text-align: center;
            animation: preloader-rotate 2s infinite linear;
        }

        .preloader__item {
            position: absolute;
            display: inline-block;
            top: 0;
            background-color: #337ab7;
            border-radius: 100%;
            width: 35px;
            height: 35px;
            animation: preloader-bounce 2s infinite ease-in-out;
        }

        .preloader__item:last-child {
            top: auto;
            bottom: 0;
            animation-delay: -1s;
        }

        @keyframes preloader-rotate {
            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes preloader-bounce {

            0%,
            100% {
                transform: scale(0);
            }
            50% {
                transform: scale(1);
            }
        }

        .loaded_hiding .preloader {
            transition: 0.3s opacity;
            opacity: 0;
        }

        .loaded .preloader {
            display: none;
        }

        .hide {
            display: none;
        }

        .hide + label ~ div {
            display: none;
        }

        .hide + label {
            border-bottom: 1px dotted royalblue;
            padding: 0;
            color: royalblue;
            cursor: pointer;
            display: inline-block;
        }

        .hide:checked + label {
            color: #7d8e8f;
            border-bottom: 0;
        }

        .hide:checked + label + div {
            display: block;
            background: #efefef;
            -moz-box-shadow: inset 3px 3px 10px #7d8e8f;
            -webkit-box-shadow: inset 3px 3px 10px #7d8e8f;
            box-shadow: inset 3px 3px 10px #7d8e8f;
            padding: 10px;
            border-radius: 5px;
        }

        .listgroupitemDZ {
            margin: 0.5% 1%;
        }

        .del {
            display: none;
        }

        .del:not(:checked) + label + * {
            display: none;
        }

        .del:not(:checked) + label,
        .del:checked + label {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 2px;
            color: #fff;
            background: #4e6473;
            cursor: pointer;
        }

        .del:checked + label {
            background: #e36443;
        }

        .cursor_pointer {
            cursor: pointer;
        }
    </style>
    <script src='https://www.google.com/recaptcha/api.js?render=6LcRTi8aAAAAAMEzgMlYhQxdAx9PREbu6G5IHzds'></script>
</head>
<body>
<div class="preloader">
    <div class="preloader__row">
        <div class="preloader__item"></div>
        <div class="preloader__item"></div>
    </div>
</div>

<?php $this->beginBody() ?>
<?php $user_id = Yii::$app->user->id;
$model = Yii::$app->db->createCommand("SELECT * FROM {{users}} WHERE [[id]] = '$user_id' ")->queryOne();
$school = $model['school'];
$classnumber = $model['classnumber'];
$classlater = $model['classlater'];
$date_segodny = date("Y-m-d");
$data = Yii::$app->db->createCommand("SELECT * FROM {{raspisanie}} ")->queryOne();
if ($model["tipe"] == 2) {
    $data = Yii::$app->db->createCommand("SELECT * FROM {{raspisanie}}  WHERE [[date]] = '$date_segodny' AND [[school_id]] = '$school' AND [[classnumber_id]] = '$classnumber' AND [[classlater_id]] = '$classlater' AND [[status_uroka]] = '1' AND [[active]] = '2'   OR [[date]] = '$date_segodny' AND [[school_id]] = '$school' AND [[ticher_id]] = '$user_id'  AND [[status_uroka]] = '0' ORDER BY time ASC")->queryOne();
}
if ($model["tipe"] == 3) {
    $data = Yii::$app->db->createCommand("SELECT * FROM {{raspisanie}}  WHERE [[date]] = '$date_segodny' AND [[school_id]] = '$school' AND [[classnumber_id]] = '$classnumber' AND [[classlater_id]] = '$classlater' AND [[status_uroka]] = '1' AND [[active]] = '2'   OR [[date]] = '$date_segodny' AND [[school_id]] = '$school' AND [[classnumber_id]] = '$classnumber' AND [[classlater_id]] = '$classlater' AND [[status_uroka]] = '0' AND [[active]] = '1'  ORDER BY time ASC")->queryOne();
}
$timestamp_hours_minutes = strtotime($data["time"]);
$timestamp_yers_day = strtotime($data["date"]);
$date1 = new DateTime();
$date1->setTimeStamp($timestamp_hours_minutes);
$hours = $date1->format("H");
$minutes = $date1->format("i");
$date2 = new DateTime();
$date2->setTimeStamp($timestamp_yers_day);
$years = $date2->format("Y");
$mondes = $date2->format("m");
$day = $date2->format("d");
?>

<?php if (!Yii::$app->user->isGuest) { ?>

    <?php
    NavBar::begin();
?>

<?php
    NavBar::end();

    ?>


<div class="wrap"  >
    <nav id="w0" class="navbar-inverse navbar-fixed-top navbar"><div class="container"><div class="navbar-header">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span></button><a class="navbar-brand" style="font-size: 26px;" href="/web/"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-grid-3x3-gap" viewBox="0 0 16 16">
                        <path d="M4 2v2H2V2h2zm1 12v-2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1zm0-5V7a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1zm0-5V2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1zm5 10v-2a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1zm0-5V7a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1zm0-5V2a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1zM9 2v2H7V2h2zm5 0v2h-2V2h2zM4 7v2H2V7h2zm5 0v2H7V7h2zm5 0h-2v2h2V7zM4 12v2H2v-2h2zm5 0v2H7v-2h2zm5 0v2h-2v-2h2zM12 1a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1h-2zm-1 6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V7zm1 4a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1h-2z"/>
                    </svg>&nbsp;List</a></div>
            <div id="w0-collapse" class="collapse navbar-collapse"><ul id="w1" class="navbar-nav navbar-right nav">

                       <p><div  style="margin-top:3px; font-size: 17px; background-color: #0e84b5">&nbsp;&nbsp;&nbsp;Доброго вечора,&nbsp;&nbsp;&nbsp;</div></p><p><div  style="margin-top:-11px; font-size: 17px; background-color: #f1c40f">&nbsp;&nbsp;&nbsp;ми з України !&nbsp;&nbsp;&nbsp;</div></p></ul></div></div></nav>

    <?php } ?>
    <!--////////////////////////////Окно оповещения о скором уроке----->
    <div class="modal fade" id="ModalMessageOnLine" tabindex="-1" data-toggle="modal">
        <div class="modal-dialog" role="document">
            <div class="alert alert-info" role="alert">
                Скоро онлайн урок ...
            </div>
        </div>
    </div>
    <!-----------------------------Конец------------------------------------------>
    <?php if (Yii::$app->user->isGuest) { ?>
    <div class="container" >
        <?php } ?>
        <?php if (!Yii::$app->user->isGuest) { ?>
        <div class="container" style="background-color:#ffffff; border-radius: 5px; padding: 7px;">
            <?php } ?>
            <?php if (!Yii::$app->user->isGuest) { ?>
           <?php //if( Yii::$app->user->id == 9 or Yii::$app->user->id == 10 or Yii::$app->user->id == 11){?>
                <div class="alert alert-warning" role="alert">
                    Увага, сайт працює в ДЭМО режимі, деякі функціі вимкнено :(
                </div>
            <?php //} ?>


            <?php } ?>
         
            <!------------------------------------------Alert о начале урока------------------------>
            <?php if (!Yii::$app->user->isGuest) { ?>
                <?php if ($model["tipe"] != 4) { ?>
                    <?php if (!empty($data)) { ?>
                        <?php $_SERVER['REQUEST_URI'];

                        $haystack = $_SERVER['REQUEST_URI'];
                        $needle = 'online';

                        $pos = strripos($haystack, $needle);
                        if ($pos == false) {
                            ?>
                            <div class="alert alert-info" role="alert">
                                <tr>
                                    <td>
                                        <div id="countdown"></div>
                                    </td>
                                    <td>
                                        <div id="countdown1"></div>
                                    </td>
                                </tr>
                            </div>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
            <?php } ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>
    <!--////////////////////////////Окно админа----->
    <div class="modal fade" id="openWindowIEStop" tabindex="-1" data-toggle="modal" data-backdrop="static"
         data-keyboard="false">
        <div class="modal-dialog" role="document">

            <div class="alert alert-danger" role="alert">
                Сайт не рпрацює з браузером Internet Explorer :(
            </div>
        </div>
    </div>
    <!--////////////////////////////Окно админа----->
    <div class="modal fade" id="openWindowOnlineOffline" tabindex="-1" data-toggle="modal" data-backdrop="static"
         data-keyboard="false">
        <div class="modal-dialog" role="document">

            <div class="alert alert-danger" role="alert">
                Зв'язок з сайтом втрачено.Перевірте інтернет з'єднання ...
            </div>
        </div>
    </div>
    <script>

        function proverkaOnOffServer() {
            let xhr = new XMLHttpRequest();
            xhr.open('GET', 'http://localhost/web/api/onoff');
            xhr.send();
            xhr.onload = function() {
                if (xhr.status != 200) {
                    alert(`Ошибка ${xhr.status}: ${xhr.statusText}`);
                } else {
                    $("#openWindowOnlineOffline").modal('hide');
                      }
            };
            xhr.onerror = function() {
                $("#openWindowOnlineOffline").modal('show');
            };
        }
        //setInterval(proverkaOnOffServer, 2000);
    </script>
    <script type="text/javascript">(function (w, doc) {
            if (!w.__utlWdgt) {
                w.__utlWdgt = true;
                var d = doc, s = d.createElement('script'), g = 'getElementsByTagName';
                s.type = 'text/javascript';
                s.charset = 'UTF-8';
                s.async = true;
                s.src = ('https:' == w.location.protocol ? 'https' : 'http') + '://w.uptolike.com/widgets/v1/uptolike.js';
                var h = d[g]('body')[0];
                h.appendChild(s);
            }
        })(window, document);
    </script>
    <div data-mobile-view="true" data-share-size="30" data-like-text-enable="false" data-background-alpha="0.0"
         data-pid="1896282" data-mode="share" data-background-color="#ffffff" data-share-shape="round-rectangle"
         data-share-counter-size="12" data-icon-color="#ffffff" data-mobile-sn-ids="fb.vk.tw.ok.wh.tm.vb."
         data-text-color="#000000" data-buttons-color="#FFFFFF" data-counter-background-color="#ffffff"
         data-share-counter-type="disable" data-orientation="fixed-right" data-following-enable="false"
         data-sn-ids="fb.vk.tw.ok.wh.tm.vb." data-preview-mobile="false" data-selection-enable="true"
         data-exclude-show-more="false" data-share-style="1" data-counter-background-alpha="1.0" data-top-button="false"
         class="uptolike-buttons"></div>
    <?php if (!Yii::$app->user->isGuest) { ?>
        <footer class="footer">
            <div class="container">
                <p class="pull-left">&copy; localhost <?= date('Y') ?></p>
                <p>«Разум благоразумного приобретает знание, а ухо мудрого ищет знания»</p>
            </div>
        </footer>
    <?php } ?>
    <?php $this->endBody() ?>
    <script>
        window.onload = function () {
            document.body.classList.add('loaded_hiding');
            window.setTimeout(function () {
                document.body.classList.add('loaded');
                document.body.classList.remove('loaded_hiding');
            }, 500);
        }
    </script>
    <?php if (!empty($data)) { ?>
        <?php
        if (!Yii::$app->user->isGuest) {
            $url = $_SERVER["REQUEST_URI"];;
            $www = strstr($url, "online");
            if (empty($www)) { ?>
                <?php if ($model["tipe"] == 3) { ?>
                <script>
                    var hours = <?php echo $hours ?>;
                    var minutes = <?php echo $minutes ?>;
                    var years = <?php echo $years ?>;
                    var mondes = <?php echo $mondes - 1 ?>;
                    var day = <?php echo $day ?>;
                    var user_id = <?php echo $user_id ?>;
                    var today = new Date();
                    var end = new Date(years, mondes, day, hours, minutes, 00);
                    var _second = 1000;
                    var _minute = _second * 60;
                    var _hour = _minute * 60;
                    var _day = _hour * 24;
                    var timer;

                    function showRemaining() {
                        var now = new Date();
                        var distance = end - now;
                        if (distance <= 0) {
                            window.location.replace("http://localhost/web/myroom/online?ids=<?php echo $user_id ?>&cod=<?php echo $data["code_uroka"] ?>");
                        }
                        var days = Math.floor(distance / _day);
                        var hours = Math.floor((distance % _day) / _hour);
                        if (hours < 10) hours = '0' + hours;
                        var minutes = Math.floor((distance % _hour) / _minute);
                        if (minutes < 10) minutes = '0' + minutes;
                        var seconds = Math.floor((distance % _minute) / _second);
                        if (seconds < 10) seconds = '0' + seconds;
                        document.getElementById('countdown1').innerHTML = "Залишилось : " + hours + ":" + minutes + ":" + seconds + "";
                    }

                    //setInterval(showRemaining, 1000);
                </script>
            <?php } ?>
            <?php if ($model["tipe"] == 2) { ?>
                <script>
                    var hours = <?php echo $hours ?>;
                    var minutes = <?php echo $minutes ?>;
                    var years = <?php echo $years ?>;
                    var mondes = <?php echo $mondes - 1 ?>;
                    var day = <?php echo $day ?>;
                    var user_id = <?php echo $user_id ?>;
                    var today = new Date();
                    var end = new Date(years, mondes, day, hours, minutes, 00);
                    var _second = 1000;
                    var _minute = _second * 60;
                    var _hour = _minute * 60;
                    var _day = _hour * 24;
                    var timer;

                    function showRemaining() {
                        var now = new Date();
                        var distance = end - now;
                        if (distance <= 0) {
                            window.location.replace("http://localhost/web/myroom/onlinestart?ids=<?php echo $user_id ?>&cod=<?php echo $data["code_uroka"] ?>");
                        }
                        var days = Math.floor(distance / _day);
                        var hours = Math.floor((distance % _day) / _hour);
                        if (hours < 10) hours = '0' + hours;
                        var minutes = Math.floor((distance % _hour) / _minute);
                        if (minutes < 10) minutes = '0' + minutes;
                        var seconds = Math.floor((distance % _minute) / _second);
                        if (seconds < 10) seconds = '0' + seconds;
                        document.getElementById('countdown1').innerHTML = "Урок почнеться через : " + hours + ":" + minutes + ":" + seconds + "";
                    }

                    //setInterval(showRemaining, 1000);
                </script>
            <?php } ?>
            <?php } ?>
        <?php }
    } ?>
    <?php
    $url = $_SERVER["REQUEST_URI"];;
    $www = strstr($url, "online");
    ?>
    <script>
        function proverkaUserSpisokUrokOnline() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'http://localhost/web/api/proverkaonlineurok?id=<?php echo $user_id ?>', true);
            xhr.onload = function () {
                var obj = JSON.parse(this.responseText);
                console.log(this.responseText);
                if (this.responseText != 0) {
                    document.location.href = "http://localhost/web/myroom/online?ids=<?php echo $user_id ?>&cod=" + this.responseText;
                }
            };
            xhr.send(null);
        }
        <?php $data_res = Yii::$app->db->createCommand("SELECT * FROM {{raspisanie}}  WHERE [[date]] = '$date_segodny' AND [[school_id]] = '$school' AND [[classnumber_id]] = '$classnumber' AND [[classlater_id]] = '$classlater' AND [[status_uroka]] = '1' OR [[date]] = '$date_segodny' AND [[ticher_id]] = '$user_id' AND [[school_id]] = '$school'  AND [[status_uroka]] = '1'  ORDER BY time ASC  ")->queryOne();
        ?>
        function DeleteOnlineUrokiTimeOut() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'http://localhost/web/api/deleteonlineurokitimeout?ids=<?php echo $data_res["code_uroka"] ?>', true);
            xhr.onload = function () {
                var obj = JSON.parse(this.responseText);
                console.log(this.responseText);
            };
            xhr.send(null);
        }
        <?php
        if (!Yii::$app->user->isGuest) {
        $url = $_SERVER["REQUEST_URI"];;
        $www = strstr($url, "online");
        if(empty($www)){ ?>
      //  setInterval(proverkaUserSpisokUrokOnline, 1000);
        <?php }} ?>
      //  setInterval(DeleteOnlineUrokiTimeOut, 1000);
    </script>
    <div style="float:left; margin-left: 40px;">
        <script>
            function proverkaUserProverkaTimeUrok() {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'http://localhost/web/api/proverkatimeurok?id=<?php echo $user_id ?>', true);
                xhr.onload = function () {
                    var obj = JSON.parse(this.responseText);
                    console.log(this.responseText);
                    if (this.responseText == 1) {
                        document.location.href = "http://localhost/web/myroom/";
                    }
                };
                xhr.send(null);
            }

            function proverkaUserProverkaTimeUrokTicher() {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'http://localhost/web/api/proverkatimeurokticher?id=<?php echo $user_id ?>', true);
                xhr.onload = function () {
                    var obj = JSON.parse(this.responseText);
                    console.log(this.responseText);
                    if (this.responseText == 1) {
                        document.location.href = "http://localhost/web/myroom/";
                    }
                };
                xhr.send(null);
            }
            <?php
            $urls = $_SERVER["REQUEST_URI"];;
            $wwws = strstr($urls, "online");
            $wwwsduble = strstr($urls, "onlinestart");
            if(empty($wwws) or empty($wwwsduble)){ ?>
           // setInterval(proverkaUserProverkaTimeUrok, 5000);
           // setInterval(proverkaUserProverkaTimeUrokTicher, 5000);
            <?php }?>
            function openNav() {
                document.getElementById("mySidebar").style.width = "250px";
                document.getElementById("main").style.marginLeft = "250px";
                document.getElementById("main").style.marginLeft = "0";
            }

            function closeNav() {
                document.getElementById("mySidebar").style.width = "0";
                document.getElementById("main").style.marginLeft = "0";
            }
        </script>
</body>
</html>
<?php $this->endPage() ?>
