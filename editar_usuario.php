<?php
include '../includes/db.php';

// Proteção completa da página
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_tipo']) || $_SESSION['user_tipo'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

// LÓGICA DE UPDATE
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_usuario'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $foto_perfil = !empty(trim($_POST['foto_perfil'])) ? trim($_POST['foto_perfil']) : NULL;

    if ($id) {
        $stmt = $pdo->prepare("UPDATE usuarios SET foto_perfil = ? WHERE id = ?");
        $stmt->execute([$foto_perfil, $id]);
        header("Location: gerenciar_usuarios.php");
        exit();
    }
}

// LÓGICA DE READ (busca dados do usuário)
$id_usuario = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id_usuario) {
    header("Location: gerenciar_usuarios.php");
    exit();
}

$stmt = $pdo->prepare("SELECT id, nome, email, foto_perfil FROM usuarios WHERE id = ?");
$stmt->execute([$id_usuario]);
$usuario = $stmt->fetch();

if (!$usuario) {
    header("Location: gerenciar_usuarios.php");
    exit();
}

include '../includes/header.php';
?>

<div class="container">
    <h2>Editar Usuário: <?= htmlspecialchars($usuario['nome']) ?></h2>
    <form method="post" action="editar_usuario.php">
        <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
        <label for="foto_perfil" style="margin-bottom: 0.5rem; display: block;">Arquivo da Foto de Perfil:</label>
        <input type="text" id="foto_perfil" name="foto_perfil" value="<?= htmlspecialchars($usuario['foto_perfil'] ?? '') ?>" placeholder="ex: felipe_admin.jpg">
        <small style="display: block; margin-top: -0.5rem; margin-bottom: 1rem; color: var(--cor-texto-secundario);">Digite o nome do arquivo da pasta 'uploads/fotos_perfil/'. Deixe em branco para remover.</small>
        <button type="submit" name="update_usuario" style="margin-top: 1rem;">Salvar Alterações</button>
    </form>
    <br>
    <a href="gerenciar_usuarios.php" class="button-link" style="display: inline-block; text-decoration: none;">Cancelar</a>
</div>

<?php include '../includes/footer.php'; ?>