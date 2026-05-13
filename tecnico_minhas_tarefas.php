<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_perfil'] !== 'tecnico') {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM - Minha Agenda</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body class="portal-tecnico">
    <header>
        <div class="header-top">
            <h2>SGM | Gestão de Técnico</h2>
        </div>
        <div class="header-top">
            <h2>Olá, <?= htmlspecialchars($_SESSION['user_nome'] ?? 'Técnico', ENT_QUOTES, 'UTF-8') ?> | </h2><a href="./api/logout.php"><button class="sair">Sair</button></a>
        </div>
    </header>
    <main>
        <h3>Minha Fila de Trabalho</h3>

    <div class="card shadow mt-3">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Foto</th>
                        <th>Local</th>
                        <th>Tipo</th>
                        <th>Prioridade</th>
                        <th>Status</th>
                        <th>Previsão</th>
                        <th>Situação</th>
                    </tr>
                </thead>

                <tbody id="tabelaChamados"></tbody>

            </table>

        </div>

    </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="./assets/js/chamado_fotos_modal.js"></script>
    <script>

const rotuloStatus = {
    aberto: 'Aberto',
    agendado: 'Pendente',
    em_execucao: 'Em execução',
    concluido: 'Finalizada',
    fechado: 'Fechado',
    cancelado: 'Cancelado'
};

function celulaAcaoStatus(c) {
    const bloqueado = c.status === 'fechado' || c.status === 'cancelado';
    if (bloqueado) {
        return '<span class="tecnico-status-bloqueado">—</span>';
    }
    const s = c.status;
    const selPend = (s === 'agendado' || s === 'aberto') ? ' selected' : '';
    const selExec = (s === 'em_execucao') ? ' selected' : '';
    const selFin = (s === 'concluido') ? ' selected' : '';
    return `
        <div class="tecnico-acao-status">
            <select class="tecnico-select-status" aria-label="Novo status do chamado #${c.id_chamado}">
                <option value="agendado"${selPend}>Pendente</option>
                <option value="em_execucao"${selExec}>Em execução</option>
                <option value="concluido"${selFin}>Finalizada</option>
            </select>
            <button type="button" class="btn-tecnico-atualizar-status">Salvar</button>
        </div>`;
}

async function carregarChamados(){

    try{

        const res = await fetch('api/tecnico_chamados.php');

        const data = await res.json();
        const chamados = Array.isArray(data) ? data : [];

        const tabela = document.getElementById('tabelaChamados');

        if(chamados.length === 0){

            tabela.innerHTML = `
                <tr>
                    <td colspan="8" class="text-center">
                        Nenhuma tarefa pendente!
                    </td>
                </tr>
            `;

            return;
        }

        tabela.innerHTML = chamados.map(c => `

            <tr data-id-chamado="${c.id_chamado}">

                <td>#${c.id_chamado}</td>

                <td>${ChamadoFotos.celulaMiniatura(c.foto_caminho)}</td>

                <td>
                    ${c.bloco_nome}<br>
                    <strong>${c.ambiente_nome}</strong>
                </td>

                <td>${c.tipo_nome}</td>

                <td>${c.prioridade}</td>

                <td class="tecnico-celula-status">${rotuloStatus[c.status] || c.status}</td>

                <td>${c.data_previsao_conclusao ?? '-'}</td>

                <td class="tecnico-celula-acao">${celulaAcaoStatus(c)}</td>

            </tr>

        `).join('');

    }catch(error){

        console.error(error);

        alert("Erro ao carregar chamados.");

    }

}

document.getElementById('tabelaChamados').addEventListener('click', async (e) => {
    const btn = e.target.closest('.btn-tecnico-atualizar-status');
    if (!btn) return;
    const tr = btn.closest('tr');
    const id = tr.getAttribute('data-id-chamado');
    const sel = tr.querySelector('.tecnico-select-status');
    if (!id || !sel) return;
    const status = sel.value;
    btn.disabled = true;
    try {
        const res = await fetch('api/tecnico_atualizar_status.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id_chamado: Number(id), status })
        });
        const json = await res.json();
        if (json.success) {
            await carregarChamados();
        } else {
            alert(json.message || 'Não foi possível atualizar o status.');
        }
    } catch (err) {
        console.error(err);
        alert('Erro de rede ao atualizar o status.');
    } finally {
        btn.disabled = false;
    }
});

carregarChamados();

</script>
</body>
</html>