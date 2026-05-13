<?php

session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

if(!isset($_SESSION['user_id']) || $_SESSION['user_perfil'] !== 'gestor'){
    echo json_encode([
        "success" => false,
        "message" => "Acesso negado."
    ]);
    exit;
}

$data = json_decode(file_get_contents("php://input"));

if(
    !isset($data->id_chamado) ||
    !isset($data->id_tecnico) ||
    !isset($data->prioridade) ||
    !isset($data->data_prevista)
){
    echo json_encode([
        "success" => false,
        "message" => "Dados incompletos."
    ]);
    exit;
}

$id_chamado = (int)$data->id_chamado;
$id_tecnico = (int)$data->id_tecnico;

$prioridade = $conn->real_escape_string($data->prioridade);
$data_prevista = $conn->real_escape_string($data->data_prevista);

$sql = "
UPDATE chamados
SET
    id_tecnico = '$id_tecnico',
    prioridade = '$prioridade',
    data_previsao_conclusao = '$data_prevista',
    status = 'em_execucao'
WHERE id_chamado = '$id_chamado'
";

if($conn->query($sql) === true){

    echo json_encode([
        "success" => true,
        "message" => "Chamado atribuído com sucesso!"
    ]);

}else{

    echo json_encode([
        "success" => false,
        "message" => "Erro ao atribuir chamado: " . $conn->error
    ]);

}