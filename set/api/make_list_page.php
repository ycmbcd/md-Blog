<?php
    function make_list_page($page_arr, $title, $tpl, $total_page, $path){    //当页数据、标题、模板、总页数（生成page_bar）、生成路径
        foreach($page_arr as $key => $page){
            $item_str = '';
            foreach($page as $item){
                $item_str = $item_str.'<li class="box"><a target="_blank" href="'.$item['url'].'">
                <div class="box_title">'.$item['title'].'</div>
                <p class="box_info">'.$item['arc_info'].'</p></a>
                <div class="box_bottom gray">
                    <div class="f_left">
                        <i class="fa fa-clock-o fa-fw"></i> '.date("Y-m-d H:i:s",$item['file_mtime']).'&nbsp;&nbsp;
                        <i class="fa fa-feed fa-fw"></i> '.date("Y-m-d H:i:s",$item['file_ctime']).'
                    </div>
                    <div class="f_right">
                    分类：'.$item['list_name'].'</span></span>&nbsp;/
                    浏览：<span class="click_num">0<span class="hidden_id">'.$item['id'].'</span>
                    </div>
                    <div class="clear"></div>
                </div></li>';
            }
            $current_page = $key + 1;
            $now_title = $title.'-第'.$current_page.'页';
            $now_tpl = str_replace("{list}",$item_str,$tpl);
            $now_tpl = str_replace("{title}",$now_title,$now_tpl);
            $page_bar = page_bar($current_page, $total_page);
            $now_tpl = str_replace("{page_bar}",$page_bar,$now_tpl);
            $now_page = $path.$current_page.'.html';
            write_file($now_page, $now_tpl);
        }
    }
