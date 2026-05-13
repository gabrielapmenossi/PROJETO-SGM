<?php

session_start();

require_once '../config/database.php';

header('Content-Type: application/json');

if (
    !isset($_SESSION['user_id']) ||
    $_SESSION['user_perfil'] !== 'tecnico'
) {
    echo json_encode([
        'success' => false,
        'message' => 'Acesso negado.',
    ]);
    exit;
}

$data = json_decode(file_get_contents('php://input'));

if (!isset($data->id_chamado) || !isset($data->status)) {
    echo json_encode([
        'success' => false,
        'message' => 'Dados incompletos.',
    ]);
    exit;
}

$id_chamado = (int) $data->id_chamado;
$status = $data->status;

$permitidos = ['agendado', 'em_execucao', 'concluido'];

if (!in_array($status, $permitidos, true)) {
    echo json_encode([
        'success' => false,
        'message' => 'Status inválido.',
    ]);
    exit;
}

$id_tecnico = (int) $_SESSION['user_id'];
$status_esc = $conn->real_escape_string($status);

$chk = $conn->query("
    SELECT id_chamado, status
    FROM chamados
    WHERE id_chamado = '$id_chamado'
      AND id_tecnico = '$id_tecnico'
    LIMIT 1
");

if (!$chk || $chk->num_rows === 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Chamado não encontrado ou não atribuído a você.',
    ]);
    exit;
}

$atual = $chk->fetch_assoc();

if (in_array($atual['status'], ['fechado', 'cancelado'], true)) {
    echo json_encode([
        'success' => false,
        'message' => 'Este chamado não pode mais ser alterado.',
    ]);
    exit;
}

if ($status === 'concluido') {
    $data_fech = $conn->real_escape_string(date('Y-m-d H:i:s'));
    $sql = "
        UPDATE chamados
        SET status = '$status_esc',
            data_fechamento = '$data_fech'
        WHERE id_chamado = '$id_chamado'
          AND id_tecnico = '$id_tecnico'
    ";
} else {
    $sql = "
        UPDATE chamados
        SET status = '$status_esc',
            data_fechamento = NULL
        WHERE id_chamado = '$id_chamado'
          AND id_tecnico = '$id_tecnico'
    ";
}

if ($conn->query($sql) === true) {
    echo json_encode([
        'success' => true,
        'message' => 'Status atualizado.',
        'status' => $status,
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Erro ao atualizar: ' . $conn->error,
    ]);
}
