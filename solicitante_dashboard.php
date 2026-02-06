<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM - Meus Chamados</title>
    <link rel="stylesheet" href="./assets/css/style.css">
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
        <div class="minhassolicitacoes">
            <h3>Minhas Solicitações</h3>
            <a href="#"><button class="novasolicitacao"> + Nova Solicitaçao</button></a>
        </div>
        <div class="solicitacoes">
            <table cellspacing="0" cellpadding="0">
                <thead class="thsolicitante" >
                    <th>ID</th>
                    <th>Foto</th>
                    <th>Local</th>
                    <th>Descrição</th>
                    <th>Data</th>
                    <th>Status</th>
                </thead>
                <tbody>
                    <tr>
                        <td>#1</td>
                        <td>Foto</td>
                        <td>Bloco administrativo</td>
                        <td>Vazando água da lâmpada</td>
                        <td>06 de fev. de 2025</td>
                        <td><button class="status">FECHADO</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
   </main>
</body>
</html>