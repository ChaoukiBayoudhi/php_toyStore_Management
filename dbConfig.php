<?php
    class dbConnect
    {
        private $hostName="localhost";
        private $databaseName="toystoreDB";
        private $username="user01";
        private $password="user01";
        private $dbCon;
        private $sqlRequest;
        public function __construct()
        {
            try {
                if(!isset($this->dbCon))
                {
                    $this->dbCon=new PDO("mysql:host=".$this->hostName.";dbname=".$this->databaseName,$this->username,$this->password);
                    // set the PDO error mode to exception
                    $this->dbCon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    //echo "You are now connected to toystorDB";
                }

            } catch (PDOException $e) {
                echo "Connection failed: ".$e->getMessage();
                exit();
                //or 
                //die();
            }
        }
        public function setDatabaseName($databaseName='toystoreDB')
        {
            $this->databaseName=$databaseName;
        }
        public function getDbCon()
        {
            return $this->dbCon;
        }
        public function showSqlRequest()
        {
            echo $this->sqlRequest;
        }

        /*
     * Returns rows from the database based on the conditions
     * @param string name of the table
     * @param array select, where, order_by, limit and return_type conditions
     */
    public function getRows($table,$conditions = array()){
        $this->sqlRequest = 'SELECT ';
        $this->sqlRequest .= array_key_exists("select",$conditions)?$conditions['select']:'*';
        $this->sqlRequest .= ' FROM '.$table;
        if(array_key_exists("where",$conditions)){
            $this->sqlRequest .= ' WHERE ';
            $i = 0;
            foreach($conditions['where'] as $key => $value){
                $pre = ($i > 0)?' AND ':'';
                $this->sqlRequest .= $pre.$key." = '".$value."'";
                $i++;
            }
        }

        if(array_key_exists("order_by",$conditions)){
            $this->sqlRequest .= ' ORDER BY '.$conditions['order_by'];
        }

        if(array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
            $this->sqlRequest .= ' LIMIT '.$conditions['start'].','.$conditions['limit'];
        }elseif(!array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
            $this->sqlRequest .= ' LIMIT '.$conditions['limit'];
        }

        
        $query = $this->dbCon->prepare($this->sqlRequest);
        $query->execute();

        if(array_key_exists("return_type",$conditions) && $conditions['return_type'] != 'all'){
            switch($conditions['return_type']){
                case 'count':
                    $data = $query->rowCount();
                    break;
                case 'single':
                    $data = $query->fetch(PDO::FETCH_ASSOC);
                    break;
                default:
                    $data = '';
            }
        }else{
            if($query->rowCount() > 0){
                $data = $query->fetchAll();
            }
        }
        return !empty($data)?$data:false;
    }

    /*
     * Insert data into the database
     * @param string name of the table
     * @param array the data for inserting into the table
     */
    public function insert($table,$data){
        if(!empty($data) && is_array($data)){
            $columns = '';
            $values  = '';
            $i = 0;
            
            $columnString = implode(',', array_keys($data));
            $valueString = ":".implode(',:', array_keys($data));
            print_r($valueString);
            $this->sqlRequest = "INSERT INTO ".$table." (".$columnString.") VALUES (".$valueString.")";
            
            $query = $this->dbCon->prepare($this->sqlRequest);
            foreach($data as $key=>$val){
                 $query->bindValue(':'.$key, $val);
            }
            $insert = $query->execute();
            return $insert?$this->dbCon->lastInsertId():false;
        }else{
            return false;
        }
    }

    /*
     * Update data into the database
     * @param string name of the table
     * @param array the data for updating into the table
     * @param array where condition on updating data
     */
    public function update($table,$data,$conditions){
        if(!empty($data) && is_array($data)){
            $colvalSet = '';
            $whereSql = '';
            $i = 0;
            if(!array_key_exists('modified',$data)){
                $data['modified'] = date("Y-m-d H:i:s");
            }
            foreach($data as $key=>$val){
                $pre = ($i > 0)?', ':'';
                $colvalSet .= $pre.$key."='".$val."'";
                $i++;
            }
            if(!empty($conditions)&& is_array($conditions)){
                $whereSql .= ' WHERE ';
                $i = 0;
                foreach($conditions as $key => $value){
                    $pre = ($i > 0)?' AND ':'';
                    $whereSql .= $pre.$key." = '".$value."'";
                    $i++;
                }
            }
            $this->sqlRequest = "UPDATE ".$table." SET ".$colvalSet.$whereSql;
            $query = $this->dbCon->prepare($this->sqlRequest);
            $update = $query->execute();
            return $update?$query->rowCount():false;
        }else{
            return false;
        }
    }

    /*
     * Delete data from the database
     * @param string name of the table
     * @param array where condition on deleting data
     */
    public function delete($table,$conditions){
        $whereSql = '';
        if(!empty($conditions)&& is_array($conditions)){
            $whereSql .= ' WHERE ';
            $i = 0;
            foreach($conditions as $key => $value){
                $pre = ($i > 0)?' AND ':'';
                $whereSql .= $pre.$key." = '".$value."'";
                $i++;
            }
        }
        $this->sqlRequest = "DELETE FROM ".$table.$whereSql;
        $delete = $this->dbCon->exec($this->sqlRequest);
        return $delete?$delete:false;
    }
  }
    //$con=new dbconnect();
?>