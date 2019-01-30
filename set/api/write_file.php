<?php
    function write_file($file, $data){
        $fp = fopen($file, "w+");   // 写入文件路径
        fwrite($fp, $data); // 写入文件
        fclose($fp);
    }
    