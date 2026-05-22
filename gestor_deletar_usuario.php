<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>SGM - Configurar Usuário - Deletar</title>
    
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
            max-width: 600px;
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

        /* Select maior para mobile */
        .form-select {
            width: 100% !important;
            height: 60px !important;
            font-size: 18px !important;
            padding: 12px 15px !important;
            border-radius: 8px !important;
            border: 1px solid #ced4da !important;
        }

        .confirmar {
            width: 100%;
            padding: 18px;
            background-color: #dc3545; /* Vermelho para indicar perigo/deleção */
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
            background-color: #a71d2a;
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
            <h2 class="fs-5">SGM | Configurar Usuário</h2>
        </div>
        <div class="header-top">
            <h2 class="fs-5">Olá, Admin Gestor | </h2>
            <a href="./api/logout.php"><button class="sair">Sair</button></a>
        </div>
    </header>
    
    <a href="gestor_usuarios.php" class="text-decoration-none">
        <button class="voltar">Voltar</button>
    </a> 
    
    <main>
        <div class="configurarambiente">
            <div class="a">
                <h2 class="text-center" style="font-weight: 700; color: #222;">Deletar Usuário</h2>
                <p class="text-center text-muted">Selecione o usuário que deseja remover permanentemente.</p>
                <hr style="margin-bottom: 30px;">

                <form id="formUsuarios">
                    <div class="triagens">
                        <label for="selectUsuario">Escolher Usuário</label>
                        <select id="selectUsuario" class="form-select" required>
                            <option value="">Carregando usuários...</option>
                        </select>
                    </div>

                    <button type="submit" class="confirmar" id="btnDeletar">
                        Deletar Usuário
                    </button>
                </form>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let usuarios = [];

        async function carregarUsuarios(){
            try {
                const res = await fetch('./api/api_usuarios.php');
                const resposta = await res.json();

                const select = document.getElementById('selectUsuario');

                if(resposta.success){
                    usuarios = resposta.data;
                    select.innerHTML = '<option value="">Selecione o usuário</option>';
                    usuarios.forEach(usuario => {
                        select.innerHTML += `<option value="${usuario.id_usuario}">${usuario.nome} - ${usuario.email}</option>`;
                    });
                } else {
                    select.innerHTML = '<option value="">Erro ao carregar usuários</option>';
                    alert(resposta.message);
                }
            } catch(error){
                console.error(error);
                alert('Erro ao conectar com o servidor.');
            }
        }

        document.getElementById('formUsuarios').addEventListener('submit', async function(e){
            e.preventDefault();

            const id_usuario = document.getElementById('selectUsuario').value;

            if(!id_usuario){
                alert('Selecione um usuário.');
                return;
            }

            const confirmar = confirm('Deseja realmente deletar este usuário? Esta ação não pode ser desfeita.');

            if(!confirmar) return;

            const btn = document.getElementById('btnDeletar');
            btn.disabled = true;
            btn.innerText = 'Deletando...';

            try {
                const res = await fetch('./api/api_usuarios.php', {
                    method: 'DELETE',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id_usuario: id_usuario })
                });

                const resposta = await res.json();
                alert(resposta.message);

                if(resposta.success){
                    window.location.href = 'gestor_usuarios.php';
                } else {
                    btn.disabled = false;
                    btn.innerText = 'Deletar Usuário';
                }
            } catch(error){
                console.error(error);
                alert('Erro ao conectar com o servidor.');
                btn.disabled = false;
                btn.innerText = 'Deletar Usuário';
            }
        });

        carregarUsuarios();
    </script>
</body>
</html>