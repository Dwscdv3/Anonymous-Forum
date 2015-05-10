<?php

require "config.php";

global $config, $sql;

if ($_GET != null) {
    Initialize();

    $id = $_GET["id"];

    $result1 = $sql->query("SELECT * FROM `$config[4]_Topics` WHERE ID=$id");
    $result2 = $sql->query("SELECT * FROM `$config[4]_Comments` WHERE Topic=$id");

    $row1 = $result1->fetch_array();
    $nick = $row1["Nick"] != null ? $row1["Nick"] : "无名氏";
    echo '<div>
    <div id="Head">
        <h1 class="left">'.$row1["Title"].'</h1>
        <div class="right monospace">'.$row1["Time"].'</div>
        <br />
        <div class="right">'.$row1["UID"].'：'.$nick.'</div>
    </div>
    <br /><br /><br /><br />
    <pre class="text-left larger" style="width: 100%;">'.$row1["Content"].'</pre>
    评论及回复施工中……';
    while ($row2 = $result2->fetch_array()) {
        echo '';
    }
    echo '</div>';
}