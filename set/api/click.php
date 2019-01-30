<?php
    require_once('./read_file.php');
    require_once('./write_file.php');
    if(isset($_POST['click'])){
        $id = $_POST['click'];
        $file = '../../data/click/'.$id;
        if(file_exists($file)){
            // 读取 + 1
            $now_num = read_file($file);
        echo    $click_num = $now_num - 0 + 1;
            // 写入
            write_file($file, $click_num);
        }else{
            // 写入 1
            write_file($file, '1');
        }
    }

    if(isset($_POST['check_file'])){
        $id = $_POST['check_file'];
        $file = '../../data/click/'.$id;
        if(file_exists($file)){
        }else{
            // 写入 0
            write_file($file, '0');
        }
        $now_num = read_file($file);
        echo $now_num;
    }
    
    // 访客统计
    if(isset($_POST['add_visitor'])){
        $file = '../../data/visitor';
        if(file_exists($file)){
            // 读取 + 1
            $now_num = read_file($file);
            $visitor = $now_num - 0 + 1;
            // 写入
            write_file($file, $visitor);
        }else{
            // 写入 1
            write_file($file, '1');
        }
    }
