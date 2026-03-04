<?php
session_start();
require_once '../config/database.php';
header('Content-Type: application/json');

if(!isset($_SESSION['user_id']) || $_SESSION['user_perfil'] !== 'gestor'){
    echo json_encode(["success" => false, "message" => "Acesso negado. "]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method){
    case 'GET': 
        $sql = "SELECT b.id_bloco, b.nome, b.descricao FROM blocos b";
            $result = $conn->query($sql);
            $blocos = [];
            if($result){
                while($row = $result->fetch_assoc()){
                    $blocos[] = $row;
                }
            }
            echo json_encode(["sucess" => true, "data" => $blocos]);
        break;
    case 'POST': 
        $data = json_decode(file_get_contents("php://input"));
        if(!isset($data->nome) || !isset($data->descricao)){
            echo json_encode(["success" => false, "message" => "Dados incompletos. Informe nome e descrição"]);
            exit;
        }
        $nome = $conn->real_escape_string(trim($data->nome));
        $descricao = $data->descricao;
        $sql = "INSERT INTO blocos (nome, descricao) VALUES ('$nome', '$descricao')";
        if($conn->query($sql) === true){
            echo json_encode(["success" => true, "message" => "Bloco criado com sucesso!", "id_bloco" => $conn->insert_id]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro ao criar bloco: " . $conn->error]);
        }
        break;
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));

        if(!isset($data->nome)){
            echo json_encode(["success" => false, "message" => "Dados incompletos para atualização. "]);
            exit;
        }
        $id_bloco = (int)$data->id_bloco;
        $nome = $conn->real_escape_string(trim($data->nome));
        $descricao = $data->descricao;
        $sql = "UPDATE blocos SET nome = '$nome', descricao = $descricao WHERE id_bloco = $id_bloco";
        if($conn->query($sql) === true){
            echo json_encode(["success" => true, "message" => "Bloco atualizado com sucesso! " . $conn->error]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro ao atualizar Bloco: " . $con->error]);
        }
        break;
    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));
        if(!isset($data->id_bloco)){
            echo json_encode(["success" => false, "message" => "ID do bloco não fornecido. "]);
            exit;
        }
        $id_bloco = (int)$data->id_bloco;
        $sql = "DELETE FROM blocos WHERE id_bloco = $id_bloco";
        if($conn->query($sql) === true){
            echo json_encode(["success" => true, "message" => "Bloco excluído com sucesso! "]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro ao excluir: pode haver dados vinculados a este Bloco. "]);
        }
        break;
    default: 
        echo json_encode(["success" => false, "message" => "Método HTTP não suportado. "]);
        break;
}