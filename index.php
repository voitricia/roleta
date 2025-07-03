<?php
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['user_id'];

// Lógica PHP para buscar todos os dados necessários
$hoje = date('Y-m-d');
$stmt_check = $pdo->prepare("SELECT id, premio_id FROM historico_giros WHERE usuario_id = ? AND DATE(data_giro) = ?");
$stmt_check->execute([$userId, $hoje]);
$ja_girou = $stmt_check->fetch();

$premios = $pdo->query("SELECT nome FROM premios")->fetchAll(PDO::FETCH_COLUMN);

$stmt_score = $pdo->prepare("SELECT SUM(p.pontos) AS score_total FROM historico_giros h JOIN premios p ON h.premio_id = p.id WHERE h.usuario_id = ?");
$stmt_score->execute([$userId]);
$score_total = $stmt_score->fetchColumn() ?? 0;

// --- AQUI ESTÁ A NOVA LÓGICA ---
$stmt_foto = $pdo->prepare("SELECT foto_perfil FROM usuarios WHERE id = ?");
$stmt_foto->execute([$userId]);
$foto_perfil = $stmt_foto->fetchColumn();
// --- FIM DA NOVA LÓGICA ---

include 'includes/header.php';
?>
<div class="container">
    
    <!-- AQUI ESTÁ A NOVA ESTRUTURA HTML -->
    <div class="profile-header">
        <?php if ($foto_perfil): ?>
            <img src="/projeto_roleta/uploads/fotos_perfil/<?= htmlspecialchars($foto_perfil) ?>" alt="Foto de Perfil" class="profile-pic-main">
        <?php endif; ?>
        <div class="profile-text">
            <h2>Roleta de Prêmios Diários</h2>
            <p>
                Bem-vindo, <?= htmlspecialchars($_SESSION['user_name']) ?>! | 
                <strong>Seu Score: <?= $score_total ?> Pontos</strong>
            </p>
        </div>
    </div>
    
    <?php if ($ja_girou): ?>
        <div class="message" style="margin-top: 2rem;">Você já girou a roleta hoje! Volte amanhã.</div>
        <?php
            if (!empty($ja_girou['premio_id'])) {
                $stmt_premio = $pdo->prepare("SELECT nome FROM premios WHERE id = ?");
                $stmt_premio->execute([$ja_girou['premio_id']]);
                $premio_ganho = $stmt_premio->fetchColumn();
                echo "<p>Seu prêmio de hoje foi: <strong>" . htmlspecialchars($premio_ganho) . "</strong></p>";
            }
        ?>
    <?php else: ?>
        <div class="roulette-container">
            <canvas id="canvas" width="400" height="400"></canvas>
            <button id="spin_button" onclick="startSpin();">GIRAR!</button>
        </div>
        <div id="result" class="message" style="display:none;"></div>
    <?php endif; ?>
</div>

<script>
    const premios = <?= json_encode($premios) ?>;
    const podeGirar = <?= $ja_girou ? 'false' : 'true' ?>;
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>
<script src="/projeto_roleta/js/Winwheel.min.js"></script>
<script src="/projeto_roleta/js/script.js"></script>

<?php include 'includes/footer.php'; ?>