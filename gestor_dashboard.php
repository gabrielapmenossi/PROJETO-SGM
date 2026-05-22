<?php
// 1. Incluindo o arquivo de conexão
require_once 'config/database.php'; 

$totalAndamento = 0;
$totalCriticos = 0;

// 2. Tenta descobrir automaticamente o nome da variável de conexão do seu config
$db = isset($conn) ? $conn : (isset($pdo) ? $pdo : (isset($conexao) ? $conexao : null));

if ($db) {
    try {
        // Consultas SQL
        $sqlAndamento = "SELECT COUNT(*) as total FROM chamados WHERE status = 'em_andamento'";
        $sqlCriticos = "SELECT COUNT(*) as total FROM chamados WHERE (prioridade = 'urgente' OR prioridade = 'critico') AND status != 'concluido'";

        // 3. Verifica se você está usando PDO ou MySQLi e executa da forma correta
        if ($db instanceof PDO) {
            $totalAndamento = $db->query($sqlAndamento)->fetchColumn() ?: 0;
            $totalCriticos = $db->query($sqlCriticos)->fetchColumn() ?: 0;
        } else {
            // Lógica para MySQLi
            $resAndamento = $db->query($sqlAndamento);
            $totalAndamento = $resAndamento ? $resAndamento->fetch_assoc()['total'] : 0;

            $resCriticos = $db->query($sqlCriticos);
            $totalCriticos = $resCriticos ? $resCriticos->fetch_assoc()['total'] : 0;
        }
    } catch (Exception $e) {
        die("Erro ao carregar indicadores do banco de dados: " . $e->getMessage());
    }
} else {
    // Se ainda assim falhar, avisa exatamente o que está faltando
    die("Erro Crítico: Nenhuma variável de conexão (\$conn, \$pdo ou \$conexao) foi encontrada no seu arquivo config/database.php.");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM - Painel do Gestor</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <style>
        /* =========================================
           CABEÇALHO (HEADER) RESPONSIVO
           ========================================= */
        header {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
        }

        @media (max-width: 576px) {
            header { flex-direction: column; text-align: center; gap: 10px; }
            .header-top h2 { font-size: 1.2rem; margin: 0; }
            
            /* Mantém a saudação e o botão Sair na mesma linha */
            .saudacao-container {
                flex-wrap: nowrap !important;
                justify-content: center;
                display: flex;
                align-items: center;
                gap: 8px;
            }
            .saudacao-container h2 {
                font-size: 0.95rem;
                white-space: nowrap;
                margin: 0;
            }
        }

        /* =========================================
           CARTÕES DE INDICADORES (DASHBOARD)
           ========================================= */
        .solicitacoes {
            display: flex;
            flex-wrap: wrap; /* Permite quebrar linha no celular */
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .solicitacoes .card {
            flex: 1 1 250px; /* Cresce igualmente, mas tem no mínimo 250px */
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border: none;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: #fff; /* Força cor do texto, ajuste caso use style.css */
        }

        .solicitacoes .card h3 { font-size: 1.2rem; margin-bottom: 10px; }
        .solicitacoes .card p { font-size: 2.5rem; font-weight: bold; margin: 0; }

        /* Cores de exemplo (caso não existam no style.css) */
        .em-andamento { background-color: #ffc107; color: #212529 !important; }
        .criticos-urgentes { background-color: #dc3545; }

        /* =========================================
           BOTÕES / LINKS (MENU GESTOR)
           ========================================= */
        .links {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); /* Cria colunas automáticas */
            gap: 15px;
        }

        .links a { text-decoration: none; display: block; }

        .links button {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 20px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            background-color: #fff;
            text-align: left;
            transition: all 0.2s ease-in-out;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            cursor: pointer;
        }

        .links button:hover {
            background-color: #f8f9fa;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.08);
        }

        .links button i {
            font-size: 1.8rem;
            color: #A22C5B; /* Pode ser alterado para combinar com o seu tema */
        }

        .links button h4 {
            margin: 0;
            font-size: 1.1rem;
            color: #333;
        }
    </style>
</head>
<body class="portal-gestor bg-light">
    <header>
        <div class="header-top">
            <h2>SGM | Gestão Administrativa</h2>
        </div>
        <div class="header-top saudacao-container">
            <h2>Olá, Admin Gestor | </h2>
            <a href="./api/logout.php" class="text-decoration-none">
                <button class="sair btn btn-danger btn-sm">Sair</button>
            </a>
        </div>
    </header>
    
    <main class="container py-4">
        <div class="solicitacoes">
            <div class="card em-andamento">
                <h3>Em Andamento</h3>
                <p><?php echo $totalAndamento; ?></p>
            </div>
            
            <div class="card criticos-urgentes">
                <h3>Críticos / Urgentes</h3>
                <p><?php echo $totalCriticos; ?></p>
            </div>
        </div>
        
        <div class="links">
            <a href="./gestor_chamados.php">
                <button class="gerenciar">
                    <i class="bi bi-list-ul"></i>
                    <h4>Gerenciar Todos os Chamados</h4>
                </button>
            </a>
            <a href="./gestor_ambientes.php">
                <button class="configurar">
                    <i class="bi bi-geo-alt"></i>
                    <h4>Configurar Ambientes</h4>
                </button>
            </a>
            <a href="./gestor_blocos.php">
                <button class="configurar">
                    <i class="bi bi-building"></i> <h4>Configurar Blocos</h4>
                </button>
            </a>
            <a href="./gestor_tipos_servico.php">
                <button class="configurar">
                    <i class="bi bi-tools"></i> <h4>Configurar Tipo de Serviço</h4>
                </button>
            </a>
            <a href="./gestor_usuarios.php">
                <button class="configurar">
                    <i class="bi bi-people"></i> <h4>Configurar Usuário</h4>
                </button>
            </a>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>