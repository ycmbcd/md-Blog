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

});
