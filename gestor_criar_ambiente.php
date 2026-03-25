<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>SGM - Configurar Ambiente - Criar</title>
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
                    <h2>Criar Ambiente</h2>
                    <hr>
                    <br>
                    <form id="formAmbientes">
                        <div class="triagens">
                            <label>Nome do ambiente</label>
                            <input type="text" id="nomeAmbiente" class="form-control" required>
                        </div>
                        <br>
                        <div class="triagens">
                            <label>Bloco</label>
                            <select id="selectBloco" required onchange="carregarBloco(this.value)">
                                <option value="">Selecione o bloco</option>
                            </select>
                        </div>
                        <br>
                        <br>
                        <a href="./gestor_ambientes.php"><button type="submit" class="confirmar" id="btnCriar">Criar Ambiente</button></a>
                    </form>
                </div>
            </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

        <script>
        document.addEventListener('DOMContentLoaded', () => {
            const formAmbientes = document.getElementById('formAmbientes');
            const selectBloco = document.getElementById('selectBloco');

            // 1. CARREGAR OS BLOCOS NO SELECT
            async function carregarBlocos() {
                try {
                    // Chama a sua API de blocos
                    const res = await fetch('api/api_blocos.php'); 
                    const resposta = await res.json();

                    // Verifica o 'success' (que agora está corrigido no PHP!)
                    if (resposta.success) {
                        selectBloco.innerHTML = '<option value="">Selecione o bloco</option>';
                        
                        // Preenche as opções usando id_bloco e nome
                        resposta.data.forEach(bloco => {
                            selectBloco.innerHTML += `<option value="${bloco.id_bloco}">${bloco.nome}</option>`;
                        });
                    } else {
                        console.error("Erro da API de blocos:", resposta.message);
                        selectBloco.innerHTML = '<option value="">Erro ao carregar blocos</option>';
                    }
                } catch (error) {
                    console.error("Erro na requisição:", error);
                    selectBloco.innerHTML = '<option value="">Erro de conexão</option>';
                }
            }

            // Executa a função assim que a página carrega
            carregarBlocos();


            // 2. SALVAR O NOVO AMBIENTE
            formAmbientes.addEventListener('submit', async (e) => {
                e.preventDefault(); 

                const nomeAmbiente = document.getElementById('nomeAmbiente').value.trim();
                const idBloco = selectBloco.value;

                if(!nomeAmbiente || !idBloco) {
                    alert("Preencha o nome e selecione um bloco.");
                    return;
                }

                const btnCriar = document.getElementById('btnCriar');
                btnCriar.disabled = true;
                btnCriar.innerText = "Criando...";

                try {
                    // Envia os dados para a API de ambientes
                    const res = await fetch('api/api_ambientes.php', {
                        method: 'POST',
                        body: JSON.stringify({
                            nome: nomeAmbiente,
                            id_bloco: idBloco
                        })
                    }); 

                    const resposta = await res.json();

                    if (resposta.success) {
                        alert("Sucesso: " + resposta.message);
                        window.location.href = "gestor_ambientes.php"; // Redireciona ao salvar
                    } else {
                        alert("Erro: " + resposta.message);
                        btnCriar.disabled = false;
                        btnCriar.innerText = "Criar Ambiente";
                    }
                } catch (error) {
                    console.error("Erro no JavaScript:", error);
                    alert("Erro ao tentar conectar com o servidor.");
                    btnCriar.disabled = false;
                    btnCriar.innerText = "Criar Ambiente";
                }
            });
        });
    </script>
</body>