<?php 

class Conexion{
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $database = "pokemontienda";
    private $con;

    public function __construct()
    {
        try {
            $this->con = new PDO("mysql:dbname=$this->database;host=$this->host", $this->user, $this->pass);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            echo "Error Conexion: ".$e->getMessage();
    }
}

    /**
     * Get the value of con
     */
    public function getCon()
    {
        return $this->con;
    }
}