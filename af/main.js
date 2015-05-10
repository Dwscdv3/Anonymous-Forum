var page = 1;

$(document).ready(function () {
    resize();
    ajaxLoadTopic();
});
$(window).resize(resize);

function resize() {
    var width = $(window).width();
    var height = $(window).height();

    var contentBoxHeight = height - 300;
    $('#Content').css('height', contentBoxHeight < 100 ? 100 : contentBoxHeight + 'px')

    $('#Topics').css('width', width - 150 + 'px');

    $('Comments-Inner').css('width', width - 140 + 'px').css('height', height - 140 + 'px');
    $('#Write-Inner').css('width', width - 140 + 'px').css('height', height - 140 + 'px');

    $('#Head').css('width', width - 140 + 'px')
}

function ViewTopic(id) {
    $('#Comments').fadeToggle(400);
    $('#Comments-Inner').html("").load('source/topic.php?id=' + id);
}
function CloseTopic() {
    $('#Comments').fadeToggle(400);
}

function Write() {
    $('#Write').fadeToggle(400);
}


function PrevPage() {
    if (page > 1) {
        page--;
        ajaxLoadTopic();
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


function ajaxLoadTopic() {
    $('#Topics').load('source/query.php?offset=' + (page - 1) * 20 +'&amount=20');
}