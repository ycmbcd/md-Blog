<?php
    if(!file_exists("./index.html")){
        header("location:./set/");
    }else{
        header("location:./index.html");
    }
