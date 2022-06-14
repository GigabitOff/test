<?php

/* @var $this yii\web\View */

$this->title = 'on-Line';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    body {
        font-family: "Lato", sans-serif;
    }

    .sidebar {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
        background-color: #111;
        overflow-x: hidden;
        transition: 0.5s;
        padding-top: 60px;
    }

    .sidebar a {
        padding: 8px 8px 8px 32px;
        text-decoration: none;
        font-size: 25px;
        color: #818181;
        display: block;
        transition: 0.3s;
    }

    .sidebar a:hover {
        color: #f1f1f1;
    }

    .sidebar .closebtn {
        position: absolute;
        top: 2;
        right: 25px;
        font-size: 46px;
        margin-left: 50px;

    }

    .openbtn {
        font-size: 20px;
        cursor: pointer;
        background-color: #2e6da4;
        color: white;
        padding: 10px 15px;

        border-radius: 5px;

    }

    .openbtn:hover {
        background-color: #ffff00;
    }


    /* На небольших экранах, где высота меньше 450px, измените стиль sidenav (меньше отступов и меньший размер шрифта) */
    @media screen and (max-height: 450px) {
        .sidebar {
            padding-top: 15px;
        }

        .sidebar a {
            font-size: 18px;
        }
    }

    #main {
        margin: 0px;
        background: e6eeee;
        z-index: 2;
        position: fixed;
        top: 0px;
        left: 0px;
        margin-top: 51px;
    }
</style>
<style>
    body {
        font-family: "Lato", sans-serif;
    }

    .sidebar {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
        background-color: #111;
        overflow-x: hidden;
        transition: 0.5s;
        padding-top: 60px;
        opacity: 0.9;
    }

    .sidebar a {
        padding: 8px 8px 8px 32px;
        text-decoration: none;
        font-size: 25px;
        color: #ffffff;
        display: block;
        transition: 0.3s;
    }

    .sidebar a:hover {
        color: #f1f1f1;
    }

    .sidebar .closebtn {
        position: absolute;
        top: 2;
        right: 25px;
        font-size: 46px;
        margin-left: 50px;

    }

    .openbtn {
        font-size: 20px;
        cursor: pointer;
        background-color: #2e6da4;
        color: white;
        padding: 10px 15px;

        border-radius: 5px;

    }

    .openbtn:hover {
        background-color: #ffff00;
    }


    /* На небольших экранах, где высота меньше 450px, измените стиль sidenav (меньше отступов и меньший размер шрифта) */
    @media screen and (max-height: 450px) {
        .sidebar {
            padding-top: 15px;
        }

        .sidebar a {
            font-size: 18px;
        }
    }

    #main {
        margin: 0px;
        background: e6eeee;
        z-index: 2;
        position: fixed;
        top: 0px;
        left: 0px;
        margin-top: 51px;
    }
</style>

<center>
    <div class="alert alert-info" role="alert">
        <h4 class="alert-heading">Все готово ;)</h4>
        <p><?php
            //echo $data_zoom["zoomdata"];
            $user_id = Yii::$app->user->id;
            $model = Yii::$app->db->createCommand("SELECT * FROM {{users}} WHERE [[id]] = '$user_id' ")->queryOne();
            ?>
            <a href="<?php
            if ($model["tipe"] == 3) {
                $text = $urok["link_add"];
                echo $text;
            }
            if ($model["tipe"] == 2) {
                $text = $urok["link_start"];
                echo $text;
            }
            ?>" target="_blank"><span class="btn btn-success"><svg width="1em" height="1em" viewBox="0 0 16 16"
                                                                   class="bi bi-camera-reels" fill="currentColor"
                                                                   xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                  d="M0 8a2 2 0 0 1 2-2h7.5a2 2 0 0 1 1.983 1.738l3.11-1.382A1 1 0 0 1 16 7.269v7.462a1 1 0 0 1-1.406.913l-3.111-1.382A2 2 0 0 1 9.5 16H2a2 2 0 0 1-2-2V8zm11.5 5.175l3.5 1.556V7.269l-3.5 1.556v4.35zM2 7a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h7.5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H2z"/>
            <path fill-rule="evenodd" d="M3 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
            <path fill-rule="evenodd" d="M9 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
        </svg>Перейти до класу </span></a>
        </p>
        <hr>
        <p class="mb-0">Для того щоб приєднатися до уроку, натисніть кнопку "Перейти до класу"
        </p>
    </div>
</center>
<!--////////////////////////////Окно оповещения о скором уроке----->
<div class="modal fade" id="ModalTicherNo" tabindex="-1" data-toggle="modal" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="alert alert-info" role="alert">
            Чекаємо вчителя ...
        </div>
    </div>
</div>
<?php
$school = $model['school'];
?>
<?php if ($model["tipe"] == 3) { ?>
    <script>
        function explode() {
            <?php
            $urls = $_SERVER['REQUEST_URI'];
            $wwws = strstr($urls, "cod=");
            $strs = $wwws;
            $results = substr(strstr($strs, '='), 1, strlen($strs));
            $string_browse = $_SERVER['QUERY_STRING'];
            ?>
            var xhr = new XMLHttpRequest();
            var code = <?php  echo $results ?>;
            xhr.open('GET', 'http://localhost/web/api/onlineticherno?cod=' + code, true);
            xhr.onload = function () {
                if (this.responseText == 0) {
                    window.location.replace("http://localhost/web/myroom/online?<?php echo $string_browse ?>");
                }
            }
            xhr.send(null);
        }

        //setInterval(explode, 3000); //10000 это время, через которое нужно запустить функцию (1 секунд = 1000 миллисекунд)
    </script>
<?php } ?>
<script>
    function openNav() {
        document.getElementById("mySidebar").style.width = "250px";
        document.getElementById("main").style.marginLeft = "250px";
        document.getElementById("main").style.marginLeft = "0";
    }

    function closeNav() {
        document.getElementById("mySidebar").style.width = "0";
        document.getElementById("main").style.marginLeft = "0";
    }

    function redirectCabinetIfNetUrokaOnline() {

        <?php
        $url = $_SERVER['REQUEST_URI'];
        $www = strstr($url, "cod=");
        $str = $www;
        $result = substr(strstr($str, '='), 1, strlen($str));
        $result; ?>
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'http://localhost/web/api/redirectifnourok?ids=<?php echo $result ?>', true);
        xhr.onload = function () {
            var obj = JSON.parse(this.responseText);
            console.log(this.responseText);
            if (this.responseText == 3) {
                window.location.href = "http://localhost/web/myroom";
            }
        };
        xhr.send(null);
    }

    //setInterval(redirectCabinetIfNetUrokaOnline, 1000);
</script>
