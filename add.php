<?php

require 'include/init.php';

$check = CHECK;

if(!$check){
    alert('你没有权限这样做', $indexPage);
    die();
}

if(isset($_GET['t'])){
  $t = $_GET['t'];
}else{
    alert('数据传输错误', $indexPage);
    die();
}

$types = (new Db())->getAllBySql("SELECT * FROM link_favorites_type");
if($_POST){
  if($t == 'link'){
    if(preg_match('/^(http:\/\/|https:\/\/)/',$_POST['f_url'])){
      $data = array(
        'f_name' => $_POST['f_name'],
        'f_url' => $_POST['f_url'],
        't_id' => $_POST['t_id'],
        'f_addtime' => time()
      );
      $res= (new Db())->addData('link_favorites',$data);
    }else{
        alert('链接格式不对！记得带上http://或者https://！');
    }
  }elseif($t == 'type'){
    $data = array(
      't_name' => $_POST['t_name']
    );
    $res = (new Db())->addData('link_favorites_type',$data);
  }
  if($res){
      alert('添加成功', $indexPage);
  }else{
      alert('数据出现错误');
  }
}

//加载模板文件
include $view->load('add');