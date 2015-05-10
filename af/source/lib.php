<?php

function navTo($url) {
    echo "
    <script type=\"text/javascript\">
    window.location.href = '$url';
    </script>
    ";
}

function genUID() {
    $uid = "";
    for ($i = 0; $i < 4; $i++) {
        $int = mt_rand(0, 61);
        if ($int < 10) {
            $uid .= $int;
        } elseif ($int >= 10 && $int < 36) {
            $uid .= chr($int + 55);
        } elseif ($int >= 36) {
            $uid .= chr($int + 61);
        }
    }
    return $uid;
}

//function transDate($date) {
//
//}

function alert($msg) {
    echo "<script type='type/javascript'>alert('$msg');</script>";
}