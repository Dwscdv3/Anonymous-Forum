//document.onclick = OnClick;

var clickTimes = 0;

function OnClick() {
    var str = "#";
    for (var i = 0; i < 6; i++) {
        str += getHexRandString(Math.random() * 16);
    }

    $("#Main").css("background-color", str);
    $("#Counter").text(++clickTimes);
}
function getHexRandString(int) {
    if (int >= 0 && int < 10) {
        return String.fromCharCode(48 + int);
    } else if (int >= 10 && int < 16) {
        return String.fromCharCode(97 + int - 10);
    }
}
function Nav_OnClick() {
    $("#Nav").slideToggle(400);
}
function Button_OnMouseOver() {
    $("#Menu").css("background-color", "rgba(153, 153, 153, 0.5)");
}
function Button_OnMouseDown() {
    $("#Menu").css("background-color", "rgba(85, 85, 85, 0.5)");
}
function Button_OnMouseOut() {
    $("#Menu").css("background-color", "");
}
function Button_OnMouseUp() {
    $("#Menu").css("background-color", "rgba(153, 153, 153, 0.5)");
}