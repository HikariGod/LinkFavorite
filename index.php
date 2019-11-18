<?php

require 'include/init.php';

$links = (new Model())->table('favorites')->select();
$types = (new Model())->table('favorites_type')->select();

$target = TARGET_BLANK?'target="_blank"':'';

$check = CHECK;

$del = false;
if(isset($_GET['del'])){
  if(!$check){
      alert('你没有权限这样做', $indexPage);
  }
    $del = true;
}
$edit = false;
if(isset($_GET['edit'])){
    if(!$check){
        alert('你没有权限这样做', $indexPage);
    }
    $edit = true;
}
if(isset($_GET['del'])&&!empty($_GET['id'])){
  if(!$check){
      alert('你没有权限这样做', $indexPage);
  }
  $res = false;
  if(isset($_GET['type'])){
    if($_GET['type'] == true){
      $res = (new Model())->table('favorites_type')->delete(['t_id' => $_GET['id']]);
    }
  }else{
    $res = (new Model())->table('favorites')->delete(['f_id' => $_GET['id']]);
  }
  if($res){
      alert('删除成功', $indexPage.'?del');
  }else{
      alert('数据执行有误，请重新删除');
  }
}
if(isset($_POST['code'])){
  if ($verifyType == 'password'){
    $cookieCode = md5($_POST['code']);
  }else{
    $cookieCode = $_POST['code'];
  }
  setcookie('code', $cookieCode, time()+(EXPIRED_TIME*30));
  echo '<script>location.href="'.$indexPage.'";</script>';
}

//p($links);
//p($types);

//加载模板文件
include $view->load('index');