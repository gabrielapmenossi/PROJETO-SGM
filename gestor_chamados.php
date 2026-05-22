<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>SGM - Gestão de Chamados</title>
    
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <style>
        /* =========================================
           Reset e Ajustes Globais
           ========================================= */
        body {
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .header-top {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header-top h2 {
            margin: 0;
            font-size: 1rem;
        }

        .sair {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 5px 12px;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        .voltar {
            margin: 15px;
            padding: 8px 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background: #fff;
            font-weight: 500;
        }

        /* =========================================
           Filtros e Botões
           ========================================= */
        .filtros-container {
            display: flex;
            flex-wrap: wrap; 
            gap: 8px;
            margin-bottom: 20px;
        }

        .filtros-container button {
            flex: 1; 
            min-width: 120px; 
            white-space: nowrap;
        }

        /* =========================================
           Tabela Desktop
           ========================================= */
        .card-tabela {
            border-radius: 12px;
            overflow: hidden;
            border: none;
            background: #fff;
        }

        .table thead th {
            background-color: #e9f0fc; /* Cor leve para o cabeçalho */
            color: #333;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #dee2e6;
        }

        .table img {
            max-width: 45px;
            border-radius: 6px;
        }

        /* =========================================
           MEDIA QUERIES (CELULAR - TABELA EM CARDS)
           ========================================= */
        @media (max-width: 768px) {
            header {
                flex-direction: column !important;
                text-align: center;
                padding: 15px !important;
                gap: 10px;
            }

            .header-top {
                flex-direction: column !important;
            }

            header .header-top:last-child {
                flex-direction: row !important;
                justify-content: center;
            }

            .voltar {
                display: block;
                width: calc(100% - 30px);
                margin: 10px auto;
                text-align: center;
            }

            /* TRANSFORMAR TABELA EM CARDS */
            .table thead {
                display: none; /* Esconde o cabeçalho original */
            }

            .table, .table tbody, .table tr, .table td {
                display: block;
                width: 100%;
            }

            .table tr {
                margin-bottom: 15px;
                border: 1px solid #ccc;
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0,0,0,0.05);
                padding: 5px 0;
            }

            .table td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                text-align: right;
                padding: 12px 15px !important;
                border-bottom: 1px solid #eee;
                font-size: 0.95rem;
            }

            .table td:last-child {
                border-bottom: none;
                justify-content: center; /* Centraliza o botão de ação */
            }

            /* USA O DATA-LABEL COMO TÍTULO NO CELULAR */
            .table td::before {
                content: attr(data-label);
                font-weight: bold;
                text-align: left;
                padding-right: 15px;
                color: #555;
            }

            .table td[data-label="Ações"]::before {
                display: none; /* Esconde a palavra "Ações" para focar no botão */
            }
        }
    </style>
</head>
<body class="portal-gestor">
    <header>
        <div class="header-top">
            <h2 class="fs-5">SGM | Gestão Administrativa</h2>
        </div>
        <div class="header-top">
            <h2 class="fs-5">Olá, Admin Gestor | </h2>
            <a href="./api/logout.php"><button class="sair">Sair</button></a>
        </div>
    </header>

    <main>
        <div class="w-100">
            <a href="gestor_dashboard.php"><button class="voltar">Voltar</button></a> 
        </div>

        <div class="container">
            <h2 class="mb-4 mt-2 text-center text-md-start">Todos os Chamados</h2>

            <div class="filtros-container">
                <button class="btn btn-outline-secondary" onclick="carregarChamados('')">Todos</button>
                <button class="btn text-white" style="background-color: #A67CEB;" onclick="carregarChamados('aberto')">Abertos</button>
                <button class="btn text-dark" style="background-color: #70E689;" onclick="carregarChamados('em_execucao')">Em Execução</button>
                <button class="btn text-dark" style="background-color: #E6B070;" onclick="carregarChamados('concluido')">Concluídos</button>
            </div>

            <div class="card card-tabela shadow-sm w-100 mb-5">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
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
                        <tbody id="tabelaGeral">
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/js/chamado_fotos_modal.js"></script>
    
    <script>
        const coresPrioridade = { 
            'urgente': 'text-danger', 
            'alta': 'text-warning', 
            'media': 'text-primary', 
            'baixa': 'text-secondary' 
        };
        
        const coresStatus = {
            'aberto': 'bg-secondary',
            'agendado': 'bg-info',
            'em_execucao': 'bg-warning text-dark',
            'concluido': 'bg-success',
            'fechado': 'bg-dark',
            'cancelado': 'bg-secondary'
        };

        async function carregarChamados(status = '') {
            const body = document.getElementById('tabelaGeral');
            body.innerHTML = '<tr><td colspan="8" class="text-center">Carregando...</td></tr>';
            
            try {
                const res = await fetch('api/gestor_chamados.php?status=' + encodeURIComponent(status));
                const data = await res.json();
                const chamados = Array.isArray(data) ? data : [];

                if (!Array.isArray(data) && data && data.success === false) {
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
                    
                    // ATENÇÃO: Adicionado data-label em todas as <td>
                    return `
                    <tr>
                        <td data-label="ID"><strong>#${c.id_chamado}</strong></td>
                        <td data-label="Foto">${ChamadoFotos.celulaMiniatura(c.foto_caminho)}</td>
                        <td data-label="Solicitante">${c.solicitante_nome ?? ''}</td>
                        <td data-label="Local / Tipo">
                            <span class="text-muted d-block" style="font-size: 0.85em;">${c.bloco_nome ?? ''}</span>
                            <strong>${c.ambiente_nome ?? ''}</strong>
                        </td>
                        <td data-label="Prioridade"><i class="bi bi-circle-fill ${coresPrioridade[prio]} me-1" style="font-size: 10px;"></i> ${prio.toUpperCase()}</td>
                        <td data-label="Técnico">${c.tecnico_nome ? c.tecnico_nome : '<em class="text-muted">Não atribuído</em>'}</td>
                        <td data-label="Status"><span class="badge ${badgeClass}">${stLabel}</span></td>
                        <td data-label="Ações">
                            <a href="gestor_detalhes.php?id=${c.id_chamado}" class="btn btn-sm btn-outline-primary px-4">
                                <i class="bi bi-gear"></i> Gerenciar
                            </a>
                        </td>
                    </tr>`;
                }).join('');
            } catch (e) {
                console.error(e);
                body.innerHTML = '<tr><td colspan="8" class="text-center text-danger">Erro ao carregar dados.</td></tr>';
            }
        }

        carregarChamados();
    </script>
</body>
</html>