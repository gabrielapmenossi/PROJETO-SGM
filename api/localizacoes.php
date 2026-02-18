<?php

require_once '../config/database.php';
header('Content-Type: application/json');

$acao = $_GET['acao'] ?? '';

if($acao === 'listar_blocos'){
    $res = $conn->query("SELECT id_bloco, nome from blocos");
    echo json_encode($res->fetch_all(MYSQLI_ASSOC));
}

elseif ($acao === 'listar_ambientes'){
    $id_bloco = (int)($_GET['id_bloco'] ?? 0);
    $stmt = $conn->prepare("SELECT id_ambiente, nome from ambientes where id_bloco = ?");
    $stmt->bind_param("i", $id_bloco);
    $stmt->execute();
    echo json_encode($stmt->get_result()->fetch_all(MYSQLI_ASSOC));
}

elseif($acao === 'listar_tipos'){
    $res = $conn->query("SELECT id_tipo, nome from tipos_servico");
    echo json_encode($res->fetch_all(MYSQLI_ASSOC));
}