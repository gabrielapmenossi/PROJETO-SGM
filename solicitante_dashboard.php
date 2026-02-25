<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM - Meus Chamados</title>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
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

   <script>
      function verFoto(url) {
            document.getElementById('imgModal').src = url;
            new bootstrap.Modal(document.getElementById('modalFoto')).show();
        }

        async function carregarChamados() {
            const chamados = await (await fetch('api/chamados.php')).json();
            const lista = document.getElementById('listaChamados');
            const cores = { 'aberto': 'bg-secondary', 'agendado': 'bg-info', 'em_execucao': 'bg-warning', 'concluido': 'bg-success', 'fechado': 'bg-dark' };

            lista.innerHTML = await Promise.all(chamados.map(async c => {
                // Busca se tem foto para mostrar miniatura na lista
                const anexos = await (await fetch(`api/anexos.php?id_chamado=${c.id_chamado}`)).json();
                const thumbHtml = anexos.length > 0 ?
                    `<img src="${anexos[0].caminho_arquivo}" class="mini-thumb" onclick="verFoto('${anexos[0].caminho_arquivo}')">` :
                    '<i class="bi bi-image text-muted"></i>';

                return `<tr>
    <td>#${c.id_chamado}</td>
    <td>${thumbHtml}</td>
    <td>${c.bloco_nome} - ${c.ambiente_nome}</td>
    <td>${c.descricao_problema.substring(0,30)}...</td>
    <td>${new Date(c.data_abertura).toLocaleDateString()}</td>
    <td><span class="badge ${cores[c.status]}">${c.status.toUpperCase()}</span></td>
</tr>`;
            })).then(rows => rows.join(''));
        }
        carregarChamados();
   </script>
</body>
</html>