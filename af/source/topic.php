<?php

require "config.php";

global $config, $sql;

if ($_GET != null) {
    Initialize();

    $id = $_GET["id"];

    $result1 = $sql->query("SELECT * FROM `$config[4]_Topics` WHERE ID=$id");
    $result2 = $sql->query("SELECT * FROM `$config[4]_Comments` WHERE Topic=$id ORDER BY Time");

    $row1 = $result1->fetch_array();
    $nick1 = $row1["Nick"] != null ? $row1["Nick"] : "无名氏";
    echo '<div>
    <div id="Head">
        <h1 class="left">'.$row1["Title"].'<span class="smaller">&nbsp;#<span id="TID">'.$id.'</span></span></h1>
        <br />
        <div class="right monospace">&nbsp;&nbsp;&nbsp;'.$row1["Time"].'</div>
        <br />
        <div class="right">'.$row1["UID"].'：'.$nick1.'</div>
    </div>
    <br /><br /><br /><br />
    <pre class="text-left larger" style="width: 100%;">'.$row1["Content"].'</pre>
    <br />';
    while ($row2 = $result2->fetch_array()) {
        $nick2 = $row2["Nick"] != null ? $row2["Nick"] : "无名氏";
        echo '<div class="comment">
    <div>
        <span class="bold">'.$row2["Title"].'</span>&nbsp;&nbsp;
        <br />
        <div class="right monospace">&nbsp;&nbsp;&nbsp;'.$row2["Time"].'</div>
        <br />
        <div class="right">'.$row2["UID"].'：'.$nick2.'</div>
    </div>
    <pre>'.$row2["Content"].'</pre>

</div>';
    }
    echo '</div>';
}