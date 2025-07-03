<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projeto Roleta de Prêmios</title>
    
    <!-- LINHA ATUALIZADA COM O TRUQUE PARA LIMPAR O CACHE -->
    <link rel="stylesheet" href="/projeto_roleta/css/styles.css?v=<?= time() ?>"> 
</head>
<body>
    <nav>
        <!-- DIV PARA O LADO ESQUERDO DA NAVEGAÇÃO -->
        <div class="nav-left">
            <a href="/projeto_roleta/index.php"><strong>Roleta do IFSC</strong></a>
            
            <?php // Links principais que aparecem se o usuário estiver logado ?>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="/projeto_roleta/historico.php">Histórico</a>
                <a href="/projeto_roleta/ranking.php">Ranking</a>
            <?php endif; ?>
        </div>

        <!-- DIV PARA O LADO DIREITO DA NAVEGAÇÃO -->
        <div class="nav-right">
            <?php if (isset($_SESSION['user_id'])): ?>
                <span class="user-info">Olá, <?= htmlspecialchars($_SESSION['user_name']) ?>!</span>
                
                <?php // Link do painel admin, visível apenas para admins ?>
                <?php if (isset($_SESSION['user_tipo']) && $_SESSION['user_tipo'] === 'admin'): ?>
                    <a href="/projeto_roleta/adm/index.php">Painel Admin</a>
                <?php endif; ?>
                
                <a href="/projeto_roleta/logout.php">Sair</a>
            <?php else: // Se o usuário não estiver logado, mostra Login/Registro ?>
                <a href="/projeto_roleta/login.php">Login</a>
                <a href="/projeto_roleta/register.php">Registrar</a>
            <?php endif; ?>
        </div>
    </nav>