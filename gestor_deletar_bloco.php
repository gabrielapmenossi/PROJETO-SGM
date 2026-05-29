<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>SGM - Configurar Bloco - Deletar</title>
    
    <link rel="stylesheet" href="./assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Ajustes Gerais e Reset */
        body {
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            min-width: 0 !important; /* Força a remoção de larguras fixas do style.css */
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

            /* Mantém o Admin e Sair lado a lado no mobile se couber */
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

            .a {
                padding: 20px !important;
                border-radius: 10px !important;
                box-shadow: none !important;
                border: 1px solid #eee !important;
                width: 100% !important;
                max-width: 100% !important;
                box-sizing: border-box !important;
            }

            .configurarambiente {
                padding: 15px !important;
                width: 80% !important; 
            }

            /* Melhora o Select para evitar zoom automático no iPhone */
            .form-select {
                height: 50px !important;
                font-size: 16px !important; 
                width: 185px !important; /* Força largura maior para evitar zoom, mas será ajustado pelo container */
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

    <a href="gestor_blocos.php"><button class="voltar">Voltar</button></a> 

    <main>
        <div class="configurarambiente">
            <div class="a">
                <h2 class="text-center">Deletar Bloco</h2>
                <hr>
                <form id="formBlocos">
                    <div class="triagens">
                        <label>Bloco</label>
                        <select id="selectBloco" class="form-select" required>
                            <option value="">Selecione o bloco</option>
                        </select>
                    </div>
                    <button type="submit" class="confirmar" id="btnDeletar">
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

            async function carregarBlocos(){
                try {
                    const res = await fetch('./api/api_blocos.php');
                    const resposta = await res.json();
                    if(resposta.success){
                        selectBloco.innerHTML = `<option value="">Selecione o bloco</option>`;
                        resposta.data.forEach(bloco => {
                            const option = document.createElement('option');
                            option.value = bloco.id_bloco;
                            option.textContent = bloco.nome;
                            selectBloco.appendChild(option);
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

            formBlocos.addEventListener('submit', async (e) => {
                e.preventDefault();
                const idBloco = selectBloco.value;
                if(!idBloco) return alert("Selecione um bloco.");

                if(!confirm("Tem certeza que deseja deletar este bloco?")) return;

                const btnDeletar = document.getElementById('btnDeletar');
                btnDeletar.disabled = true;
                btnDeletar.innerText = "Deletando...";

                try {
                    const res = await fetch('./api/api_blocos.php', {
                        method: 'DELETE',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id_bloco: idBloco })
                    });
                    const resposta = await res.json();
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
</html>