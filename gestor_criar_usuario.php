<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>SGM - Configurar Usuário - Criar</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <header>
        <div class="header-top" >
            <h2 class="fs-5 ">SGM | Configurar Usuário</h2>
        </div>
        <div class="header-top" >
            <h2 class="fs-5 ">Olá, Admin Gestor | </h2><a href="./api/logout.php"><button class="sair">Sair</button></a>
        </div>
    </header>
    <a href="gestor_usuarios.php"><button class="voltar">Voltar</button></a> 
    <main>
        <div class="configurarambiente">
            <div class="a">
                <h2>
                    Criar Usuário
                </h2>
                <hr>
                <br>
                <form id="formUsuarios">
                    <div class="triagens">
                        <label>
                            Nome do Usuário
                        </label>
                        <input
                            type="text"
                            id="nomeUsuario"
                            class="form-control"
                            required>
                    </div>
                    <br>
                    <div class="triagens">
                        <label>
                            Email
                        </label>
                        <input
                            type="email"
                            id="emailUsuario"
                            class="form-control"
                            required>
                    </div>
                    <br>
                    <div class="triagens">
                        <label>
                            Senha
                        </label>
                        <input
                            type="password"
                            id="senhaUsuario"
                            class="form-control"
                            required>
                    </div>
                    <br>
                    <div class="triagens">
                        <label>
                            Perfil
                        </label>
                        <select
                            id="perfilUsuario"
                            class="form-select"
                            required>
                            <option value="">
                                Selecione o perfil
                            </option>
                            <option value="gestor">
                                Gestor
                            </option>
                            <option value="solicitante">
                                Solicitante
                            </option>
                            <option value="tecnico">
                                Técnico
                            </option>
                        </select>
                    </div>
                    <br>
                    <button
                        type="submit"
                        class="confirmar"
                        id="btnCriar">
                        Criar Usuário
                    </button>
                </form>
            </div>
        </div>
    </main>
    <script>

        document.getElementById('formUsuarios')
        .addEventListener('submit', async function(e){

            e.preventDefault();

            const nome =
                document.getElementById('nomeUsuario')
                .value
                .trim();

            const email =
                document.getElementById('emailUsuario')
                .value
                .trim();

            const senha =
                document.getElementById('senhaUsuario')
                .value
                .trim();

            const perfil =
                document.getElementById('perfilUsuario')
                .value;

            if(
                !nome ||
                !email ||
                !senha ||
                !perfil
            ){

                alert(
                    'Preencha todos os campos.'
                );

                return;
            }

            const btn =
                document.getElementById('btnCriar');

            btn.disabled = true;

            btn.innerText =
                'Criando...';

            try {

                const res =
                    await fetch(
                        './api/api_usuarios.php',
                        {
                            method: 'POST',

                            headers: {
                                'Content-Type':
                                    'application/json'
                            },

                            body: JSON.stringify({

                                nome: nome,

                                email: email,

                                senha: senha,

                                perfil: perfil

                            })

                        }
                    );

                const resposta =
                    await res.json();

                console.log(resposta);

                if(resposta.success){

                    alert(
                        resposta.message
                    );

                    window.location.href =
                        'gestor_usuarios.php';

                } else {

                    alert(
                        'Erro: ' +
                        resposta.message
                    );

                    btn.disabled = false;

                    btn.innerText =
                        'Criar Usuário';

                }

            } catch(error){

                console.error(error);

                alert(
                    'Erro ao conectar com o servidor.'
                );

                btn.disabled = false;

                btn.innerText =
                    'Criar Usuário';

            }

        });

    </script>
</body>