<?php
    require_once('./write_file.php');

    if(isset($_POST['save_conf'])){
        $arr = $_POST;
        $arr['save_conf'] = date('Y-m-d H:i:s',time());
        $json = json_encode($arr);
        // 写入
        $file = '../../data/blog.json';
        write_file($file, $json);
        echo 'OK';
    }
    