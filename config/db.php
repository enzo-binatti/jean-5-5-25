<?php
require_once __DIR__ . '/config.php';

class Database {
    private $connection;
    
    public function __construct() {
        $this->connect();
    }
    
    private function connect() {
        try {
            $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if ($this->connection->connect_error) {
                throw new Exception("Erro de conexão: " . $this->connection->connect_error);
            }
            $this->connection->set_charset("utf8mb4");
        } catch (Exception $e) {
            error_log("Erro de conexão com o banco: " . $e->getMessage());
            throw new Exception("Não foi possível conectar ao banco de dados: " . $e->getMessage());
        }
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    public function query($sql, $params = []) {
        try {
            if (empty($params)) {
                $result = $this->connection->query($sql);
                return $result;
            }
            
            $stmt = $this->connection->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro na preparação da query: " . $this->connection->error);
            }
            
            $types = '';
            $bind_params = [];
            
            foreach ($params as $param) {
                if (is_int($param)) {
                    $types .= 'i';
                } elseif (is_float($param)) {
                    $types .= 'd';
                } else {
                    $types .= 's';
                }
                $bind_params[] = $param;
            }
            
            $stmt->bind_param($types, ...$bind_params);
            $stmt->execute();
            
            return $stmt->get_result();
        } catch (Exception $e) {
            error_log("Erro na query: " . $e->getMessage());
            throw new Exception("Erro ao executar a query: " . $e->getMessage());
        }
    }
    
    public function insert($table, $data) {
        $fields = array_keys($data);
        $values = array_values($data);
        
        $sql = "INSERT INTO $table (" . implode(", ", $fields) . ") VALUES (";
        $sql .= "?" . str_repeat(", ?", count($fields) - 1) . ")";
        
        $this->query($sql, $values);
        return $this->connection->insert_id;
    }
    
    public function select($table, $conditions = [], $fields = '*') {
        $sql = "SELECT $fields FROM $table";
        
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", array_keys($conditions));
        }
        
        return $this->query($sql, array_values($conditions));
    }
    
    public function update($table, $data, $conditions) {
        $set = [];
        foreach ($data as $field => $value) {
            $set[] = "$field = ?";
        }
        
        $sql = "UPDATE $table SET " . implode(", ", $set);
        
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", array_keys($conditions));
        }
        
        $values = array_values($data) + array_values($conditions);
        return $this->query($sql, $values);
    }
    
    public function delete($table, $conditions) {
        $sql = "DELETE FROM $table";
        
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", array_keys($conditions));
        }
        
        return $this->query($sql, array_values($conditions));
    }
}
