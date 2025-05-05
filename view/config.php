<?php
class Database {
    private $host = "localhost";
    private $dbname = "tarefa do jean";
    private $user = "root";
    private $pass = "";
    public $pdo;

    public function getConnection() {
        try {
            $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->pdo;
        } catch (PDOException $e) {
            die("Erro na conexão: " . $e->getMessage());
        }
    }
}
?>