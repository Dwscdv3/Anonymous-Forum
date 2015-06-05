var entityMap = {
    "&": "&amp;",
    "<": "&lt;",
    ">": "&gt;",
    '"': '&quot;',
    "'": '&#39;',
    "/": '&#x2F;'
};
String.prototype.escapeHtml = function() {
    return this.replace(/[&<>"'\/]/g, function (s) {
        return entityMap[s];
    });
};