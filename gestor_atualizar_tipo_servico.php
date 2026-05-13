<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>SGM - Configurar Tipo de Serviço - Atualizar</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body class="portal-gestor">
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
                    Editar Tipo de Serviço
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

                        </select>

                    </div>

                    <br>

                    <div class="triagens">

                        <label>
                            Novo Nome
                        </label>

                        <input
                            type="text"
                            id="nomeTipo"
                            class="form-control"
                            required>

                    </div>

                    <br>

                    <div class="triagens">

                        <label>
                            Descrição
                        </label>

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
                        id="btnAtualizar">

                        Atualizar Tipo de Serviço

                    </button>

                </form>

            </div>

        </div>
    </main>
    <script>

        let tipos = [];

        // CARREGAR TIPOS
        async function carregarTipos(){

            try {

                const res =
                    await fetch('./api/api_tipos_servico.php');

                const texto = await res.text();

                console.log(texto);

                const resposta = JSON.parse(texto);

                console.log(resposta);

                // SUA API USA "sucess"
                if(resposta.success){

                    tipos = resposta.data;

                    const select =
                        document.getElementById('selectTipo');

                    select.innerHTML = '';

                    tipos.forEach(tipo => {

                        select.innerHTML += `
                            <option value="${tipo.id_tipo}">
                                ${tipo.nome}
                            </option>
                        `;

                    });

                    // CARREGA PRIMEIRO
                    if(tipos.length > 0){

                        document.getElementById('nomeTipo')
                            .value = tipos[0].nome;

                        document.getElementById('descricaoTipo')
                            .value = tipos[0].descricao ?? '';

                    }

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

        // ALTERAR CAMPOS AO TROCAR SELECT
        document.getElementById('selectTipo')
        .addEventListener('change', function(){

            const id = this.value;

            const tipo =
                tipos.find(t => t.id_tipo == id);

            if(tipo){

                document.getElementById('nomeTipo')
                    .value = tipo.nome;

                document.getElementById('descricaoTipo')
                    .value = tipo.descricao ?? '';

            }

        });

        // ATUALIZAR
        document.getElementById('formTiposServico')
        .addEventListener('submit', async function(e){

            e.preventDefault();

            const id =
                document.getElementById('selectTipo')
                .value;

            const nome =
                document.getElementById('nomeTipo')
                .value
                .trim();

            const descricao =
                document.getElementById('descricaoTipo')
                .value
                .trim();

            const btn =
                document.getElementById('btnAtualizar');

            btn.disabled = true;

            btn.innerText = "Atualizando...";

            try {

                const res =
                    await fetch('./api/api_tipos_servico.php', {

                        method: 'PUT',

                        headers: {
                            'Content-Type': 'application/json'
                        },

                        body: JSON.stringify({

                            id_tipo: id,
                            nome: nome,
                            descricao: descricao

                        })

                    });

                const resposta = await res.json();

                console.log(resposta);

                alert(resposta.message);

                if(resposta.success){

                    window.location.href =
                        'gestor_tipos_servico.php';

                } else {

                    btn.disabled = false;

                    btn.innerText =
                        'Atualizar Tipo de Serviço';

                }

            } catch(error){

                console.error(error);

                alert(
                    "Erro ao conectar com o servidor."
                );

                btn.disabled = false;

                btn.innerText =
                    'Atualizar Tipo de Serviço';

            }

        });

        carregarTipos();

    </script>
</body>