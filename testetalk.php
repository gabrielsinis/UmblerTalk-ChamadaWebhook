<?php
// Configuração do banco de dados
$servername = "mysql247.umbler.com";
$username = "gabrielsinis";
$password = "sdasdasdasd";
$dbname = "projeto1talk";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Checa a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Define o cabeçalho para permitir requisições CORS (se necessário)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Recebe os dados da solicitação POST
$data = json_decode(file_get_contents("php://input"), true);

// Verifica se o CPF foi enviado
if (isset($data['cpf'])) {
    $cpf = $data['cpf'];

    // Consulta no banco de dados
    $stmt = $conn->prepare("SELECT * FROM user WHERE cpf = ?");
    $stmt->bind_param("s", $cpf);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // CPF existe, seguir fluxo 1
        echo json_encode(['message' => 'CPF encontrado. Seguir fluxo 1.']);
    } else {
        // CPF não existe, seguir fluxo 2
        echo json_encode(['message' => 'CPF não encontrado. Seguir fluxo 2.']);
    }

    $stmt->close();
} else {
    echo json_encode(['message' => 'CPF não fornecido']);
}

// Fecha a conexão
$conn->close();
?>
