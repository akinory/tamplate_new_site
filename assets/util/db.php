<?php
/** 
 * @author D.A.O.C.
 **/
class db {    
    
    private $host = "127.0.0.1";
    private $port = "5432";
    private $db   = "template";
    private $user = "postgres"; 
    private $pass = "akinory18";
    private $conn;

    public function __construct(){}

    public function setParams($host,$port,$db,$user,$pass){
        $this->host = $host;
        $this->port = $port;
        $this->db   = $db;
        $this->user = $user;
        $this->pass = $pass;
    }

    public function openDb(){
        $this->conn = pg_connect("host=$this->host port=$this->port dbname=$this->db user=$this->user password=$this->pass");
        return $this->conn;
    }

    public function closeDb(){
        pg_close($this->conn);
    }
}
?>