<?php

require 'include/init.php';

$links = (new Db())->getAllBySql("SELECT * FROM link_favorites");
$types = (new Db())->getAllBySql("SELECT * FROM link_favorites_type");

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
      $res = (new Db())->delData('link_favorites_type','t_id='.$_GET['id']);
    }
  }else{
    $res = (new Db())->delData('link_favorites','f_id='.$_GET['id']);
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