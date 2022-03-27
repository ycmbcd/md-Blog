<?php

    // 生成 HTML
    function make_html($md_dir, $md_id, $title, $list_id, $list_name, $c_time, $u_time){
        $file_path = "../../blog/html/".$md_id.".html";

        // 替换md 图片地址
        $img_src = '/md/'.$list_name.'/';
        $markdown = read_file($md_dir);
        $replace = '/(\!\[\w*\]\()/';
        $to = "$1".$img_src;
        $str = preg_replace($replace, $to, $markdown);

        // 资源路径获取
        $md_src = str_replace($title.'.md', '', $md_dir);
        $md_src = '<div id="md_src" style="display:none;">'.$md_src.'</div>';

        // 生成 html
        $parser = new HyperDown\Parser;
        $article = $parser->makeHtml($str).'<br/>'.$md_src;

        // 读取 header.html
        $header = read_file("../../blog/header.html");

        // 读取 blog.htm
        $blog = read_file("../../tpl/blog.htm");

        // 读取配置
        $json_string = file_get_contents('../../data/blog.json'); 
        $blog_conf = json_decode($json_string, true);

        if($blog_conf['cy_status'] == 'on'){
            $cy_appid = $blog_conf['cy_appid'];
            $cy_conf = $blog_conf['cy_conf'];
            $cy_comment = '
            <!--PC版-->
<div id="SOHUCS" sid="{sid}"></div>
<script charset="utf-8" type="text/javascript" src="https://changyan.sohu.com/upload/changyan.js" ></script>
<script type="text/javascript">
window.changyan.api.config({
appid: \'{appid}\',
conf: \'{conf}\'
});
</script>';
            $cy_comment = str_replace('{sid}', $md_id, $cy_comment);
            $cy_comment = str_replace('{appid}', $cy_appid, $cy_comment);
            $cy_comment = str_replace('{conf}', $cy_conf, $cy_comment);
            $cy_comment = str_replace('{conf}', $cy_conf, $cy_comment);
            
        }else{
            $cy_comment = '&nbsp;';
        }

        // Google Adsense
        if($blog_conf['gad_status'] == 'on'){
            $gad_code = $blog_conf['gad_code'];
        }else{
            $gad_code = '';
        }

        // 获取打赏配置
        if($blog_conf['ali_qrcode'] == '' or $blog_conf['wx_qrcode'] == ''){
            $ali_qrcode = '';
            $wx_qrcode = '';
        }else{
            $ali_qrcode = '<div class="col-4 pay_item col-offset-1"><img src="'.$blog_conf['ali_qrcode'].'" /></div>';
            $wx_qrcode = '<div class="col-4 pay_item col-offset-2"><img src="'.$blog_conf['wx_qrcode'].'" /></div>';
        }
        $pay_txt = '<br><h3 class="tagc pay_txt">'.$blog_conf['pay_txt'].'</h3><br>';
        $side_list = '';
        
        $c_time = date("Y-m-d H:i:s",$c_time);                
        $u_time = date("Y-m-d H:i:s",$u_time);                
        $blog = str_replace("{title}", $title, $blog);
        $blog = str_replace("{google_adsense}", $gad_code, $blog);   // Google Adsense
        $blog = str_replace("{c_time}", $c_time, $blog);
        $blog = str_replace("{u_time}", $u_time, $blog);
        $blog = str_replace("{cy_comment}", $cy_comment, $blog);  // 畅言评论
        $blog = str_replace("{list_name}", $list_name, $blog); 
        $blog = str_replace("{code_css}", $blog_conf['code_css'], $blog);
        $blog = str_replace("{header}", $header, $blog);
        $blog = str_replace("{b_color}",$blog_conf['b_color'],$blog);
        $blog = str_replace("{side_list}", $side_list, $blog);
        $blog = str_replace("{article}", $article, $blog);
        $blog = str_replace('{pay_txt}', $pay_txt, $blog);
        $blog = str_replace('{ali_qrcode}', $ali_qrcode, $blog);
        $blog = str_replace('{wx_qrcode}', $wx_qrcode, $blog);
        write_file($file_path, $blog); 
    }
