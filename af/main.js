var FadeTime = 300;

var page = 1;

var ajaxFinished = false;

// DOM事件
{
    // 删除主题
    $('#Delete-Topic').click(function () {
        $('#Delete-Topic-Validate').fadeToggle(FadeTime);
        $('#Password-Delete').val('');
    });
    // 刷新主题页
    $('#Refresh-Topic').click(function () {
        LoadComments(tid);
    });
    // 回复
    $('#Reply').click(function () {
        Write($('#TID').text());
    });
    // 编辑主题
    $('#Edit-Topic').click(function () {
        Write($('#TID').text(), 1);
    });
}


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

    $('#Title-Write').css('width', width - 140 - 48 + 'px');

    $('#Nick').css('width', (width - 140 - 240) / 2 + 'px');
    $('#Password').css('width', (width - 140 - 360) / 2 + 'px');

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
    $('#Comments').fadeOut(FadeTime, function() {
        $('.toolbar-button').addClass('hide');
    });
}

var tid = 0;
var isEdit = 0;
/**
 * @param _isEdit 0: 新, _tid != 0 为发表回复指定主题id, _tid == 0 为发表主题
 *                1: 编辑主题, _tid为要编辑的主题id
 *                2: 编辑回复, _tid为要编辑的回复id (见topic.php: <div class="hide cid">'.$row2["ID"].'</div>)
 */
function Write(_tid, _isEdit) {
    var $pw_label = $('#Password-Label');
    switch (_isEdit) {
        case undefined:
        case 0:
            $pw_label.html('管理密码<span class="small">(可留空, 但将无法编辑删除)</span>');
            break;
        default:
            $pw_label.html('请验证密码');
            break;
    }

    $('#Write').fadeIn(FadeTime);

    tid = _tid == undefined ? 0 : _tid;
    isEdit = _isEdit;

    $('#Nick').val(getCookie('Nick'));
    $('#Password').val(getCookie('Password'));
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
    $.get('source/query.php?offset=' + (page) * 20 +'&amount=20', function(data) {
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
    var $title = $('#Title-Write');
    var content = $('#Content').val();
    if (!($('#ContentUseHTML').prop('checked'))) {
        content = content.escapeHtml();
    }
    if ($.trim($title.val()) == '') {
        $('#TitleRequired').css('color', '#f00');
        return;
    }

    $.post('source/write.php', {
        Title: $title.val(),
        Content: content,
        Nick: $('#Nick').val(),
        Password: $('#Password').val(),
        Topic: tid,
        IsEdit: isEdit
    }, function (data) {
        if (data == 'Wrong Password') {
            $('#Password').addClass('form-incorrect').focus();
        } else {
            if ((isEdit == 0 && tid != 0)
                || (isEdit == 1)
                || (isEdit == 2)) {
                LoadComments(tid);
            } else {
                ajaxLoadTopics();
            }
        }
    });

    CloseWrite();
    setTimeout(function () {
        $('#Title-Write').val('');
        $('#Content').val('');
    }, FadeTime);
}
function Delete(cid) {
    var pw = $('#Password-Delete').val();
    if (!cid) {
        $.post('source/delete.php', {
            TID: tid,
            Password: pw
        }, function (data) {
            if (data == 'Succeed') {
                CloseComments();
                ajaxLoadTopics();
            } else if (data == 'Failed') {
                $('#Password-Delete').addClass('form-incorrect').focus();
            }
        });
    }
}

function ajaxLoadTopics() {
    $('#Topics').load('source/query.php?offset=' + (page - 1) * 20 +'&amount=20', function() {
        ajaxFinished = true;
    });
}