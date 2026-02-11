<?php
session_start();
require_once '../config/database.php';
header('Content-Type: application/json');

if(!isset($_SESSION['user_id']) || $_SESSION['user_perfil'] !== 'solicitante'){
    echo json_encode(["success" => false, "message" => "Acesso negado. "]);
    exit;
}

$sql = "SELECT chamados_anexos.caminho_arquivo, chamados_anexos.tipo_anexo from chamados_anexos;";
$res = $conn->query($sql);
$dados = $res->fetch_all(MYSQLI_ASSOC);
echo json_encode($dados);