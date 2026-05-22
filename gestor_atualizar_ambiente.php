<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>SGM - Configurar Ambiente - Atualizar</title>
    
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
           INPUTS E LABELS - ESTILO "TOUCH"
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

        /* Padronizando select e input para o mesmo tamanho robusto */
        .triagem, .form-control {
            width: 100% !important;
            height: 60px !important;
            font-size: 18px !important;
            padding: 12px 15px !important;
            border-radius: 8px !important;
            border: 1px solid #ced4da !important;
            background-color: #fff;
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
           REGRAS DE RESPONSIVIDADE
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
            <h2 class="fs-5">SGM | Configurar Ambiente</h2>
        </div>
        <div class="header-top">
            <h2 class="fs-5">Olá, Admin Gestor | </h2>
            <a href="./api/logout.php"><button class="sair">Sair</button></a>
        </div>
    </header>
    
    <a href="gestor_ambientes.php" class="text-decoration-none">
        <button class="voltar">Voltar</button>
    </a> 
    
    <main>
        <div class="configurarambiente">
            <div class="a">
                <h2 class="text-center" style="font-weight: 700; color: #222;">Editar Ambiente</h2>
                <hr style="margin-bottom: 30px;">

                <form id="formAmbientes">
                    <div class="triagens">
                        <label for="selectAmbiente">Ambiente Atual</label>
                        <select id="selectAmbiente" class="triagem" required>
                            <option value="">Carregando ambientes...</option>
                        </select>
                    </div>

                    <div class="triagens">
                        <label for="nomeAmbiente">Novo nome</label>
                        <input type="text" id="nomeAmbiente" class="form-control" placeholder="Ex: Sala 101" required>
                    </div>

                    <div class="triagens">
                        <label for="selectBloco">Bloco Correspondente</label>
                        <select id="selectBloco" class="triagem" required>
                            <option value="">Carregando blocos...</option>
                        </select>
                    </div>

                    <button type="submit" class="confirmar">Atualizar Ambiente</button>
                </form>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let ambientes = [];
        let blocos = [];

        async function carregarAmbientes(){
            try {
                const res = await fetch("./api/api_ambientes.php");
                const data = await res.json();
                ambientes = data.data;

                const select = document.getElementById("selectAmbiente");
                select.innerHTML = '<option value="">Selecione o ambiente</option>' + 
                    ambientes.map(a => `<option value="${a.id_ambiente}">${a.nome} - ${a.nome_bloco}</option>`).join('');
            } catch(e) { console.error("Erro ao carregar ambientes"); }
        }

        async function carregarBlocos(){
            try {
                const res = await fetch("api/api_blocos.php");
                const data = await res.json();
                blocos = data.data;

                const select = document.getElementById("selectBloco");
                select.innerHTML = '<option value="">Selecione o bloco</option>' + 
                    blocos.map(b => `<option value="${b.id_bloco}">${b.nome}</option>`).join('');
            } catch(e) { console.error("Erro ao carregar blocos"); }
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
            const btn = e.target.querySelector('button');
            btn.disabled = true;
            btn.innerText = "Atualizando...";

            const payload = {
                id_ambiente: document.getElementById("selectAmbiente").value,
                nome: document.getElementById("nomeAmbiente").value.trim(),
                id_bloco: document.getElementById("selectBloco").value
            };

            try {
                const res = await fetch("./api/api_ambientes.php", {
                    method: "PUT",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(payload)
                });

                const data = await res.json();
                alert(data.message);

                if(data.success) window.location.href = "gestor_ambientes.php";
                else { btn.disabled = false; btn.innerText = "Atualizar Ambiente"; }
            } catch(error){
                alert("Erro ao conectar com o servidor.");
                btn.disabled = false;
                btn.innerText = "Atualizar Ambiente";
            }
        });

        carregarAmbientes();
        carregarBlocos();
    </script>
</body>
</html>