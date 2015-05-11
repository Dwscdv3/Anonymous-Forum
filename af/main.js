const FadeTime = 400;

var page = 1;
var tid = 0;

$(document).ready(function () {
    resize();
    ajaxLoadTopics();
});
$(window).resize(resize);

function resize() {
    var width = $(window).width();
    var height = $(window).height();

    var contentBoxHeight = height - 320;
    $('#Content').css('height', contentBoxHeight + 'px');

    $('#Topics').css('width', width - 150 + 'px');

    $('#Comments-Inner').css('width', width - 140 + 'px').css('height', height - 140 + 'px');
    $('#Write-Inner').css('width', width - 140 + 'px').css('height', height - 140 + 'px');

    $('#Head').css('width', width - 140 + 'px')
}

function ViewComments(id) {
    $('#Comments').fadeIn(FadeTime);
    LoadComments(id);

}
function LoadComments(id) {
    $('#Comments-Inner').html("").load('source/topic.php?id=' + id, function() {
        resize();
    });
}
function CloseComments() {
    $('#Comments').fadeOut(FadeTime);
}

function Write(_tid) {
    $('#Write').fadeIn(FadeTime);
    tid = _tid;
}
function CloseWrite() {
    $('#Write').fadeOut(FadeTime);
}


function PrevPage() {
    if (page > 1) {
        page--;
        ajaxLoadTopics();
    } else {
        $('#Page').text('第一页');
        setTimeout(function() {
            $('#Page').text(page);
        }, 1000);
    }
}
function NextPage() {
    var isEnd = false;
    var topics = $('#Topics').html();
    $.get('source/query.php?offset=' + (page) * 20 +'&amount=20', function(data, status) {
        if (data != '无主题') {
            page++;
            $('#Topics').html(data);
        } else {
            isEnd = true;
            $('#Page').text('最后一页');
            setTimeout(function() {
                $('#Page').text(page);
            }, 1000);
        }
    });
    if (isEnd) {
        $('#Topics').html(topics);
    }
}

function Submit() {
    var title = $('#Title-Write').val();

    if ($.trim(title) == "") {
        $('#TitleRequired').css('color', '#f00');
        return;
    }

    if (tid) {
        $.post("source/write.php", {
            Title:title,
            Content:$('#Content').val(),
            Nick:$('#Nick').val(),
            Topic:tid
        }, function() {
            LoadComments(tid);
        });
    } else {
        $.post("source/write.php", {
            Title:$('#Title-Write').val(),
            Content:$('#Content').val(),
            Nick:$('#Nick').val()
        }, function() {
            ajaxLoadTopics();
        });
    }
    CloseWrite();
}

function ajaxLoadTopics() {
    $('#Topics').load('source/query.php?offset=' + (page - 1) * 20 +'&amount=20');
}