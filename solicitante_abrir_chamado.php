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

</head>
<body class="portal-solicitante">
    <main>
        <div class="chamado rounded">
            <div class="abrir-chamado rounded p-1 text-light d-flex align-items-center">
                <h3 class="d-flex justify-content-center m-1">Abrir chamado</h3>
                 <a href="./solicitante_dashboard.php"><button class="voltarsolicitacao rounded"> Voltar</button></a>
            </div>
            <form class="form-criar-chamado" id="formChamado">
                <div class="mb-3">
                    <label class="form-label">Bloco</label>
                    <select id="selectBloco" class="form-select" required ">
                        <option value="">Selecione o bloco</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ambiente / Sala</label>
                    <select id="selectAmbiente" class="form-select" required>
                        <option value="">Selecione o ambiente</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tipo de serviço</label>
                    <select id="selectTipo" class="form-select" required>
                        <option value="">Selecione o tipo de serviço</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Descrição do problema</label>
                    <textarea id="descricao" class="form-control" rows="4" required placeholder="Ex.: Lâmpada queimada ou vazamento"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Foto da ocorrência</label>
                    <input type="file" id="foto" class="form-control" accept="image/*">
                </div>
                <button type="submit" class="btn btn-registrar-solicitacao w-100">Registrar solicitação</button>
            </form>
            
        </div>
        
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="./assets/js/solicitante_abrir_chamado.js"></script>
    
</body>
</html>