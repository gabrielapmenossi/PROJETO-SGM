<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>SGM - Configurar Ambiente - Deletar</title>
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
                    <h2>Deletar Ambientes</h2>
                    <hr>
                    <br>
                    <form id="formDeletarAmbiente">
                        <div class="triagens">
                            <label>Ambiente</label>
                            <select id="selectAmbiente" class="triagem" required></select>
                        </div>
                        <br>
                        <button id="btnDeletar" type="submit" class="confirmar">
                            Deletar Ambiente
                        </button>
                    </form>
                </div>
            </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const formDeletar = document.getElementById('formDeletarAmbiente');
            const selectAmbiente = document.getElementById('selectAmbiente');

            // 1. CARREGAR OS AMBIENTES NO SELECT
            async function carregarAmbientes() {
                try {
                    // Puxa a lista de ambientes da sua API
                    const res = await fetch('api/api_ambientes.php'); 
                    const resposta = await res.json();

                    if (resposta.success) {
                        selectAmbiente.innerHTML = '<option value="">Selecione o ambiente</option>';
                        
                        // Preenche as opções usando id_ambiente, nome e bloco
                        resposta.data.forEach(ambiente => {
                            const nomeBloco = ambiente.nome_bloco ? ambiente.nome_bloco : 'Sem bloco';
                            selectAmbiente.innerHTML += `<option value="${ambiente.id_ambiente}">${ambiente.nome} (${nomeBloco})</option>`;
                        });
                    } else {
                        console.error("Erro da API:", resposta.message);
                        selectAmbiente.innerHTML = '<option value="">Erro ao carregar ambientes</option>';
                    }
                } catch (error) {
                    console.error("Erro na requisição:", error);
                    selectAmbiente.innerHTML = '<option value="">Erro de conexão</option>';
                }
            }

            // Executa a função assim que a página carrega
            carregarAmbientes();


            // 2. ENVIAR O PEDIDO PARA DELETAR
            formDeletar.addEventListener('submit', async (e) => {
                e.preventDefault(); 

                const idAmbiente = selectAmbiente.value;

                if(!idAmbiente) {
                    alert("Selecione um ambiente válido.");
                    return;
                }

                // Pede confirmação extra ao utilizador para evitar apagar por engano
                if (!confirm("Tem a certeza absoluta que deseja eliminar este ambiente? Esta ação não pode ser desfeita.")) {
                    return; // Se o utilizador clicar em Cancelar, o código para por aqui
                }

                const btnDeletar = document.getElementById('btnDeletar');
                btnDeletar.disabled = true;
                btnDeletar.innerText = "A apagar...";

                try {
                    // Envia os dados para a API de ambientes usando o método DELETE
                    const res = await fetch('api/api_ambientes.php', {
                        method: 'DELETE',
                        body: JSON.stringify({
                            id_ambiente: idAmbiente
                        })
                    }); 

                    const resposta = await res.json();

                    if (resposta.success) {
                        alert("Sucesso: " + resposta.message);
                        window.location.href = "gestor_ambientes.php"; // Redireciona após apagar
                    } else {
                        // Exibe erro se tentar apagar um ambiente que já tem dados ligados a ele
                        alert("Erro: " + resposta.message);
                        btnDeletar.disabled = false;
                        btnDeletar.innerText = "Deletar Ambiente";
                    }
                } catch (error) {
                    console.error("Erro no JavaScript:", error);
                    alert("Erro ao tentar ligar ao servidor.");
                    btnDeletar.disabled = false;
                    btnDeletar.innerText = "Deletar Ambiente";
                }
            });
        });
    </script>
</body>