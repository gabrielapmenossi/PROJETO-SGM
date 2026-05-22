<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>SGM - Configurar Bloco - Criar</title>

    <link rel="stylesheet" href="./assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <style>
        /* =========================================
           Ajustes de Layout e Reset
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
        }

        /* =========================================
           FORÇAR INPUTS GRANDES E EMPILHADOS
           ========================================= */
        .triagens {
            display: flex !important;
            flex-direction: column !important; /* Label acima do Input */
            width: 100% !important;
            margin-bottom: 15px;
        }

        .triagens label {
            font-weight: bold;
            margin-bottom: 8px;
            text-align: left !important;
        }

        .form-control {
            width: 100% !important;
            height: 50px !important; /* Altura maior para toque */
            font-size: 16px !important; /* Evita zoom no iPhone */
            box-sizing: border-box !important;
            padding: 10px !important;
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
        }

        /* =========================================
           MEDIA QUERIES (MOBILE)
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
            }

            .a {
                padding: 20px !important;
                box-shadow: none !important;
                border: 1px solid #eee !important;
            }
        }
    </style>
</head>

<body class="portal-gestor">

    <header>
        <div class="header-top">
            <h2 class="fs-5">SGM | Configurar Bloco</h2>
        </div>
        <div class="header-top">
            <h2 class="fs-5">Olá, Admin Gestor | </h2>
            <a href="./api/logout.php">
                <button class="sair">Sair</button>
            </a>
        </div>
    </header>

    <a href="gestor_blocos.php">
        <button class="voltar">Voltar</button>
    </a>

    <main>
        <div class="configurarambiente">
            <div class="a">
                <h2 class="text-center">Criar Bloco</h2>
                <hr>
                <form id="formBlocos">
                    <div class="triagens">
                        <label>Nome do Bloco</label>
                        <input type="text" id="nomeBloco" class="form-control" required>
                    </div>

                    <div class="triagens">
                        <label>Descrição</label>
                        <input type="text" id="descricaoBloco" class="form-control">
                    </div>

                    <button type="submit" class="confirmar" id="btnCriar">
                        Criar Bloco
                    </button>
                </form>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const formBlocos = document.getElementById('formBlocos');

            formBlocos.addEventListener('submit', async (e) => {
                e.preventDefault();

                const nomeBloco = document.getElementById('nomeBloco').value.trim();
                const descricaoBloco = document.getElementById('descricaoBloco').value.trim();

                if (!nomeBloco) {
                    alert("Preencha o nome do bloco.");
                    return;
                }

                const btnCriar = document.getElementById('btnCriar');
                btnCriar.disabled = true;
                btnCriar.innerText = "Criando...";

                try {
                    const response = await fetch('./api/api_blocos.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            nome: nomeBloco,
                            descricao: descricaoBloco
                        })
                    });

                    const texto = await response.text();
                    const resposta = JSON.parse(texto);

                    if (resposta.success) {
                        alert(resposta.message);
                        window.location.href = "gestor_blocos.php";
                    } else {
                        alert("Erro: " + resposta.message);
                        btnCriar.disabled = false;
                        btnCriar.innerText = "Criar Bloco";
                    }
                } catch (error) {
                    console.error(error);
                    alert("Erro ao processar a requisição.");
                    btnCriar.disabled = false;
                    btnCriar.innerText = "Criar Bloco";
                }
            });
        });
    </script>
</body>
</html>