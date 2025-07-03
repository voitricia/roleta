<?php
// Inclui o arquivo de banco de dados, que também inicia a sessão.
include 'includes/db.php';

// Se o usuário já estiver logado, redireciona para a página apropriada para evitar que ele veja a tela de login novamente.
if (isset($_SESSION['user_id'])) {
    if (isset($_SESSION['user_tipo']) && $_SESSION['user_tipo'] === 'admin') {
        header("Location: adm/index.php");
    } else {
        header("Location: index.php");
    }
    exit();
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Verifica se o usuário existe E se a senha digitada corresponde à senha no banco
    if ($user && password_verify($senha, $user['senha'])) {
        
        // Login bem-sucedido! Regenera o ID da sessão para segurança (previne Session Fixation).
        session_regenerate_id(true);

        // Armazena os dados do usuário na sessão
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nome'];
        
        // --- CORREÇÃO PRINCIPAL AQUI ---
        // Armazena o 'tipo' do usuário, que vem do banco (ex: 'admin' ou 'usuario')
        $_SESSION['user_tipo'] = $user['tipo'];

        // Verifica se o 'tipo' do usuário é 'admin' e redireciona
        if ($user['tipo'] === 'admin') {
            header("Location: adm/index.php");
            exit(); // Garante que o script pare após o redirecionamento
        } else {
            header("Location: index.php");
            exit(); // Garante que o script pare após o redirecionamento
        }

    } else {
        // Se o login falhar, define uma mensagem de erro
        $message = "Email ou senha incorretos!";
    }
}

// Inclui o cabeçalho da página
include 'includes/header.php';
?>
<div class="container">
    <h2>Login</h2>
    <?php if ($message): ?>
        <p class="message error"><?= $message ?></p>
    <?php endif; ?>
    <form method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit">Entrar</button>
    </form>
    <p>Não tem uma conta? <a href="register.php">Registre-se</a></p>
</div>
<?php 
// Inclui o rodapé da página
include 'includes/footer.php'; 
?>