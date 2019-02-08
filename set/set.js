$(function(){
    // 检测是否登录
    $.ajax({
        type:"POST",
        url:"./index.php",
        cache: false,
        data: "is_login=1",
        success:function(res){
            if(res === 'ok'){
                alert_msg('msg_success','md-Blog 控制台');
            }else{
                window.location.href = './';
            }
        } 
    })
    // 加载配置项
    get_conf();
    $('.header').load('../../blog/header.html');
})

function hide_arc_top(){
    $('.arc_top').css({'display':'none'})
}
function show_arc_top(){
    $('.arc_top').css({'display':'block'})
}

function get_arc(){
    var file = '../../data/list.json';
    
    $.getJSON(file,{random:Math.random()},function(res){
        var html = '';
        res.forEach(e => {
            html = html + '<li onclick="arc_top_me(\''+e.title+'\')">' + e.title + '</li>';
        });
        html = '<ul>' + html + '</ul>';
        $('#arc_list').html(html);
    })
}
// 置顶
function arc_top_me(title){
    $('#arc_top_title').val(title);
    save_conf();
}

// 登出
function logout(){
    $.ajax({
        type:"POST",
        url:"./index.php",
        cache: false,
        data: "logout=1",
        success:function(res){
            if(res === 'ok'){
                window.location.href = './';
            }else{
                alert_msg('msg_danger','登出失败，请重试。');
            }
        } 
    })
}

function cg_code_css(){
    var new_code = '../static/lib/styles/' + $("#code_css").val() + '.css';
    document.getElementById("code_link").setAttribute("href",new_code);
}

function list_demo(){
    var list_hover = $("#list_hover").val();
    $('#list_demo').removeClass().addClass(list_hover);
}

function page_demo(){
    var page_hover = $("#page_hover").val();
    $('#page_demo').removeClass().addClass(page_hover);
}

function p_indent_demo(){
    var p_indent = $("#p_indent").val();
    $('#p_indent_demo').removeClass().addClass(p_indent);

}

function b_color_demo(){
    var color = $("#b_color").val();
    var new_color = '../static/css/color/' + color + '.css';
        document.getElementById("color_link").setAttribute("href",new_color);
}

function get_conf(){
    var file = '../data/blog.json';
    $.getJSON(file,{random:Math.random()},function(res){
        $("#blog_name").val(res.blog_name);
        $("#blog_info").val(res.blog_info);
        $("#blog_ipc").val(res.blog_ipc);
        $("#code_css").val(res.code_css);
        $("#my_info").val(res.my_info);
        $("#my_name").val(res.my_name);
        $("#page_size").val(res.page_size);
        $("#list_hover").val(res.list_hover);
        $("#page_hover").val(res.page_hover);
        $("#p_indent").val(res.p_indent);
        $("#github").val(res.github);
        $("#b_color").val(res.b_color);
        $("#fork_me").val(res.fork_me);
        $("#arc_top_title").val(res.arc_top_title);
        $("input[name='cy_status'][value="+res.cy_status+"]").attr("checked",true);
        $("#cy_appid").val(res.cy_appid);
        $("#cy_conf").val(res.cy_conf);
        $("#p_indent_demo").addClass(res.p_indent);
        $('#list_demo').addClass(res.list_hover);
        $('#page_demo').addClass(res.page_hover);
        $("input[name='bd_status'][value="+res.bd_status+"]").attr("checked",true);
        $("#bd_code").val(res.bd_code);
        $("#gad_code").val(res.gad_code);
        $("input[name='gad_status'][value="+res.gad_status+"]").attr("checked",true);
        $("#pay_txt").val(res.pay_txt);
        $("#val_wx_qrcode").val(res.wx_qrcode);
        $("#show_wx_qrcode").attr('src', res.wx_qrcode);
        $("#val_ali_qrcode").val(res.ali_qrcode);
        $("#show_ali_qrcode").attr('src', res.ali_qrcode);
        var new_code = '../static/lib/styles/' + res.code_css + '.css';
        document.getElementById("code_link").setAttribute("href",new_code);
        var new_color = '../static/css/color/' + res.b_color + '.css';
        document.getElementById("color_link").setAttribute("href",new_color);
        if(res.cy_status=='on'){
            $(".cy_box").show();
        }else{
            $(".cy_box").hide();
        }
        if(res.bd_status=='on'){
            $(".bd_box").show();
        }else{
            $(".bd_box").hide();
        }
        if(res.gad_status=='on'){
            $(".gad_box").show();
        }else{
            $(".gad_box").hide();
        }
    })
}

function save_conf(){
    var blog_conf = $("#blog_conf").serialize();
    $.ajax({
        type:"POST",
        url:"./api/config.php",
        cache: false,
        data: "save_conf=save&" + blog_conf,
        success:function(res){
            if(res === 'OK'){
                alert_msg('msg_success','保存完成');
            }else{
                alert_msg('msg_danger', res);
            }
        } 
    })
}

function hide_info(){
    $("#run_info").hide(100);
}

function make_html(){
    hide_info();
    $("#make_status").text('生成中，请稍等 ...');
    setTimeout(function(){
        $.post("./api/run.php",{run:'start'},function(res){
            var close = '<br><button onclick="hide_info()" class="btn danger col-4 col-offset-4"><i class="fa fa-fw fa-close"></i>关 闭</button><div class="clear"></div><br>';
            $("#run_info").show(100).html(close).append(res).append(close);
            $("#make_status").text('静态生成');
        });
    },1000)
}

function ck_cy(status){
    if(status === 1){
        $(".cy_box").show();
    }else{
        $(".cy_box").hide();
    }
}

function ck_bd(status){
    if(status === 1){
        $(".bd_box").show();
    }else{
        $(".bd_box").hide();
    }
}

function ck_gad(status){
    if(status === 1){
        $(".gad_box").show();
    }else{
        $(".gad_box").hide();
    }
}

// 打赏
function ck_wxpay(){
    uploadImage('wx_qrcode');
}

function ck_alipay(){
    uploadImage('ali_qrcode');
}

function uploadImage(method_id) {
    var imageForm = new FormData();
    imageForm.append("qrImg", $("#"+method_id).get(0).files[0]);
    var url = '../set/api/upload.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: imageForm,
        processData: false,
        contentType: false,
        success: function (data) {
            if(data == 'No File'){
                alert_msg('msg_danger','上传错误，请重试。');
            }else{
                $("#show_" + method_id).attr("src", data);
                $("#val_" + method_id).val(data);
            }
        }
    });
}

function remove_aliqr(){
    $('#ali_qrcode').val('')
    $('#val_ali_qrcode').val('')
    $('#show_ali_qrcode').attr('src','')
}

function remove_wxqr(){
    $('#wx_qrcode').val('')
    $('#val_wx_qrcode').val('')
    $('#show_wx_qrcode').attr('src','')
}