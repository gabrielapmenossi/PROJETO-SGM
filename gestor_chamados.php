
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>SGM - Gestão de Chamados</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
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
        </div>
    </div>
<div class="modal fade" id="modalFoto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-0 text-center bg-dark">
                <img src="" id="imgModal" class="img-fluid">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<script>
    function verFoto(url) {
        document.getElementById('imgModal').src = url;
        new bootstrap.Modal(document.getElementById('modalFoto')).show();
    }
</script>
    <script>
        const coresPrioridade = { 'urgente': 'text-danger', 'alta': 'text-warning', 'media': 'text-primary', 'baixa': 'text-secondary' };
        const coresStatus = { 'aberto': 'bg-secondary', 'em_execucao': 'bg-warning', 'concluido': 'bg-success', 'fechado': 'bg-dark' };

        async function carregarChamados(status = '') {
            const res = await fetch(`api/gestor_chamados.php?status=${status}`);
            const chamados = await res.json();
            const body = document.getElementById('tabelaGeral');

            body.innerHTML = chamados.map(c => `
                <tr>
                    <td>#${c.id_chamado}</td>
                    <td>${c.solicitante_nome}</td>
                    <td>
                        <small class="text-muted">${c.bloco_nome}</small><br>
                        <strong>${c.ambiente_nome}</strong>
                    </td>
                    <td><i class="bi bi-circle-fill ${coresPrioridade[c.prioridade]} me-1"></i> ${c.prioridade.toUpperCase()}</td>
                    <td>${c.tecnico_nome || '<em class="text-muted">Não atribuído</em>'}</td>
                    <td><span class="badge ${coresStatus[c.status]}">${c.status.replace('_', ' ').toUpperCase()}</span></td>
                    <td>
                        <a href="gestor_detalhes.php?id=${c.id_chamado}" class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-eye"></i> Gerenciar
                        </a>
                    </td>
                </tr>
            `).join('');
        }

        carregarChamados();
    </script>
</body>
</html> 

