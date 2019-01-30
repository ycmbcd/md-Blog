<?php
function make_search(){
    $file = "../../blog/search.html";

    // 读取配置
    $json_string = file_get_contents('../../data/blog.json'); 
    $blog_conf = json_decode($json_string, true);

    // 读取 search.htm
    $search_tpl = read_file("../../tpl/search.htm");

    // 替换 header
    $header = read_file("../../blog/header.html");
    $search_tpl = str_replace("{header}", $header, $search_tpl);

    // 替换 side_list
    $side_list = read_file("../../blog/side_list.html");
    $search_tpl = str_replace("{side_list}", $side_list, $search_tpl);

    // 替换标题
    $search_tpl = str_replace("{title}", $blog_conf['blog_name'], $search_tpl);

    // 加载主题色
    $search_tpl = str_replace("{b_color}",$blog_conf['b_color'],$search_tpl);

    write_file($file, $search_tpl);
}
