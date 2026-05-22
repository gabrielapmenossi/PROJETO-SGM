<?php

session_start();

require_once '../config/database.php';

header('Content-Type: application/json');

if(
    !isset($_SESSION['user_id']) ||
    $_SESSION['user_perfil'] !== 'tecnico'
){
    echo json_encode([]);
    exit;
}

$id_tecnico = $_SESSION['user_id'];

$sql = "
    SELECT
        c.id_chamado,
        c.descricao_problema,
        c.prioridade,
        c.status,
        c.data_previsao_conclusao,

        b.nome AS bloco_nome,
        a.nome AS ambiente_nome,
        ts.nome AS tipo_nome,

        (SELECT ca.caminho_arquivo FROM chamados_anexos ca
         WHERE ca.id_chamado = c.id_chamado
         ORDER BY (ca.tipo_anexo = 'abertura') DESC, ca.data_upload ASC, ca.id_anexo ASC
         LIMIT 1) AS foto_caminho

    FROM chamados c

    INNER JOIN ambientes a
        ON c.id_ambiente = a.id_ambiente

    INNER JOIN blocos b
        ON a.id_bloco = b.id_bloco

    INNER JOIN tipos_servico ts
        ON c.id_tipo_servico = ts.id_tipo

    WHERE c.id_tecnico = '$id_tecnico'

    ORDER BY c.id_chamado DESC
";

$result = $conn->query($sql);

$chamados = [];

if($result){

    while($row = $result->fetch_assoc()){

        $chamados[] = $row;

    }

}

echo json_encode($chamados);