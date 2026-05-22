<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM - Configurar Tipos de Serviço</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <style>
        /* =========================================
           Ajustes Básicos Desktop
           ========================================= */
        @media (min-width: 769px) {
            header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px 20px;
            }
            .header-top {
                display: flex;
                align-items: center;
            }
            .links {
                display: flex;
                justify-content: center;
                gap: 20px;
                margin-top: 20px;
            }
            .w-75 {
                margin: 0 auto;
            }
            .voltar { margin: 10px 20px; }
        }

        /* =========================================
           CSS RESPONSIVO (Apenas Mobile - Reforçado)
           ========================================= */
        @media (max-width: 768px) {
            
            /* -- Header Ajustado -- */
            header {
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
                text-align: center !important;
                padding: 20px 15px 15px 15px !important;
                gap: 15px !important;
                height: auto !important; /* Impede que o fundo fique cortado */
            }

            .header-top {
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
                justify-content: center !important;
                width: 100% !important;
            }

            /* Container do "Olá" e Botão Sair */
            header .header-top:last-child {
                flex-direction: row !important; /* Lado a lado */
                gap: 15px !important;
            }

            .header-top h5 {
                margin: 0 !important;
                font-size: 1.1rem !important;
                white-space: normal !important; /* Deixa o texto quebrar naturalmente */
                line-height: 1.3 !important;
            }

            .sair {
                margin: 0 !important;
                padding: 5px 15px !important;
            }

            /* -- Botão Voltar -- */
            .voltar { 
                display: block !important;
                margin: 15px auto !important; 
                width: calc(100% - 30px) !important;
                text-align: center !important;
            }
            
            a[href="gestor_dashboard.php"] {
                text-decoration: none !important;
            }

            /* -- Botões de Ação (Criar, Deletar, Atualizar) -- */
            .links {
                display: flex !important;
                flex-direction: column !important; /* Força empilhar 1 embaixo do outro */
                gap: 12px !important;
                padding: 0 15px !important;
                margin-top: 10px !important;
            }

            .links a {
                width: 100% !important;
                display: block !important;
            }

            .configurar {
                width: 100% !important;
                display: flex !important;
                flex-direction: row !important;
                align-items: center !important;
                justify-content: center !important; /* Centraliza ícone e texto */
                padding: 12px !important;
                gap: 10px !important;
                margin: 0 !important;
            }

            .configurar p {
                margin: 0 !important;
            }

            /* -- Tabela em formato de Cards -- */
            .w-75 {
                width: 100% !important;
                padding: 0 15px !important;
            }

            table.table, thead, tbody, th, td, tr {
                display: block !important;
                width: 100% !important;
            }

            thead {
                display: none !important; /* Esconde cabeçalho */
            }

            tr {
                margin-bottom: 15px !important;
                border: 1px solid #dee2e6 !important;
                border-radius: 8px !important;
                background-color: #fff !important;
                box-shadow: 0 2px 5px rgba(0,0,0,0.05) !important;
                padding: 5px 0 !important;
            }

            td {
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
                padding: 12px 15px !important;
                border-bottom: 1px solid #eee !important;
                text-align: right !important;
                word-break: break-word !important;
                gap: 15px !important;
            }

            td:last-child {
                border-bottom: none !important;
            }

            td::before {
                content: attr(data-label);
                font-weight: bold !important;
                text-align: left !important;
                color: #333 !important;
                white-space: nowrap !important;
            }
        }
    </style>
</head>
<body class="portal-gestor">
    <header>
        <div class="header-top">
            <h5>SGM | Configurar Tipos de Serviço</h5>
        </div>
        <div class="header-top">
            <h5>Olá, Admin Gestor | </h5><a href="./api/logout.php"><button class="sair">Sair</button></a>
        </div>
    </header>
    
    <a href="gestor_dashboard.php"><button class="voltar">Voltar</button></a> 
    
    <main>
        <div class="links">
            <a href="./gestor_criar_tipo_servico.php" class="text-decoration-none"><button class="configurar">
                <i class="bi bi-geo-alt"></i>
                <p>Criar Tipo de Serviço</p>
            </button></a>
            <a href="./gestor_deletar_tipo_servico.php" class="text-decoration-none"><button class="configurar">
                <i class="bi bi-geo-alt"></i>
                <p>Deletar Tipo de Serviço</p>
            </button></a>
            <a href="./gestor_atualizar_tipo_servico.php" class="text-decoration-none"><button class="configurar">
                <i class="bi bi-geo-alt"></i>
                <p>Atualizar Tipo de Serviço</p>
            </button></a>
        </div>
        <br>

        <div class="w-75">
            <table class="table table-striped table-hover rounded">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo de Serviço</th>
                        <th>Descrição</th>
                    </tr>
                </thead>
                <tbody id="tabelaTiposServico">
                </tbody>
            </table>
        </div>
        <br>
    </main> 

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tabelaTiposServico = document.getElementById('tabelaTiposServico');

            async function carregarTiposServico(){
                try {
                    const res = await fetch('./api/api_tipos_servico.php');
                    const resposta = await res.json();
                    
                    if(resposta.success){
                        tabelaTiposServico.innerHTML = '';

                        if(resposta.data.length === 0){
                            tabelaTiposServico.innerHTML = `
                                <tr>
                                    <td colspan="3" style="text-align: center; display:block; padding: 20px;">
                                        Nenhum tipo de serviço encontrado.
                                    </td>
                                </tr>
                            `;
                            return;
                        }

                        resposta.data.forEach(tipo => {
                            tabelaTiposServico.innerHTML += `
                                <tr>
                                    <td data-label="ID">${tipo.id_tipo}</td>
                                    <td data-label="Tipo de Serviço">${tipo.nome}</td>
                                    <td data-label="Descrição">${tipo.descricao ?? '-'}</td>
                                </tr>
                            `;
                        });

                    } else {
                        tabelaTiposServico.innerHTML = `
                            <tr>
                                <td colspan="3" style="text-align: center; display:block; padding: 20px;">
                                    Erro: ${resposta.message}
                                </td>
                            </tr>
                        `;
                    }
                } catch(error){
                    console.error(error);
                    tabelaTiposServico.innerHTML = `
                        <tr>
                            <td colspan="3" style="text-align: center; display:block; padding: 20px;">
                                Erro ao conectar com o servidor.
                            </td>
                        </tr>
                    `;
                }
            }
            carregarTiposServico();
        });
    </script>   
</body>
</html>