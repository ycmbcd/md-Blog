<?php
    function make_header($blog_conf, $path){
        
        // 读取 header.htm
        $header = read_file($path.'tpl/header.htm');
        
        $header = str_replace("{blog_name}",$blog_conf['blog_name'],$header);
        $header = str_replace("{blog_info}",$blog_conf['blog_info'],$header);

        // 生成 header.html
        write_file($path."/blog/header.html", $header);
    }
    