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
            $blog_ipc = '<li class="box b-info"><a href="http://beian.miit.gov.cn/" target="_blank" rel="nofollow noopener">'.$blog_conf['blog_ipc'].'</a></li>';
        }
        if($bd_code == '' and $blog_ipc == ''){
            $b_info = '';
        }else{
            $b_info = '<div class="b-box boxes">'.$blog_ipc.$bd_code.'</div>';
        }
        
        // 搜索引擎
        $side_list = '
        <div class="boxes b-box">
            <div class="box"><h3>'.$blog_conf['my_name'].'</h3></div>
            <textarea readonly class="my_info box gray">'.$blog_conf['my_info'].'</textarea>
            <hr style="margin-top:0;">
            <div class="form-group">
                <form action="/set/api/search.php">
                    <input type="search" autocomplete="off" name="t" id="bd_txt" placeholder="请输入关键字" class="search_txt form-field" />
                    <button class="f_left search_btn pointer" type="submit"><i class="fa fa-search"></i> 搜索</button>
                    <div onclick="bd_search()" class="f_left icon pointer bd_search_btn">
                        <svg t="1578460261835" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1786" width="20" height="22"><path d="M184.682058 538.758771c111.176877-23.873478 96.029086-156.736593 92.70169-185.775677-5.444828-44.768588-58.101436-123.020542-129.605526-116.831122-89.979276 8.074168-103.125977 138.051991-103.125977 138.051991-12.169424 60.079258 29.132158 188.451554 140.029813 164.554808z m118.064352 231.102709c-3.25759 9.330667-10.51736 33.227413-4.234867 54.029449 12.402109 46.676604 52.912561 48.770769 52.912562 48.770769h58.217778V730.351572h-62.336302c-28.01527 8.35339-41.534266 30.155972-44.559171 39.509908z m88.280676-453.898564c61.405563 0 111.037266-70.666424 111.037266-158.039629 0-87.280131-49.631703-157.923287-111.037266-157.923287-61.312489 0-111.060534 70.643156-111.060534 157.923287 0 87.373205 49.771314 158.039629 111.060534 158.039629z m264.469733 10.447555c82.067988 10.656971 134.840938-76.92565 145.33503-143.310671 10.703508-66.291947-42.25559-143.287402-100.357026-156.527177-58.217779-13.356117-130.908562 79.904017-137.540084 140.704599-7.911289 74.319578 10.633703 148.59262 92.56208 159.133249z m201.086348 390.212688s-126.976186-98.239593-201.109617-204.413743c-100.473368-156.550445-243.202327-92.841302-290.949282-13.216506-47.537539 79.601527-121.624432 129.954554-132.141792 143.287403-10.68024 13.123432-153.38593 90.165424-121.694237 230.870023 31.668424 140.611525 142.938375 137.935648 142.938374 137.935648s81.998182 8.074168 177.119797-13.216506c95.168151-21.104526 177.096528 5.25868 177.096528 5.258681s222.283948 74.435921 283.107798-68.851482c60.754045-143.333939-34.36757-217.653518-34.367569-217.653518z m-380.323578 213.255772h-144.520632c-62.406108-12.448646-87.256862-55.029995-90.39811-62.289765-3.071442-7.376113-20.802036-41.604072-11.424832-99.845119 26.968188-87.256862 103.870569-93.516088 103.870569-93.516088h76.92565v-94.563171l65.524087 1.000546v349.213597z m269.146701-1.000545h-166.299946c-64.453736-16.613707-67.455372-62.406108-67.455371-62.406108v-183.890929l67.455371-1.093619v165.276131c4.118524 17.63752 26.014179 20.825304 26.01418 20.825305h68.525722v-185.007817h71.760044v246.297037z m235.40738-490.988548c0-31.761498-26.386475-127.395019-124.230503-127.395019-98.006908 0-111.107071 90.258498-111.107072 154.060716 0 60.893656 5.142338 145.893474 126.883112 143.194329 121.787311-2.699146 108.454463-137.935648 108.454463-169.860026z m0 0" fill="#348fe2" p-id="1787"></path></svg>&nbsp;
                    </div>
                    <div onclick="bd_search()" class="bd_search_txt pointer">百度站内搜索</div>
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
