<?php
include 'includes/db.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
        $stmt= $pdo->prepare($sql);
        $stmt->execute([$nome, $email, $senha]);
        $message = "Usuário cadastrado com sucesso! <a href='login.php'>Faça o login</a>";
    } catch (PDOException $e) {
        if ($e->errorInfo[1] == 1062) { // Código de erro para entrada duplicada
            $message = "Este email já está cadastrado!";
        } else {
            $message = "Erro ao cadastrar: " . $e->getMessage();
        }
    }
}
include 'includes/header.php';
?>
<div class="container">
    <h2>Registrar</h2>
    <?php if ($message): ?>
        <p class="message"><?= $message ?></p>
    <?php endif; ?>
    <form method="post">
        <input type="text" name="nome" placeholder="Nome Completo" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit">Registrar</button>
    </form>
</div>
<?php include 'includes/footer.php'; ?>
