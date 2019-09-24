<?php
/**
 * Notes: 初始化文件
 * User: Hikari
 * Date: 2019/9/24
 * Time: 14:48
 */

//编码
header('Content-Type:text/html;Charset=utf-8;');

//初始化配置文件
require 'config.php';

//初始化公共函数
require 'common.php';

//初始化数据库类
require 'Db.class.php';

//验证分类
$verifyType = strtolower(VERIFY_TYPE);

if ($verifyType == 'google'){
    require 'PHPGangsta/GoogleAuthenticator.php';

    $ga = new PHPGangsta_GoogleAuthenticator();

    $code = isset($_COOKIE['code']) ? $_COOKIE['code'] : '';
    $check = $ga->verifyCode(SECRET, $code, EXPIRED_TIME);

    $verifyHtml = '<input type="text" class="form-control" placeholder="请输入CODE" name="code">&nbsp;<input type="submit" class="btn btn-default" value="提交">';

}elseif ($verifyType == 'password'){
    $password = PASSWORD;

    $code = isset($_COOKIE['code']) ? $_COOKIE['code'] : '';
    $check = ($password == $code);

    $verifyHtml = '<input type="text" class="form-control" placeholder="请输入密码" name="code">&nbsp;<input type="submit" class="btn btn-default" value="提交">';

}else{
    $check = true;

    $verifyHtml = '';

}

//页面名
$indexPage = INDEX_PAGE;
$addPage = ADD_PAGE;
$editPage = EDIT_PAGE;