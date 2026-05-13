<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM - Configurar Tipos de Serviço</title>
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
            <a href="./gestor_criar_tipo_servico.php" class="text-decoration-none align-items-center"><button class="configurar">
                <i class="bi bi-geo-alt"></i>
                <p>Criar Tipo de Serviço</p>
            </button></a>
            <a href="./gestor_deletar_tipo_servico.php" class="text-decoration-none align-items-center"><button class="configurar">
                <i class="bi bi-geo-alt"></i>
                <p>Deletar Tipo de Serviço</p>
            </button></a>
            <a href="./gestor_atualizar_tipo_servico.php" class="text-decoration-none align-items-center"><button class="configurar">
                <i class="bi bi-geo-alt"></i>
                <p>Atualizar Tipo de Serviço</p>
            </button></a>
        </div>
        <br>

        <div class="w-75">
                <table class="table table-striped table-hover rouded">
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

            const tabelaTiposServico =
                document.getElementById('tabelaTiposServico');

            async function carregarTiposServico(){

                try {

                    const res =
                        await fetch('./api/api_tipos_servico.php');

                    const resposta = await res.json();

                    console.log(resposta);

                    if(resposta.success){

                        tabelaTiposServico.innerHTML = '';

                        if(resposta.data.length === 0){

                            tabelaTiposServico.innerHTML = `
                                <tr>
                                    <td colspan="3">
                                        Nenhum tipo de serviço encontrado.
                                    </td>
                                </tr>
                            `;

                            return;
                        }

                        resposta.data.forEach(tipo => {

                            tabelaTiposServico.innerHTML += `
                                <tr>
                                    <td>${tipo.id_tipo}</td>
                                    <td>${tipo.nome}</td>
                                    <td>${tipo.descricao ?? ''}</td>
                                </tr>
                            `;

                        });

                    } else {

                        tabelaTiposServico.innerHTML = `
                            <tr>
                                <td colspan="3">
                                    Erro: ${resposta.message}
                                </td>
                            </tr>
                        `;

                    }

                } catch(error){

                    console.error(error);

                    tabelaTiposServico.innerHTML = `
                        <tr>
                            <td colspan="3">
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