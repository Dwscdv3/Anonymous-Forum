<?php

require "config.php";

global $config, $sql;

if ($_POST != null) {
    $title = $_POST["Title"];
    $content = $_POST["Content"];
    $nick = $_POST["Nick"];

    $uid = $_COOKIE["UID"];

    Initialize();

    $date = date('Y-m-d H:i:s', time());

    if ($_POST["Topic"] == null) {
        $sql->query("INSERT INTO `$config[4]_Topics` (
    Title,
    Content,
    Nick,
    UID,
    Time,
    LastTime
) VALUES (
    '$title',
    '$content',
    '$nick',
    '$uid',
    '$date',
    '$date'
)");

        navTo("../");
    } else {
        $topic = $_POST["Topic"];

        $sql->query("INSERT INTO `$config[4]_Comments` (
    Topic,
    Title,
    Content,
    Nick,
    UID
) VALUES (
    '$topic',
    '$title',
    '$content',
    '$nick',
    '$uid'
)");
        $sql->query("UPDATE `$config[4]_Topics` SET
    Comments=Comments+1
WHERE ID=$topic
");
        if (!$sql->errno) {
            exit("refresh");
        } else {
            alert($sql->errno.' '.$sql->error);
        }
    }
}