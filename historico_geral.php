<?php
// adm/historico_geral.php

// 1. Inclusão e Segurança
include '../includes/db.php';

// Proteção da página: Garante que apenas administradores logados possam acessar.
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_tipo']) || $_SESSION['user_tipo'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

// 2. Lógica PHP (Query com JOIN)
// Esta query é o coração da página.
// - Selecionamos o nome do usuário da tabela 'usuarios'.
// - Selecionamos o nome do prêmio da tabela 'premios'.
// - Selecionamos a data do giro da tabela 'historico_giros'.
// - Usamos JOIN para conectar as tabelas através dos seus IDs.
// - Ordenamos pelo giro mais recente no topo.
$stmt = $pdo->query("
    SELECT 
        u.nome AS nome_usuario, 
        p.nome AS nome_premio, 
        h.data_giro
    FROM 
        historico_giros AS h
    JOIN 
        usuarios AS u ON h.usuario_id = u.id
    JOIN 
        premios AS p ON h.premio_id = p.id
    ORDER BY 
        h.data_giro DESC
");
$historico_completo = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Inclui o cabeçalho HTML
include '../includes/header.php';
?>

<!-- --- 3. ESTRUTURA HTML DA PÁGINA --- -->
<div class="container" style="max-width: 900px;">
    <h2>Histórico Geral de Giros</h2>
    <p>Aqui está a lista de todos os prêmios já sorteados na roleta.</p>

    <?php if (empty($historico_completo)): ?>
        <p>Ainda não foi realizado nenhum giro no sistema.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Data do Giro</th>
                    <th>Usuário</th>
                    <th>Prêmio Ganho</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($historico_completo as $giro): ?>
                <tr>
                    <!-- Formata a data para um formato mais legível (ex: 25/12/2024 15:30:00) -->
                    <td><?= date('d/m/Y H:i:s', strtotime($giro['data_giro'])) ?></td>
                    <td><?= htmlspecialchars($giro['nome_usuario']) ?></td>
                    <td><?= htmlspecialchars($giro['nome_premio']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    
    <br>
    <a href="index.php" class="button-link" style="display: inline-block; margin-top: 1rem; text-decoration: none;">Voltar ao Painel</a>
</div>

<?php 
// Inclui o rodapé HTML
include '../includes/footer.php'; 
?>