<?php
abstract class Db {

    private $dbhost;
    private $dbuser;
    private $dbpass;
    private $dbname;
    public $mysqli;

    public function __construct() {
        $this->dbhost = "localhost";
        $this->dbuser = "root";
        $this->dbpass = "";
        $this->dbname = "tiramisu";

        $this->connect();
    }

    protected function connect(){
        $this->mysqli = mysqli_connect($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname) or die("Error " . mysqli_error($mysqli));
    }

    //Auxiliares
    protected function resourceToArray($res){
        $array = array();
        while ($row = $res->fetch_assoc()) {
            $array[] = $row;
        }
        return $array;
    }
    
    protected function resourceToObjects($res,$class){
        $array = array();
        while ($row = $res->fetch_assoc()) {
            $array[] = new $class($row);
        }
        return $array;
    }
}
?>