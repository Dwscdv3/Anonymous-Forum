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
}