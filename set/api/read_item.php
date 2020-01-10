<?php

    // 遍历文件
    function read_item($dir_arr){
        // setlocale(LC_ALL, 'zh_CN.GBK'); // windows
        setlocale(LC_ALL, 'zh_CN.UTF8'); // linux

        $b_list = array();

        $md_id = 0; 
        $md_arr = [];
        // 遍历目录
        foreach($dir_arr as $key => $dir_f){
            $dir = $dir_f['dir'];
            $handle = opendir($dir);
            $list_id = $key + 1;

            if($handle){
                while(($fl = readdir($handle)) !== false){
                    $temp = $dir.DIRECTORY_SEPARATOR.$fl;
                    if(is_dir($temp) && $fl!='.' && $fl != '..'){
    
                    }else{
                        if($fl!='.' && $fl != '..' && $fl != '.DS_Store'){

                            $file_ctime = filectime($temp);  // 文件创建时间
                            $file_mtime = filemtime($temp);  // 文件修改时间
                            $title = basename($temp);
                            $title = str_replace('.md','',$title);
                            
                            // json 索引
                            $md_arr[$md_id]['title'] = $title;
                            $md_arr[$md_id]['file_ctime'] = $file_ctime;
                            $md_arr[$md_id]['file_mtime'] = $file_mtime;
                            $md_arr[$md_id]['list_id'] = $list_id;
                            $md_arr[$md_id]['list_name'] = str_replace('../../md/', '', $dir);
                            $md_arr[$md_id]['md_dir'] = $temp;
                            $md_arr[$md_id]['id'] = $file_ctime.rand(1000,9999);
                            $now_url = '/blog/html/'.$md_arr[$md_id]['id'].'.html';
                            $md_arr[$md_id]['url'] = $now_url;
                            $md_id = $md_id + 1;
                        }
                    }
                }
            }
        }

        $json_list = '../../data/list.json';
        
        if(file_exists($json_list)){
            // 读取 list.json
            $json_str = read_file($json_list);
            $data = json_decode($json_str, true);

            foreach($data as $o_val){
                
                foreach($md_arr as $md_key => $md_val){
                    $now_item = array();

                    if($md_val['md_dir'] === $o_val['md_dir']){   // 如果存在该 md
                        $now_item['title'] = $md_val['title'];  // 更新标题
                        $now_item['url'] = '/blog/html/'.$o_val['id'].'.html';    // 更新 URL
                        $now_item['list_id'] = $md_val['list_id'];  // 更新 list_id
                        $now_item['file_mtime'] = $md_val['file_mtime'];    // 更新更新时间
                        $now_item['file_ctime'] = $o_val['file_ctime']; // 创建时间保留
                        $now_item['id'] = $o_val['id'];    // id保留
                        $now_item['md_dir'] = $o_val['md_dir'];    // 保留目录
                        $now_item['list_name'] = $o_val['list_name'];  // 保留 list_name
                        unset($md_arr[$md_key]);
                        array_push($b_list, $now_item);
                    }
                }
            }
            $b_list = array_merge($b_list,$md_arr);
        }else{
            $b_list = $md_arr;
        }

        // 根据最后修改时间排序
        array_multisort(array_column($b_list,'file_mtime'),SORT_DESC,$b_list);

        // 生成站点地图
        $site_map = "<!DOCTYPE html><html><head><meta charset='utf-8' /><title>网站地图</title><style>a{color:rgb(0, 0, 238);font-size:13px;}</style></head><body><ol>";

        // https 还是 http 判断

        $now_http = '';
        if ( !empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
            $now_http = 'https://';
        } elseif ( isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) {
            $now_http = 'https://';
        } elseif ( !empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
            $now_http = 'http://';
        }

        // 生成 html
        foreach($b_list as $key => $item){
            make_html($item['md_dir'], $item['id'], $item['title'], $item['list_id'], $item['list_name'], $item['file_ctime'], $item['file_mtime']);
            $now_path = '/blog/html/'.$item['id'].'.html';
            echo '[ok] 生成 blog:《'.$item['title'].'》=> '.$now_path;
            echo '<br>';
            // 生成摘要
            $html = file_get_contents('../../'.$now_path);
            $arc_arr = explode(' <span style="display: none;">不要删除</span>',$html);
            $arc_info = strip_tags(stripslashes($arc_arr[1]));
            $arc_info = trim($arc_info);
            $arc_info = mb_strcut($arc_info,0,420,'utf-8');
            $b_list[$key]['arc_info'] = $arc_info;
            // 站点地图
            $site_map = $site_map."<li><a href='".$now_http.$_SERVER['SERVER_NAME'].$now_path."'>".$item['title']."</a></li>";
        }
        $site_map = $site_map."</ol>
        <p>Powered by <a target='_blank' href='https://github.com/ycmbcd/md-Blog'> md-Blog</a></p></body>
        </html>";
        write_file('../../Sitemap.html', $site_map);
        echo '[ok] 生成网站地图<br>';
        // 保存到 list.json
        $json = json_encode($b_list);
        write_file('../../data/list.json', $json);
    }
    