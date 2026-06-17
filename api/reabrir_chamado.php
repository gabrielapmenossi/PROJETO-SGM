<?php

session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

if (
    !isset($_SESSION['user_id']) ||
    $_SESSION['user_perfil'] !== 'gestor'
) {
    echo json_encode([
        "success" => false,
        "message" => "Acesso negado."
    ]);
    exit;
}

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id_chamado)) {
    echo json_encode([
        "success" => false,
        "message" => "ID do chamado não informado."
    ]);
    exit;
}

$id_chamado = (int)$data->id_chamado;

$sql = "
UPDATE chamados
SET
    id_tecnico = NULL,
    status = 'aberto'
WHERE id_chamado = '$id_chamado'
";

if ($conn->query($sql) === TRUE) {

    echo json_encode([
        "success" => true,
        "message" => "Chamado reaberto com sucesso."
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "Erro ao reabrir chamado: " . $conn->error
    ]);

}