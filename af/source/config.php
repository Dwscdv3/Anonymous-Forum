<?php

require "lib.php";

static $config = null;
static $sql = null;

date_default_timezone_set('Etc/GMT-8');

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