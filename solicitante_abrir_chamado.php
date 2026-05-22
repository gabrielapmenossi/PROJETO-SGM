<?php

session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['user_perfil'] !== 'solicitante'){
    header("Location: login.php");
    exit;
}

// echo  $_SESSION['user_id'];
// echo '<br>';
// echo  $_SESSION['user_nome']

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitante - Abrir chamado</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <style>
        /* Centraliza o formulário e cria um espaçamento seguro para o celular */
        main {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            min-height: 100vh;
        }

        /* Limita a largura do formulário no PC, mas deixa fluido no mobile */
        .chamado {
            width: 100%;
            max-width: 600px;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        /* Ajustes específicos para celular */
        @media (max-width: 576px) {
            .chamado {
                padding: 15px; /* Reduz o padding interno para ganhar tela */
            }
            .abrir-chamado {
                flex-direction: column; /* Joga o botão voltar para baixo do título */
                text-align: center;
                gap: 12px;
            }
        }
    </style>

</head>
<body class="portal-solicitante bg-light">
    <main>
        <div class="chamado rounded">
            <div class="abrir-chamado rounded p-3 text-light d-flex justify-content-between align-items-center mb-4" style="background-color: #A22C5B;">
                <h3 class="m-0 fs-4">Abrir chamado</h3>
                <a href="./solicitante_dashboard.php" class="text-decoration-none">
                    <button class="voltarsolicitacao btn btn-sm btn-outline-light">Voltar</button>
                </a>
            </div>
            
            <form class="form-criar-chamado" id="formChamado">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Bloco</label>
                    <select id="selectBloco" class="form-select" required>
                        <option value="">Selecione o bloco</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Ambiente / Sala</label>
                    <select id="selectAmbiente" class="form-select" required>
                        <option value="">Selecione o ambiente</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Tipo de serviço</label>
                    <select id="selectTipo" class="form-select" required>
                        <option value="">Selecione o tipo de serviço</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Descrição do problema</label>
                    <textarea id="descricao" class="form-control" rows="4" required placeholder="Ex.: Lâmpada queimada ou vazamento"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Foto da ocorrência</label>
                    <input type="file" id="foto" class="form-control" accept="image/*">
                </div>
                
                <button type="submit" class="btn btn-registrar-solicitacao w-100 py-2 mt-2 fw-bold" style="background-color: #A22C5B; color: #fff;">Registrar solicitação</button>
            </form>
        </div>
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="./assets/js/solicitante_abrir_chamado.js"></script>
</body>
</html>