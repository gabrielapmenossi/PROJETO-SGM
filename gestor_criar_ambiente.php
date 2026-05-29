<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>SGM - Configurar Ambiente - Criar</title>
    
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
            min-width: 0 !important;
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
            text-decoration: none;
            display: inline-block;
        }

        /* =========================================
           FORÇAR INPUTS GRANDES E EMPILHADOS
           ========================================= */
        .triagens {
            display: flex !important;
            flex-direction: column !important; /* Label em cima, campo embaixo */
            width: 100% !important;
            margin-bottom: 15px;
        }

        .triagens label {
            font-weight: bold;
            margin-bottom: 8px;
            text-align: left !important;
        }

        /* Ajuste para inputs e selects */
        .form-control, .form-select, .triagem {
            width: 100% !important;
            height: 50px !important;
            font-size: 16px !important; /* Evita zoom no iPhone */
            box-sizing: border-box !important;
            padding: 10px !important;
            border-radius: 6px !important;
        }

        .confirmar {
            width: 100%;
            padding: 15px;
            background-color: #0d6efd;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            margin-top: 10px;
            font-size: 1.1rem;
            transition: 0.3s;
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
                width: 80% !important; 
            }

            .a {
                padding: 20px !important;
                box-shadow: none !important;
                border: 1px solid #eee !important;
                width: 100% !important;
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
    
    <a href="gestor_ambientes.php" class="voltar-container">
        <button class="voltar">Voltar</button>
    </a> 
    
    <main>
        <div class="configurarambiente">
            <div class="a">
                <h2 class="text-center">Criar Ambiente</h2>
                <hr>
                <form id="formAmbientes">
                    <div class="triagens">
                        <label>Nome do ambiente</label>
                        <input type="text" id="nomeAmbiente" class="form-control" required>
                    </div>
                    
                    <div class="triagens">
                        <label>Bloco</label>
                        <select id="selectBloco" class="form-select triagem" required>
                            <option value="">Selecione o bloco</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="confirmar" id="btnCriar">Criar Ambiente</button>
                </form>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const formAmbientes = document.getElementById('formAmbientes');
            const selectBloco = document.getElementById('selectBloco');

            // 1. CARREGAR OS BLOCOS NO SELECT
            async function carregarBlocos() {
                try {
                    const res = await fetch('api/api_blocos.php'); 
                    const resposta = await res.json();

                    if (resposta.success) {
                        selectBloco.innerHTML = '<option value="">Selecione o bloco</option>';
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
                    const res = await fetch('api/api_ambientes.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            nome: nomeAmbiente,
                            id_bloco: idBloco
                        })
                    }); 

                    const resposta = await res.json();

                    if (resposta.success) {
                        alert("Sucesso: " + resposta.message);
                        window.location.href = "gestor_ambientes.php"; 
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
</html>