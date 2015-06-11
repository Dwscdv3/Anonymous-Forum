<?php

header("Content-type: text/html; charset=utf-8");

require "source/config.php";

global $config, $sql;

Initialize();

if (!isset($_COOKIE["UID"])) {
    setcookie("UID", genUID(), time() + (86400 * 365));
}

// QueryString ?id=*
// 立即转到该主题的内容
if ($_GET["id"] != null) {
    echo '<script type="text/javascript">
var waitForAjax = setInterval(function() {
    try {
        if (ajaxFinished) {
            clearInterval(waitForAjax);
            ViewComments(' . $_GET["id"] . ');
        }
    } catch (ex) {}
}, 500);
</script>';
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta content="width=divice-width, target-densitydpi=280, initial-scale=0.55, maximum-scale=0.55, user-scalable=0" name="viewport">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <title>匿名版</title>
        <link rel="stylesheet" type="text/css" href="style.css" />
        <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="jslib/lib.js"></script>
        <script type="text/javascript" src="main.js"></script>
    </head>
    <body>
        <div class="container" id="Topics">

        </div>
        <div class="sidebar-left-150" id="SideBar">
            <h1 class="sidebaritem-150" id="Title">匿名版</h1>
            <h5 class="sidebaritem-150">Anonymous Forum</h5>
            <div class="separator"></div>

            <div class="smaller">
                决策中: <br />
                &nbsp;&nbsp;可视化编辑器<br />
            </div>

            <div class="bottom z-10" id="ReturnDiv">
                <a class="sidebaritem-150" onclick="ajaxLoadTopics();">☯ 刷新</a>
                <a class="sidebaritem-150" onclick="Write(0);">+ 发表新主题</a>
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
            <div class="head">
                <a class="close-button" onclick="CloseComments();">×</a>
                <a class="toolbar-button hide" id="Refresh-Topic">刷新</a>
                <a class="toolbar-button hide" id="Reply">回复</a>
                <a class="toolbar-button pw-needed hide" id="Delete-Topic">删除</a>
                <a class="toolbar-button pw-needed hide" id="Edit-Topic">编辑</a>
            </div>
            <div class="border full-screen-inner" id="Comments-Inner">

            </div>
        </div>
        <div class="center full-screen half-transparent" style="display: none;" id="Write">
            <div class="head">
                <a class="close-button" onclick="CloseWrite();">×</a>
            </div>
            <div class="border full-screen-inner" id="Write-Inner">
                <label class="larger" for="Title-Write">标题</label>
                <input id="Title-Write" name="Title" type="text" maxlength="253" />
                <br />
                <span class="small right" id="TitleRequired">* 标题必须填写&nbsp;</span>
                <br />
                <div class="left">
                    <label class="larger" for="Nick">昵称</label>
                    <input id="Nick" name="Nick" type="text" maxlength="24" />
                </div>
                <div class="right">
                    <label class="larger" id="Password-Label" for="Password">管理密码<span class="small">(可留空, 但将无法编辑删除)</span></label>
                    <input id="Password" name="Password" type="text" maxlength="128" />&nbsp;
                </div>
                <br /><br />
                <label class="larger left" for="Content">正文</label>
                <div class="right">
                    <input id="ContentUseHTML" type="checkbox" />
                    <label class="small" for="ContentUseHTML">使用HTML</label>
                </div>
                <textarea id="Content" name="Content" maxlength="20000"></textarea>
                <br /><br />
                <input class="larger" type="button" value="发表" onclick="Submit();" />
            </div>
        </div>
        <div class="border pw-needed hide" id="Delete-Topic-Validate" style="
            position: absolute;
            top: 60px;
            right: 10px;
            background-color: #666;
            padding: 5px;
            z-index: 200;
        ">
            <label class="inline" for="Password-Delete">密码</label>
            <input id="Password-Delete" name="Password" type="password" />
            <input type="button" value="确认" onclick="Delete(tid);" />
        </div>
    </body>
</html>