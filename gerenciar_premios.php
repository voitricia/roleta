<?php
// Inclui o arquivo de banco de dados e inicia a sessão.
include '../includes/db.php';

// Proteção da página: Garante que apenas administradores logados possam acessar.
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_tipo']) || $_SESSION['user_tipo'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

// --- LÓGICA DO CRUD ---

// AÇÃO: Adicionar um novo prêmio (CREATE)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_premio'])) {
    // Pega os dados do formulário de forma segura
    $nome = trim($_POST['nome']);
    $chance = filter_input(INPUT_POST, 'chance', FILTER_VALIDATE_INT);
    $pontos = filter_input(INPUT_POST, 'pontos', FILTER_VALIDATE_INT); // NOVO: Pega os pontos

    // Validação simples
    if (!empty($nome) && $chance !== false && $chance >= 0 && $pontos !== false && $pontos >= 0) {
        // NOVO: Query atualizada para incluir os pontos
        $stmt = $pdo->prepare("INSERT INTO premios (nome, chance, pontos) VALUES (?, ?, ?)");
        $stmt->execute([$nome, $chance, $pontos]);
        
        header("Location: gerenciar_premios.php"); 
        exit();
    }
}

// AÇÃO: Deletar um prêmio (DELETE)
if (isset($_GET['delete'])) {
    $id_para_deletar = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);
    
    if ($id_para_deletar) {
        $stmt = $pdo->prepare("DELETE FROM premios WHERE id = ?");
        $stmt->execute([$id_para_deletar]);
        header("Location: gerenciar_premios.php");
        exit();
    }
}

// AÇÃO: Buscar todos os prêmios (READ) - // NOVO: Buscando também a coluna pontos
$premios = $pdo->query("SELECT id, nome, chance, pontos FROM premios ORDER BY chance DESC")->fetchAll();

include '../includes/header.php';
?>

<!-- --- ESTRUTURA HTML DA PÁGINA --- -->
<div class="container">
    <h2>Gerenciar Prêmios</h2>
    
    <h3>Adicionar Novo Prêmio</h3>
    <form method="post" action="gerenciar_premios.php">
        <input type="text" name="nome" placeholder="Nome do Prêmio" required>
        <input type="number" name="chance" placeholder="Chance (ex: 10, 50)" required min="0">
        <!-- NOVO: Campo para adicionar a pontuação -->
        <input type="number" name="pontos" placeholder="Pontos (ex: 5, 20)" required min="0">
        <button type="submit" name="add_premio">Adicionar Prêmio</button>
    </form>

    <h3 style="margin-top: 2rem;">Prêmios Existentes</h3>
    
    <?php if (empty($premios)): ?>
        <p>Ainda não há prêmios cadastrados.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Chance</th>
                    <th>Pontos</th> <!-- NOVO: Cabeçalho da coluna -->
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($premios as $premio): ?>
                <tr>
                    <td><?= $premio['id'] ?></td>
                    <td><?= htmlspecialchars($premio['nome']) ?></td>
                    <td><?= $premio['chance'] ?></td>
                    <td><?= $premio['pontos'] ?></td> <!-- NOVO: Exibindo os pontos -->
                    <td>
                        <a href="gerenciar_premios.php?delete=<?= $premio['id'] ?>" onclick="return confirm('Tem certeza que deseja deletar este prêmio?')">Deletar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    
    <br>
    <a href="index.php" class="button-link" style="display: inline-block; margin-top: 1rem; text-decoration: none;">Voltar ao Painel</a>
</div>

<?php 
include '../includes/footer.php'; 
?>