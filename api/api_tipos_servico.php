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
        $sql = "SELECT id_tipo, nome, descricao FROM tipos_servico";
            $result = $conn->query($sql);
            $tipos_servico = [];
            if($result){
                while($row = $result->fetch_assoc()){
                    $tipos_servico[] = $row;
                }
            }
            echo json_encode(["sucess" => true, "data" => $tipos_servico]);
        break;
    case 'POST': 
        $data = json_decode(file_get_contents("php://input"));
        if(!isset($data->nome) || !isset($data->descricao)){
            echo json_encode(["success" => false, "message" => "Dados incompletos. Informe nome e descrição"]);
            exit;
        }
        $nome = $conn->real_escape_string(trim($data->nome));
        $descricao = $data->descricao;
        $sql = "INSERT INTO tipos_servico (nome, descricao) VALUES ('$nome', '$descricao')";
        if($conn->query($sql) === true){
            echo json_encode(["success" => true, "message" => "Tipo de serviço criado com sucesso!", "id_tipo" => $conn->insert_id]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro ao criar tipo de serviço: " . $conn->error]);
        }
        break;
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));

        if(!isset($data->nome)){
            echo json_encode(["success" => false, "message" => "Dados incompletos para atualização. "]);
            exit;
        }
        $id_tipo = (int)$data->id_tipo;
        $nome = $conn->real_escape_string(trim($data->nome));
        $descricao = $data->descricao;
        $sql = "UPDATE tipos_servico SET nome = '$nome', descricao = '$descricao' WHERE id_tipo = '$id_tipo'";
        if($conn->query($sql) === true){
            echo json_encode(["success" => true, "message" => "Tipo de serviço atualizado com sucesso! " . $conn->error]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro ao atualizar tipo de serviço: " . $con->error]);
        }
        break;
    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));
        if(!isset($data->id_tipo)){
            echo json_encode(["success" => false, "message" => "ID do tipo de serviço não fornecido. "]);
            exit;
        }
        $id_tipo = (int)$data->id_tipo;
        $sql = "DELETE FROM tipos_servico WHERE id_tipo = $id_tipo";
        if($conn->query($sql) === true){
            echo json_encode(["success" => true, "message" => "Tipo de serviço excluído com sucesso! "]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro ao excluir: pode haver dados vinculados a este tipo de serviço. "]);
        }
        break;
    default: 
        echo json_encode(["success" => false, "message" => "Método HTTP não suportado. "]);
        break;
}