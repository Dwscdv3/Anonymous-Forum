<?php

require("config.php");

global $config, $sql;

if ($_POST != null) {
    Initialize();
    $pw = md5($_POST["Password"]);

    if (!empty($_POST["TID"])) {
        $id = $_POST["TID"];
        $result = $sql->query("SELECT `Password` FROM `$config[4]_Topics` WHERE `ID`=$id;");
        $row = $result->fetch_array();
        if ($pw = $row["Password"]) {
            $sql->query("DELETE FROM `$config[4]_Topics` WHERE `ID`=$id;");
            $sql->query("DELETE FROM `$config[4]_Comments` WHERE `Topic`=$id;");
            exit("Succeed");
        } else {
            exit("Failed");
        }
    }
}