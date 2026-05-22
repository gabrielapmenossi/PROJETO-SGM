<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    
    <style>
        /* Ajuste no body para centralizar perfeitamente e evitar que grude nas bordas no mobile */
        body { 
            background-color: #f8f9fa; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            min-height: 100vh; 
            padding: 15px; /* Espaçamento seguro para telas pequenas */
        }
        
        .login-card { 
            width: 100%; 
            max-width: 400px; 
            /* A borda e a sombra originais foram mantidas */
            border: 1px solid #70E689; 
            border-radius: 8px; /* Arredondamento um pouco maior para ficar mais moderno */
            box-shadow: 1px 1px 10px rgba(81, 171, 100, 0.5); /* Sombra mais suave */
        }
    </style>
</head>
<body>
    <div class="login-card p-4 p-sm-5 bg-white">
        <div class="text-center mb-3">
            <i class="bi bi-airplane" style="font-size: 2.5rem; color: #A67CEB;"></i>
        </div>
        
        <h3 class="text-center mb-4 fw-bold" style="color: #333;">SGM - Acesso</h3>
        
        <form id="formLogin">
            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary">E-mail</label>
                <input type="email" id="email" class="form-control" placeholder="Digite seu e-mail" required>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold text-secondary">Senha</label>
                <input type="password" id="senha" class="form-control" placeholder="Digite sua senha" required>
            </div>
            
            <button type="submit" class="btn w-100 fw-bold text-white py-2" style="background-color: #A67CEB; border-radius: 5px;">Entrar</button>
            
            <div id="mensagem" class="mt-3 text-center text-danger small fw-semibold"></div>
        </form>
    </div>

    <script src="assets/js/login.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>