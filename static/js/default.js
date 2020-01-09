// 百度收录
(function(){
    var bp = document.createElement('script');
    var curProtocol = window.location.protocol.split(':')[0];
    if (curProtocol === 'https') {
        bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';
    }
    else {
        bp.src = 'http://push.zhanzhang.baidu.com/push.js';
    }
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(bp, s);
})();

$(function(){
    $("a").attr("rel","noopener noreferrer");
    // 总篇数
    var total_num = 0;

    function get_total(){
        $('.side_list .box').each(function(){
            var str = $(this).text();
            reg = /\[(\d+)\]/;
            if(reg.test(str)){
                total_num = parseInt(total_num) + parseInt(RegExp.$1);
            }
        })
        $('#total_num').text(total_num);
    }
    setTimeout(() => {
        get_total();
    }, 100);

    // 加载统计
    $('.click_num').each(function(){
        var _this = $(this);
        var id = _this.find('.hidden_id').text();

        // 检测点击文件
        $.ajax({
            type:"POST",
            url:"../../set/api/click.php",
            cache: false,
            data: "check_file=" + id,
            success: function(res){
                _this.text(res);
            }
        })
    })

    var arr_json = '';
    var file = '../../data/blog.json';
    $.getJSON(file,{random:Math.random()},function(res){
        arr_json = res;
        load_action();
    })

    function load_action(){
        // p 段落开头样式
        $("p").addClass(arr_json.p_indent);
        // 列表浮动效果
        $("#article_list").each(function(){
            if(arr_json.list_hover == 'None'){
            }else{
                $("#article_list .box").addClass(arr_json.list_hover).addClass('list_hover');
            }
        })
        // 访问统计、fork_me
        var blog_name = arr_json.blog_name;
        blog_name = arr_json.blog_name;
        if(arr_json.fork_me != '-'){
            var fork_me = '<a href="'+arr_json.github+'" target="_blank"><img src="/static/images/'+arr_json.fork_me+'.png"></a>';
            $('.fork_me').html(fork_me);
        }
        b_color = arr_json.b_color;
    
        tz = 'md-Blog' + blog_name;

        // 分页阴影
        $(".page_bar li").each(function(){
            var _this = $(this);
            var file = '../../data/blog.json';

            if(arr_json.page_hover == 'None'){
            }else{
                _this.addClass(arr_json.page_hover);
            }
        })

        // 访客统计
        var visitor = sessionStorage[tz];

        if(visitor === undefined){
            sessionStorage.setItem(tz,'Hello md-Blog.');
            $.ajax({
                type: "POST",
                cache: false,
                url: "../../set/api/click.php",
                data: "add_visitor=add"
            })
        }
    }

    // 访客读取
    $('#visitor_num').each(function(){
        var _this = this;
        var file = '../../data/visitor';

        $.getJSON(file,{},function(res){
            $('#visitor_num').text(res);
        })
    })

    // 置顶按钮
    var scroll_top = '<div class="scroll_top"><svg t="1578536579009" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="6483" width="30" height="30"><path d="M93.334 700.269c0-14.331 5.512-27.677 15.529-37.657l365.99-365.34c1.306-1.337 2.417-2.38 3.607-3.234l2.723-2.16c10.703-10.653 23.296-15.888 36.627-15.888 13.571 0 26.26 5.351 35.73 15.053l363.953 367.853c9.813 9.951 15.222 23.238 15.222 37.401 0 13.848-5.25 26.931-14.769 36.832-9.549 9.841-22.867 15.507-36.518 15.506-13.484 0-26.259-5.365-35.969-15.134l-328.283-331.846-336.964 336.081c-9.666 9.607-22.296 14.915-35.619 14.915-13.958 0-27.055-5.673-36.876-15.937-9.271-9.768-14.381-22.734-14.381-36.444z" p-id="6484" fill="#cdcdcd"></path></svg></div>';
    $("body").append(scroll_top);
    $('.scroll_top').click(function () {
        $('html, body').animate({
            scrollTop: 0
        }, 320);
        return false;
    });

    $(window).scroll(function(){
        if($(document).scrollTop() > 400){
            $('.scroll_top').fadeIn();
        }
        if($(document).scrollTop() < 400){
            $('.scroll_top').fadeOut();
        }
    })
});
