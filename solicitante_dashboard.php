<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM - Meus Chamados</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body class="portal-solicitante">
    <header>
        <div class="header-top">
            <h2>SGM | Painel do Solicitante</h2>
        </div>
        <div class="header-top">
            <h2>Olá, Maria Solicitante | </h2><a href="./api/logout.php"><button class="sair">Sair</button></a>
        </div>
   </header>
   <main>
        <div class="minhassolicitacoes">
            <h3>Minhas Solicitações</h3>
            <a href="./solicitante_abrir_chamado.php"><button class="novasolicitacao"> + Nova Solicitaçao</button></a>
        </div>
        <div class="solicitacoes">
            <table cellspacing="0" cellpadding="0" id="tabelaChamados">
                <thead class="thsolicitante">
                    <th>ID</th>
                    <th>Foto</th>
                    <th>Local</th>
                    <th>Descrição</th>
                    <th>Data</th>
                    <th>Status</th>
                </thead>
                <tbody id="listaChamados">
                    <tr>
                    </tr>
                </tbody>
            </table>
        </div>
   </main>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
   <script src="./assets/js/chamado_fotos_modal.js"></script>
   <script>
        async function carregarChamados() {
            const lista = document.getElementById('listaChamados');
            try {
                const res = await fetch('api/chamados.php');
                const data = await res.json();
                const chamados = Array.isArray(data) ? data : [];
                if (!Array.isArray(data) && data && data.success === false) {
                    lista.innerHTML = '<tr><td colspan="6">Acesso negado.</td></tr>';
                    return;
                }
                const cores = { 'aberto': 'bg-secondary', 'agendado': 'bg-info', 'em_execucao': 'bg-warning', 'concluido': 'bg-success', 'fechado': 'bg-dark', 'cancelado': 'bg-dark' };

                lista.innerHTML = chamados.map(function (c) {
                    const desc = (c.descricao_problema || '');
                    const descShort = desc.length > 30 ? desc.substring(0, 30) + '...' : desc;
                    const st = c.status || '';
                    const badge = cores[st] || 'bg-secondary';
                    return '<tr>' +
                        '<td>#' + c.id_chamado + '</td>' +
                        '<td>' + ChamadoFotos.celulaMiniatura(c.foto_caminho) + '</td>' +
                        '<td>' + (c.bloco_nome || '') + ' - ' + (c.ambiente_nome || '') + '</td>' +
                        '<td>' + descShort + '</td>' +
                        '<td>' + new Date(c.data_abertura).toLocaleDateString() + '</td>' +
                        '<td><span class="badge ' + badge + '">' + st.toUpperCase() + '</span></td>' +
                        '</tr>';
                }).join('');
            } catch (e) {
                console.error(e);
                lista.innerHTML = '<tr><td colspan="6">Erro ao carregar chamados.</td></tr>';
            }
        }
        carregarChamados();
   </script>
</body>
</html>
