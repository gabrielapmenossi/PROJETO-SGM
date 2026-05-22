<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM - Configurar Usuários</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <style>
        /* Ajustes básicos para o desktop baseados na sua estrutura */
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
                margin: 0 auto; /* Centraliza a tabela no desktop */
            }
            .voltar { margin: 10px 20px; }
        }

        /* =========================================
           CSS RESPONSIVO (Apenas Mobile)
           ========================================= */
        @media (max-width: 768px) {
            /* Força a div de 75% a ocupar 100% no celular */
            .w-75 {
                width: 100% !important;
                padding: 0 15px;
            }

            /* Centraliza e empilha o Header */
            header {
                display: flex;
                flex-direction: column;
                text-align: center;
                gap: 10px;
                padding: 15px;
            }
            .header-top {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-wrap: wrap;
            }

            /* Empilha os botões de ação */
            .links {
                display: flex;
                flex-direction: column;
                gap: 10px;
                padding: 0 15px;
            }
            .links a, .links button {
                width: 100%;
                justify-content: center;
            }

            .voltar { margin: 10px 15px; }

            /* Transforma a Tabela em Cards */
            table, thead, tbody, th, td, tr {
                display: block;
                width: 100%;
            }
            thead {
                display: none; /* Esconde o cabeçalho no celular */
            }
            tr {
                margin-bottom: 15px;
                border: 1px solid #dee2e6;
                border-radius: 8px;
                background-color: #fff;
                box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            }
            td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px 15px !important;
                border-bottom: 1px solid #eee;
                text-align: right;
                word-break: break-word; /* Impede que e-mails longos vazem */
                gap: 15px;
            }
            td:last-child {
                border-bottom: none;
            }
            td::before {
                content: attr(data-label);
                font-weight: bold;
                text-align: left;
                color: #333;
                white-space: nowrap;
            }
        }
    </style>
</head>
<body class="portal-gestor">
    <header>
        <div class="header-top">
            <h5>SGM | Configurar Usuários</h5>
        </div>
        <div class="header-top">
            <h5>Olá, Admin Gestor | </h5><a href="./api/logout.php"><button class="sair">Sair</button></a>
        </div>
    </header>
    <a href="gestor_dashboard.php"><button class="voltar">Voltar</button></a> 
    <main>
        <div class="links">
            <a href="./gestor_criar_usuario.php" class="text-decoration-none align-items-center"><button class="configurar">
                <i class="bi bi-geo-alt"></i>
                <p>Criar Usuários</p>
            </button></a>
            <a href="./gestor_deletar_usuario.php" class="text-decoration-none align-items-center"><button class="configurar">
                <i class="bi bi-geo-alt"></i>
                <p>Deletar Usuários</p>
            </button></a>
            <a href="./gestor_atualizar_usuario.php" class="text-decoration-none align-items-center"><button class="configurar">
                <i class="bi bi-geo-alt"></i>
                <p>Atualizar Usuários</p>
            </button></a>
        </div>
        <br>
        <div class="w-75">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Perfil</th>
                            <th>Ativo</th>
                            <th>Data de criação</th>
                        </tr>
                    </thead>
                    <tbody id="tabelaUsuarios">
                    </tbody>
                </table>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tabela = document.getElementById('tabelaUsuarios');

            async function carregarUsuarios(){
                try {
                    const res = await fetch('./api/api_usuarios.php');
                    const texto = await res.text();
                    console.log(texto);
                    const resposta = JSON.parse(texto);
                    console.log(resposta);

                    // ACEITA success OU sucess
                    if(resposta.success || resposta.sucess){
                        tabela.innerHTML = '';

                        if(resposta.data.length === 0){
                            tabela.innerHTML = `
                                <tr>
                                    <td colspan="6" style="text-align:center;">
                                        Nenhum usuário encontrado.
                                    </td>
                                </tr>
                            `;
                            return;
                        }

                        resposta.data.forEach(usuario => {
                            // NOTA: Foi adicionado o 'data-label' em cada 'td' para o responsivo funcionar
                            tabela.innerHTML += `
                                <tr>
                                    <td data-label="ID">
                                        ${usuario.id_usuario}
                                    </td>
                                    <td data-label="Nome">
                                        ${usuario.nome}
                                    </td>
                                    <td data-label="Email">
                                        ${usuario.email}
                                    </td>
                                    <td data-label="Perfil">
                                        ${usuario.perfil}
                                    </td>
                                    <td data-label="Ativo">
                                        ${usuario.ativo}
                                    </td>
                                    <td data-label="Data de criação">
                                        ${usuario.data_criacao}
                                    </td>
                                </tr>
                            `;
                        });
                    } else {
                        tabela.innerHTML = `
                            <tr>
                                <td colspan="6" style="text-align:center;">
                                    ${resposta.message || 'Erro ao carregar usuários.'}
                                </td>
                            </tr>
                        `;
                    }
                } catch(error){
                    console.error(error);
                    tabela.innerHTML = `
                        <tr>
                            <td colspan="6" style="text-align:center;">
                                Erro ao conectar com o servidor.
                            </td>
                        </tr>
                    `;
                }
            }
            carregarUsuarios();
        });
    </script>
</body>
</html>