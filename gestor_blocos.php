<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM - Configurar Blocos</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
    <header>
        <div class="header-top">
            <h2>SGM | Configurar Blocos</h2>
        </div>
        <div class="header-top">
            <h2 >Olá, Admin Gestor | </h2><a href="./api/logout.php"><button class="sair">Sair</button></a>
        </div>
    </header>
    <a href="gestor_dashboard.php"><button class="voltar">Voltar</button></a> 
    <main>
        <div class="links">
            <a href="./gestor_criar_bloco.php"><button class="configurar">
                <i class="bi bi-geo-alt"></i>
                <h4>Criar Bloco</h4>
            </button></a>
            <a href="./gestor_deletar_bloco.php"><button class="configurar">
                <i class="bi bi-geo-alt"></i>
                <h4>Deletar Bloco</h4>
            </button></a>
            <a href="./gestor_atualizar_bloco.php"><button class="configurar">
                <i class="bi bi-geo-alt"></i>
                <h4>Atualizar Bloco</h4>
            </button></a>
        </div>
        <br>
        <div class="card shadow w-100">
            <div class="table-responsive w-100">
                <table class="table table-hover align-middle mb-0 ">
                    <thead class="">
                        <tr>
                            <th>ID</th>
                            <th>Bloco</th>
                            <th>Descrição</th>
                        </tr>
                    </thead>
                    <tbody id="tabelaAmbientes"></tbody>
                </table>
            </div>
            <br>
        </div>
    </main>
</body>