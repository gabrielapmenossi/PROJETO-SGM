<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM - Configurar Usuários</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

</head>
<body class="portal-gestor">
    <header>
        <div class="header-top">
            <h5>SGM | Configurar Tipos de Serviço</h5>
        </div>
        <div class="header-top">
            <h5 >Olá, Admin Gestor | </h5><a href="./api/logout.php"><button class="sair">Sair</button></a>
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

            const tabela =
                document.getElementById('tabelaUsuarios');

            async function carregarUsuarios(){

                try {

                    const res =
                        await fetch('./api/api_usuarios.php');

                    const texto = await res.text();

                    console.log(texto);

                    const resposta =
                        JSON.parse(texto);

                    console.log(resposta);

                    // ACEITA success OU sucess
                    if(resposta.success || resposta.success){

                        tabela.innerHTML = '';

                        if(resposta.data.length === 0){

                            tabela.innerHTML = `
                                <tr>
                                    <td colspan="6">
                                        Nenhum usuário encontrado.
                                    </td>
                                </tr>
                            `;

                            return;
                        }

                        resposta.data.forEach(usuario => {

                            tabela.innerHTML += `
                                <tr>

                                    <td>
                                        ${usuario.id_usuario}
                                    </td>

                                    <td>
                                        ${usuario.nome}
                                    </td>

                                    <td>
                                        ${usuario.email}
                                    </td>

                                    <td>
                                        ${usuario.perfil}
                                    </td>

                                    <td>
                                        ${usuario.ativo}
                                    </td>

                                    <td>
                                        ${usuario.data_criacao}
                                    </td>

                                </tr>
                            `;

                        });

                    } else {

                        tabela.innerHTML = `
                            <tr>
                                <td colspan="6">
                                    ${resposta.message || 'Erro ao carregar usuários.'}
                                </td>
                            </tr>
                        `;

                    }

                } catch(error){

                    console.error(error);

                    tabela.innerHTML = `
                        <tr>
                            <td colspan="6">
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