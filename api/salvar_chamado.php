<?php

session_start();



require_once '../config/database.php';
header('Content-Type: application/json');

if(!isset($_SESSION['user_id']) || $_SESSION['user_perfil'] !== 'solicitante'){
    header("Location: login.php");
    exit;
}

// if(!isset($_SESSON['user_id'])){
//     echo json_encode(["sucess" => false, "message" => "Sessão expirada. "]);
//     exit;
// }

$id_solicitante = $_SESSION['user_id'];
$id_ambiente = (int)($_POST['id_ambiente'] ?? 0);
$id_tipo = (int)($_POST['id_tipo'] ?? 0);
$descricao = $conn->real_Escape_string($_POST['descricao'] ?? 0);

if(!$id_ambiente || !$id_tipo || empty($descricao)){
    echo json_encode(["sucess" => false, "message" => "Preencha todos os campos!"]);
    exit;
}

$sql = "INSERT INTO chamados (descricao_problema, id_solicitante, id_ambiente, id_tipo_servico, status) values ('$descricao', $id_solicitante, $id_ambiente, $id_tipo, 'aberto')";
if($conn->query($sql)){
    $id_chamado = $conn->insert_id;
    if(isset($_FILES['foto']) && $_FILES['foto']['name'] === UPLOAD_ERR_OK){
        $diretorio = "../assets/uploads/";
        if(!is_dir($diretorio)) mkdir($diretorio, 0777, true);
        $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $nome_arquivo = "abertura_" . uniqid() . "." . $extensao;
        $caminho_final = $diretorio . $nome_arquivo;
        if(move_uploaded_file($_FILES['foto']['tmp_name'], $caminho_final)){
            $caminho_db = "assets/uploads/" . $nome_arquivo;
            $conn->query("INSERT INTO chamados_anexos (id_chamado, chaminho arquivo, tipo anexo)
            value ($id_chamado, '$caminho_db', 'abertura')");
        }
    }
    
    echo json_encode(["sucess" => true, "message" => "Chamado #$id_chamado aberto com sucesso!"]);
} else {
    echo json_encode(["sucess" => false, "message" => "Erro: " . $conn->error]);
}