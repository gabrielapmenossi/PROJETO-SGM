<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>SGM - Configurar Ambiente - Atualizar</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <header>
        <div class="header-top" >
            <h2 class="fs-5 ">SGM | Configurar Ambiente</h2>
        </div>
        <div class="header-top" >
            <h2 class="fs-5 ">Olá, Admin Gestor | </h2><a href="./api/logout.php"><button class="sair">Sair</button></a>
        </div>
    </header>
    <a href="gestor_ambientes.php"><button class="voltar">Voltar</button></a> 
    <main>
        <div class="configurarambiente">
                <div class="a">
                    <h2>Editar Ambientes</h2>
                    <hr>
                    <br>
                    <form id="formAmbientes">
                        <div class="triagens">
                            <label>Ambiente</label>
                            <select id="selectAmbiente" class="triagem" required></select>
                        </div>
                        
                        <br>
                    </form>
                </div>
                <a href="#"><button type="submit" class="confirmar">Editar Ambiente</button></a>
            </div>
    </main>
</body>