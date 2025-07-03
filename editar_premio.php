<?php
// adm/editar_premio.php

include '../includes/db.php';

// Proteção da página
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_tipo']) || $_SESSION['user_tipo'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

// LÓGICA DE UPDATE (QUANDO O FORMULÁRIO É ENVIADO)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_premio'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $nome = trim($_POST['nome']);
    $chance = filter_input(INPUT_POST, 'chance', FILTER_VALIDATE_INT);
    $pontos = filter_input(INPUT_POST, 'pontos', FILTER_VALIDATE_INT);

    if ($id && !empty($nome) && $chance !== false && $pontos !== false) {
        $stmt = $pdo->prepare("UPDATE premios SET nome = ?, chance = ?, pontos = ? WHERE id = ?");
        $stmt->execute([$nome, $chance, $pontos, $id]);
        
        // Redireciona de volta para a lista principal
        header("Location: gerenciar_premios.php");
        exit();
    }
}

// LÓGICA DE READ (QUANDO A PÁGINA É CARREGADA)
// Pega o ID da URL de forma segura
$id_premio = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id_premio) {
    // Se não houver ID válido, volta para a lista
    header("Location: gerenciar_premios.php");
    exit();
}

// Busca os dados atuais do prêmio no banco
$stmt = $pdo->prepare("SELECT id, nome, chance, pontos FROM premios WHERE id = ?");
$stmt->execute([$id_premio]);
$premio = $stmt->fetch();

// Se o prêmio não for encontrado, volta para a lista
if (!$premio) {
    header("Location: gerenciar_premios.php");
    exit();
}

include '../includes/header.php';
?>

<!-- FORMULÁRIO DE EDIÇÃO HTML -->
<div class="container">
    <h2>Editar Prêmio</h2>
    
    <form method="post" action="editar_premio.php">
        <!-- Campo oculto para enviar o ID junto com o formulário -->
        <input type="hidden" name="id" value="<?= $premio['id'] ?>">
        
        <label for="nome">Nome do Prêmio:</label>
        <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($premio['nome']) ?>" required>
        
        <label for="chance">Chance:</label>
        <input type="number" id="chance" name="chance" value="<?= $premio['chance'] ?>" required min="0">
        
        <label for="pontos">Pontos:</label>
        <input type="number" id="pontos" name="pontos" value="<?= $premio['pontos'] ?>" required min="0">
        
        <button type="submit" name="update_premio" style="margin-top: 1rem;">Salvar Alterações</button>
    </form>
    
    <br>
    <a href="gerenciar_premios.php" class="button-link" style="text-decoration: none;">Cancelar e Voltar</a>
</div>

<?php 
include '../includes/footer.php'; 
?>