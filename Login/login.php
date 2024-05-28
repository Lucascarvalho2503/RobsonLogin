<?php
$usuario = $_POST['usu'] ?? '';
$senha = $_POST['sem'] ?? '';

if (empty($usuario)) {
    echo json_encode([
        "status" => "0",
        "msg" => "Usuário não fornecido."
    ]);
    exit;
}

echo "Recebido usuário: " . htmlspecialchars($usuario) . "<br>"; // Mensagem de depuração

try {
    $pdo = new PDO("mysql:host=localhost;dbname=teste", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Consulta o banco de dados para o usuário fornecido
    $sql = "SELECT * FROM usuario u WHERE u.email = :email";
    $stm = $pdo->prepare($sql);
    $stm->bindParam(':email', $usuario);
    $stm->execute();
    $qry = $stm->fetchAll(PDO::FETCH_ASSOC);

    if ($qry === false) {
        echo json_encode([
            "status" => "0",
            "msg" => "Erro ao executar a consulta."
        ]);
    } else {
        echo "Consulta executada com sucesso.<br>";
        echo "Resultados encontrados: " . count($qry) . "<br>";

        if (count($qry) > 0) {
            // Verifica a senha
            if ($qry[0]['senha'] == $senha) {
                $response = [
                    "status" => "1",
                    "msg" => "Login efetuado com sucesso",
                    "token" => "asdyhoawjdisja",
                ];
            } else {
                $response = [
                    "status" => "0",
                    "msg" => "Usuário ou senha inválido"
                ];
            }
        } else {
            $response = [
                "status" => "0",
                "msg" => "Usuário não encontrado."
            ];
        }
        echo json_encode($response);
    }
} catch (PDOException $e) {
    echo json_encode([
        "status" => "0",
        "msg" => "Erro: " . $e->getMessage()
    ]);
}
?>
