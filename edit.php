<?php

require 'include/init.php';

$check = CHECK;

if(!$check){
    alert('你没有权限这样做', $indexPage);
    die();
}

if(isset($_GET['t']) && isset($_GET['id'])){
    $t = $_GET['t'];
    $id = $_GET['id'];
}else{
    alert('数据传输错误', $indexPage);
    die();
}

$types = (new Model())->table('favorites_type')->select();

if($t == 'link'){
    $outData = (new Model)->table('favorites')->where(['f_id' => $id])->find();
}elseif($t == 'type'){
    $outData = (new Model)->table('favorites_type')->where(['t_id' => $id])->find();
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
      $res = (new Model())->table('favorites')->where(['f_id' => $id])->update($data);
    }else{
      $res = false;
    }
  }elseif($t == 'type'){
    $data = array(
      't_name' => $_POST['t_name']
    );
    $res = (new Model())->table('favorites_type')->where(['t_id' => $id])->update($data);
  }
  if($res){
      alert('修改成功', $indexPage.'?edit');
  }else{
      alert('数据出现错误');
  }
}

//加载模板文件
include $view->load('edit');