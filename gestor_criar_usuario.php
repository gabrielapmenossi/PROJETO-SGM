<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>SGM - Configurar Usuário - Criar</title>
    
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
        }

        /* =========================================
           REGRAS PARA FORÇAR OS INPUTS GRANDES
           ========================================= */
        .triagens {
            display: flex !important;
            flex-direction: column !important; /* Força um item embaixo do outro */
            width: 100% !important;
            margin-bottom: 15px;
        }

        .triagens label {
            font-weight: bold;
            margin-bottom: 8px;
            text-align: left !important;
            width: 100%;
        }

        /* Aumenta a caixa de input para 100% do espaço */
        .form-control, .form-select {
            width: 100% !important;
            height: 50px !important;
            font-size: 16px !important; /* Evita zoom automático no celular */
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

            

            .a {
                padding: 20px !important;
                border-radius: 10px !important;
                box-shadow: none !important;
                border: 1px solid #eee !important;
            }
            .configurarambiente {
                padding: 15px !important;
                width: 80% !important; 
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
    
    <a href="gestor_usuarios.php"><button class="voltar">Voltar</button></a> 
    
    <main>
        <div class="configurarambiente">
            <div class="a">
                <h2 class="text-center" style="margin-bottom: 20px;">Criar Usuário</h2>
                <hr style="margin-bottom: 20px;">
                <form id="formUsuarios">
                    <div class="triagens">
                        <label>Nome do Usuário</label>
                        <input type="text" id="nomeUsuario" class="form-control" required>
                    </div>
                    
                    <div class="triagens">
                        <label>Email</label>
                        <input type="email" id="emailUsuario" class="form-control" required>
                    </div>
                    
                    <div class="triagens">
                        <label>Senha</label>
                        <input type="password" id="senhaUsuario" class="form-control" required>
                    </div>
                    
                    <div class="triagens">
                        <label>Perfil</label>
                        <select id="perfilUsuario" class="form-select" required>
                            <option value="">Selecione o perfil</option>
                            <option value="gestor">Gestor</option>
                            <option value="solicitante">Solicitante</option>
                            <option value="tecnico">Técnico</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="confirmar" id="btnCriar">
                        Criar Usuário
                    </button>
                </form>
            </div>
        </div>
    </main>

    <script>
        document.getElementById('formUsuarios').addEventListener('submit', async function(e){
            e.preventDefault();

            const nome = document.getElementById('nomeUsuario').value.trim();
            const email = document.getElementById('emailUsuario').value.trim();
            const senha = document.getElementById('senhaUsuario').value.trim();
            const perfil = document.getElementById('perfilUsuario').value;

            if(!nome || !email || !senha || !perfil){
                alert('Preencha todos os campos.');
                return;
            }

            const btn = document.getElementById('btnCriar');
            btn.disabled = true;
            btn.innerText = 'Criando...';

            try {
                const res = await fetch('./api/api_usuarios.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        nome: nome,
                        email: email,
                        senha: senha,
                        perfil: perfil
                    })
                });

                const resposta = await res.json();
                console.log(resposta);

                if(resposta.success){
                    alert(resposta.message);
                    window.location.href = 'gestor_usuarios.php';
                } else {
                    alert('Erro: ' + resposta.message);
                    btn.disabled = false;
                    btn.innerText = 'Criar Usuário';
                }

            } catch(error){
                console.error(error);
                alert('Erro ao conectar com o servidor.');
                btn.disabled = false;
                btn.innerText = 'Criar Usuário';
            }
        });
    </script>
</body>
</html>