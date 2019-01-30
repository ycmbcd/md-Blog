<?php
    // 读取 list.json
    function make_list(){
        $file = "../../data/list.json";
        $fp = fopen($file, "r");
        $data = fread($fp,filesize($file));
        fclose($fp);
        
        $items = json_decode($data, true);

        // 生成 side_list.html
        $strs = '';
        $list_side_names = array();
        $list_names = array();
        foreach($items as $val){
            if(in_array($val['list_name'], $list_names)){
                
            }else{
                $list_names[] = $val['list_name'];
            }

            $list_side_names[] = $val['list_name'].'$'.$val['list_id'];
        }

        $arr_count = array_count_values($list_side_names);

        foreach($arr_count as $key => $val){
            $name_arr = explode('$',$key);
            $strs = $strs.'<li class="box"><a href="/blog/'.$name_arr[1].'/1.html">'.$name_arr[0].' ['.$val.']</a></li>';
        }

        // 读取 blog 参数
        $json_string = file_get_contents('../../data/blog.json'); 
        $blog_conf = json_decode($json_string, true);

        $blog_conf['my_info'] = str_replace('\r', '<br>', $blog_conf['my_info']);

        // bview + ipc
        $bd_code = '';
        $blog_ipc = '';
        if($blog_conf['bd_status'] == 'on'){
            $bd_code = '<li class="box b-info"><a href="http://tongji.baidu.com" target="_blank" rel="nofollow noopener">百度统计</a>'.$blog_conf['bd_code'].'</li>';
        }
        if($blog_conf['blog_ipc'] !== ''){
            $blog_ipc = '<li class="box b-info"><a href="http://www.miitbeian.gov.cn/" target="_blank" rel="nofollow noopener">'.$blog_conf['blog_ipc'].'</a></li>';
        }
        if($bd_code == '' and $blog_ipc == ''){
            $b_info = '';
        }else{
            $b_info = '<div class="b-box boxes">'.$blog_ipc.$bd_code.'</div>';
        }
 
        $side_list = '
        <div class="boxes b-box">
            <div class="box"><h3>'.$blog_conf['my_name'].'</h3></div>
            <textarea readonly class="my_info box gray">'.$blog_conf['my_info'].'</textarea>
            <hr style="margin-top:0;">
            <div class="form-group">
                <form action="/set/api/search.php">
                    <input type="search" autocomplete="off" name="t" placeholder="搜索" class="search_txt form-field f_left">
                    <div class="f_left">
                        <button class="search_btn" type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </form>
                <div class="clear"></div>
            </div>
        </div>
        <br>
        <div class="b-box boxes">'.$strs.'</div>
        <br>
        '.$b_info;

        // 生成 side_list.html
        write_file("../../blog/side_list.html", $side_list);
        echo '[ok] 生成列表';echo '<br>';

        // 读取 list.htm
        $list_tpl = read_file("../../tpl/list.htm");

        // 替换 header
        $header = read_file("../../blog/header.html");
        $list_tpl = str_replace("{header}",$header,$list_tpl);

        // 替换 side_list
        $side_list = read_file("../../blog/side_list.html");
        $list_tpl = str_replace("{side_list}",$side_list,$list_tpl);

        // 加载主题色
        $list_tpl = str_replace("{b_color}",$blog_conf['b_color'],$list_tpl);
        
        $strs = '';

        foreach($list_names as $list){
            $item_str = '';
            $list_id = 0;
            $list_arr = array();
            
            foreach($items as $item){
                if($item['list_name'] === $list){
                    $list_id = $item['list_id'];
                    array_push($list_arr, $item);
                    $str = json_encode($list_arr);
                    $list_json_dir = '../../blog/'.$list_id.'/list.json';
                    write_file($list_json_dir, $str);
                }
            }

            // 根据 list.json 生成列表
            $str = read_file("../../blog/".$list_id."/list.json");
            $now_list = json_decode($str, true);

            // 分页
            $res = page_arr($now_list);
            $page_arr = $res['page_arr'];
            $total_page = $res['total_page'];

            // 生成页面
            $path = '../../blog/'.$list_id.'/';
            $title = $list;
            make_list_page($page_arr, $title, $list_tpl, $total_page, $path);
        }
    }
