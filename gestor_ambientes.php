<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM - Configurar Ambientes</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
    <header>
        <div class="header-top">
            <h2>SGM | Configurar Ambientes</h2>
        </div>
        <div class="header-top">
            <h2 >Olá, Admin Gestor | </h2><a href="./api/logout.php"><button class="sair">Sair</button></a>
        </div>
    </header>
    <a href="gestor_dashboard.php"><button class="voltar">Voltar</button></a> 
    <main>
        <div class="links">
            <a href="./gestor_criar_ambiente.php"><button class="configurar">
                <i class="bi bi-geo-alt"></i>
                <h4>Criar Ambiente</h4>
            </button></a>
            <a href="./gestor_deletar_ambiente.php"><button class="configurar">
                <i class="bi bi-geo-alt"></i>
                <h4>Deletar Ambiente</h4>
            </button></a>
            <a href="./gestor_atualizar_ambiente.php"><button class="configurar">
                <i class="bi bi-geo-alt"></i>
                <h4>Atualizar Ambiente</h4>
            </button></a>
        </div>
        <br>
        <div class="card shadow w-100">
            <div class="table-responsive w-100">
                <table class="table table-hover align-middle mb-0 rounded">
                    <thead class="">
                        <tr>
                            <th>ID</th>
                            <th>Ambiente</th>
                            <th>Bloco</th>
                        </tr>
                    </thead>
                    <tbody id="tabelaAmbientes"></tbody>
                </table>
            </div>
            <br>
        </div>
    </main>
    <script>
        async function carregarAmbientes(status = '') {
            const res = await fetch(`api/gestor_ambientes.php?status=${status}`);
            const ambientes = await res.json();
            const body = document.getElementById('tabelaAmbientes');

            body.innerHTML = ambientes.map(c => `
                <tr>
                    <td>#${c.id_ambiente}</td>
                    <td>${c.ambinetes.nome}</td>
                    <td>${c.blocos.nome}</td>
                </tr>
            `).join('');
        }
        carregarAmbientes();
    </script>

</body>