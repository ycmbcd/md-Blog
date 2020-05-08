<?php
    // 遍历目录
    function read_md($dir){
        // setlocale(LC_ALL, 'zh_CN.GBK'); // windows
        setlocale(LC_ALL, 'zh_CN.UTF8'); // linux

        if(!is_dir($dir)) return false;
        $handle = opendir($dir);
        $dir_names = [];
        $index = 0;
        if($handle){
            while(($fl = readdir($handle)) !== false){
                $temp = $dir.DIRECTORY_SEPARATOR.$fl;
                if(is_dir($temp) && $fl!='.' && $fl != '..'){
                    $dir_names[$index]['name'] = basename($temp);
                    $dir_names[$index]['ctime'] = filectime($temp);
                    $dir_names[$index]['dir'] = $temp;
                    $index = $index + 1;
                }
            }
        }

        // 根据目录创建时间排序
        array_multisort(array_column($dir_names,'ctime'),SORT_DESC,$dir_names);

        // 创建目录
        for($i=0;$i<$index;$i++){
            $dir_name = $i + 1;
            $dir = '../../blog/'.$dir_name;
            make_dir($dir);
        }

        // 读取 md 生成 html 文件
        read_item($dir_names);

    }
    