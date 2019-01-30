<?php
    function make_index($blog_conf){

        $file = '../../index.html';
        $title = $blog_conf['blog_name'];
        // 读取 blog 参数
        $json_string = file_get_contents('../../data/blog.json'); 
        $blog_conf = json_decode($json_string, true);
        $arc_top_title = $blog_conf['arc_top_title'];
        
        // 读取 list.json
        $blog_list = read_file("../../data/list.json");
        $arr_list = json_decode($blog_list, true);

        // 置顶
        foreach($arr_list as $key => $val){
            if($val['title'] == $arc_top_title){
                $arr_list[$key]['title'] = '【置顶】'.$arr_list[$key]['title'];
                $arr = $arr_list[$key];
                unset($arr_list[$key]);
                array_unshift($arr_list, $arr);
            }
        }

        // 分页
        $res = page_arr($arr_list);
        $page_arr = $res['page_arr'];
        $total_page = $res['total_page'];

        // 读取 index.htm
        $index_tpl = read_file("../../tpl/index.htm");

        // 替换 header
        $header = read_file("../../blog/header.html");
        $index_tpl = str_replace("{header}", $header, $index_tpl);

        // 替换 side_list
        $side_list = read_file("../../blog/side_list.html");
        $index_tpl = str_replace("{side_list}", $side_list, $index_tpl);

        // 加载主题色
        $index_tpl = str_replace("{b_color}",$blog_conf['b_color'],$index_tpl);

        del_dir('../../index/');
        make_dir('../../index/');

        // 生成页面
        $path = '../../index/';
        make_list_page($page_arr, $title, $index_tpl, $total_page, $path);

        // 读取 list.htm
        $blog = read_file("../../index/1.html");

        $index = str_replace('class="page_a" href="./', 'class="page_a" href="./index/', $blog);
        write_file($file, $index);
        
        echo '[ok] 生成主页 ['.$file.']';
        echo '<br>';
    }
