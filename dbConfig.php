<?php
    class dbConnect
    {
        private $hostName="localhost";
        private $databaseName="toystoreDB";
        private $username="user01";
        private $password="user01";
        private $dbCon;
        private $myQuery;
        public function __construct()
        {
            try {
                if(!isset($this->dbCon))
                {
                    $this->dbCon=new PDO("mysql:host=".$this->hostName.";dbname=".$this->databaseName,$this->username,$this->password);
                    // set the PDO error mode to exception
                    $this->dbCon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                   // echo "You are now connected to toystorDB";
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

        /*
     * Returns rows from the database based on the conditions
     * @param string name of the table
     * @param array select, where, order_by, limit and return_type conditions
     */
    public function getRows($table,$conditions = array()){
        $sql = 'SELECT ';
        $sql .= array_key_exists("select",$conditions)?$conditions['select']:'*';
        $sql .= ' FROM '.$table;
        if(array_key_exists("where",$conditions)){
            $sql .= ' WHERE ';
            $i = 0;
            foreach($conditions['where'] as $key => $value){
                $pre = ($i > 0)?' AND ':'';
                $sql .= $pre.$key." = '".$value."'";
                $i++;
            }
        }

        if(array_key_exists("order_by",$conditions)){
            $sql .= ' ORDER BY '.$conditions['order_by'];
        }

        if(array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
            $sql .= ' LIMIT '.$conditions['start'].','.$conditions['limit'];
        }elseif(!array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
            $sql .= ' LIMIT '.$conditions['limit'];
        }

        $query = $this->dbCon->prepare($sql);
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
            if(!array_key_exists('created',$data)){
                $data['created'] = date("Y-m-d H:i:s");
            }
            if(!array_key_exists('modified',$data)){
                $data['modified'] = date("Y-m-d H:i:s");
            }

            $columnString = implode(',', array_keys($data));
            $valueString = ":".implode(',:', array_keys($data));
            $sql = "INSERT INTO ".$table." (".$columnString.") VALUES (".$valueString.")";
            $query = $this->dbCon->prepare($sql);
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
            $sql = "UPDATE ".$table." SET ".$colvalSet.$whereSql;
            $query = $this->dbCon->prepare($sql);
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
        $sql = "DELETE FROM ".$table.$whereSql;
        $delete = $this->dbCon->exec($sql);
        return $delete?$delete:false;
    }












//         public function get($table, $rows = '*', $join = null, $where = null, $order = null, $limit = null){
//             $selectQuery = 'SELECT '.$rows.' FROM '.$table;
//             if($join != null){
//                 $selectQuery .= ' JOIN '.$join;
//             }
//             if($where != null){
//                 $selectQuery .= ' WHERE '.$where;
//             }
//             if($order != null){
//                 $selectQuery .= ' ORDER BY '.$order;
//             }
//             if($limit != null){
//                 $selectQuery .= ' LIMIT '.$limit;
//             }
//             $this->myQuery = $selectQuery;
//             if($this->checkTable($table)){
//                 try {
//                     // $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
//                     // // set the PDO error mode to exception
//                     // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//                      // use exec() because no results are returned
//                     $this->dbCon->exec($this->myQuery);
//                     $stmt->execute(array(":id"=>$id));
//   $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
//   return $editRow;
//                     echo "New record created successfully";
//                   } catch(PDOException $e) {
//                     echo $this->myQuery . "<br>" . $e->getMessage();
//                   }
                  
//                   $this->dbCon = null;//close the DB connection
//             }
//         }	
//         public function insert($table,$params=array()){
//             if($this->checkTable($table)){
//                  $insertQuery='INSERT INTO `'.$table.'` (`'.implode('`, `',array_keys($params)).'`) VALUES ("' . implode('", "', $params) . '")';
//                  $this->myQuery = $insertQuery;
//                  if($this->checkTable($table)){
//                      try {
//                          // $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
//                          // // set the PDO error mode to exception
//                          // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//                           // use exec() because no results are returned
//                          $this->dbCon->exec($this->myQuery);
//                          echo "New record created successfully";
//                        } catch(PDOException $e) {
//                          echo $this->myQuery . "<br>" . $e->getMessage();
//                        }
                       
//                        $this->dbCon = null;//close the DB connection
//                  }
//                 }
//         }	
//         public function update($table,$params=array(),$where){
//             if($this->checkTable($table)){
//                 $args=array();
//                 foreach($params as $field=>$value){
//                     $args[]=$field.'="'.$value.'"';
//                 }
//                 $updateQuery='UPDATE '.$table.' SET '.implode(',',$args).' WHERE '.$where;
//                 $this->myQuery = $updateQuery;
//             if($this->checkTable($table)){
//                 try {
//                     // $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
//                     // // set the PDO error mode to exception
//                     // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//                      // use exec() because no results are returned
//                     $this->dbCon->exec($this->myQuery);
//                     echo "New record created successfully";
//                   } catch(PDOException $e) {
//                     echo $this->myQuery . "<br>" . $e->getMessage();
//                   }
                  
//                   $this->dbCon = null;//close the DB connection
//             }
//         }
//         }
//         // public function delete($table,$where = null){
//         //     if($this->checkTable($table)){
//         //          if($where == null){
//         //             $deleteQuery = 'DROP TABLE '.$table;
//         //         }else{
//         //             $deleteQuery = 'DELETE FROM '.$table.' WHERE '.$where;
//         //         }
//         //         if($del = @mysql_query($deleteQuery)){
//         //             array_push($this->result,mysql_affected_rows());
//         //             $this->myQuery = $deleteQuery; 
//         //             return true;
//         //         }else{
//         //             array_push($this->result,mysql_error());
//         //                return false; 
//         //         }
//         //     }else{
//         //         return false;
//         //     }
//         // }
//         private function checkTable($table){
//             try {
                
//             $sql = 'SHOW TABLES FROM '.$this->databaseName.' LIKE "'.$table.'"';
            
//             //Prepare our SQL statement,
//             $statement = $this->dbCon->prepare($sql);

//             //Execute the statement.
//             $statement->execute();

//             //Fetch the rows from our statement.
//             $tables = $statement->fetchAll(PDO::FETCH_NUM);

//             if(empty($tables))
//                 throw new Exception($table." does not exist !!! Try to verify");
//             return true;
//             } catch (Exception $e) {
//                 echo $e->getMessage();
//             }
//             return false;
//         }
//         // public function getResult(){
//         //     $value = $this->result;
//         //     $this->result = array();
//         //     return $value;
//         // }    
//         // public function escapeString($data){
//         //     return mysql_real_escape_string($data);
//         // }
//         public function check_empty($data, $fields) {
//             $msg = null;
//             foreach ($fields as $value) {
//                 if (empty($data[$value])) {
//                     $msg .= "$value field empty";
//                 }
//             } 
//             return $msg;
//         }
    

    }
    //$con=new dbconnect();
?>