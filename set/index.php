<?php
    session_start();
    require_once('./api/make_dir.php');
    require_once('./api/read_file.php');
    require_once('./api/write_file.php');
    require_once('./api/make_header.php');

    if(isset($_POST['pwd'])){
        if(file_exists("../data/blog.lock"))die;
        $salt = '342X2E354elkg390P45pC';
        $pwd = md5(addslashes($_POST['pwd']),$salt);
        if(!file_exists("../data")) make_dir('../data');
        if(!file_exists("../blog")) make_dir('../blog');
        if(!file_exists("../data/click")) make_dir('../data/click');
        write_file('../data/blog.lock', $pwd);
        usleep(500);
        $init_json = read_file('./init.json');
        if(!file_exists("../data/blog.json")){
            // 初始化数据
            write_file('../data/blog.json', $init_json);
        }
        if(!file_exists("../data/visitor")) write_file('../data/visitor', '1');
       
        $blog_conf = json_decode($init_json, true);
        usleep(500);
        // 生成页头
        make_header($blog_conf, '../');
        echo 'ok';
        return false;
    }

    if(isset($_POST['login'])){
        $pwd = addslashes($_POST['login']);
        $salt = '342X2E354elkg390P45pC';
        $pwd = md5($pwd,$salt);
        $o_pwd = read_file('../data/blog.lock');
        if($pwd === $o_pwd){
            echo 'ok';
            // 缓存
            $_SESSION['md-Blog'] = 1;
        }
        return false;
    }

    if(isset($_POST['is_login'])){
        if(isset($_SESSION['md-Blog'])){
            echo 'ok';
        }else{
            echo '0';
        }
        return false;
    }

    if(isset($_POST['logout'])){
        session_destroy();
        echo 'ok';
        return false;
    }

    if(!file_exists("../data/blog.lock")){
        echo $page = read_file("./init.html");
    }else{
        echo $page = read_file("./login.html");
    }
