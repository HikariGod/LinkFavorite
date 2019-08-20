<?php
header('Content-Type:text/html;Charset=utf-8;');
include('include/connect_db.php');
include('include/function.php');
require_once 'include/PHPGangsta/GoogleAuthenticator.php';
$ga=new PHPGangsta_GoogleAuthenticator();
$code=isset($_COOKIE['code'])?$_COOKIE['code']:'';
$check=$ga->verifyCode(SECRET,$code,EXPIRED_TIME);

$indexName=INDEX;
$addName=ADD;

if(!$check){
  show_msg('你没有权限这样做',$indexName);
}

if(isset($_GET['t'])){
  $t=$_GET['t'];
}else{
  die('数据传输错误');
}

$types=getAllBySql("SELECT * FROM tt_favorites_type");
if($_POST){
  if($t=='link'){
    if(preg_match('/^(http:\/\/|https:\/\/)/',$_POST['f_url'])){
      $data=array(
        'f_name'=>$_POST['f_name'],
        'f_url'=>$_POST['f_url'],
        't_id'=>$_POST['t_id'],
        'f_addtime'=>time()
      );
      $res=addData('tt_favorites',$data);
    }else{
      $res=false;
    }
  }elseif($t=='type'){
    $data=array(
      't_name'=>$_POST['t_name']
    );
    $res=addData('tt_favorites_type',$data);
  }
  if($res){
    show_msg('添加成功',$indexName);
  }else{
    show_msg('数据出现错误');
  }
}
?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="shortcut icon" href="images/favicon.ico">
    <script src="js/bootstrap.min.js"></script>
    <style>
      .bg-error{
        background-color: red;
      }
      .bg-frp{
        background-color: skyblue;
      }
      .title,.title:hover{
        color: black;
        text-decoration: none;
      }
      .del,.del:hover{
        color: red;
      }
      .add,.add:hover{
        color: skyblue;
      }
    </style>
    <title>Hikari-网站收藏夹添加</title>
  </head>

  <body>
    <center><a class="title" href="favorites.php"><h1>添加<?php echo $t=='link'?'链接':'分类';?><h1></a></center>
    <center><h4><a class="btn btn-default" href="<?php echo $indexName;?>">返回</a></h4></center>
    <br>
    <div class="container">
      <div class="row">
        <form active="" method="post">
          <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <?php if($t=='link'){?>
            <div class="form-group">
              <label for="f_name">链接名称：</label>
              <input name="f_name" type="f_name" class="form-control" id="f_name" placeholder="请输入链接名称">
            </div>
            <div class="form-group">
              <label for="f_url">链接地址：</label>
              <input name="f_url" type="f_url" class="form-control" id="f_url" placeholder="请输入链接地址">
            </div>
            <div class="form-group">
              <label for="t_id">链接分类：</label>
              <select name="t_id" id="t_id" class="form-control">
                <?php foreach($types as $v){?>
                <option value="<?php echo $v['t_id'];?>"><?php echo $v['t_name'];?></option>
                <?php }?>
              </select>
            </div>
            <?php }elseif($t=='type'){?>
            <div class="form-group">
              <label for="t_name">分类名称：</label>
              <input name="t_name" type="t_name" class="form-control" id="t_name" placeholder="请输入分类名称">
            </div>
            <?php }?>
            <button type="submit" class="btn btn-default">添加</button>
          </div>
        </form>
      </div>
      <br>
    </div>
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.bootcss.com/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.bootcss.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>

</html>