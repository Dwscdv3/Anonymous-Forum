var entityMap = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#39;',
    '/': '&#x2F;'
};
String.prototype.escapeHtml = function() {
    return this.replace(/[&<>"'\/]/g, function (s) {
        return entityMap[s];
    });
};

function getCookie(name) {
    var cookieStr = document.cookie;
    var cookieList = cookieStr.split('; ');
    for (var i = 0; i < cookieList.length; i++) {
        var cookie = cookieList[i].split('=');
        if (cookie[0] == name) {
            return decodeURI(cookie[1]);
        }
    }
    return '';
}