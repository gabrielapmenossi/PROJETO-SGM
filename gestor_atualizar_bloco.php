<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>SGM - Configurar Bloco - Atualizar</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body class="portal-gestor">
    <header>
        <div class="header-top" >
            <h2 class="fs-5 ">SGM | Configurar Bloco</h2>
        </div>
        <div class="header-top" >
            <h2 class="fs-5 ">Olá, Admin Gestor | </h2><a href="./api/logout.php"><button class="sair">Sair</button></a>
        </div>
    </header>
    <a href="gestor_blocos.php"><button class="voltar">Voltar</button></a> 
    <main>
        <div class="configurarambiente">
            <div class="a">
                <h2>Editar Bloco</h2>
                <hr>
                <br>
                <form id="formBlocos">
                    <div class="triagens">
                        <label>Bloco</label>
                        <select 
                            id="selectBloco"
                            class="triagem"
                            required>
                        </select>
                    </div>
                    <br>
                    <div class="triagens">
                        <label>Novo nome</label>
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
                    <button 
                        type="submit"
                        class="confirmar">
                        Atualizar Bloco
                    </button>
                </form>
            </div>
        </div>
    </main>
    <script>

        let blocos = [];

        // CARREGAR BLOCOS
        async function carregarBlocos(){

            try {

                const res = await fetch("./api/api_blocos.php");

                const data = await res.json();

                console.log(data);

                blocos = data.data;

                const select = document.getElementById("selectBloco");

                select.innerHTML = blocos.map(bloco =>

                    `<option value="${bloco.id_bloco}">
                        ${bloco.nome}
                    </option>`

                ).join('');

                // CARREGA PRIMEIRO BLOCO AUTOMATICAMENTE
                if(blocos.length > 0){

                    document.getElementById("nomeBloco").value =
                        blocos[0].nome;

                    document.getElementById("descricaoBloco").value =
                        blocos[0].descricao ?? '';

                }

            } catch(error){

                console.error(error);

                alert("Erro ao carregar blocos.");

            }

        }

        // TROCAR DADOS AO MUDAR SELECT
        document.getElementById("selectBloco")
        .addEventListener("change", function(){

            const id = this.value;

            const bloco = blocos.find(
                b => b.id_bloco == id
            );

            if(bloco){

                document.getElementById("nomeBloco").value =
                    bloco.nome;

                document.getElementById("descricaoBloco").value =
                    bloco.descricao ?? '';

            }

        });

        // ATUALIZAR BLOCO
        document.getElementById("formBlocos")
        .addEventListener("submit", async function(e){

            e.preventDefault();

            const id = document.getElementById("selectBloco").value;

            const nome = document.getElementById("nomeBloco").value;

            const descricao =
                document.getElementById("descricaoBloco").value;

            try {

                const res = await fetch("./api/api_blocos.php", {

                    method: "PUT",

                    headers: {
                        "Content-Type": "application/json"
                    },

                    body: JSON.stringify({

                        id_bloco: id,
                        nome: nome,
                        descricao: descricao

                    })

                });

                const data = await res.json();

                console.log(data);

                alert(data.message);

                if(data.success){

                    window.location.href =
                        "gestor_blocos.php";

                }

            } catch(error){

                console.error(error);

                alert("Erro ao atualizar bloco.");

            }

        });

        carregarBlocos();

    </script>
</body>