<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM - Gestão de Chamados</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
    <header>
        <div class="header-top">
            <h2>SGM | Painel do Solicitante</h2>
        </div>
        <div class="header-top">
            <h2>Olá, Maria Solicitante | </h2><a href="./api/logout.php"><button class="sair">Sair</button></a>
        </div>
   </header> 
   <main>
        <div class="todososchamados">
            <h3>Todos os chamados</h3>
            <div class="tiposchamados">
               <a href="#"><button class="tipo todos">Todos</button></a> 
               <a href="#"><button class="tipo abertos">Abertos</button></a> 
               <a href="#"><button class="tipo emexecucao">Em Execução</button></a> 
               <a href="#"><button class="tipo concluidos">Concluídos</button></a> 
            </div>  
        </div>
        
        <div class="solicitacoes">
            <table cellspacing="0" cellpadding="0">
                <thead class="thsolicitante" >
                    <th>ID</th>
                    <th>Solicitante</th>
                    <th>Local</th>
                    <th>Prioridade</th>
                    <th>Técnico</th>
                    <th>Status</th>
                    <th>Ações</th>
                </thead>
                <tbody>
                    <tr>
                        <td>#1</td>
                        <td>Maria Solicitante</td>
                        <td>Bloco administrativo</td>
                        <td class="prioridadealta">
                            <i class="bi bi-balloon-fill"></i>
                            Alta</td>
                        <td>João Técnico</td>
                        <td><button class="status">FECHADO</button></td>
                        <td><button class="acoes">
                            <i class="bi bi-eye"></i>
                            Gerenciar</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
   </main>
</body>
</html>