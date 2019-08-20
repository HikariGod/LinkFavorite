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

$links=getAllBySql("SELECT * FROM tt_favorites");
$types=getAllBySql("SELECT * FROM tt_favorites_type");
$del=false;
if(isset($_GET['del'])){
  if(!$check){
    show_msg('你没有权限这样做',$indexName);
  }
    $del=true;
}
if(isset($_GET['del'])&&!empty($_GET['id'])){
  if(!$check){
    show_msg('你没有权限这样做',$indexName);
  }
  $res=false;
  if(isset($_GET['type'])){
    if($_GET['type']==true){
      $res=delData('tt_favorites_type','t_id='.$_GET['id']);
    }
  }else{
    $res=delData('tt_favorites','f_id='.$_GET['id']);
  }
  if($res){
    show_msg('删除成功',$indexName);
  }else{
    show_msg('数据执行有误，请重新删除');
  }
}
if(isset($_POST['code'])){
  setcookie('code',$_POST['code'],time()+1800);
  echo '<script>location.href="'.$indexName.'";</script>';
}

//p($links);
//p($types);
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
    <script src="js/jquery.slim.min.js"></script>
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
      .del{
        display: inline;
      }
    </style>
    <title>Hikari-网站收藏夹</title>
  </head>

  <body>
    <center><a class="title" href="<?php echo $indexName;?>"><h1>网站收藏夹<h1></a></center>
    <center>
    <form action="" method="post" class="form-inline">
    <input type="text" class="form-control" placeholder="请输入CODE" name="code">
    <input type="submit" class="btn btn-default" value="提交">
    </form>
    </center>
    <?php if($check){?>
    <center><h4><a class="btn btn-default" href="<?php echo $addName;?>?t=link">添加链接</a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default" href="<?php echo $addName;?>?t=type">添加分类</a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default btn-danger" href="<?php echo $del?getUrl('del'):getUrl('del').'del';?>"><?php echo $del?'取消删除':'删除模式';?></a></h4></center>
    <?php }?>
    <br>
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
          <a href="favorites.php" class="list-group-item active">快速导航分类</a>
          <?php foreach($types as $v3){?>
            <?php if($del){?>
          <a class="list-group-item list-group-item-danger" onclick="return confirm('你确定要删除吗？')" href="<?php echo getUrl().'id='.$v3['t_id'].'&type=true';?>"><?php echo $v3['t_name'].' --- 删除';?></a>
            <?php }elseif(isset($_GET['type'])){?>
              <a href="<?php echo getUrl('type').'type='.$v3['t_id'];?>" class="list-group-item"><?php echo $v3['t_name'];?></a>
            <?php }else{?>
              <a href="<?php echo getUrl('del');?>#<?php echo $v3['t_id'];?>" class="list-group-item"><?php echo $v3['t_name'];?></a>
            <?php }?>
          <?php }?>
        </div>
      </div>
      <br>
      <?php foreach($types as $v1){?>
      <?php
        if(isset($_GET['type'])){
          if($v1['t_id']!=$_GET['type']){
            continue;
          }
        }
      ?>
      <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
          <a id="<?php echo $v1['t_id'];?>" href="<?php echo getUrl('type');?>type=<?php echo $v1['t_id'];?>" class="list-group-item active"><?php echo $v1['t_name'];?></a>
          <?php foreach($links as $v2){?>
          <?php if($v1['t_id']==$v2['t_id']){?>
          <a class="list-group-item<?php echo $del?' list-group-item-danger':''?>" onclick="<?php echo $del?"return confirm('你确定要删除吗？')":''?>" <?php echo $del?'':BLANK?'target="_blank"':'';?> href="<?php if($del){echo getUrl().'id='.$v2['f_id'];}else{echo $v2['f_url'];}?>"><?php echo $del?$v2['f_name'].' --- 删除':$v2['f_name'];?></a>
          <?php }}?>
        </div>
      </div>
      <br>
      <?php }?>
    </div>
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <!-- <script src="https://cdn.bootcss.com/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> -->
    <!-- <script src="https://cdn.bootcss.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->
    <script src="js/popper.min.js"></script>
    <script>
      $('.badge').click(function(){
        var linkid=$(this).attr('link');
        aletr('你要删除的链接ID是'+linkid+'没错吧？');
      });
    </script>
  </body>

</html>