<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>SGM - Configurar Usuário - Atualizar</title>
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
                    Editar Usuário
                </h2>

                <hr>

                <br>

                <form id="formUsuarios">

                    <div class="triagens">

                        <label>
                            Usuário
                        </label>

                        <select
                            id="selectUsuario"
                            class="form-select"
                            required>

                            <option value="">
                                Carregando usuários...
                            </option>

                        </select>

                    </div>

                    <br>

                    <div class="triagens">

                        <label>
                            Nome
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
                            Perfil
                        </label>

                        <select
                            id="perfilUsuario"
                            class="form-select"
                            required>

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
                        id="btnAtualizar">

                        Atualizar Usuário

                    </button>

                </form>

            </div>

        </div>
    </main>
    <script>

        let usuarios = [];


        // =========================
        // CARREGAR USUÁRIOS
        // =========================
        async function carregarUsuarios(){

            try {

                const res =
                    await fetch(
                        './api/api_usuarios.php'
                    );

                const resposta =
                    await res.json();

                console.log(resposta);

                const select =
                    document.getElementById(
                        'selectUsuario'
                    );

                if(resposta.success){

                    usuarios =
                        resposta.data;

                    select.innerHTML =
                        '<option value="">Selecione o usuário</option>';

                    usuarios.forEach(usuario => {

                        select.innerHTML += `
                            <option value="${usuario.id_usuario}">
                                ${usuario.nome} - ${usuario.email}
                            </option>
                        `;

                    });

                } else {

                    alert(
                        resposta.message
                    );

                }

            } catch(error){

                console.error(error);

                alert(
                    'Erro ao carregar usuários.'
                );

            }

        }


        // =========================
        // PREENCHER CAMPOS
        // =========================
        document.getElementById('selectUsuario')
        .addEventListener('change', function(){

            const id =
                this.value;

            const usuario =
                usuarios.find(
                    u => u.id_usuario == id
                );

            if(usuario){

                document.getElementById(
                    'nomeUsuario'
                ).value =
                    usuario.nome;

                document.getElementById(
                    'emailUsuario'
                ).value =
                    usuario.email;

                document.getElementById(
                    'perfilUsuario'
                ).value =
                    usuario.perfil;

            }

        });


        // =========================
        // ATUALIZAR USUÁRIO
        // =========================
        document.getElementById('formUsuarios')
        .addEventListener('submit', async function(e){

            e.preventDefault();

            const id_usuario =
                document.getElementById(
                    'selectUsuario'
                ).value;

            const nome =
                document.getElementById(
                    'nomeUsuario'
                ).value.trim();

            const email =
                document.getElementById(
                    'emailUsuario'
                ).value.trim();

            const perfil =
                document.getElementById(
                    'perfilUsuario'
                ).value;

            if(
                !id_usuario ||
                !nome ||
                !email ||
                !perfil
            ){

                alert(
                    'Preencha todos os campos.'
                );

                return;

            }

            const btn =
                document.getElementById(
                    'btnAtualizar'
                );

            btn.disabled = true;

            btn.innerText =
                'Atualizando...';

            try {

                const res =
                    await fetch(
                        './api/api_usuarios.php',
                        {
                            method: 'PUT',

                            headers: {
                                'Content-Type':
                                    'application/json'
                            },

                            body: JSON.stringify({

                                id_usuario:
                                    id_usuario,

                                nome:
                                    nome,

                                email:
                                    email,

                                perfil:
                                    perfil

                            })

                        }
                    );

                const resposta =
                    await res.json();

                console.log(resposta);

                alert(
                    resposta.message
                );

                if(resposta.success){

                    window.location.href =
                        'gestor_usuarios.php';

                } else {

                    btn.disabled = false;

                    btn.innerText =
                        'Atualizar Usuário';

                }

            } catch(error){

                console.error(error);

                alert(
                    'Erro ao conectar com o servidor.'
                );

                btn.disabled = false;

                btn.innerText =
                    'Atualizar Usuário';

            }

        });


        // =========================
        // INICIAR
        // =========================
        carregarUsuarios();

    </script>
</body>