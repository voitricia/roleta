<?php
include 'includes/db.php';

// Garantir que o usuário esteja logado para ver o histórico
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Consulta SQL para buscar o histórico do usuário logado
// Usamos JOIN para pegar o nome do prêmio da tabela 'premios'
$stmt = $pdo->prepare(
    "SELECT p.nome AS premio_nome, h.data_giro
     FROM historico_giros h
     JOIN premios p ON h.premio_id = p.id
     WHERE h.usuario_id = ?
     ORDER BY h.data_giro DESC" // Ordena do mais recente para o mais antigo
);
$stmt->execute([$_SESSION['user_id']]);
$historico = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'includes/header.php';
?>

<div class="container">
    <h2>Seu Histórico de Prêmios</h2>

    <?php if (empty($historico)): ?>
        <p>Você ainda não ganhou nenhum prêmio. Gire a roleta para começar!</p>
    <?php else: ?>
        <table class="history-table">
            <thead>
                <tr>
                    <th>Prêmio</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($historico as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['premio_nome']) ?></td>
                        <td><?= date('d/m/Y \à\s H:i', strtotime($item['data_giro'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <p style="margin-top: 20px;"><a href="index.php">Voltar para a Roleta</a></p>
</div>

<?php include 'includes/footer.php'; ?>