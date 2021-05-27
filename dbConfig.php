<?php
    class dbConnect
    {
        //class Properties
        private $hostName="localhost";
        private $databaseName="toystoreDB";
        private $username="user06";
        private $password="user06";
        private $dbCon;
        private $sqlRequest;

        //constructor
        public function __construct()
        {
            try {
                if(!isset($this->dbCon))
                {
                    $this->dbCon=new PDO("mysql:host=".$this->hostName.";dbname=".$this->databaseName,$this->username,$this->password);
                    // set the PDO error mode to exception
                    $this->dbCon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    //echo "You are now connected to toystorDB";
                    // $toy_data=["name"=>"game1",
                    // "type"=>"electronic",
                    // "price"=>"20.3",
                    // "minAge"=>6,
                    // "maxAge"=>18
                    // ];
                    // $sqlRequest="insert into Toy(name,type,price,minAge,maxAge) values(:name,:type,:price,:minAge,:maxAge)";
                    // $stmt=$this->dbCon->prepare($sqlRequest);
                    // $stmt->execute($toy_data);
                    // echo "the toy game1 has been successufly added";

                }

            } catch (PDOException $e) {
                echo "Connection failed: ".$e->getMessage();
                exit();
                //or 
                //die();
            }
        }
        //setters and getters
        public function setDatabaseName($databaseName='toystoreDB')
        {
            $this->databaseName=$databaseName;
        }
        public function setHostName($hostName)
        {
            $this->hostName=$hostName;
        }
        public function setUserName($userName)
        {
            $this->username=$userName;
        }
        public function setPassword($password)
        {
            $this->password=$password;
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
        //set the SQL Request
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
    //Exampe of insert request :
    //$sqlRequest="nsert into Toy(name,price) values(:name,:price);
    public function insert($table,$data){
        if(!empty($data) && is_array($data)){
            $columnString = '';
            $valueString  = '';
            $i = 0;
            //prepare the SQL request
            //explode(',','abc,nfk,ccc') ==>split a string using separators
            //the result of explode is an array (['abc','nfk','ccc'])
            //implode ==>merge an array values using the separator given as first parameter
            $columnString = implode(',', array_keys($data));
            $valueString = ":".implode(',:', array_keys($data));
            print_r($valueString);
            $this->sqlRequest = "INSERT INTO ".$table." (".$columnString.") VALUES (".$valueString.")";
            
             //Execute the SQL request
            $stmt = $this->dbCon->prepare($this->sqlRequest);
            //this
            // foreach($data as $key=>$val){
            //      $query->bindValue(':'.$key, $val);
            // }
            //or simply pass $data as parameter to the execute function
           
            $insert = $stmt->execute($data);
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
        $delete = $this->dbCon->exec($this->sqlRequest); //without prepared statement
        return $delete?$delete:false;
    }
  }
   
?>