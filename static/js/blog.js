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
        $(this).html("<div class=\"code_bar\"></div><ol id=\"copy_"+index+"\"><span class=\"line_num\"></span><li>" + $(this).html().replace(/\n/g,"\n</li><span class=\"line_num\"></span><li>") +"\n</li></ol>");
        
        setTimeout(() => {
            var now_num = $(this).find("li").length;
            var copy_btn = '<div onclick="copy_code(\'copy_'+index+'\')" class="copy_btn" data-clipboard-action="copy" data-clipboard-target="#copy_code"><i class="fa fa-clipboard fa-fw"></i>Copy<div>';
            $(this).find('.code_bar').html(now_num + '&nbsp;lines' + copy_btn);            
        }, 100);
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

    // 打赏调取
    function append_pay(){
        var file = '../../data/blog.json';
    
        $.getJSON(file,{random:Math.random()},function(res){
            if(res.wx_qrcode || res.ali_qrcode){
                $(".pay_box").append('<br><h3 class="tagc pay_txt">'+ res.pay_txt +'</h3><br>');
                $(".pay_box").append('<div class="col-4 pay_item col-offset-1"><img src="'+res.ali_qrcode+'" /></div>');
                $(".pay_box").append('<div class="col-4 pay_item col-offset-2"><img src="'+res.wx_qrcode+'" /></div>');
            }
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
        append_pay();
    }, 100);

});
