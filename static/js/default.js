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
        p_indent();
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

    function p_indent(){
        // p 段落开头样式
        var file = '../../data/blog.json';
    
        $.getJSON(file,{random:Math.random()},function(res){
            $("p").addClass(res.p_indent);
        })
    }

    // 列表浮动效果
    $("#article_list").each(function(){
        var _this = this;
        var file = '../../data/blog.json';

        $.getJSON(file,{random:Math.random()},function(res){
            if(res.list_hover == 'None'){
            }else{
                $("#article_list .box").addClass(res.list_hover).addClass('list_hover');
            }
        })
    })

    // 访客读取
    $('#visitor_num').each(function(){
        var _this = this;
        var file = '../../data/visitor';

        $.getJSON(file,{random:Math.random()},function(res){
            $('#visitor_num').text(res);
        })
    })

    // 访问统计、fork_me
    var blog_name = '';

    $.getJSON('../../data/blog.json',{random:Math.random()},function(res){
        blog_name = res.blog_name;
        if(res.fork_me != '-'){
            var fork_me = '<a href="'+res.github+'" target="_blank"><img src="/static/images/'+res.fork_me+'.png"></a>';
            $('.fork_me').html(fork_me);
        }
        b_color = res.b_color;
    })
    tz = 'md-Blog' + blog_name;
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

    // 分页阴影
    $(".page_bar li").each(function(){
        var _this = $(this);
        var file = '../../data/blog.json';

        $.getJSON(file,{random:Math.random()},function(res){
            if(res.page_hover == 'None'){
            }else{
                _this.addClass(res.page_hover);
            }
        })
    })
});
