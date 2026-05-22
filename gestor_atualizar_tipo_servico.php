<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>SGM - Configurar Tipo de Serviço - Atualizar</title>
    
    <link rel="stylesheet" href="./assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

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
            padding: 15px 20px;
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
            padding: 20px;
        }

        /* =========================================
           O QUADRO (CARD) - AMPLO
           ========================================= */
        .a {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 600px; /* Quadro maior */
        }

        .sair {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 8px 18px;
            border-radius: 6px;
        }

        .voltar {
            margin: 20px;
            padding: 10px 25px;
            border-radius: 6px;
            border: 1px solid #ccc;
            background: #fff;
            color: #333;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
        }

        /* =========================================
           INPUTS E LABELS - MAIORES
           ========================================= */
        .triagens {
            display: flex !important;
            flex-direction: column !important;
            width: 100% !important;
            margin-bottom: 20px;
        }

        .triagens label {
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 1.1rem;
            color: #444;
        }

        /* Campos maiores para facilitar o uso mobile */
        .form-control, .form-select {
            width: 100% !important;
            height: 60px !important; /* Input maior */
            font-size: 18px !important; /* Fonte maior */
            padding: 12px 15px !important;
            border-radius: 8px !important;
            border: 1px solid #ced4da !important;
        }

        .confirmar {
            width: 100%;
            padding: 18px;
            background-color: #0d6efd;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 1.2rem;
            margin-top: 15px;
            transition: 0.3s;
        }

        .confirmar:active {
            transform: scale(0.98);
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

            .a {
                padding: 25px 20px !important;
                max-width: 100% !important;
            }

            .voltar {
                display: block !important;
                width: calc(100% - 40px) !important;
                margin: 10px auto !important;
                text-align: center !important;
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
    
    <a href="gestor_tipos_servico.php" class="text-decoration-none">
        <button class="voltar">Voltar</button>
    </a> 
    
    <main>
        <div class="configurarambiente">
            <div class="a">
                <h2 class="text-center" style="font-weight: 700; color: #222;">Editar Tipo de Serviço</h2>
                <hr style="margin-bottom: 30px;">

                <form id="formTiposServico">
                    <div class="triagens">
                        <label for="selectTipo">Tipo de Serviço</label>
                        <select id="selectTipo" class="form-select" required>
                            <option value="">Carregando tipos...</option>
                        </select>
                    </div>

                    <div class="triagens">
                        <label for="nomeTipo">Novo Nome</label>
                        <input type="text" id="nomeTipo" class="form-control" placeholder="Digite o nome" required>
                    </div>

                    <div class="triagens">
                        <label for="descricaoTipo">Descrição</label>
                        <input type="text" id="descricaoTipo" class="form-control" placeholder="Breve descrição" required>
                    </div>

                    <button type="submit" class="confirmar" id="btnAtualizar">
                        Atualizar Tipo de Serviço
                    </button>
                </form>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let tipos = [];

        async function carregarTipos(){
            try {
                const res = await fetch('./api/api_tipos_servico.php');
                const texto = await res.text();
                const resposta = JSON.parse(texto);

                if(resposta.success){
                    tipos = resposta.data;
                    const select = document.getElementById('selectTipo');
                    select.innerHTML = '';

                    tipos.forEach(tipo => {
                        select.innerHTML += `
                            <option value="${tipo.id_tipo}">${tipo.nome}</option>
                        `;
                    });

                    if(tipos.length > 0){
                        document.getElementById('nomeTipo').value = tipos[0].nome;
                        document.getElementById('descricaoTipo').value = tipos[0].descricao ?? '';
                    }
                } else {
                    alert("Erro ao carregar tipos.");
                }
            } catch(error){
                console.error(error);
                alert("Erro ao conectar com o servidor.");
            }
        }

        document.getElementById('selectTipo').addEventListener('change', function(){
            const id = this.value;
            const tipo = tipos.find(t => t.id_tipo == id);
            if(tipo){
                document.getElementById('nomeTipo').value = tipo.nome;
                document.getElementById('descricaoTipo').value = tipo.descricao ?? '';
            }
        });

        document.getElementById('formTiposServico').addEventListener('submit', async function(e){
            e.preventDefault();
            const btn = document.getElementById('btnAtualizar');
            btn.disabled = true;
            btn.innerText = "Atualizando...";

            const payload = {
                id_tipo: document.getElementById('selectTipo').value,
                nome: document.getElementById('nomeTipo').value.trim(),
                descricao: document.getElementById('descricaoTipo').value.trim()
            };

            try {
                const res = await fetch('./api/api_tipos_servico.php', {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });
                const resposta = await res.json();
                alert(resposta.message);

                if(resposta.success){
                    window.location.href = 'gestor_tipos_servico.php';
                } else {
                    btn.disabled = false;
                    btn.innerText = 'Atualizar Tipo de Serviço';
                }
            } catch(error){
                alert("Erro ao conectar com o servidor.");
                btn.disabled = false;
                btn.innerText = 'Atualizar Tipo de Serviço';
            }
        });

        carregarTipos();
    </script>
</body>
</html>