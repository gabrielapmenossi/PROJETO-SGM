<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM - Configurar Ambientes</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

</head>
<body class="portal-gestor">
    <header>
        <div class="header-top">
            <h5>SGM | Configurar Ambientes</h5>
        </div>
        <div class="header-top">
            <h5 >Olá, Admin Gestor | </h5><a href="./api/logout.php"><button class="sair">Sair</button></a>
        </div>
    </header>
    <a href="gestor_dashboard.php"><button class="voltar">Voltar</button></a> 
    <main>
        <div class="links">
            <a href="./gestor_criar_ambiente.php" class="text-decoration-none align-items-center"><button class="configurar">
                <i class="bi bi-geo-alt"></i>
                <p>Criar Ambiente</p>
            </button></a>
            <a href="./gestor_deletar_ambiente.php" class="text-decoration-none align-items-center"><button class="configurar">
                <i class="bi bi-geo-alt"></i>
                <p>Deletar Ambiente</p>
            </button></a>
            <a href="./gestor_atualizar_ambiente.php" class="text-decoration-none align-items-center"><button class="configurar">
                <i class="bi bi-geo-alt"></i>
                <p>Atualizar Ambiente</p>
            </button></a>
        </div>
        <br>
            <div class="w-75">
                <table class="table table-striped table-hover rouded">
                    <thead class="w-100">
                        <tr>
                            <th>ID</th>
                            <th>Ambiente</th>
                            <th>Bloco</th>
                        </tr>
                    </thead>
                    <tbody id="tabelaAmbientes" class=" w-100"></tbody>
                </table>
            </div>
            <br>
    </main>
    <script>
        async function carregarAmbientes() {
            const res = await fetch(`api/api_ambientes.php`);
            const ambientes = await res.json();
            const body = document.getElementById('tabelaAmbientes');

            body.innerHTML = ambientes.data.map(a => 
             `
                <tr>
                    <td>#${a.id_ambiente}</td>
                    <td>${a.nome}</td>
                    <td>${a.nome_bloco}</td>
                </tr>
            `).join('');
        }

        carregarAmbientes();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</body>