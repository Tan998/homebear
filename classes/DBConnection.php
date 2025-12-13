<?php
if(!defined('DB_SERVER')){
    require_once("../initialize.php");
}
class DBConnection{

    private $host = DB_SERVER;
    private $username = DB_USERNAME;
    private $password = DB_PASSWORD;
    private $database = DB_NAME;
    private $port = DB_PORT;
    
    public $conn;
    //thêm port khi đưa lên server 205: , 3308
    public function __construct(){

        if (!isset($this->conn)) {
            
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database, $this->port);
            
            if (!$this->conn) {
                die("接続失敗しました: " . $conn->connect_error);
            }
            // Đặt charset UTF-8 để tránh lỗi hiển thị tiếng Nhật
            $this->conn->set_charset("utf8mb4");
        }    
        
    }
    public function __destruct(){
        $this->conn->close();
    }
}
?>