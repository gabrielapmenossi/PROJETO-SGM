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
        $sql = "SELECT id_usuario, nome, email, perfil, ativo, data_criacao FROM usuarios";
            $result = $conn->query($sql);
            $usuarios = [];
            if($result){
                while($row = $result->fetch_assoc()){
                    $usuarios[] = $row;
                }
            }
            echo json_encode(["success" => true, "data" => $usuarios]);
        break;
    case 'POST': 
        $data = json_decode(file_get_contents("php://input"));
        if(!isset($data->nome) || !isset($data->email)){
            echo json_encode(["success" => false, "message" => "Dados incompletos. Informe nome e email"]);
            exit;
        }
        $nome = $conn->real_escape_string(trim($data->nome));
        $email = $data->email;
        $perfil = $data->perfil;
        $sql = "INSERT INTO usuarios (nome, email, perfil) VALUES ('$nome', '$email', '$perfil')";
        if($conn->query($sql) === true){
            echo json_encode(["success" => true, "message" => "Usuário criado com sucesso!", "id_usuario" => $conn->insert_id]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro ao criar usuário: " . $conn->error]);
        }
        break;
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));

        if(!isset($data->nome)){
            echo json_encode(["success" => false, "message" => "Dados incompletos para atualização. "]);
            exit;
        }
        $id_usuario = (int)$data->id_usuario;
        $nome = $conn->real_escape_string(trim($data->nome));
        $email = $data->email;
        $perfil = $data->perfil;
        $sql = "UPDATE usuarios SET nome = '$nome', email = '$email', perfil = '$perfil' WHERE id_usuario = '$id_usuario'";
        if($conn->query($sql) === true){
            echo json_encode(["success" => true, "message" => "Usuário atualizado com sucesso! " . $conn->error]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro ao atualizar usuário: " . $con->error]);
        }
        break;
    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));
        if(!isset($data->id_usuario)){
            echo json_encode(["success" => false, "message" => "ID do usuário não fornecido. "]);
            exit;
        }
        $id_usuario = (int)$data->id_usuario;
        $sql = "DELETE FROM usuarios WHERE id_usuario = $id_usuario";
        if($conn->query($sql) === true){
            echo json_encode(["success" => true, "message" => "Usuário excluído com sucesso! "]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro ao excluir: pode haver dados vinculados a este usuário. "]);
        }
        break;
    default: 
        echo json_encode(["success" => false, "message" => "Método HTTP não suportado. "]);
        break;
}