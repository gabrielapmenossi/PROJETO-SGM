<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM - Detalhes do Chamado</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
    <a href="#"><button class="voltar">Voltar</button></a> 
    <main>
       <div class="dadosetriagem">
            <div class="dadossolicitacao">
                <div class="a">
                    <h2>Dados da Solicitaçao</h2>
                    <hr>
                    <div class="dados">
                        <p><strong class="strong">Descrição: </strong>Vazando água da lâmpada</p>
                    </div>
                    <div class="dados">
                        <p><strong class="strong">Local: </strong>Bloco Administrativo</p>
                    </div>
                    <div class="dados">
                        <p><strong class="strong">Solicitante: </strong>Maria Solicitante</p>
                    </div>
                    <div class="dados">
                        <p><strong class="strong">Abertura: </strong>06 de fev. de 2026, 10:51</p>
                    </div>
                    <hr>
                    <div class="evidencias">
                        <p>Evidências</p>
                        <img src="./docs/telas/gestor_atribuir_chamado.png" alt="">
                    </div>
                </div>
                <a href="#"><button class="reabrir">Reabrir Chamado</button></a>
            </div>
            <div class="triagemeatribuicao">
                
                <div class="a">
                    <h2>Triagem e Atribuição</h2>
                    <hr>
                    <div class="triagens">
                        <h3>Técnico Responsável</h3>
                        <select name="" id="triagem">
                            <option value="">João Técnico</option>
                            <option value="">Luciana Técnica</option>
                        </select>
                    </div>
                    <div class="triagem">
                        <h3>Prioridade</h3>
                        <select name="" id="triagem">
                            <option value="">Baixa</option>
                            <option value="">Média</option>
                            <option value="">Alta</option>
                        </select>
                    </div>
                    <div class="triagens">
                        <h3>Data Prevista</h3>
                        <input type="date" name="" id="triagem">
                    </div>
                </div>
                    <a href="#"><button class="confirmar">Confirmar atribuição</button></a>
            </div>
       </div>
    </main>
    
</body>
</html>