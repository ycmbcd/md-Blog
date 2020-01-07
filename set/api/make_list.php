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
        
        // 原搜索引擎
        $side_list = '
        <div class="boxes b-box">
            <div class="box"><h3>'.$blog_conf['my_name'].'</h3></div>
            <textarea readonly class="my_info box gray">'.$blog_conf['my_info'].'</textarea>
            <hr style="margin-top:0;">
            <div class="form-group">
                <form action="/set/api/search.php">
                    <input type="search" autocomplete="off" name="t" id="bd_txt" placeholder="搜索" class="search_txt form-field f_left">
                    <div class="f_left">
                    <button class="search_btn" type="submit"><i class="fa fa-search"></i></button>
                    <svg t="1578387064595" onclick="bd_search()" class="icon pointer bd_search_btn" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2901" width="26" height="26"><path d="M226.522 536.053c96.993-20.839 83.792-136.761 80.878-162.089-4.758-39.065-50.691-107.346-113.075-101.952-78.499 7.036-89.957 120.445-89.957 120.445C93.748 444.857 129.764 556.857 226.522 536.053zM329.512 737.61c-2.848 8.175-9.18 29.014-3.686 47.173 10.822 40.707 46.168 42.55 46.168 42.55l50.792 0L422.786 703.169 368.41 703.169C343.952 710.473 332.159 729.468 329.512 737.61zM406.537 341.666c53.572 0 96.859-61.646 96.859-137.9 0-76.12-43.287-137.767-96.859-137.767-53.472 0-96.892 61.646-96.892 137.767C309.645 280.019 353.065 341.666 406.537 341.666zM637.241 350.779c71.598 9.281 117.632-67.141 126.777-125.035 9.349-57.827-36.854-125.036-87.544-136.561-50.791-11.659-114.213 69.688-119.976 122.757C549.597 276.803 565.779 341.566 637.241 350.779zM812.666 691.174c0 0-110.761-85.701-175.425-178.305-87.645-136.593-212.177-81.011-253.822-11.558-41.478 69.452-106.106 113.375-115.286 125-9.314 11.458-133.813 78.666-106.173 201.423 27.64 122.69 124.7 120.345 124.7 120.345s71.53 7.036 154.519-11.524c83.021-18.428 154.484 4.59 154.484 4.59s193.919 64.929 246.988-60.072C895.655 756.037 812.666 691.174 812.666 691.174zM480.881 877.253 354.807 877.253c-54.443-10.855-76.12-48.044-78.867-54.343-2.68-6.433-18.125-36.317-9.951-87.109 23.52-76.12 90.627-81.614 90.627-81.614l67.107 0 0-82.485 57.157 0.871L480.88 877.253zM715.674 876.382l-145.07 0c-56.219-14.508-58.866-54.444-58.866-54.444L511.738 661.49l58.866-0.938 0 144.199c3.586 15.345 22.682 18.159 22.682 18.159l59.771 0L653.057 661.49l62.618 0L715.675 876.382zM921.051 448.006c0-27.708-23.018-111.13-108.385-111.13-85.501 0-96.925 78.732-96.925 134.382 0 53.136 4.489 127.313 110.695 124.935C932.677 593.846 921.051 475.881 921.051 448.006z" p-id="2902" fill="#348fe2"></path></svg>
                    </div>
                    <div class="clear"></div>
                </form>
                <div class="clear"></div>
            </div>
        </div>
        <script>
            function bd_search(){
                var bd_txt = document.getElementById("bd_txt").value;
                var site_url = window.location.host;
                window.open("https://www.baidu.com/s?wd=inurl:"+site_url+" "+bd_txt);
            }
        </script>
        <br>
        <div class="b-box boxes">'.$strs.'</div>
        <br>
        '.$b_info;

        // // 百度搜索引擎
        // $side_list = '
        // <div class="boxes b-box">
        //     <div class="box"><h3>'.$blog_conf['my_name'].'</h3></div>
        //     <textarea readonly class="my_info box gray">'.$blog_conf['my_info'].'</textarea>
        //     <hr style="margin-top:0;">
        //     <div class="form-group">
        //         <input type="search" autocomplete="off" id="bd_txt" placeholder="搜索" class="search_txt form-field f_left">
        //         <div class="f_left">
        //             <button class="search_btn" onclick="bd_search()"><i class="fa fa-search"></i></button>
        //         </div>
        //         <div class="clear"></div>
        //     </div>
        // </div>
        
        // <br>
        // <div class="b-box boxes">'.$strs.'</div>
        // <br>
        // '.$b_info;

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
        
        // Google Adsense
        if($blog_conf['gad_status'] == 'on'){
            $gad_code = $blog_conf['gad_code'];
        }else{
            $gad_code = '';
        }
        $list_tpl = str_replace("{google_adsense}",$gad_code,$list_tpl);
        
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
