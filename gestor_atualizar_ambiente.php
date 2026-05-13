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

                <form id="formAmbientes">
                    <div class="triagens">
                        <label>Ambiente</label>
                        <select id="selectAmbiente" class="triagem" required></select>
                    </div>
                    <br>
                    <div class="triagens">
                        <label>Novo nome</label>
                        <input type="text" id="nomeAmbiente" class="form-control" required>
                    </div>
                    <br>
                    <div class="triagens">
                        <label>Bloco</label>
                        <select id="selectBloco" class="triagem" required></select>
                    </div>
                    <br>
                    <button type="submit" class="confirmar">Atualizar Ambiente</button>
                </form>
            </div>
        </div>
    </main>
    <script>
        let ambientes = [];
        let blocos = [];

        async function carregarAmbientes(){

            const res = await fetch("./api/api_ambientes.php");
            const data = await res.json();

            ambientes = data.data;

            const select = document.getElementById("selectAmbiente");

            select.innerHTML = ambientes.map(a =>
                `<option value="${a.id_ambiente}">
                    ${a.nome} - ${a.nome_bloco}
                </option>`
            ).join('');

        }

        async function carregarBlocos(){

            const res = await fetch("api/api_blocos.php");
            const data = await res.json();

            blocos = data.data;

            const select = document.getElementById("selectBloco");

            select.innerHTML = blocos.map(b =>
                `<option value="${b.id_bloco}">
                    ${b.nome}
                </option>`
            ).join('');

        }

        document.getElementById("selectAmbiente").addEventListener("change", function(){

            const id = this.value;

            const ambiente = ambientes.find(a => a.id_ambiente == id);

            if(ambiente){
                document.getElementById("nomeAmbiente").value = ambiente.nome;
                document.getElementById("selectBloco").value = ambiente.id_bloco;
            }

        });
        document.getElementById("formAmbientes").addEventListener("submit", async function(e){
            e.preventDefault();
            const id = document.getElementById("selectAmbiente").value;
            const nome = document.getElementById("nomeAmbiente").value;
            const id_bloco = document.getElementById("selectBloco").value;

            const res = await fetch("./api/api_ambientes.php", {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    id_ambiente: id,
                    nome: nome,
                    id_bloco: id_bloco
                })
            });

            const data = await res.json();

            alert(data.message);

            if(data.success){
                window.location.href = "gestor_ambientes.php";
            }

        });

        carregarAmbientes();
        carregarBlocos();
    </script>
</body>