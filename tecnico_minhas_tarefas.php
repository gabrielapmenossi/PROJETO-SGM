<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM - Painel do Técnico</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* Ajuste do Header para ficar alinhado no celular */
        header {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }

        @media (max-width: 576px) {
            header { flex-direction: column; text-align: center; gap: 10px; }
            .header-top h2 { font-size: 1.2rem; }
            
            /* ==== CORREÇÃO DA SAUDAÇÃO NO MOBILE ==== */
            .saudacao-container {
                flex-wrap: nowrap !important; /* Força a ficar na mesma linha */
                justify-content: center;
            }
            .saudacao-container h2 {
                font-size: 0.95rem; /* Diminui a fonte levemente para caber o nome longo */
                white-space: nowrap; /* Impede o "|" de cair para a linha de baixo */
            }
        }

        /* ========================================================================
           TABELA RESPONSIVA (VIRA CARDS NO CELULAR)
           ======================================================================== */
        @media (max-width: 768px) {
            #tabelaChamados, #tabelaChamados thead, #tabelaChamados tbody, #tabelaChamados tr, #tabelaChamados td {
                display: block;
                width: 100%;
            }

            #tabelaChamados thead {
                display: none;
            }

            #tabelaChamados tr {
                margin-bottom: 20px;
                border: 1px solid #dee2e6;
                border-radius: 10px;
                background-color: #fff;
                box-shadow: 0 4px 6px rgba(0,0,0,0.05);
                overflow: hidden;
                padding: 5px 0;
            }

            #tabelaChamados td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 12px 15px !important;
                border-bottom: 1px solid #f2f2f2;
                text-align: right;
                word-break: break-word;
            }

            #tabelaChamados td:last-child {
                border-bottom: none;
            }

            #tabelaChamados td::before {
                content: attr(data-label);
                font-weight: bold;
                color: #A22C5B;
                text-align: left;
                padding-right: 10px;
                min-width: 90px;
                display: inline-block;
            }

            #tabelaChamados td > * {
                max-width: 65%; 
            }
        }
    </style>
</head>
<body class="portal-solicitante">
    <header>
        <div class="header-top">
            <h2>SGM | Painel do Técnico</h2>
        </div>
        <div class="header-top d-flex align-items-center gap-2 saudacao-container">
            <h2 class="m-0">Olá, Técnico | </h2>
            <a href="./api/logout.php" class="text-decoration-none"><button class="sair btn btn-danger btn-sm">Sair</button></a>
        </div>
   </header>

    <main class="container-fluid py-4">
        <div class="minhassolicitacoes mb-4">
            <h3>Chamados Atribuídos a Mim</h3>
        </div>

        <div class="solicitacoes">
            <table cellspacing="0" cellpadding="0" id="tabelaChamados" class="table table-hover">
                <thead class="thtecnico table-light">
                    <tr>
                        <th>ID</th>
                        <th>Foto</th>
                        <th>Local</th>
                        <th>Descrição</th>
                        <th>Data</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="listaChamados">
                    </tbody>
            </table>
        </div>
    </main>

    <div class="modal fade" id="modalDescricao" tabindex="-1" aria-labelledby="modalDescricaoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDescricaoLabel">Descrição Completa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <p id="textoDescricaoCompleta" class="text-break" style="white-space: pre-wrap; color: #333;"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/js/chamado_fotos_modal.js"></script>
    <script>
    window.abrirModalDescricao = function(textoCodificado) {
        const texto = decodeURIComponent(textoCodificado);
        document.getElementById('textoDescricaoCompleta').textContent = texto;
        const modal = new bootstrap.Modal(document.getElementById('modalDescricao'));
        modal.show();
    };

    // FUNÇÃO PARA ATUALIZAR STATUS
    async function atualizarStatus(idChamado, novoStatus) {
        try {
            // Ajustado para o nome do seu arquivo e pasta correta
            const res = await fetch('api/tecnico_atualizar_status.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ 
                    id_chamado: idChamado, // Nome corrigido para bater com o PHP
                    status: novoStatus 
                })
            });
            
            const data = await res.json();
            
            if (data.success) {
                alert('Status atualizado com sucesso!');
                carregarChamados(); // Recarrega a lista para atualizar as cores
            } else {
                alert('Erro: ' + data.message);
            }
        } catch (e) {
            console.error(e);
            alert('Erro de conexão ao tentar atualizar o status.');
        }
    }

    async function carregarChamados() {
        const lista = document.getElementById('listaChamados');
        try {
            const res = await fetch('api/chamados.php');
            const data = await res.json();
            const chamados = Array.isArray(data) ? data : [];
            
            if (chamados.length === 0) {
                lista.innerHTML = '<tr><td colspan="6" class="text-center">Nenhum chamado atribuído.</td></tr>';
                return;
            }
            
            lista.innerHTML = chamados.map(function (c) {
                const descEnc = encodeURIComponent(c.descricao_problema || '');
                const descShort = c.descricao_problema?.length > 25 ? c.descricao_problema.substring(0, 25) + '...' : c.descricao_problema;
                const st = c.status || 'agendado';

                // Cores dinâmicas para o select
                let corSelect = "#6c757d"; // Pendente
                if(st === 'em_execucao') corSelect = "#ffc107"; // Andamento
                if(st === 'concluido') corSelect = "#198754"; // Concluído

                return `<tr>
                    <td data-label="ID"><strong>#${c.id_chamado}</strong></td>
                    <td data-label="Foto">${ChamadoFotos.celulaMiniatura(c.foto_caminho)}</td>
                    <td data-label="Local">${c.bloco_nome || ''} - ${c.ambiente_nome || ''}</td>
                    <td data-label="Descrição">
                        <a href="javascript:void(0)" onclick="abrirModalDescricao('${descEnc}')" class="text-decoration-none text-dark">${descShort}</a>
                    </td>
                    <td data-label="Data">${new Date(c.data_abertura).toLocaleDateString('pt-BR')}</td>
                    <td data-label="Status">
                        <select class="form-select form-select-sm" 
                                style="font-weight:bold; color: white; background-color: ${corSelect}"
                                onchange="atualizarStatus(${c.id_chamado}, this.value)">
                            <option value="agendado" ${st === 'agendado' ? 'selected' : ''}>Pendente</option>
                            <option value="em_execucao" ${st === 'em_execucao' ? 'selected' : ''}>Em Andamento</option>
                            <option value="concluido" ${st === 'concluido' ? 'selected' : ''}>Concluído</option>
                        </select>
                    </td>
                </tr>`;
            }).join('');
        } catch (e) {
            console.error(e);
            lista.innerHTML = '<tr><td colspan="6" class="text-center">Erro ao carregar dados.</td></tr>';
        }
    }
    carregarChamados();
</script>
</body>
</html>