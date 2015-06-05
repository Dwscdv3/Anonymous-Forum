<?php

require "config.php";

global $config, $sql;

if ($_POST != null) {
    $tid = $_POST["Topic"];

    $title = htmlspecialchars($_POST["Title"]);
    $content = $_POST["Content"];
    $nick = htmlspecialchars($_POST["Nick"]);
    $pw = empty($_POST["Password"]) ? "" : md5($_POST["Password"]);
    $uid = $_COOKIE["UID"];

    setcookie("Nick", $nick, time() + (86400 * 365), "/af");

    Initialize();

    $date = date('Y-m-d H:i:s', time());

    if (!empty($tid)) {
        switch ($_POST["IsEdit"]) {
            case 0:
                $sql->query("INSERT INTO `$config[4]_Topics` (
    Title,
    Content,
    Nick,
    UID,
    Time,
    LastTime,
    Password
) VALUES (
    '$title',
    '$content',
    '$nick',
    '$uid',
    '$date',
    '$date',
    '$pw'
)");
                navTo("../");
                break;
            case 1:
                $result = $sql->query("SELECT Password FROM `$config[4]_Topics` WHERE ID=$tid;");
                $row = $result->fetch_array();
                if ($row["Password"] == $pw) {
                    $sql->query("UPDATE `$config[4]_Topics` SET
    Title='$title',
    Content='$content',
    Nick='$nick',
    Time='$date',
    LastTime='$date'
WHERE ID=$tid;");
                    exit("Success");
                } else {
                    exit("Wrong Password");
                }
        }
    } else {
        $topic = $_POST["Topic"];

        $sql->query("INSERT INTO `$config[4]_Comments` (
    Topic,
    Title,
    Content,
    Nick,
    UID,
    Time,
    Password
) VALUES (
    '$topic',
    '$title',
    '$content',
    '$nick',
    '$uid',
    '$date',
    '$pw'
);");
        $sql->query("UPDATE `$config[4]_Topics` SET
    LastTime='$date',
    Comments=Comments+1
WHERE ID=$topic");

        if (!$sql->errno) {
            exit;
        } else {
            alert($sql->errno.' '.$sql->error);
        }
    }
}