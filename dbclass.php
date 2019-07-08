<?php
class Database {
    // protected $servername = "localhost:3307";
    // protected $dbName = "lets_go_to_switzerland";
    // protected $userName = "root";
    // protected $passCode = "";
    public $connection;
    protected $servername = "localhost";
    protected $dbName = "id10129394_lets_go_to_switzerland";
    protected $userName = "id10129394_lets_go_to_switzerland";
    protected $passCode = "3@Y79bpSV(_Rh#RL";

    function getConnection(){
        $this->connection = mysqli_connect(
            $this->servername, 
            $this->userName, 
            $this->passCode, 
            $this->dbName
        );

        if (!$this->connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        return $this->connection;
    }
}
?>