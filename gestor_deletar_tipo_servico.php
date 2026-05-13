<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>SGM - Configurar Tipo de Serviço - Deletar</title>
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

                <h2>
                    Deletar Tipo de Serviço
                </h2>

                <hr>

                <br>

                <form id="formTiposServico">

                    <div class="triagens">

                        <label>
                            Tipo de Serviço
                        </label>

                        <select
                            id="selectTipo"
                            class="form-select"
                            required>

                            <option value="">
                                Carregando...
                            </option>

                        </select>

                    </div>

                    <br>

                    <button
                        type="submit"
                        class="confirmar"
                        id="btnDeletar">

                        Deletar Tipo de Serviço

                    </button>

                </form>

            </div>

        </div>
    </main>
    <script>

        document.addEventListener('DOMContentLoaded', () => {

            const selectTipo =
                document.getElementById('selectTipo');

            const form =
                document.getElementById('formTiposServico');

            // CARREGAR TIPOS
            async function carregarTipos(){

                try {

                    const res =
                        await fetch('./api/api_tipos_servico.php');

                    const resposta = await res.json();

                    console.log(resposta);

                    // SUA API USA "sucess"
                    if(resposta.success){

                        selectTipo.innerHTML = `
                            <option value="">
                                Selecione o tipo de serviço
                            </option>
                        `;

                        resposta.data.forEach(tipo => {

                            const option =
                                document.createElement('option');

                            option.value = tipo.id_tipo;

                            option.textContent = tipo.nome;

                            selectTipo.appendChild(option);

                        });

                    } else {

                        alert(
                            "Erro ao carregar tipos."
                        );

                    }

                } catch(error){

                    console.error(error);

                    alert(
                        "Erro ao conectar com o servidor."
                    );

                }

            }

            carregarTipos();

            // DELETAR
            form.addEventListener('submit', async (e) => {

                e.preventDefault();

                const idTipo = selectTipo.value;

                if(!idTipo){

                    alert(
                        "Selecione um tipo de serviço."
                    );

                    return;
                }

                const confirmar = confirm(
                    "Deseja realmente deletar?"
                );

                if(!confirmar){
                    return;
                }

                const btn =
                    document.getElementById('btnDeletar');

                btn.disabled = true;

                btn.innerText = "Deletando...";

                try {

                    const res =
                        await fetch('./api/api_tipos_servico.php', {

                            method: 'DELETE',

                            headers: {
                                'Content-Type': 'application/json'
                            },

                            body: JSON.stringify({

                                id_tipo: idTipo

                            })

                        });

                    const resposta = await res.json();

                    console.log(resposta);

                    if(resposta.success){

                        alert(resposta.message);

                        window.location.href =
                            "gestor_tipos_servico.php";

                    } else {

                        alert(
                            "Erro: " +
                            resposta.message
                        );

                        btn.disabled = false;

                        btn.innerText =
                            "Deletar Tipo de Serviço";

                    }

                } catch(error){

                    console.error(error);

                    alert(
                        "Erro ao conectar com o servidor."
                    );

                    btn.disabled = false;

                    btn.innerText =
                        "Deletar Tipo de Serviço";

                }

            });

        });

    </script>


</body>