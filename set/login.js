$(document).keypress(function(e) {
    // 回车登录
    if(e.which == 13){
        login_blog();
    }
})

function save_init(){
    var blog_pwd = $("#blog_pwd").val();
    $.post("./index.php",{pwd:blog_pwd},function(res){
        if(res === 'ok'){
            history.go(0);
        }else{
            alert('密码保存失败，无法继续！');
        }
    });
}

function ck_pwd(){
    var blog_pwd = $("#blog_pwd").val();
    if(blog_pwd!=''){
        $("#init_ok").fadeIn(300);
    }else{
        $("#init_ok").fadeOut(300);
    }
}

function login_blog(){
    var blog_pwd = $("#blog_pwd").val();
    $.post("./index.php",{login:blog_pwd},function(res){
        if(res === 'ok'){
            window.location.href = './admin.html';
        }else{
            alert_msg('msg_danger','密码错误，请重试！');
        }
    });
}

function alert_msg(type,txt){
    $("#msg_box").removeClass().addClass(type).fadeIn(300);
    $("#msg_txt").text(txt);
    setTimeout(() => {
        $("#msg_box").fadeOut(300);
    }, 2000);
}