<?php
/**
 * Notes: 自制模型（低仿TP）
 * File: Model.php
 * User: Hikari
 * Date: 2019/11/18
 * Time: 10:10
 */

class Model
{
    private $tableName = '';
    private $prefix = '';
    private $field = '*';
    private $where = '';
    private $join = '';
    private $order = '';
    private $limit = '';
    private $fetchSql = false;

    private $db;

    function __construct()
    {
        $this->db = (new Db());
        $this->prefix = DATABASE_PREFIX;
        if(empty($this->tableName)){
            $tableName = str_replace("Model", "", static::class); //去除Model后缀（UserDataModel => UserData）
            $tableName = strtolower(preg_replace('/(?<=[a-z])([A-Z])/', '_$1', $tableName)); //处理驼峰为小写下划线（UserData => user_data）
            $this->tableName = $tableName;
        }
    }

    /**
     * 处理数组where
     * @param $where
     * @return string
     */
    public function handleWhere($where)
    {
        //数组条件
        if(is_array($where)){
            $handleWhere = '';
            foreach ($where as $field => $value){
                if(is_array($value)){ //处理[x, y, z]条件格式
                    if(strtolower($value[1]) == 'in'){ //处理in条件格式
                        if(is_array($value[2])){ //处理[x, y, [a, b]]条件格式
                            $valueStr = implode(',', $value[2]);
                            $handleWhere .= " `{$value[0]}` {$value[1]} ({$valueStr}) AND";
                        }else{
                            $handleWhere .= " `{$value[0]}` {$value[1]} ({$value[2]}) AND";
                        }
                    }else{
                        if($value[1] == '=' && $value[2] == null){ //处理[x, '=' NULL]条件格式
                            $handleWhere .= " `{$value[0]}` IS NULL AND";
                        }else{
                            if(is_numeric($value[2])){
                                $handleWhere .= " `{$value[0]}` {$value[1]} {$value[2]} AND";
                            }else{
                                $handleWhere .= " `{$value[0]}` {$value[1]} '{$value[2]}' AND";
                            }
                        }
                    }
                }else{ //直接拼接
                    $handleWhere .= " `{$field}` = '{$value}' AND";
                }
            }
            $handleWhere = rtrim($handleWhere, ' AND');
        }else{
            $handleWhere = $where;
        }

        return $handleWhere;
    }

    /**
     * 选择字段
     * @param string $field
     * @return $this
     */
    public function field($field = '')
    {
        if(is_array($field)){
            $field = implode(',', $field);
        }
        $this->field = $field;
        return $this;
    }

    /**
     * 表名
     * @param string $tableName
     * @return $this
     */
    public function table($tableName = '')
    {
        $this->tableName = $tableName;
        return $this;
    }

    /**
     * 连表查询（支持多个）
     * @param $join
     * @param null $condition
     * @param string $type
     * @return $this
     */
    public function join($join, $condition = null, $type = 'INNER')
    {
        if($condition == null){
            foreach ($join as $key => $value) {
                if (is_array($value) && 2 <= count($value)) {
                    $this->join($value[0], $value[1], isset($value[2]) ? $value[2] : $type);
                }
            }
        }else{
            $this->join .= ' '.strtoupper($type).' JOIN '.$join.' ON '.$condition;
        }
        return $this;
    }

    /**
     * LEFT JOIN（支持多个）
     * @param $join
     * @param null $condition
     * @return $this
     */
    public function leftJoin($join, $condition = null)
    {
        return $this->join($join, $condition, 'LEFT');
    }

    /**
     * RIGHT JOIN（支持多个）
     * @param $join
     * @param null $condition
     * @return $this
     */
    public function rightJoin($join, $condition = null)
    {
        return $this->join($join, $condition, 'RIGHT');
    }

    /**
     * 与条件（支持多个）
     * @param string $where
     * @return $this
     */
    public function where($where = '')
    {
        $handleWhere = $this->handleWhere($where);

        if(empty($this->where)){
            $this->where = ' WHERE '.$handleWhere;
        }else{
            $this->where .= ' AND '.$handleWhere;
        }
        return $this;
    }

