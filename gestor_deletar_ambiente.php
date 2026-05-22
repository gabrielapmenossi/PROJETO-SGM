<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>SGM - Configurar Ambiente - Deletar</title>
    
    <link rel="stylesheet" href="./assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <style>
        /* =========================================
           Ajustes Gerais e Reset
           ========================================= */
        body {
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            min-width: 0 !important; /* Quebra as restrições do style.css original */
        }
        
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .header-top {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header-top h2 {
            margin: 0;
            font-size: 1.1rem;
        }

        .configurarambiente {
            display: flex;
            justify-content: center;
            padding: 40px 20px;
        }

        .a {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 450px;
        }

        .sair {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 5px 15px;
            border-radius: 4px;
        }

        .voltar {
            margin: 20px;
            padding: 8px 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background: #fff;
        }

        .confirmar {
            width: 100%;
            padding: 12px;
            background-color: #0d6efd;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            margin-top: 15px;
            transition: 0.3s;
        }

        .triagens label {
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
        }

        /* =========================================
           REGRAS PARA CELULAR (MOBILE)
           ========================================= */
        @media (max-width: 768px) {
            header {
                flex-direction: column !important;
                padding: 15px !important;
                text-align: center !important;
                gap: 10px !important;
            }

            .header-top {
                flex-direction: column !important;
                width: 100% !important;
            }

            .header-top h2 {
                font-size: 1rem !important;
            }

            header .header-top:last-child {
                flex-direction: row !important;
                justify-content: center !important;
            }

            .voltar {
                display: block !important;
                width: calc(100% - 40px) !important;
                margin: 10px auto !important;
                text-align: center !important;
            }

            .configurarambiente {
                padding: 15px !important;
            }

            .a {
                padding: 20px !important;
                border-radius: 10px !important;
                box-shadow: none !important;
                border: 1px solid #eee !important;
                width: 100% !important;
                max-width: 100% !important;
                box-sizing: border-box !important;
            }

            /* Ajustes nos inputs para melhor uso com os dedos no mobile */
            .form-select, .triagem {
                height: 50px !important;
                font-size: 16px !important; 
                width: 100% !important;
                box-sizing: border-box !important;
            }

            .confirmar {
                padding: 15px !important;
                font-size: 1.1rem !important;
            }
        }
    </style>
</head>
<body class="portal-gestor">
    <header>
        <div class="header-top">
            <h2 class="fs-5">SGM | Configurar Ambiente</h2>
        </div>
        <div class="header-top">
            <h2 class="fs-5">Olá, Admin Gestor | </h2>
            <a href="./api/logout.php"><button class="sair">Sair</button></a>
        </div>
    </header>
    
    <a href="gestor_ambientes.php"><button class="voltar">Voltar</button></a> 
    
    <main>
        <div class="configurarambiente">
            <div class="a">
                <h2 class="text-center">Deletar Ambiente</h2>
                <hr>
                <form id="formDeletarAmbiente">
                    <div class="triagens">
                        <label>Ambiente</label>
                        <select id="selectAmbiente" class="form-select" required>
                            <option value="">Carregando ambientes...</option>
                        </select>
                    </div>
                    <button id="btnDeletar" type="submit" class="confirmar btn btn-primary">
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
                    const res = await fetch('api/api_ambientes.php'); 
                    const resposta = await res.json();

                    if (resposta.success) {
                        selectAmbiente.innerHTML = '<option value="">Selecione o ambiente</option>';
                        
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

            carregarAmbientes();

            // 2. ENVIAR O PEDIDO PARA DELETAR
            formDeletar.addEventListener('submit', async (e) => {
                e.preventDefault(); 

                const idAmbiente = selectAmbiente.value;

                if(!idAmbiente) {
                    alert("Selecione um ambiente válido.");
                    return;
                }

                if (!confirm("Tem a certeza absoluta que deseja eliminar este ambiente? Esta ação não pode ser desfeita.")) {
                    return; 
                }

                const btnDeletar = document.getElementById('btnDeletar');
                btnDeletar.disabled = true;
                btnDeletar.innerText = "A apagar...";

                try {
                    const res = await fetch('api/api_ambientes.php', {
                        method: 'DELETE',
                        body: JSON.stringify({
                            id_ambiente: idAmbiente
                        })
                    }); 

                    const resposta = await res.json();

                    if (resposta.success) {
                        alert("Sucesso: " + resposta.message);
                        window.location.href = "gestor_ambientes.php"; 
                    } else {
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
</html>