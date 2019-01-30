<?php
    function read_file($tpl_name){
        $fp = fopen($tpl_name, "r");
        $tpl = fread($fp,filesize($tpl_name));
        fclose($fp);
        return $tpl;
    }
    