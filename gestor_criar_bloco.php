<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>SGM - Configurar Bloco - Criar</title>

    <link rel="stylesheet" href="./assets/css/style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

</head>

<body class="portal-gestor">

    <header>
        <div class="header-top">
            <h2 class="fs-5">SGM | Configurar Bloco</h2>
        </div>

        <div class="header-top">
            <h2 class="fs-5">Olá, Admin Gestor | </h2>

            <a href="./api/logout.php">
                <button class="sair">Sair</button>
            </a>
        </div>
    </header>

    <a href="gestor_blocos.php">
        <button class="voltar">Voltar</button>
    </a>

    <main>

        <div class="configurarambiente">

            <div class="a">

                <h2>Criar Bloco</h2>

                <hr>
                <br>

                <form id="formBlocos">

                    <div class="triagens">
                        <label>Nome do Bloco</label>

                        <input
                            type="text"
                            id="nomeBloco"
                            class="form-control"
                            required>
                    </div>

                    <br>

                    <div class="triagens">
                        <label>Descrição</label>

                        <input
                            type="text"
                            id="descricaoBloco"
                            class="form-control">
                    </div>

                    <br>
                    <br>

                    <button
                        type="submit"
                        class="confirmar"
                        id="btnCriar">

                        Criar Bloco

                    </button>

                </form>

            </div>

        </div>

    </main>

    <script>

        document.addEventListener('DOMContentLoaded', () => {

            const formBlocos = document.getElementById('formBlocos');

            formBlocos.addEventListener('submit', async (e) => {

                e.preventDefault();

                const nomeBloco = document.getElementById('nomeBloco').value.trim();

                const descricaoBloco = document.getElementById('descricaoBloco').value.trim();

                if (!nomeBloco) {

                    alert("Preencha o nome do bloco.");

                    return;
                }

                const btnCriar = document.getElementById('btnCriar');

                btnCriar.disabled = true;

                btnCriar.innerText = "Criando...";

                try {

                    const response = await fetch('./api/api_blocos.php', {

                        method: 'POST',

                        headers: {
                            'Content-Type': 'application/json'
                        },

                        body: JSON.stringify({
                            nome: nomeBloco,
                            descricao: descricaoBloco
                        })

                    });

                    // MOSTRA O TEXTO BRUTO DO PHP
                    const texto = await response.text();

                    console.log("RESPOSTA DO PHP:");
                    console.log(texto);

                    // TENTA CONVERTER EM JSON
                    const resposta = JSON.parse(texto);

                    if (resposta.success) {

                        alert(resposta.message);

                        window.location.href = "gestor_blocos.php";

                    } else {

                        alert("Erro: " + resposta.message);

                        btnCriar.disabled = false;

                        btnCriar.innerText = "Criar Bloco";
                    }

                } catch (error) {

                    console.error(error);

                    alert("Erro real detectado. Veja o console (F12).");

                    btnCriar.disabled = false;

                    btnCriar.innerText = "Criar Bloco";
                }

            });

        });

    </script>

</body>

</html>