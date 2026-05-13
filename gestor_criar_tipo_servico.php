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
                    <form id="formTiposServico">
                        <div class="triagens">
                            <label>Tipo de Serviço</label>
                            <input 
                                type="text"
                                id="nomeTipo"
                                class="form-control"
                                required>
                        </div>
                        <br>
                        <div class="triagens">
                            <label>Descrição</label>
                            <input 
                                type="text"
                                id="descricaoTipo"
                                class="form-control"
                                required>
                        </div>
                        <br>
                        <button 
                            type="submit"
                            class="confirmar"
                            id="btnCriar">
                            Criar Tipo de Serviço
                        </button>
                    </form>
                </div>
            </div>
    </main>
    <script>

        document.addEventListener('DOMContentLoaded', () => {

            const form =
                document.getElementById('formTiposServico');

            form.addEventListener('submit', async (e) => {

                e.preventDefault();

                const nome =
                    document.getElementById('nomeTipo')
                    .value
                    .trim();

                const descricao =
                    document.getElementById('descricaoTipo')
                    .value
                    .trim();

                if(!nome || !descricao){

                    alert(
                        "Preencha todos os campos."
                    );

                    return;
                }

                const btnCriar =
                    document.getElementById('btnCriar');

                btnCriar.disabled = true;

                btnCriar.innerText = "Criando...";

                try {

                    const res =
                        await fetch('./api/api_tipos_servico.php', {

                            method: 'POST',

                            headers: {
                                'Content-Type': 'application/json'
                            },

                            body: JSON.stringify({

                                nome: nome,
                                descricao: descricao

                            })

                        });

                    const resposta = await res.json();

                    console.log(resposta);

                    if(resposta.success){

                        alert(
                            "Sucesso: " +
                            resposta.message
                        );

                        window.location.href =
                            "gestor_tipos_servico.php";

                    } else {

                        alert(
                            "Erro: " +
                            resposta.message
                        );

                        btnCriar.disabled = false;

                        btnCriar.innerText =
                            "Criar Tipo de Serviço";

                    }

                } catch(error){

                    console.error(error);

                    alert(
                        "Erro ao conectar com o servidor."
                    );

                    btnCriar.disabled = false;

                    btnCriar.innerText =
                        "Criar Tipo de Serviço";

                }

            });

        });

    </script>

</body>