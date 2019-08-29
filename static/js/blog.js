hljs.initHighlightingOnLoad();
function copy_code(id){
    var copy_val = $("#"+id).text();
    $("#copy_code").val(copy_val);
}

function alert_msg(type,txt){
    $("#msg_box").removeClass().addClass(type).fadeIn(300);
    $("#msg_txt").text(txt);
    setTimeout(() => {
        $("#msg_box").fadeOut(300);
    }, 2000);
}

$(function(){
    // 空白页打开
    $('.b-body').find('a').attr("target","_blank");

    // code 行号
    $('pre code').each(function(index){
        $(this).html("<ol id=\"copy_"+index+"\"><span class=\"line_num\"></span><li>" + $(this).html().replace(/\n/g,"\n</li><span class=\"line_num\"></span><li>") +"\n</li></ol>");
        $(this).parent().append('<div class=\"code_bar\"><div onclick="copy_code(\'copy_'+index+'\')" class="copy_btn" data-clipboard-action="copy" data-clipboard-target="#copy_code"><i class="fa fa-clipboard fa-fw"></i>Copy<div></div>');
    });

    var clipboard = new ClipboardJS('.copy_btn');
    clipboard.on('success', function(e) {
        alert_msg('msg_success','已复制到剪贴板');
        e.clearSelection();
    });

    // 调取侧栏
    $('.side_list').load('../../blog/side_list.html');

    // 访问 +1
    var now_url = window.location.pathname;
    var now_id = now_url.match(/\/\d+.html$/g);
    if(now_id != null){
        now_id = now_id.toString().replace(/\//,'').replace(/.html/,'');
        $.ajax({
            type:"POST",
            cache: false,
            url:"../../set/api/click.php",
            data: "click=" + now_id
        })
    }

    setTimeout(() => {
        $('.click_number').each(function(){
            var _this = $(this);
            var now_url = window.location.pathname;
            var now_id = now_url.match(/\/\d+.html$/g).toString().replace(/\//,'').replace(/.html/,'');
            var file = '../../data/click/'+now_id;
            $.getJSON(file,{random:Math.random()},function(res){
                o_num = res - 1;
                _this.text('浏览：' + o_num);
                setTimeout(() => {
                    _this.text('浏览：' + res);
                }, 1000);
            })
        })
    }, 100);

    // right_nav 右侧悬浮文章导航
    var right_nav = '';
    $('#blog_body h1').each(function(e){
        e = e + 1;
        $(this).attr('id', 'bt_' + e);
        // $(this).attr('name', 'bt_' + e);
        right_nav = right_nav + '<li class="box"><a class="right_nav_item" href="#bt_' + e + '"> ' + $(this).text() + '</a></li>';
    })
    if(right_nav !== ''){
        right_nav = '<br><div id="right_nav" class="b-box boxes">' + right_nav + '</div>';
        setTimeout(function(){
            // 追加到右侧栏
            $('.side_list').append(right_nav);
            // 钉住
            $('#right_nav').pin({minWidth: 940, padding:{top: 20}});
            // 平滑滚动
            $('.right_nav_item').click(function () {
                $('html, body').animate({
                    scrollTop: $($.attr(this, 'href')).offset().top
                }, 500);
                return false;
            });
            var pin_height = $('.pin-wrapper').height();
            var win_height = $(window).height();
            var right_height = win_height - 50;
            if(pin_height > win_height){
                $('#right_nav').css({'height': right_height, 'overflow': 'auto'});
            }
        }, 300);
    }
});
