<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>SGM - Configurar Tipo de Serviço - Deletar</title>
    
    <link rel="stylesheet" href="./assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <style>
        /* =========================================
           Ajustes Gerais e Reset de Desktop
           ========================================= */
        body {
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            min-width: 0 !important; /* Remove travas de largura do style.css */
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
                border-radius: 8px !important;
                box-shadow: none !important;
                border: 1px solid #eee !important;
                width: 100% !important;
                max-width: 100% !important;
                box-sizing: border-box !important;
            }

            /* Evita zoom automático no iPhone ao clicar no Select */
            .form-select {
                height: 50px !important;
                font-size: 16px !important; 
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
            <h2 class="fs-5">SGM | Configurar Tipo de Serviço</h2>
        </div>
        <div class="header-top">
            <h2 class="fs-5">Olá, Admin Gestor | </h2>
            <a href="./api/logout.php"><button class="sair">Sair</button></a>
        </div>
    </header>
    
    <a href="gestor_tipos_servico.php"><button class="voltar">Voltar</button></a>
    
    <main>
        <div class="configurarambiente">
            <div class="a">
                <h2 class="text-center">Deletar Tipo de Serviço</h2>
                <hr>
                <form id="formTiposServico">
                    <div class="triagens">
                        <label>Tipo de Serviço</label>
                        <select id="selectTipo" class="form-select" required>
                            <option value="">Carregando...</option>
                        </select>
                    </div>
                    <button type="submit" class="confirmar" id="btnDeletar">
                        Deletar Tipo de Serviço
                    </button>
                </form>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const selectTipo = document.getElementById('selectTipo');
            const form = document.getElementById('formTiposServico');

            // CARREGAR TIPOS
            async function carregarTipos(){
                try {
                    const res = await fetch('./api/api_tipos_servico.php');
                    const resposta = await res.json();
                    console.log(resposta);

                    if(resposta.success){
                        selectTipo.innerHTML = `<option value="">Selecione o tipo de serviço</option>`;
                        resposta.data.forEach(tipo => {
                            const option = document.createElement('option');
                            option.value = tipo.id_tipo;
                            option.textContent = tipo.nome;
                            selectTipo.appendChild(option);
                        });
                    } else {
                        alert("Erro ao carregar tipos.");
                    }
                } catch(error){
                    console.error(error);
                    alert("Erro ao conectar com o servidor.");
                }
            }

            carregarTipos();

            // DELETAR
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const idTipo = selectTipo.value;

                if(!idTipo){
                    alert("Selecione um tipo de serviço.");
                    return;
                }

                const confirmar = confirm("Deseja realmente deletar?");
                if(!confirmar){
                    return;
                }

                const btn = document.getElementById('btnDeletar');
                btn.disabled = true;
                btn.innerText = "Deletando...";

                try {
                    const res = await fetch('./api/api_tipos_servico.php', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id_tipo: idTipo
                        })
                    });

                    const resposta = await res.json();
                    console.log(resposta);

                    if(resposta.success){
                        alert(resposta.message);
                        window.location.href = "gestor_tipos_servico.php";
                    } else {
                        alert("Erro: " + resposta.message);
                        btn.disabled = false;
                        btn.innerText = "Deletar Tipo de Serviço";
                    }
                } catch(error){
                    console.error(error);
                    alert("Erro ao conectar com o servidor.");
                    btn.disabled = false;
                    btn.innerText = "Deletar Tipo de Serviço";
                }
            });
        });
    </script>
</body>
</html>