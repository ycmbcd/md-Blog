<?php
    if(isset($_GET['t'])){
        sleep(1);
        $tpl = file_get_contents('../../blog/search.html');
        $search_txt = addslashes($_GET['t']);
        $json_string = file_get_contents('../../data/list.json'); 
        $list = json_decode($json_string, true);

        $res = '搜索<span style="color:#348fe2;"> '.$search_txt.' </span>的结果：<hr>';
        $total_num = 0;
        foreach($list as $item){
            $now_title = $item['title'];
            $now_url = $item['url'];
            $c_time = date("Y-m-d H:i:s",$item['file_ctime']);
            if(strpos($now_title, $search_txt) !== false){
                $total_num = $total_num + 1;
                $res = $res.
                '<div>
                    <div class="f_left">
                        <h4>
                            <a href="'.$now_url.'" target="_blank">'.$now_title.'</a>
                        </h4>
                    </div>
                    <div class="f_right">
                    分类：'.$item['list_name'].'<br>
                    创建日期：'.$c_time.'</div>
                    <div class="clear"></div>
                </div>
                <hr>';
            }
        }
        echo $tpl = str_replace('{list}', $res, $tpl);
    }
