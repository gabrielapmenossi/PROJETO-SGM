
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>SGM - Gestão de Chamados</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body class="portal-gestor">
    <header>
        <div class="header-top" >
            <h2 class="fs-5 ">SGM | Gestão Administrativa</h2>
        </div>
        <div class="header-top" >
            <h2 class="fs-5 ">Olá, Admin Gestor | </h2><a href="./api/logout.php"><button class="sair">Sair</button></a>
        </div>
    </header>
<main>
    <div class="w-100 ">
        <a href="gestor_dashboard.php"><button class="voltar ">Voltar</button></a> 
    </div>
    <div class="container">
        <br>
        <h2 class="mb-4">Todos os Chamados</h2>

        <div class="mb-3 d-flex gap-2">
            <button class="btn btn-sm btn-outline-secondary" style="background-color:" onclick="carregarChamados('')">Todos</button>
            <button class="btn btn-sm" style="background-color: #A67CEB;" onclick="carregarChamados('aberto')">Abertos</button>
            <button class="btn btn-sm" style="background-color: #70E689;" onclick="carregarChamados('em_execucao')">Em Execução</button>
            <button class="btn btn-sm" style="background-color: #E6B070;" onclick="carregarChamados('concluido')">Concluídos</button>
        </div>

        <div class="card shadow w-100">
            <div class="table-responsive w-100">
                <table class="table table-hover align-middle mb-0 ">
                    <thead class="">
                        <tr>
                            <th>ID</th>
                            <th>Foto</th>
                            <th>Solicitante</th>
                            <th>Local / Tipo</th>
                            <th>Prioridade</th>
                            <th>Técnico</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody id="tabelaGeral"></tbody>
                </table>
            </div>
            <br>
        </div>
        <br>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<script src="./assets/js/chamado_fotos_modal.js"></script>
    <script>
        const coresPrioridade = { 'urgente': 'text-danger', 'alta': 'text-warning', 'media': 'text-primary', 'baixa': 'text-secondary' };
        const coresStatus = {
            'aberto': 'bg-secondary',
            'agendado': 'bg-info',
            'em_execucao': 'bg-warning',
            'concluido': 'bg-success',
            'fechado': 'bg-dark',
            'cancelado': 'bg-secondary'
        };

        async function carregarChamados(status = '') {
            const body = document.getElementById('tabelaGeral');
            try {
                const res = await fetch('api/gestor_chamados.php?status=' + encodeURIComponent(status));
                const data = await res.json();
                const chamados = Array.isArray(data) ? data : [];

                if (!Array.isArray(data) && data && data.success === false) {
                    alert(data.message || 'Não foi possível carregar os chamados.');
                    body.innerHTML = '<tr><td colspan="8" class="text-center text-muted">—</td></tr>';
                    return;
                }

                if (chamados.length === 0) {
                    body.innerHTML = '<tr><td colspan="8" class="text-center text-muted">Nenhum chamado encontrado.</td></tr>';
                    return;
                }

                body.innerHTML = chamados.map(c => {
                    const prio = c.prioridade || 'baixa';
                    const st = c.status || '';
                    const badgeClass = coresStatus[st] || 'bg-secondary';
                    const stLabel = st.replace(/_/g, ' ').toUpperCase();
                    return `
                <tr>
                    <td>#${c.id_chamado}</td>
                    <td>${ChamadoFotos.celulaMiniatura(c.foto_caminho)}</td>
                    <td>${c.solicitante_nome ?? ''}</td>
                    <td>
                        <small class="text-muted">${c.bloco_nome ?? ''}</small><br>
                        <strong>${c.ambiente_nome ?? ''}</strong>
                    </td>
                    <td><i class="bi bi-circle-fill ${coresPrioridade[prio] || 'text-secondary'} me-1"></i> ${prio.toUpperCase()}</td>
                    <td>${c.tecnico_nome ? c.tecnico_nome : '<em class="text-muted">Não atribuído</em>'}</td>
                    <td><span class="badge ${badgeClass}">${stLabel}</span></td>
                    <td>
                        <a href="gestor_detalhes.php?id=${c.id_chamado}" class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-eye"></i> Gerenciar
                        </a>
                    </td>
                </tr>`;
                }).join('');
            } catch (e) {
                console.error(e);
                alert('Erro ao carregar os chamados.');
                body.innerHTML = '<tr><td colspan="8" class="text-center text-danger">Erro ao carregar dados.</td></tr>';
            }
        }

        carregarChamados();
    </script>
</body>
</html> 

