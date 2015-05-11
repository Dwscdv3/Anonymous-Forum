<?php

require "config.php";

global $config, $sql;

if ($_GET != null) {
    $offset = $_GET["offset"];
    $amount = $_GET["amount"];

    Initialize();

    $result = $sql->query("SELECT * FROM `$config[4]_Topics` ORDER BY `LastTime` DESC LIMIT $offset, $amount");
    if (mysqli_num_rows($result) <= 0) {
        echo '无主题';
        exit;
    }
    while ($row = $result->fetch_array()) {
        $nick = $row["Nick"] != null ? $row["Nick"] : "无名氏";
        echo '
<div class="topic">
    <div class="topic-inner">
        <a class="larger" onclick="tid = '.$row["ID"].'; ViewComments(tid);">'.$row["Title"].'<span class="right smaller">回复 ('.$row["Comments"].')&nbsp;</span></a>
        <p><pre class="content">'.$row["Content"].'</pre></p>
        <div class="topic-bar smaller">
            '.$row["UID"].'：'.$nick.'<div class="right monospace">'.$row["Time"].' / '.$row["LastTime"].'&nbsp;</div>
        </div>
    </div>
</div>
';
    }
}