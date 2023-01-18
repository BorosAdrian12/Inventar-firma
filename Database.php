<?php

use FFI\Exception;

class Config
{
    const TB_USERS = "users";
    const TB_ITEMS = "item";
    const TB_LOCATIEPRODUS = "locatieProdus";
    const TB_MAGAZIE = "magazie";
    const DATABASENAME = "a_boros";
    const RESTRICTEDLIST = [Config::TB_USERS => ['password', 'email']];
    const TABEL_TIP_ITEM = "product_type";
}
class DbInfo
{
    public static $host = "127.0.0.1:3306";
    public static $username = "root";
    public static $password = "adiboros";
    public static $database = "a_boros";
}
class Database
{
    //singleton
    /**
     * notite :
     * 1)toate actiunile cu token ar trebuii sa fie salvate pe server , in cache , ca sa nu tot apeleze serverul. o sa trebuiasca sa fie modificat cand stiu si eu sa fac asta
     * dar pana atunci salveazale in server
     */
    public $servername, $username, $password;
    private $database;
    private static $structDB;
    private static $restrictedTable; //this is declared in getConnection , need to be initialize
    private static $connection;

    private function __construct($sv, $usr, $pw, $db)
    {
        // //i need a methode to not allow this class to be use if the connection is not good
        // if()
        // $this->connection = new mysqli($sv, $usr, $pw, $db);
        // if (!$this->connection->connect_errno) {
        //     $this->servername = $sv;
        //     $this->username = $usr;
        //     $this->password = $pw;
        //     return;
        // }
        // throw new Exception('Connection to database faild.');
        //trow exeption
    }
    public static function getConnection()
    {
        self::$restrictedTable = Config::RESTRICTEDLIST;
        if (self::$connection == null)
            self::$connection = new mysqli(DbInfo::$host, DbInfo::$username, DbInfo::$password, DbInfo::$database);
        if (self::$structDB == null) {
            $result = Database::runQueryRaw("show tables;");
            $rows = [];
            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    $rows[] = $row["Tables_in_" . Config::DATABASENAME];
                }
            }
            foreach ($rows as $index => $table) {
                $x = Database::runQueryRaw('SHOW COLUMNS FROM ' . $table);
                $coloana = array();
                while ($row = mysqli_fetch_assoc($x)) {
                    $coloana[] = $row['Field'];
                }
                self::$structDB[$rows[$index]] = $coloana;
                // print_r($coloana);
            }
            // print_r(self::$structDB);
        }

        return self::$connection;
    }
    public static function existingUser($username, $email = "")
    {
        if (preg_match('/[;"]/', $email) || preg_match('/[;"]/', $username)) {
            echo "injectie\n";
            return false;
        }
        $query = self::$connection->query('SELECT username,idUser from users where username = "' . $username . '";');
        if ($query->num_rows > 0) {
            $row = $query->fetch_assoc();
            return $row;
            // return [
            //     "idUser"=>$row["idUser"]
            // ];
        }
        return false;
    }
    public static function returnUser($idUser, $username, $token)
    {
        $query = self::$connection->query('SELECT username,token from users where idUser =' . $idUser . ';');
        if ($query->num_rows == 1) {
        }
    }
    public static function updateTimeStamp($idUser, $username, $days = 0)
    { //this function need to be verify before execution
        self::$connection->query('UPDATE users SET tokenLife=NOW() + INTERVAL ' . $days . ' DAY WHERE idUser=' . $idUser . ' AND username="' . $username . '";');
    }
    public static function verifyTime($idUser, $username)
    { //i'm using the username as a verification , if someone just verify randomly then he shoud know who it is 
        $query = self::$connection->query('SELECT username,token from users where idUser =' . $idUser . ';');
        if ($query->num_rows == 1) {
        }
        //daca nu e 1 atunci trebuie sa apara o eroare , nu are voie sa existe copii
    }
    public static function searchUser($username, $email)
    {
        $query = self::$connection->query('SELECT username,email,idUser from users where username = "' . $username . '" or email="' . $email . '";');
        if ($query->num_rows > 1) {
            // output data of each row

            echo $query->num_rows . "\n";
        }
        //To be continued
    }
    public static function addUser($username, $email, $password, $repassword)
    {
        //filter
        if ($password !== $repassword) {
            echo "nu sunt egale parolele\n";
            return false;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "email invalid\n";
            return false;
        }
        if (preg_match('/[;"]/', $password) || preg_match('[;"]', $username)) {
            echo "injectie\n";
            return false;
        }
        if (self::existingUser($username, $email)) {
            echo "this user exists";
            return false;
        }
        self::$connection->query('INSERT INTO users (username, password , email) VALUES ("' . $username . '","' . $password . '","' . $email . '");');
        return true;
    }
    public static function createToken($idUser)
    {
        $token = openssl_random_pseudo_bytes(128);
        $token = bin2hex($token);
        self::$connection->query('UPDATE users SET token="' . $token . '", tokenLife=NOW() + INTERVAL 1 DAY WHERE idUser=' . $idUser . ';');
        return $token;
    }
    public static function deleteToken($idUser, $username)
    {
        self::$connection->query('UPDATE users SET token=null, tokenLife=NOW() WHERE idUser=' . $idUser . ' and username="' . $username . '";');
    }
    public static function existItem($name,$series){
        //here will check if item allreadi exist , but maby i only need series because multiple product can have the same name
    }
    public static function addItem($name,$series,$item_type_id,$location_id)
    {
        $result=self::$connection->query("INSERT INTO item(name,series,item_type_id,location_id) values('$name','$series',$item_type_id,$location_id);");
        self::$connection->query("update item_type set count = count + 1 where id=$item_type_id");
        //uitate la documentatia de la bea insert id
    }
    public static function addItemTest($name,$series,$item_type_id,$location_id)
    {
        self::$connection->query("INSERT INTO Test_produs(name,series,item_type_id,location_id) values('$name','$series',$item_type_id,$location_id);");
       
        //uitate la documentatia de la bea insert id
    }
    public static function addProductPlace($type,$id){
        $arr=["deposit"=>"deposit_id","user"=>"user_id"];
        if(!key_exists($type,$arr))
        return null;
        self::$connection->query("INSERT INTO productLocation(".$arr[$type].") values($id);");
        $result=mysqli_insert_id(self::$connection);
        return $result;
    }
    public static function loginUser($username, $password)
    {
        //maby i need to see if the token exists , and it's lifetime  
        $query = self::$connection->query('SELECT username,idUser from users where username ="' . $username . '" and password ="' . $password . '";');
        if ($query->num_rows == 1) {
            $row = $query->fetch_assoc();
            $token = self::createToken($row["idUser"]);
            return [
                "idUser" => $row["idUser"],
                "username" => $row["username"],
                "token" => $token
            ];
        }
        return false;
        //here need to trow a error
    }
    public static function returnTableStruct($table, $type)
    { //shoud be rename return parameters
        //add something for restricted table
        if (array_key_exists($table, self::$structDB) === false) {
            return;
        }
        if ($type == "string") {
            $parametrii = '';
            if (array_key_exists($table, self::$restrictedTable)) {
                foreach (self::$structDB[$table] as $field)
                    if (array_search($field, self::$restrictedTable[$table]) === false) {
                        $parametrii .= $field . ', ';
                        // print_r($field."::\n");
                    }
                $parametrii = rtrim($parametrii, ", ");
                return $parametrii;
            }
            foreach (self::$structDB[$table] as $field)
                $parametrii .= $field . ', ';
            $parametrii = rtrim($parametrii, ", ");
            return $parametrii;
        } else if ($type == "array") {
            $parametrii = [];
            //nu mai trebuie ca deja ii array
            if (array_key_exists($table, self::$restrictedTable)) {
                foreach (self::$structDB[$table] as $field)
                    if (array_search($field, self::$restrictedTable[$table]) === false) {
                        $parametrii[] = $field;
                        // print_r($field."::\n");
                    }
                return $parametrii;
            }
            foreach (self::$structDB[$table] as $field)
                $parametrii[] = $field;
            return $parametrii;
        }
    }
    public static function runQueryRaw($query)
    { //this is for testing , do not use it as a function
        return self::$connection->query($query);
    }
    public static function runQuery($query){
        //it is dangerous because i don't verify for ilegal column
        $result = self::$connection->query($query);
        $rows = [];
        try {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // $rows[][$arrSt[]] = $row["Tables_in_" . Config::DATABASENAME];
                    // $data = "";
                    foreach ($row as $key => $value) {
                        // $data .= "[$key:$value],";
                        $rows[$key][] = $value;
                    }
                    // print_r($data . "\n");
                }
                return $rows;
            }else{
                return null;
            }
            
        } catch (\Throwable $th) {
            //throw $th;
        }
        return;
    }
    public static function updateCountDeposits(){
        $allDepositinUse=Database::runQuery("select id,deposit_id from productLocation where deposit_id is not null;");
        var_dump($allDepositinUse);
        for($i=0;$i<count($allDepositinUse['id']);$i++){
            $count=self::runQuery("select count(id) from item where location_id=".$allDepositinUse['id'][$i].";");
            $count=$count['count(id)'][0];
            // echo $allDepositinUse['deposit_id'][$i]." are ".$count."\n";
            self::$connection->query("update deposit set count=$count where id=".$allDepositinUse['deposit_id'][$i].";");
        }
    }
    public static function updateCountItemType(){
        $allUsersItems=Database::runQuery("select id from item_type");
        // print_r($allUsersItems);
        for($i=0;$i<count($allUsersItems['id']);$i++){
            $count=Database::runQuery("select count(id) from item where item_type_id=".$allUsersItems['id'][$i].";");
            $count=$count['count(id)'][0];
            Database::runQuery("update item_type set count=$count where id=".$allUsersItems['id'][$i].";");
        }
        $typeId=1;
        $data=Database::selectView("returnitemWithType","idType=$typeId");
        $data1=Database::selectView("returnItemWithTypeBaseUser","idType=$typeId");
        $data2=['id'=>null,'series'=>null,'name'=>null,'data'=>null];
        $data2['id']=array_merge($data['id'],$data1['id']);
        $data2['series']=array_merge($data['series'],$data1['series']);
        $data2['name']=array_merge($data['name'],$data1['name']);
        $data2['data']=array_merge($data['data'],$data1['data']);
    //   print_r($data2);
    }
    public static function addItemType($name, $count = 0)
    {
        $query = self::$connection->query('INSERT INTO item_type(name,count) values("' . $name . '",' . $count . ')');
    }
    //the one below need to be rewrite
    public static function selectFromTable($table, $type, $param = null)
    {
        //asta ar trebuii rescris neaparat
        $st = self::returnTableStruct($table, "string");
        $arrSt = self::returnTableStruct($table, "array");
        //i trust the user to not select password and other vital information
        if ($type == "interval") {

            if ($param == null)
                $param = [0, 0];
            //it should stop but for now i don't know where it will crash
            $q = "SELECT " . $st . " FROM " . $table . " WHERE " . substr($st, 0, strpos($st, ',')) . " BETWEEN " . $param[0] . " AND " . $param[1] . ";";
            // print_r($q);
            $result = self::$connection->query($q);
            $rows = [];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // $rows[][$arrSt[]] = $row["Tables_in_" . Config::DATABASENAME];
                    // $data = "";
                    foreach ($row as $key => $value) {
                        // $data .= "[$key:$value],";
                        $rows[$key][] = $value;
                    }
                    // print_r($data . "\n");
                }
            }

            return $rows;
        } else if ($type == "all") {
            // $st = self::returnTableStruct($table, "string");
            // $arrSt = self::returnTableStruct($table, "array");
            if ($param == null)
                $param = "";
            else
                $param = " where " . $param;
            $q = "SELECT " . $st . " FROM " . $table . $param . ";";
            // print_r($q);
            $result = self::$connection->query($q);
            $rows = [];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // $rows[][$arrSt[]] = $row["Tables_in_" . Config::DATABASENAME];
                    // $data = "";
                    foreach ($row as $key => $value) {
                        // $data .= "[$key:$value],";
                        $rows[$key][] = $value;
                    }
                    // print_r($data . "\n");
                }
            }
            return $rows;
        }else if($type=="chunk"){
            // $st = self::returnTableStruct($table, "string");
            // $arrSt = self::returnTableStruct($table, "array");
            if ($param == null)
                return;
            // else
            //     print_r($param);
            $q = "SELECT " . $st . " FROM " . $table . " limit ". $param[1] ." offset ".$param[0].";";
            // print_r($q);
            $result = self::$connection->query($q);
            $rows = [];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // $rows[][$arrSt[]] = $row["Tables_in_" . Config::DATABASENAME];
                    // $data = "";
                    foreach ($row as $key => $value) {
                        // $data .= "[$key:$value],";
                        $rows[$key][] = $value;
                    }
                    // print_r($data . "\n");
                }
            }
            return $rows;
        }
    }
    public static function selectView($view, $param = "")
    {
        if ($param !== "") {
            $param = " where " . $param;
        }
        $q = "SELECT * FROM " . $view . "_view" . $param . ";";
        // print_r($q);
        $result = self::$connection->query($q);
        $rows = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // $rows[][$arrSt[]] = $row["Tables_in_" . Config::DATABASENAME];
                // $data = "";
                foreach ($row as $key => $value) {
                    // $data .= "[$key:$value],";
                    $rows[$key][] = $value;
                }
                // print_r($data . "\n");
            }
        }
        return $rows;
    }
    public function getDeposit()
    {
        //at sql view , maby i should use a inner join , but for now is left join 
    }
    public static function searchProduct($by, $ToSearch)
    {
        switch ($by) {
            case 'name':
                echo "nume\n";
                break;

            case 'series':
                break;

            case 'type':
                break;

            default:
                echo "default\n";

                return null;
                break;
        }
        $q = "SELECT * FROM item where " . $by . " like '%" . $ToSearch . "%';";
        $result = self::$connection->query($q);
        $rows = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // $rows[][$arrSt[]] = $row["Tables_in_" . Config::DATABASENAME];
                // $data = "";
                foreach ($row as $key => $value) {
                    // $data .= "[$key:$value],";
                    $rows[$key][] = $value;
                }
                // print_r($data . "\n");
            }
        }
        return $rows;
    }
    public static function getProduct($id){
        $q = "SELECT * FROM item where id=$id;";
        $result = self::$connection->query($q);
        $rows = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // $rows[][$arrSt[]] = $row["Tables_in_" . Config::DATABASENAME];
                // $data = "";
                foreach ($row as $key => $value) {
                    // $data .= "[$key:$value],";
                    $rows[$key][] = $value;
                }
                // print_r($data . "\n");
            }
        }
        return $rows;
    }
    public static function debug()
    {
        echo "\n-----------structura tabel--------------------\n";
        print_r(Database::$structDB);
        echo "\n-----------structura interzisa--------------------\n";
        print_r(Database::$restrictedTable);
    }
}
