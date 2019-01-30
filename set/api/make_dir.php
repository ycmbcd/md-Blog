<?php
    // 生成目录
    function make_dir($dir){
        mkdir ($dir, 0755, true);
        chmod ($dir, 0755);
    }
    