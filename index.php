<?php
include '../includes/db.php';

// Proteção da página
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_tipo']) || $_SESSION['user_tipo'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

include '../includes/header.php';
?>

<!-- O container principal que cria o bloco central -->
<div class="container">
    <h2>Painel de Administração</h2>
    <p>Bem-vindo, <?= htmlspecialchars($_SESSION['user_name']) ?>!</p>
    
    <!-- Menu de Administração com todos os links -->
    <!-- Os estilos inline garantem o espaçamento e alinhamento corretos -->
    <ul style="list-style-type: none; padding: 0; text-align: left; margin-top: 2rem;">
        
        <li style="margin-bottom: 10px;">
            <a href="gerenciar_premios.php" class="button-link" style="text-decoration:none; display: block;">Gerenciar Prêmios</a>
        </li>
        
        <li style="margin-bottom: 10px;">
            <a href="gerenciar_usuarios.php" class="button-link" style="text-decoration:none; display: block;">Gerenciar Usuários</a>
        </li>

        <!-- --- LINK NOVO CORRETAMENTE POSICIONADO --- -->
        <li>
            <a href="historico_geral.php" class="button-link" style="text-decoration:none; display: block;">Ver Histórico Geral</a>
        </li>

    </ul>
</div>

<?php include '../includes/footer.php'; ?>