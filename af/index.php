<?php

header("Content-type: text/html; charset=utf-8");

require "source/config.php";

global $config, $sql;

Initialize();

if (!isset($_COOKIE["UID"])) {
    setcookie("UID", genUID(), time() + (86400 * 365));
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>匿名版</title>
        <link rel="stylesheet" type="text/css" href="style.css" />
        <script type="text/javascript" src="http://libs.baidu.com/jquery/2.0.3/jquery.min.js"></script>
        <script type="text/javascript" src="main.js"></script>
    </head>
    <body>
        <div class="container" id="Topics">

        </div>
        <div class="sidebar-left-150" id="SideBar">
            <h1 class="sidebaritem-150" id="Title">匿名版</h1>
            <h5 class="sidebaritem-150">Anonymous Forum</h5>
            <div class="separator"></div>
            <div class="bottom z-10" id="ReturnDiv">
                <a class="sidebaritem-150" onclick="Write();">+ 发表新主题</a>
                <div class="separator"></div>
                <div class="sidebaritem-150" style="padding-left: 0; width: 142px;">
                    <a class="block left" style="text-align: center; width: 30px;" onclick="PrevPage();">&lt;</a>
                    <div class="smaller center" id="Page" style="width: 82px; float: left">1</div>
                    <a class="block right" style="text-align: center; width: 30px;" onclick="NextPage();">&gt;</a>
                </div>
                <div class="separator"></div>
                <a class="sidebaritem-150" href="../">&lt;&nbsp;返回主站</a>
            </div>
        </div>
        <div class="center full-screen half-transparent" style="display: none;" id="Comments">
            <div class="full-screen-inner" id="Comments-Inner">

            </div>
        </div>
        <div class="center full-screen half-transparent" style="display: none;" id="Write">
            <a class="close-button" onclick="Write();">×</a>
            <div class="full-screen-inner" id="Write-Inner">
                <form action="source/write.php" method="post">
                    <label for="Title" style="display: inline;">标题</label>
                    <input class="dark-textbox" id="Title-Write" name="Title" type="text" style="width: 90%;">
                    <br /><br />
                    <label for="Nick" style="display: inline;">昵称</label>
                    <input class="dark-textbox" id="Nick" name="Nick" type="text" style="width: 90%;">
                    <br /><br />
                    <label for="Content">正文</label>
                    <textarea class="dark-textarea" id="Content" name="Content"></textarea>
                    <br /><br />
                    <input type="submit" value="发表" />
                </form>
            </div>
        </div>
    </body>
</html>