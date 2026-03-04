<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>SGM - Configurar Tipo de Serviço - Criar</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <header>
        <div class="header-top" >
            <h2 class="fs-5 ">SGM | Configurar Tipo de Serviço</h2>
        </div>
        <div class="header-top" >
            <h2 class="fs-5 ">Olá, Admin Gestor | </h2><a href="./api/logout.php"><button class="sair">Sair</button></a>
        </div>
    </header>
    <a href="gestor_tipos_servico.php"><button class="voltar">Voltar</button></a>
    <main>
        <div class="configurarambiente">
                <div class="a">
                    <h2>Criar Tipos de Serviço</h2>
                    <hr>
                    <br>
                    <form id="formAmbientes">
                        <div class="triagens">
                            <label>Tipo de Serviço</label>
                            <input type="text">
                        </div>
                        <br>
                        <div class="triagens">
                            <label>Descrição</label>
                            <input type="text">
                        </div>
                        <br>
                    </form>
                </div>
                <a href="#"><button type="submit" class="confirmar">Criar Tipo de Serviço</button></a>
            </div>
    </main>
</body>