<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>SGM - Configurar Bloco - Deletar</title>
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
                <h2>Deletar Bloco</h2>
                <hr>
                <br>
                <form id="formBlocos">
                    <div class="triagens">
                        <label>Bloco</label>
                        <select 
                            id="selectBloco"
                            class="form-select"
                            required>
                            <option value="">
                                Selecione o bloco
                            </option>
                        </select>
                    </div>
                    <br>
                    <button 
                        type="submit"
                        class="confirmar"
                        id="btnDeletar">
                        Deletar Bloco
                    </button>
                </form>
            </div>
        </div>
    </main>
    <script>

        document.addEventListener('DOMContentLoaded', () => {

            const formBlocos = document.getElementById('formBlocos');

            const selectBloco = document.getElementById('selectBloco');

            // CARREGAR BLOCOS
            async function carregarBlocos(){

                try {

                    const res = await fetch('./api/api_blocos.php');

                    const resposta = await res.json();

                    console.log(resposta);

                    if(resposta.success){

                        selectBloco.innerHTML = `
                            <option value="">
                                Selecione o bloco
                            </option>
                        `;

                        resposta.data.forEach(bloco => {

                            selectBloco.innerHTML += `
                                <option value="${bloco.id_bloco}">
                                    ${bloco.nome}
                                </option>
                            `;

                        });

                    } else {

                        alert("Erro ao carregar blocos: " + resposta.message);

                    }

                } catch(error){

                    console.error(error);

                    alert("Erro ao conectar com o servidor.");

                }

            }

            carregarBlocos();


            // DELETAR BLOCO
            formBlocos.addEventListener('submit', async (e) => {

                e.preventDefault();

                const idBloco = selectBloco.value;

                if(!idBloco){

                    alert("Selecione um bloco.");

                    return;
                }

                const confirmar = confirm(
                    "Tem certeza que deseja deletar este bloco?"
                );

                if(!confirmar){
                    return;
                }

                const btnDeletar = document.getElementById('btnDeletar');

                btnDeletar.disabled = true;

                btnDeletar.innerText = "Deletando...";

                try {

                    const res = await fetch('./api/api_blocos.php', {

                        method: 'DELETE',

                        headers: {
                            'Content-Type': 'application/json'
                        },

                        body: JSON.stringify({
                            id_bloco: idBloco
                        })

                    });

                    const resposta = await res.json();

                    console.log(resposta);

                    if(resposta.success){

                        alert("Sucesso: " + resposta.message);

                        window.location.href = "gestor_blocos.php";

                    } else {

                        alert("Erro: " + resposta.message);

                        btnDeletar.disabled = false;

                        btnDeletar.innerText = "Deletar Bloco";

                    }

                } catch(error){

                    console.error(error);

                    alert("Erro ao conectar com o servidor.");

                    btnDeletar.disabled = false;

                    btnDeletar.innerText = "Deletar Bloco";

                }

            });

        });

    </script>
</body>