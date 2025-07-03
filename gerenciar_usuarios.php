<?php
include '../includes/db.php';

// Proteção da página
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_tipo']) || $_SESSION['user_tipo'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

// ... (toda a sua lógica de 'mudar_tipo' e 'delete' permanece igual) ...
if (isset($_GET['mudar_tipo']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $tipo_atual = $_GET['tipo_atual'];
    if ($id != $_SESSION['user_id']) {
        $novo_tipo = ($tipo_atual === 'admin') ? 'usuario' : 'admin';
        $stmt = $pdo->prepare("UPDATE usuarios SET tipo = ? WHERE id = ?");
        $stmt->execute([$novo_tipo, $id]);
    }
    header("Location: gerenciar_usuarios.php");
    exit();
}
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if ($id != $_SESSION['user_id']) {
        $stmt_delete_giros = $pdo->prepare("DELETE FROM historico_giros WHERE usuario_id = ?");
        $stmt_delete_giros->execute([$id]);
        $stmt_delete_user = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt_delete_user->execute([$id]);
    }
    header("Location: gerenciar_usuarios.php");
    exit();
}

$usuarios = $pdo->query("SELECT id, nome, email, tipo FROM usuarios ORDER BY nome ASC")->fetchAll();
include '../includes/header.php';
?>
<div class="container" style="max-width: 900px;">
    <h2>Gerenciar Usuários</h2>
    <?php if (empty($usuarios)): ?>
        <p>Não há usuários cadastrados.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Tipo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= $usuario['id'] ?></td>
                    <td><?= htmlspecialchars($usuario['nome']) ?></td>
                    <td><?= htmlspecialchars($usuario['email']) ?></td>
                    <td><?= ucfirst($usuario['tipo']) ?></td>
                    <td style="white-space: nowrap;">
                        <?php if ($usuario['id'] != $_SESSION['user_id']): ?>
                            <a href="editar_usuario.php?id=<?= $usuario['id'] ?>">Editar</a> | 
                            <a href="gerenciar_usuarios.php?mudar_tipo=1&id=<?= $usuario['id'] ?>&tipo_atual=<?= $usuario['tipo'] ?>">
                                Mudar para <?= ($usuario['tipo'] === 'admin') ? 'Usuário' : 'Admin' ?>
                            </a> |
                            <a href="gerenciar_usuarios.php?delete=<?= $usuario['id'] ?>" onclick="return confirm('ATENÇÃO: Deletar este usuário também apagará todo o seu histórico. Tem certeza?')">
                                Deletar
                            </a>
                        <?php else: ?>
                            <a href="editar_usuario.php?id=<?= $usuario['id'] ?>">Editar Perfil</a>
                        <?php endif; ?>
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