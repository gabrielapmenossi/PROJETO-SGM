<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM - Configurar Blocos</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

</head>
<body>
<header>
        <div class="header-top">
            <h5>SGM | Configurar Blocos</h5>
        </div>
        <div class="header-top">
            <h5 >Olá, Admin Gestor | </h5><a href="./api/logout.php"><button class="sair">Sair</button></a>
        </div>
    </header>
    <a href="gestor_dashboard.php"><button class="voltar">Voltar</button></a> 
    <main>
        <div class="links">
            <a href="./gestor_criar_bloco.php" class="text-decoration-none align-items-center"><button class="configurar">
                <i class="bi bi-geo-alt"></i>
                <p>Criar Bloco</p>
            </button></a>
            <a href="./gestor_deletar_bloco.php" class="text-decoration-none align-items-center"><button class="configurar">
                <i class="bi bi-geo-alt"></i>
                <p>Deletar Bloco</p>
            </button></a>
            <a href="./gestor_atualizar_bloco.php" class="text-decoration-none align-items-center"><button class="configurar">
                <i class="bi bi-geo-alt"></i>
                <p>Atualizar Bloco</p>
            </button></a>
        </div>
        <br>
         <div class="w-75">
                <table class="table table-striped table-hover rouded">
                    <thead class="w-100">
                        <tr>
                            <th>ID</th>
                            <th>Bloco</th>
                            <th>Descrição</th>
                        </tr>
                    </thead>

                    <tbody id="tabelaBlocos">

                    </tbody>
                </table>
            </div>
            
            <br>

    </main>

    <script>

        document.addEventListener('DOMContentLoaded', () => {

            const tabelaBlocos = document.getElementById('tabelaBlocos');

            async function carregarBlocos() {

                try {

                    const res = await fetch('./api/api_blocos.php');

                    const resposta = await res.json();

                    console.log(resposta);

                    if(resposta.success) {

                        tabelaBlocos.innerHTML = '';

                        if(resposta.data.length === 0){

                            tabelaBlocos.innerHTML = `
                                <tr>
                                    <td colspan="3">
                                        Nenhum bloco encontrado.
                                    </td>
                                </tr>
                            `;

                            return;
                        }

                        resposta.data.forEach(bloco => {

                            tabelaBlocos.innerHTML += `
                                <tr>
                                    <td>${bloco.id_bloco}</td>
                                    <td>${bloco.nome}</td>
                                    <td>${bloco.descricao ?? ''}</td>
                                </tr>
                            `;

                        });

                    } else {

                        tabelaBlocos.innerHTML = `
                            <tr>
                                <td colspan="3">
                                    Erro: ${resposta.message}
                                </td>
                            </tr>
                        `;

                    }

                } catch(error) {

                    console.error(error);

                    tabelaBlocos.innerHTML = `
                        <tr>
                            <td colspan="3">
                                Erro ao conectar com o servidor.
                            </td>
                        </tr>
                    `;

                }

            }

            carregarBlocos();

        });

    </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</body>

</html>