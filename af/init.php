<?php

header("Content-type: text/html; charset=utf-8");

if ($_POST != null) {
    echo "开始初始化……<br />";

    $srv = $_POST["_Server"];
    $user = $_POST["_UserName"];
    $pw = $_POST["_Password"];
    $db = $_POST["_DataBase"];
    $pre = $_POST["_Prefix"];

    echo "连接数据库……<br />";

    try {
        $con = new mysqli($srv, $user, $pw, $db);
    }
    catch (Exception $ex) {
        exit("无法连接到数据库。请确认服务器、用户名和密码填写正确。");
    }

    if (file_exists("config")) {
        delTable($con, $pre);
    }

    echo "创建数据表……<br />";

    createTable($con, $pre);

    if ($con->errno) {
        if ($con->errno == 1050) {
            delTable($con, $pre);
            createTable($con, $pre);
        } else {
            echo $con->errno . ' ' . $con->error . "<br />";
            echo "失败";
            exit;
        }
    }

    $con->close();


    echo "创建配置文件……<br />";

    $txt = fopen("config", "w");
    fwrite($txt, $srv."\n");
    fwrite($txt, $user."\n");
    fwrite($txt, $pw."\n");
    fwrite($txt, $db."\n");
    fwrite($txt, $pre."\n");
    fclose($txt);

    echo "成功";
}

function createTable($con, $pre) {
    $con->query("CREATE TABLE `".$pre."_Topics` (
        `ID` INT NOT NULL AUTO_INCREMENT,
        `Title` VARCHAR(253) BINARY NOT NULL,
        `Content` VARCHAR(20000) BINARY,
        `Nick` VARCHAR(24) BINARY,
        `UID` CHAR(4) BINARY NOT NULL,
        `LastTime` TIMESTAMP NOT NULL,
        `Time` TIMESTAMP NOT NULL,
        `Comments` INT DEFAULT 0,
        PRIMARY KEY(ID)
    ) DEFAULT CHARSET=utf8");      # LastTime 字段应在发表评论时更新

    $con->query("CREATE TABLE `".$pre. "_Comments` (
        `ID` INT NOT NULL AUTO_INCREMENT,
        `Topic` INT NOT NULL,
        `Title` VARCHAR(253) BINARY NOT NULL,
        `Content` VARCHAR(20000) BINARY,
        `Nick` VARCHAR(24) BINARY,
        `UID` CHAR(4) BINARY NOT NULL,
        `Time` TIMESTAMP NOT NULL,
        PRIMARY KEY(ID)
    ) DEFAULT CHARSET=utf8");
}

function delTable($con, $pre) {
    echo "删除旧数据表……<br />";
    $con->query("DROP TABLE `".$pre."_Topics`");
    $con->query("DROP TABLE `".$pre."_Comments`");
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>初始化 - 匿名版</title>
        <link rel="stylesheet" type="text/css" href="style.css" />
        <style type="text/css">
            .tag {
                text-align: right;
                width: 80px;
                display: inline;
                margin-left: 10px;
            }
            .textbox {
                color: #ddd;
                background-color: rgba(0, 0, 0, 0.00);

                border-width: 0 0 1px 0;
                border-bottom-color: #777;

                width: 160px;
            }
            .tbcontainer {
                display: inline;
                float: right;
                margin-right: 10px;
            }
            #Wrap {
                padding: 0;
                width: 100%;
            }
            #Main {
                padding: 20px;
                width: 250px;
                text-align: left;
                margin-left: auto;
                margin-right: auto;
            }
        </style>
    </head>
    <body>
        <div class="center full-screen" id="Wrap">
            <div id="Main">
                <h1 class="center">初始化</h1>
                <div class="separator" style="margin: 3px; height: 1px;"></div><br />
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <div class="tag">服务器&nbsp;&nbsp;</div><div class="tbcontainer"><input class="textbox" name="_Server" type="text" value="localhost:3306" /></div><br /><br />
                    <div class="tag">用户名&nbsp;&nbsp;</div><div class="tbcontainer"><input class="textbox" name="_UserName" type="text" /></div><br /><br />
                    <div class="tag">　密码&nbsp;&nbsp;</div><div class="tbcontainer"><input class="textbox" name="_Password" type="password" /></div><br /><br />
                    <div class="tag">数据库&nbsp;&nbsp;</div><div class="tbcontainer"><input class="textbox" name="_DataBase" type="text" /></div><br /><br />
                    <div class="tag">　前缀&nbsp;&nbsp;</div><div class="tbcontainer"><input class="textbox" name="_Prefix" type="text" value="af" /></div><br /><br />
                    <input type="submit" value="下一步" style="float: right;" />
                </form>
            </div>
        </div>
    </body>
</html>