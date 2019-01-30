<?php
    function page_arr($list_json){
        // 读取配置
        $blog_conf = json_decode(read_file("../../data/blog.json"), true);

        // 分页数
        $one_page_num = $blog_conf['page_size'];  // 每页显示数
        $total_page = ceil(count($list_json) / $one_page_num);

        $page_arr = array();

        for($i=0; $i<$total_page; $i++){
            $page_arr[] = array_slice($list_json, $i * $one_page_num, $one_page_num);         
        }
        $final_arr['page_arr'] = $page_arr;
        $final_arr['total_page'] = $total_page;
        return $final_arr;
    }

    function page_bar($current_page,$total_page){
        $str = '';

        for($i=0; $i<$total_page; $i++){
            $page = $i + 1;
            if($total_page > 9){
                $show_page = array();
                $show_page[] = $current_page;
                $show_page[] = $current_page + 1;
                $show_page[] = $current_page + 2;
                $show_page[] = $current_page + 3;
                $show_page[] = $current_page - 1;
                $show_page[] = $current_page - 2;
                $show_page[] = $current_page - 3;
                $show_page[] = 1;
                $show_page[] = $total_page;

                if($page === $current_page){
                    $str = $str.'<li class="page_active">'.$page.'</li>';
                }elseif(in_array($page, $show_page)){
                    $str = $str.'<a class="page_a" href="./'.$page.'.html"><li class="page_item">'.$page.'</li></a>';
                }else{
                    $str = $str.'<li class="page_dot">...</li>';
                }
            }else{
                if($page === $current_page){
                    $str = $str.'<li class="page_active">'.$page.'</li>';
                }else{
                    $str = $str.'<a class="page_a" href="./'.$page.'.html"><li class="page_item">'.$page.'</li></a>';
                }
            }
        }
        
        // 格式化 dot
	 	$dot_count = substr_count($str,'<li class="page_dot">...</li>');
        $replace_line = '<li class="page_dot">...</li><li class="page_dot">...</li>';
        for($i=0; $i<$dot_count; $i++){
            $str = str_replace($replace_line,'<li class="page_dot">...</li>',$str);
        }

        // 上一页、下一页
        $pre_page = 0;
        $next_page = 0;
        $pre = $current_page - 1;
        $next = $current_page + 1;
        $pre_page = '<a class="page_a" href="./'.$pre.'.html"><li class="page_item">上一页</li></a>';
        $next_page = '<a class="page_a" href="./'.$next.'.html"><li class="page_item">下一页</li></a>';
        if($current_page == 1 and $current_page < $total_page){
            $str = $str.$next_page;
        }elseif($current_page == 1 and $total_page == 1){
            // Do Nothing
        }elseif($current_page == $total_page){
            $str = $pre_page.$str;
        }else{
            $str = $pre_page.$str.$next_page;
        }

        return $str;
    }
