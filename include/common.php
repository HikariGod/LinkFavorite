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

//花式弹窗
function alert($msg, $url='', $style = 1) {
    if ($url) {
        $href = "location.href='{$url}';";
    } else {
        $href = 'window.history.go(-1)';
    }

    echo <<<EOT
<html>
<head>
<script src="static/js/jquery-1.12.4.js"></script>

<!-- Syalert Lib -->
<link rel="stylesheet" href="https://cdn.bootcss.com/animate.css/3.7.2/animate.min.css" />
<link rel="stylesheet" href="static/syalert/syalert.min.css" />
<script src="static/syalert/syalert.min.js"></script>
<script>
function ok(id){
	//syalert.syhide(id);
	var url = "$url";
	if (typeof (url) == "undefined" || url == null || url === ""){
	    window.history.go(-1);
	}else{
	    location.href = url;
	}
}
</script>
</head>

<body>
<!-- 提示弹窗 -->
<div class="sy-alert sy-alert-tips animated" sy-enter="zoomIn" sy-leave="zoomOut" sy-type="tips" sy-mask="false" id="alert">
    <div class="sy-content">$msg</div>
</div>

<div class="sy-alert sy-alert-alert animated" sy-enter="zoomIn" sy-leave="zoomOut" sy-type="alert" sy-mask="true" id="alert2">
  <div class="sy-title">提示</div>
  <div class="sy-content">$msg</div>
  <div class="sy-btn">
    <button onClick="ok('alert2')">确定</button>
  </div>
</div>
</body>
</html>
EOT;

    echo '<script>';
    echo "syalert.syopen('alert2');";
    echo '</script>';
}

/*function only_alert($msg, $url='', $style = 1) {
    if ($url) {
        $href = "location.href='{$url}';";
    } else {
        $href = 'window.history.go(-1)';
    }

    echo '<script>';
    echo "syalert.syopen('alert2');";
    echo '</script>';
}*/

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
