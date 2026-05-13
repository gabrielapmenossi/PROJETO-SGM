<?php

session_start();
require_once '../config/database.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Acesso negado.']);
    exit;
}

$id_chamado = (int) ($_GET['id_chamado'] ?? 0);

if ($id_chamado <= 0) {
    echo json_encode([]);
    exit;
}

$perfil = $_SESSION['user_perfil'];
$user_id = (int) $_SESSION['user_id'];

if ($perfil === 'solicitante') {
    $chk = $conn->query("SELECT id_chamado FROM chamados WHERE id_chamado = $id_chamado AND id_solicitante = $user_id LIMIT 1");
} elseif ($perfil === 'gestor') {
    $chk = $conn->query("SELECT id_chamado FROM chamados WHERE id_chamado = $id_chamado LIMIT 1");
} elseif ($perfil === 'tecnico') {
    $chk = $conn->query("SELECT id_chamado FROM chamados WHERE id_chamado = $id_chamado AND id_tecnico = $user_id LIMIT 1");
} else {
    echo json_encode([]);
    exit;
}

if (!$chk || $chk->num_rows === 0) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT caminho_arquivo, tipo_anexo FROM chamados_anexos WHERE id_chamado = $id_chamado ORDER BY data_upload ASC";
$res = $conn->query($sql);
$dados = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];

echo json_encode($dados);
