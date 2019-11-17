<?php

require 'include/init.php';

$check = CHECK;

if(!$check){
    alert('你没有权限这样做', $indexPage);
}

if(isset($_GET['t']) && isset($_GET['id'])){
  $t = $_GET['t'];
  $id = $_GET['id'];
}else{
  die('数据传输错误');
}

$types = (new Db())->getAllBySql("SELECT * FROM link_favorites_type");

if($t == 'link'){
    $outData = (new Db())->getOnceBySql("SELECT * FROM link_favorites WHERE f_id={$id}");
}elseif($t == 'type'){
    $outData = (new Db())->getOnceBySql("SELECT * FROM link_favorites_type WHERE t_id={$id}");
}

if($_POST){
  if($t == 'link'){
    if(preg_match('/^(http:\/\/|https:\/\/)/',$_POST['f_url'])){
      $data = array(
        'f_name' => $_POST['f_name'],
        'f_url' => $_POST['f_url'],
        't_id' => $_POST['t_id'],
        'f_addtime' => time()
      );
      $res= (new Db())->updateData('link_favorites', $data, 'f_id='.$id);
    }else{
      $res = false;
    }
  }elseif($t == 'type'){
    $data = array(
      't_name' => $_POST['t_name']
    );
    $res = (new Db())->updateData('link_favorites_type', $data, 't_id='.$id);
  }
  if($res){
      alert('修改成功', $indexPage.'?edit');
  }else{
      alert('数据出现错误');
  }
}

//加载模板文件
include $view->load('edit');