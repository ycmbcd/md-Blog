<?php
    function clear_cache(){

        // 读取 list.json
        $list_json = read_file('../../data/list.json');
        $list_arr = json_decode($list_json, true);
        $arr_id = array();
        foreach($list_arr as $val){
            $arr_id[] = $val['id'];
        }

        // 获取 /data/click 目录下所有文件名
        $click_arr = scandir('../../data/click/');
        unset($click_arr[0]);   // .
        unset($click_arr[1]);   // ..
        $del_arr = array_diff($click_arr, $arr_id);
        foreach($del_arr as $del){
            $del_click = '../../data/click/'.$del;
            unlink($del_click);
            echo '[ok] 清理缓存 /data/click/'.$del;
            echo '<br>';
        }
        echo '>> 结束';
    }
