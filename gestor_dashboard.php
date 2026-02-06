<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM - Painel do Gestor</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
    <header>
        <div class="header-top">
            <h2>SGM | Gestão Administrativa</h2>
        </div>
        <div class="header-top">
            <h2>Olá, Admin Gestor | </h2><a href="./api/logout.php"><button class="sair">Sair</button></a>
        </div>
    </header>
    <main>
        <div class="solicitacoes">
            <div class="card novas-solicitacoes">
                <h3>Novas Solicitações</h3> 
                <p>0</p>
            </div>
            <div class="card em-andamento">
                <h3>Em Andamento</h3>
                <p>0</p>
            </div>
            <div class="card criticos-urgentes">
                <h3>Críticos / Urgentes</h3>
                <p>0</p>
            </div>
        </div>
        <div class="links">
            <a href="#"><button class="gerenciar">
                <i class="bi bi-list-ul"></i>
                <h4>Gerenciar Todos os Chamados</h4>
            </button></a>
            <a href="#"><button class="configurar">
                <i class="bi bi-geo-alt"></i>
                <h4>Configurar Ambientes</h4>
            </button></a>
        </div>
    </main>
    
</body>
</html>