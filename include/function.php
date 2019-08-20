<?php
//打印数组
function p($a){
    echo '<pre>';
    print_r($a);
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

//多条查询
function getAllBySql($sql){
    $res=mysql_query($sql);
    $iptarr=array();
    if($res && mysql_num_rows($res)>0){
        while($arr=mysql_fetch_assoc($res)){
            $iptarr[]=$arr;
        }
    }
    return $iptarr;
}

//单条查询
function getOneBySql($sql){
    $res=mysql_query($sql);
    $iptarr=array();
    if($res && mysql_num_rows($res)>0){
        while($arr=mysql_fetch_assoc($res)){
            $iptarr[]=$arr;
        }
    }else{
        $iptarr[0]=false;
    }
    return $iptarr[0];
}

//单个查询
function getOnceBySql($sql){
    $res=mysql_query($sql);
    $ipt=mysql_fetch_assoc($res);
    return $ipt;
}

//取出主键
function getMainKey($tablename){
    $tablearr=getAllBySql('SELECT * FROM '.$tablename.' LIMIT 1');//取出数据
    $mainkey=array_keys($tablearr[0]);//根据第一个数据取出所有字段
    $mainkey=$mainkey[0];//取第一个字段（主键）
    return $mainkey;
}

//添加数据
//第一个参数是表名
//第二个参数是数组，数组的键值是字段名，值是需要添加的数据
function addData($tablename,$data){
    $sql="INSERT INTO {$tablename} ";
    $sql.="(`".implode('`,`',array_keys($data))."`)VALUES";
    $sql.="('".implode("','",$data)."')";
    //echo $sql;die;
    $res=mysql_query($sql);
    return $res;
}

//编辑数据
//第三个参数是条件，s_number='1'
//editData('student',$data,"s_number='1'");
function editData($tablename,$data,$conditions){
    $sql="UPDATE {$tablename} SET ";
    /* end($data);
    $last_key=key($data);
    foreach($data as $k=>$v){
        if($last_key==$k){
            $sql.='`'.$k."`='".$v."'";
        }else{
            $sql.='`'.$k."`='".$v."',";
        }
    } */
    foreach($data as $k=>$v){
        $sql.='`'.$k."`='".$v."',";
    }
    $sql=rtrim($sql,',');//直接去除最后一个,
    //$sql.="`s_name`='张三',`s_sex`='1',`s_age`='18',`d_id`='2'";
    $sql.=" WHERE {$conditions}";
    $res=mysql_query($sql);
    return $res;
}

//删除数据
/* 
 *   $tablename 表名
 *   $conditions 条件
 */
function delData($tablename,$conditions,$tablename2='',$conditions2=''){
    if($tablename2){
        mysql_query("DELETE FROM $tablename2 WHERE $conditions2");
    }
    $res=mysql_query("DELETE FROM $tablename WHERE $conditions");
    return $res;
}
?>