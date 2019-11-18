<?php

class Db{

    public $db;

    public function __construct(){
        $DATABASE_HOST = DATABASE_HOST; //数据库地址
        $DATABASE_USER = DATABASE_USER; //数据库用户
        $DATABASE_PASS = DATABASE_PASS; //数据库密码
        $DATABASE_DB = DATABASE_DB; //选择的数据库
        $DATABASE_ERROR = DATABASE_ERROR; //数据库错误语

        $this->db = @mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS);
        if(!$this->db){
            die($DATABASE_ERROR);
        }

        mysqli_select_db($this->db, $DATABASE_DB);
        mysqli_set_charset($this->db, 'utf8');
    }

    /**
     * 查询
     * @param $sql
     * @return bool|mysqli_result
     */
    public function query($sql)
    {
        return mysqli_query($this->db, $sql);
    }

    /**
     * 获取多条数据
     * @param string $sql sql语句
     * @return array
     */
    public function getAllBySql($sql){
        $res = mysqli_query($this->db, $sql);
        $inputArr = array();
        if($res && mysqli_num_rows($res)>0){
            while($arr = mysqli_fetch_assoc($res)){
                $inputArr[] = $arr;
            }
        }
        return $inputArr;
    }

    /**
     * 获取单条数据
     * @param string $sql sql语句
     * @return bool|array
     */
    public function getOneBySql($sql){
        $res = mysqli_query($this->db, $sql);
        $inputArr = array();
        if($res && mysqli_num_rows($res)>0){
            while($arr = mysqli_fetch_assoc($res)){
                $inputArr[] = $arr;
            }
        }else{
            $inputArr[0] = false;
        }
        return $inputArr[0];
    }

    /**
     * 单个查询
     * @param string $sql sql语句
     * @return array
     */
    public function getOnceBySql($sql){
        $res = mysqli_query($this->db, $sql);
        $ipt = mysqli_fetch_assoc($res);
        return $ipt;
    }

    /**
     * 取出该表主键
     * @param string $tableName 表名
     * @return array
     */
    public function getMainKey($tableName){
        $tableArr = self::getAllBySql('SELECT * FROM '.$tableName.' LIMIT 1');//取出数据
        $mainKey = array_keys($tableArr[0]);//根据第一个数据取出所有字段
        $mainKey = $mainKey[0];//取第一个字段（主键）
        return $mainKey;
    }

    /**
     * 添加数据
     * @param string $tableName 表名
     * @param array $data 数据数组
     * @return bool|mysqli_result
     */
    public function addData($tableName, $data){
        $sql = "INSERT INTO {$tableName} ";
        $sql .= "(`".implode('`,`',array_keys($data))."`)VALUES";
        $sql .= "('".implode("','",$data)."')";
        //echo $sql;die;
        $res = mysqli_query($this->db, $sql);
        return $res;
    }

    /**
     * 更新数据
     * @param string $tableName 表名
     * @param array $data 数据数组
     * @param $conditions
     * @return bool|mysqli_result
     */
    public function updateData($tableName, $data, $conditions){
        $sql = "UPDATE {$tableName} SET ";
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
            $sql .= '`'.$k."`='".$v."',";
        }
        $sql = rtrim($sql,',');//直接去除最后一个,
        //$sql.="`s_name`='张三',`s_sex`='1',`s_age`='18',`d_id`='2'";
        $sql .= " WHERE {$conditions}";
        $res = mysqli_query($this->db, $sql);
        return $res;
    }

    /**
     * 删除数据
     * @param string $tableName 表名
     * @param string $conditions 条件
     * @param string $tablename2 表名2
     * @param string $conditions2 条件2
     * @return bool|mysqli_result
     */
    public function delData($tableName, $conditions, $tablename2 = '', $conditions2 = ''){
        if($tablename2){
            mysqli_query($this->db, "DELETE FROM $tablename2 WHERE $conditions2");
        }
        $res = mysqli_query($this->db, "DELETE FROM $tableName WHERE $conditions");
        return $res;
    }

}
