<?php
//打印数组
function p($str){
    echo '<pre>';
    print_r($str);
    echo '</pre>';
}

//换行br
function b(){
    echo '<br>';
}

//获取本页面的地址
function getUrl($con1='',$con2=''){
    $str=$_SERVER['PHP_SELF'].'?';
    if($_GET){//判断地址栏是否有参数
        foreach($_GET as $k=>$v){
            if($k!=$con1&&$k!=$con2){//保留非page参数
                $str.=$k.'='.$v.'&';
            }
        }
    }
    return $str;
}

//弹窗
function show_msg($msg,$url=''){
    echo '<script>';
    echo "alert('{$msg}');";
    if($url){
        echo "location.href='{$url}';";
    }else{
        echo 'window.history.go(-1)';
    }
    echo '</script>';
    die();
}

//显示模板（快捷函数）
function show($tpl){
    global $view;
    return $view->load($tpl);
}

//判断两个值是否相同，如果相同就返回selected
function selected($value1, $value2){
    if($value1 == $value2){
        return 'selected';
    }else{
        return '';
    }
}

//判断两个值是否相同，如果相同就返回checked
function checked($value1, $value2){
    if($value1 == $value2){
        return 'checked';
    }else{
        return '';
    }
}
