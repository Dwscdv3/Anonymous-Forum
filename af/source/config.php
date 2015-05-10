<?php

require "lib.php";

static $config = null;
static $sql = null;

function Initialize() {
    global $config, $sql;

    if ($config == null) {
        if (file_exists("config")) {
            $txt = fopen("config", "r");
            $configStr = fread($txt, filesize("config"));
            $config = explode("\n", $configStr);
        } elseif (file_exists("../config")) {
            $txt = fopen("../config", "r");
            $configStr = fread($txt, filesize("../config"));
            $config = explode("\n", $configStr);
        } else {
            navTo("init.php");
            exit;
        }
    }
    if (!$sql) {
        $sql = new mysqli($config[0], $config[1], $config[2], $config[3]);

    }
}