    /**
     * 或条件（支持多个）
     * @param string $where
     * @return $this
     */
    public function whereOr($where = '')
    {
        $handleWhere = $this->handleWhere($where);

        if(empty($this->where)){
            $this->where = ' WHERE '.$handleWhere;
        }else{
            if(stripos($this->where, ') OR (')){
                $this->where .= ' OR ('.$handleWhere.')';
            }else{
                $this->where = ' WHERE ('.str_replace('WHERE ', '', $this->where).') OR ('.$handleWhere.')';
            }
        }
        return $this;
    }

    /**
     * 排序
     * @param string $order
     * @return $this
     */
    public function order($order = '')
    {
        $this->order = ' ORDER BY '.$order;
        return $this;
    }

    /**
     * 限制
     * @param $limit
     * @param null $offset
     * @return $this
     */
    public function limit($limit, $offset = null)
    {
        if(is_null($offset) || $offset == 1){
            $this->limit = ' LIMIT '.$limit;
        }else{
            $this->limit = ' LIMIT '.$offset.','.$limit;
        }
        return $this;
    }

    /**
     * 获取sql语句
     * @param bool $fetch
     * @return $this
     */
    public function fetchSql($fetch = true)
    {
        $this->fetchSql = $fetch;
        return $this;
    }

    /**
     * 多条获取
     * @return array|string
     */
    public function select()
    {
        $sql = 'SELECT '.$this->field.' FROM `'.$this->prefix.$this->tableName.'`'.$this->join.$this->where.$this->order.$this->limit;
        if($this->fetchSql) return $sql;
        return $this->db->getAllBySql($sql);
    }

    /**
     * 单条获取
     * @return array|string
     */
    public function find()
    {
        $sql = 'SELECT '.$this->field.' FROM `'.$this->prefix.$this->tableName.'`'.$this->join.$this->where.$this->order.' LIMIT 1';
        if($this->fetchSql) return $sql;
        return $this->db->getOnceBySql($sql);
    }

    /**
     * 插入单条
     * @param array $data
     * @return bool|mysqli_result
     */
    public function insert($data = [])
    {
        $sql = 'INSERT INTO `'.$this->prefix.$this->tableName;
        $sql .= '` (`'.implode('`,`',array_keys($data)).'`)VALUES';
        $sql .= "('".implode("','",$data)."')";
        if($this->fetchSql) return $sql;
        return $this->db->query($sql);
    }

    /**
     * 插入多条
     * @param array $data
     * @return bool|mysqli_result|string
     */
    public function insertAll($data = [])
    {
        $sql = 'INSERT INTO `'.$this->prefix.$this->tableName;
        $i = 0;
        foreach ($data as $key => $value){
            if($i<1){
                $sql .= '` (`'.implode('`,`',array_keys($value)).'`)VALUES';
                $i++;
            }
            $sql .= "('".implode("','",$value)."'),";
        }
        $sql = rtrim($sql, ',');
        if($this->fetchSql) return $sql;
        return $this->db->query($sql);
    }

    /**
     * 更新数据
     * @param $data
     * @return bool|mysqli_result|string
     */
    public function update($data)
    {
        $sql = 'UPDATE `'.$this->prefix.$this->tableName.'` SET ';
        foreach($data as $k=>$v){
            $sql .= '`'.$k."`='".$v."',";
        }
        $sql = rtrim($sql,',');
        $sql .= $this->where;
        if($this->fetchSql) return $sql;
        return $this->db->query($sql);
    }

    /**
     * 删除数据
     * @param $where
     * @return bool|mysqli_result|string
     */
    public function delete($where = '')
    {
        if (!empty($where)){
            $this->where = '';
            $this->where($where);
        }
        $sql = 'DELETE FROM `'.$this->prefix.$this->tableName.'`'.$this->where;
        if($this->fetchSql) return $sql;
        return $this->db->query($sql);
    }

}