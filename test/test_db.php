<?php
require_once __DIR__ . '/../config/db.php';

try {
    // Criar instância do banco
    $db = new Database();
    
    // Testar conexão
    if ($db->getConnection()) {
        echo "Conexão com o banco de dados estabelecida com sucesso!\n";
    } else {
        throw new Exception("Não foi possível conectar ao banco de dados");
    }
    
    // Testar inserção
    $usuario = [
        'nome' => "Teste " . time(),
        'email' => "teste" . time() . "@teste.com",
        'telefone' => "999999999",
        'senha' => password_hash("123456", PASSWORD_DEFAULT)
    ];
    
    $id = $db->insert('usuarios', $usuario);
    
    if ($id) {
        echo "Usuário inserido com sucesso! ID: $id\n";
        
        // Verificar se o usuário foi inserido
        $result = $db->select('usuarios', ['id' => $id]);
        if ($result->num_rows > 0) {
            $usuario = $result->fetch_assoc();
            echo "Usuário encontrado:\n";
            echo "ID: " . $usuario['id'] . "\n";
            echo "Nome: " . $usuario['nome'] . "\n";
            echo "Email: " . $usuario['email'] . "\n";
            echo "Telefone: " . $usuario['telefone'] . "\n";
        } else {
            throw new Exception("Usuário não encontrado no banco de dados");
        }
    } else {
        throw new Exception("Erro ao inserir usuário");
    }
    
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
    error_log("Erro no teste do banco: " . $e->getMessage());
}
