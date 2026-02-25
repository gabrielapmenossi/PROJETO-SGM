<?php

session_start();

// Proteção: Apenas Gestores
if (!isset($_SESSION['user_id']) || $_SESSION['user_perfil'] !== 'gestor') {
    echo json_encode(["success" => false, "message" => "Acesso negado."]);
    exit;
}

$id = $_GET['id'] ?? 0;

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM - Detalhes do Chamado</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
    <a href="gestor_chamados.php"><button class="voltar">Voltar</button></a> 
    <main>
       <div class="dadosetriagem">
            <div class="dadossolicitacao">
                
                <div id="detalheFechamento"></div>
                <div class="a">
                    <div class="crad shadow mb-4">
                    <div class="card-header bg-white"><strong><h2>Dados da Solicitação</h2></strong></div>
                    <hr>
                    <div id="detalhesChamado" class="card-body">Carregando...</div>
                </div>
                    <div class="evidencias">
                        <p>Evidências</p>
                        <img src="./docs/telas/gestor_atribuir_chamado.png" alt="">
                    </div>
                </div>
                <a href="#"><button class="reabrir">Reabrir Chamado</button></a>
            </div>
            <div class="triagemeatribuicao">
                <div class="a">
                    <h2>Triagem e Atribuição</h2>
                    <hr>
                    <br>
                    <form id="formAtribuir">
                        <div class="triagens">
                            <label>Técnico</label>
                            <select id="selectTecnico" class="triagem" required></select>
                        </div>
                        <br>
                        <div class="triagens">
                            <label>Prioridade</label>
                            <select id="prioridade" class="triagem">
                                <option value="baixa">Baixa</option>
                                <option value="media">Média</option>
                                <option value="alta">Alta</option>
                                <option value="urgente">Urgente</option>
                            </select>
                        </div>
                        <br>
                        <div class="triagens">
                            <label>Data Prevista</label>
                            <input type="date" id="data_prevista" class="triagem" required>
                        </div>
                    </form>
                </div>
                <a href="#"><button type="submit" class="confirmar">Confirmar atribuição</button></a>
            </div>
       </div>
    </main>
    <script>
        function verFoto(url) {
            document.getElementById('imgModal').src = url;
            new bootstrap.Modal(document.getElementById('modalFoto')).show();
        }

        async function carregarDados() {
            // Carrega Técnicos
            const resTec = await fetch(`api/usuarios.php`);
            const tecnicos = await resTec.json();
            const select = document.getElementById('selectTecnico');
            select.innerHTML = '<option value="">Selecione um técnico...</option>';
            tecnicos.forEach(t => select.innerHTML += `<option value="${t.id_usuario}">${t.nome}</option>`);

            // Carrega Chamado
            const c = await (await fetch(`api/chamados.php?id=<?= $id ?>`)).json();
            document.getElementById('detalhesChamado').innerHTML = `
                <p><strong>Status:</strong> <span class="badge bg-secondary">${c.status.toUpperCase()}</span></p>
                <p><strong>Descrição:</strong> ${c.descricao_problema}</p>
                <p><strong>Local:</strong> ${c.bloco_nome} - ${c.ambiente_nome}</p>
                <p><strong>Solicitante:</strong> ${c.solicitante_nome}</p>
                <p><strong>Abertura:</strong> ${new Date(c.data_abertura).toLocaleString()}</p>
                <div id="fotosContainer"></div>
            `;

            if(c.id_tecnico) document.getElementById('selectTecnico').value = c.id_tecnico;
            if(c.prioridade) document.getElementById('prioridade').value = c.prioridade;
            if(c.data_previsao_conclusao) document.getElementById('data_prevista').value = c.data_previsao_conclusao;

            // Carrega Fotos
            const anexos = await (await fetch(`api/anexos.php?id_chamado=<?= $id ?>`)).json();
            if(anexos.length > 0) {
                let htmlFotos = '<hr><h6>Evidências:</h6><div class="row">';
                anexos.forEach(arq => {
                    htmlFotos += `
                        <div class="col-4 text-center mb-2">
                            <img src="${arq.caminho_arquivo}" class="thumb-img" onclick="verFoto('${arq.caminho_arquivo}')">
                            <small class="text-muted">${arq.tipo_anexo === 'abertura' ? 'Abertura' : 'Conclusão'}</small>
                        </div>`;
                });
                document.getElementById('fotosContainer').innerHTML = htmlFotos + '</div>';
            }

            // Botões de Status
            const area = document.getElementById('detalheFechamento');
            if (c.status === 'concluido') {
                area.innerHTML = `<div class="alert alert-success">
                    <h6>Técnico finalizou:</h6><p>${c.solucao_tecnica || 'Sem descrição'}</p>
                    <button onclick="alterarStatusOS(<?= $id ?>, 'fechar')" class="btn btn-success w-100">Fechar O.S.</button>
                </div>`;
            } else if (c.status === 'fechado') {
                area.innerHTML = `<button onclick="alterarStatusOS(<?= $id ?>, 'reabrir')" class="btn btn-warning w-100">Reabrir Chamado</button>`;
            }
        }

        async function alterarStatusOS(id, acao) {
            if(!confirm("Confirmar alteração de status?")) return;
            const res = await fetch('api/gestor_acoes.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ id_chamado: id, acao: acao })
            });
            if((await res.json()).success) location.reload();
        }

        document.getElementById('formAtribuir').onsubmit = async (e) => {
            e.preventDefault();
            const res = await fetch('api/atribuir_chamado.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({
                    id_chamado: <?= $id ?>,
                    id_tecnico: document.getElementById('selectTecnico').value,
                    prioridade: document.getElementById('prioridade').value,
                    data_prevista: document.getElementById('data_prevista').value
                })
            });
            if((await res.json()).success) window.location.href = 'gestor_chamados.php';
        };

        carregarDados();
    </script>
</body>
</html>